<?php namespace App\Http\Controllers;

use DB;
use Carbon;
use Log;
use Request;
use File;
use Image;

use App\Models\Video;
use App\Models\Comment;
use App\Users;

class AdminController extends Controller {

	public function __construct() {  

	}

	public function getIndex() {

		$today = Carbon\Carbon::toDay()->toDateTimeString();

		$count_users_registered_today = DB::table('users')->where('created_at', $today)->count();

		$count_videos_uploaded_today = DB::table('videos')->where('created_at', $today)->count();

		return view('dashboards.admin.index', compact('count_users_registered_today', 'count_videos_uploaded_today'));
	}

	public function getVideosToValidate() {

		$videos = DB::table('videos')->where('validated', false)->get();

		return view('dashboards.admin.videos_to_validate', compact('videos'));
	}

	public function getVideoToValidate($id) {

		$video = DB::table('videos')->where('id', $id)->first();

		$file = $video->path;
		$file = substr($file, strrpos($file, '/'));
		$file = ltrim($file, '/');
		
		return view('dashboards.admin.video_to_validate', compact('video', 'file'));
	}

	public function postVideoToValidate($id) {

		$video = DB::table('videos')->where('id', $id);

		$validate = Request::input('validate');

		$destination = public_path('users_content/videos/'.$id);


		if ($validate == 'yes') {
			# update status
			$video->update(['validated' => true]);
		

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
		$file = substr($file, strrpos($file, '/'));
		$file = ltrim($file, '/');
		$only_name = substr($file, 0, strrpos($file, '.'));

		$extension = substr($file, -3);

		if ($extension == 'mp4' || $extension == 'webm' || $extension == 'avi') {
			chdir($destination);

			$total_seconds = shell_exec("ffprobe -i $file -show_format -v quiet | sed -n 's/duration=//p'");
			$total_seconds = floor($total_seconds);

			$fps = $total_seconds / $nb_thumbnails;
			$fps = floor($fps);
			
			$command = "ffmpeg -i $file -vf fps=1/$fps z_img__$only_name%03d.jpg;";

			exec($command);

			// resize images with Intervention.io
			$images = File::files($destination);
			array_shift($images);
			foreach ($images as $image) {
				$img = Image::make($image);
				$img->resize(180, 75);
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

		return view('dashboards.admin.videos_online', compact('videos'));
	}

	public function getVideosSearch() {
		$searchZone = Request::input('search-zone');

		$videos = Video::where('name', 'LIKE', '%'.$searchZone.'%')->get();

		return view('dashboards.admin.videos_online')->with(compact('videos', 'searchZone'));
	}

	public function getUsers() {

		$users = DB::table('users')->paginate(10);

		return view('dashboards.admin.users', compact('users'));
	}

	public function getUser($id) {

		$user = DB::table('users')->where('id', $id)->first();

		return view('dashboards.admin.user', compact('user'));
	}

	public function  getComments() {

		$comments = DB::table('comments')->paginate(10);

		return view('dashboards.admin.comments', compact('comments'));
	}

	public function getFastDelete() {
		return view('dashboards.admin.fast_delete');

	}

	public function postFastDelete($elements) {
		switch ($elements) {
			case 'videos':
				$elements = Request::input('elements');
				$elements = explode(' ', $elements);
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
				}
				return redirect()->back()->with('message_success', 'Elements have been deleted');		
			break;

			case 'users':
				$elements = Request::input('elements');
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
				$elements = Request::input('elements');
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

	public function getLogs() {

	}
}