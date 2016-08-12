<?php namespace App\Http\Controllers;

use DB;
use Carbon;
use Log;
use Illuminate\Http\Request;
use File;
use Image;
use PHPRedis;
use Elasticsearch\ClientBuilder;
use App\User;
use App\Models\Video;
use App\Models\Comment;

class AdminController extends Controller {

	public function __construct() {  

	}

	public function getIndex() {

		$today = Carbon\Carbon::toDay()->toDateTimeString();

		$count_pages = PHPRedis::get('count_pages');

		$count_users_registered_today = DB::table('users')->where('created_at', $today)->count();

		$count_videos_uploaded_today = DB::table('videos')->where('created_at', $today)->count();

		return view('dashboards.admin.index', compact('count_users_registered_today', 'count_videos_uploaded_today', 'count_pages'));
	}

	public function getVideosToValidate() {

		$videos = DB::table('videos')->where('validated', false)->get();

		return view('dashboards.admin.videos.videos_to_validate', compact('videos'));
	}

	public function getVideoToValidate($id) {

		$video = DB::table('videos')->where('id', $id)->first();

		$file = $video->path;
		$file = substr($file, strrpos($file, '/'));
		$file = ltrim($file, '/');
		
		return view('dashboards.admin.videos.video_to_validate', compact('video', 'file'));
	}

	public function postVideoToValidate($id, Request $request) {

		$video = DB::table('videos')->where('id', $id)->first();

		$validate = $request->input('validate');

		$destination = public_path('users_content/videos/'.$id);

		if ($validate == 'yes') {

			# update status
			DB::table('videos')->where('id', $id)->update(['validated' => true]);
		

			# convert formats
			$file = File::files($destination)[0];
			$file = substr($file, strrpos($file, '/'));
			$file = ltrim($file, '/');
			$file_no_extension = substr($file, 0, -4);

			$extension = substr($file, -3);
			
			if ($extension != 'webm') {

				chdir($destination);

				$command = "ffmpeg -i $file $file_no_extension.webm > /dev/null &";

				exec($command);
			}
			
			# Redis cache
			$video_cache = [
				'name' => $video->name,
				'slug' => $video->slug,
				'poster' => $video->poster,
				'path' => $video->path,
				'duration' => $video->duration,
				'user_id' => $video->user_id,
				'nb_total_rate' => $video->nb_total_rate,
				'nb_users_rating' => $video->nb_users_rating,
				'rate' => $video->rate,
				'nb_views' => $video->nb_views,
				'nb_favorited' => $video->nb_favorited,
				'nb_comments' => $video->nb_comments,
			];
			PHPRedis::hMset("video:$id", $video_cache);


			return redirect('/admin/videos-to-validate')->with('message_success', 'the video has been validated');

		}
		elseif ($validate == 'no') {

			File::deleteDirectory($destination);

			DB::table('videos')->where('id', $id)->delete();

			return redirect('/admin/videos-to-validate')->with('message_error', 'the video has been deleted');
		}
		else {
			return redirect()->back();
		}
	}

	public function postCreateThumbnails($id) {

		$nb_thumbnails = 12;
		
		$destination = public_path("/users_content/videos/$id");
	
		$file = File::files($destination)[0];
		$name = File::name($file);
		$extension = File::extension($file);
		$complete_name = basename($file);

		if ($extension == 'mp4' || $extension == 'webm' || $extension == 'avi') {
			chdir($destination);

			$total_seconds = shell_exec("ffprobe -i $file -show_format -v quiet | sed -n 's/duration=//p'");
			$total_seconds = floor($total_seconds);

			$fps = $total_seconds / $nb_thumbnails;
			$fps = floor($fps);

			//$command = "ffmpeg -i $name.$extension -vf fps=1/$fps z_img__$name%03d.jpg;";
			$command = "ffmpeg -i $complete_name -vf fps=1/$fps thumb-$name-%d.jpg";
			exec($command);

			// resize images with Intervention.io
			$images = File::files($destination);
			array_shift($images);
			
			foreach ($images as $image) {
				$img = Image::make($image);
				$img->resize(220, 170);
				$img->save($image);
			}
			
			return redirect()->back()->with('message_success', 'Thumbnails created');
		}
		else {
			return redirect()->back()->with('message_error', 'this is not a video file');
		}
		
	}

	public function postConvertFormats($id) {

		$command = base_path('sudo node sv.js');
		exec($command);
		return redirect()->back()->with('message_success', 'ça à l air bon');
		/*
		$destination = public_path("/users_content/videos/$id");
		
		$file = File::files($destination)[0];
		$file = substr($file, strrpos($file, '/'));
		$file = ltrim($file, '/');

		$extension = substr($file, -3);

		if ($extension == 'mp4' || $extension == 'webm' || $extension == 'avi') {
			chdir($destination);

			$command = "ffmpeg -i $file "
		}	
		*/
	}

	public function getVideosOnline() {

		$videos = DB::table('videos')->where('validated', true)->paginate(10);

		return view('dashboards.admin.videos.videos_online', compact('videos'));
	}

	public function getVideoEdit($id) {

		# Elastic
		$client = ClientBuilder::create()->build();
		$params = [
			'index' => 'bdd',
			'type' => 'video',
			'id' => $id
		];
		$response = $client->get($params);
		//dd($response['_source']['tags']);

		# Eloquent
		$video = Video::find($id);
		$video->tags = $response['_source']['tags'];
		$video->stars = $response['_source']['stars'];
	

		return view('dashboards.admin.videos.video_edit', compact('video'));
	}

	public function postVideoEdit($id, Request $request) {
		$client = ClientBuilder::create()->build();
		$params = [
			'index' => 'bdd',
			'type' => 'video',
			'id' => $id,
			'body' => [
				'doc' => []
			]
		];

		if ($request->has('tags')) {
			$tags = $request->input('tags');
			$tags = explode(' ', $tags);
			$params['body']['doc']['tags'] = $tags;
		}

		if ($request->has('stars')) {
			$stars = $request->input('stars');
			$stars = explode(' ', $stars);
			$params['body']['doc']['stars'] = $stars;
		}

		$response = $client->update($params);


		return redirect()->back()->with('message_success', 'successfull update');
	}

	public function getVideosSearch(Request $request) {
		$searchZone = $request->input('search-zone');

		$videos = Video::where('name', 'LIKE', '%'.$searchZone.'%')->get();

		return view('dashboards.admin.videos.videos_online')->with(compact('videos', 'searchZone'));
	}

	public function  getComments() {

		$comments = DB::table('comments')->paginate(10);

		return view('dashboards.admin.comments.comments', compact('comments'));
	}

	public function getCommentsReported() {
		$comments = DB::table('comments_reported')->get();

		return view('dashboards.admin.comments', compact('comments'));
	}

	public function getFastDelete() {
		return view('dashboards.admin.fast_delete');

	}

	public function postFastDelete($elements, Request $request) {
		switch ($elements) {
			case 'videos':
				$elements = $request->input('elements');
				$elements = explode(' ', $elements);
				PHPRedis::delete($elements);
				foreach($elements as $element) {

					// delete video from database
					$elemId = Video::find($element);
					if( !is_null($elemId)) {
						$elemId->delete();
					}

					// delete folder
					$destination =  public_path("users_content/videos/$element");
					if (File::exists($destination)) {
						File::deleteDirectory($destination);
						
					}

					// delete comments from database
					Comment::where('video_id', $element)->delete();
					
				}

				return redirect()->back()->with('message_success', 'Elements have been deleted');		
			break;

			case 'users':
				$elements = $request->input('elements');
				$elements = explode(' ', $elements);
				foreach($elements as $element) {
					$elem = User::find($element);
					if( !is_null($elem)) {
						$elem->delete();
					}
				}
				return redirect()->back()->with('message_success', 'Elements have been deleted');
			break;	
			
			default:
				$elements = $request->input('elements');
				$elements = explode(' ', $elements);
				foreach($elements as $element) {
					$elem = Comment::find($element);
					if( !is_null($elem)) {
						$elem->delete();
					}
				}
				return redirect()->back()->with('message_success', 'Elements have been deleted');	
			break;
		}
	}

	public function getInfos() {


	    $ffmpeg = shell_exec('which ffmpeg');
        $redis = shell_exec('which redis-server');


    }
}