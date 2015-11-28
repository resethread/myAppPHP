<?php namespace App\Http\Controllers;

use Auth;
use DB;
use Request;
use Validator;
use Session;
use Redirect;
use File;
use Log;
use Image;

use App\Models\Video;
use Elasticsearch\ClientBuilder;

class UserController extends Controller {
	public function __construct() {  

	}

	public function getIndex() {

		$auth_user_id = Auth::user()->id;

		// icones du haut
		$videos_count = DB::table('videos')->where('user_id', $auth_user_id)->count();

		// tableau
		///$last_videos = DB::table('videos')->where('user_id', $auth_user_id)->take(5)->get();

		$last_videos = DB::table('users')->join('videos', function($join) {
			$join->on('users.id', '=', 'videos.user_id')->where('videos.user_id', '=', Auth::user()->id);
		})->take(5)->get();

		return view('dashboards.user.index')
			->with(compact('videos_count', 'last_videos'));
	}

	public function getAddVideo() {
		$scripts = ['dropzone', 'add_video'];
		return view('dashboards.user.add_video')->with(compact('scripts'));
	}

	public function postAddVideo() {

		$file = Request::file('file');

		$rules = [
			'file'  => 'required|mimes:mp4,mov,ogg,avi|max:50000'
		];
		$validator = Validator::make(Request::all(), $rules);
	
		if ($validator->fails()) {
			return $validator->errors()->all();
		}
		else {
			if (Request::file('file')->isValid()) {
				$file = Request::file('file');

				$video = new Video;
				$video->name = substr($file->getClientOriginalName(), 0, -4);
				$video->slug = str_slug($video->name);
				$video->poster = "/users_content/videos/$video->id/thumbs/thumb_2.jpg";
				$video->user_id = (Auth::user()->id);
				$video->save();

				//create folders if not exist 
				$destination = public_path("/users_content/videos/$video->id");	
				if (!File::exists($destination)) {
					File::makeDirectory($destination);
				}

				// rename file
				$extension = $file->getClientOriginalExtension(); // return extension
				$random_string = str_random(10);
				$filename = "$random_string.$extension"; 
				
				$uploadSuccess = $file->move($destination, $filename);
				if ($uploadSuccess) {
					$video->path = "/users_content/videos/$video->id/$random_string";
					$video->save();
				}
				else {
					return 'erreur dans le transfert du fichier';
				}

				// change dir
				chdir($destination);
				
				// get duration and save
				function getDuration($media) {
					$total_seconds = shell_exec("ffprobe -i $media -show_format -v quiet | sed -n 's/duration=//p'");
					$duration = $total_seconds / 60;
					return number_format($duration, '1', ':', ',');
				}
				$video->duration = getDuration(File::files($destination)[0]);
				


				# ES
				$client = ClientBuilder::create()->build();
				$params = [
					'index' => 'bdd',
					'type' => 'video',
					'id' => $video->id,
					'body' => [
						'name' => $video->name,
						'user' => Auth::user()->name,
						'description' => '',
						'tags' => [],
						'stars' => []
					]
				];

				if (Request::has('description')) {
					$description = Request::input('description');
					$params['body']['description'] = $description;
				}
				if (Request::has('tags')) {
					$tags = Request::input('tags');
					$tags = explode(' ', $tags);
					$params['body']['tags'] = $tags;
				}
				if (Request::has('stars')) {
					$stars = Request::input('stars');
					$stars = explode(' ', $stars);
					$params['body']['stars'] = $stars;
				}
				$client->index($params);

				# mysql
				$video->save();
				# /ES

				/*
				$total_frames = shell_exec("ffprobe -show_streams '$filename' 2> /dev/null | grep nb_frames | head -n1 | sed 's/.*=//'");
				$numbers = range(10, $total_frames);
				shuffle($numbers);
				$numbers = array_slice($numbers, 0, 16);Ô
				sort($numbers);

				foreach ($numbers as $key => $val) {
					exec("ffmpeg -i $filename -vf 'select=gte(n\,$val)' -vframes 1 $random_string-$key.jpg");
				}
				*/

				return redirect()->back()->with('message_success', 'Your video has been successfully uploaded and is waiting for admin validation');
				
			} 
			else {
				echo "no valid";
			}
		}
	}

	
	
	public function getVideos() {

		$auth_user_id = Auth::user()->id;

		$videos = DB::table('videos')->where('user_id', $auth_user_id)->paginate(20);

		return view('dashboards.user.list_videos')
			->with(compact('videos'));
	}
	
	public function getFavorites() {

		$auth_user_id = Auth::user()->id;

		$favorited = DB::table('favorited')->where('user_id', $auth_user_id)->get();

		$videos = [];

		foreach($favorited as $fav) {
			array_push($videos, 
				DB::table('videos')->where('id', $fav->video_id)->first()
			);
		}

		return view('dashboards.user.list_favorited')->with(compact('videos'));
	}

	public function postDeleteFavorite($id) {
		$user_id = Auth::user()->id;

		# Mysql
		DB::table('favorited')->where('user_id', $user_id)->where('video_id', $id)->delete();

		#Elastic
		$client = ClientBuilder::create()->build();
		$params = [
		    'index' => 'bdd',
		    'type' => 'video',
		    'id' => $id
		];

		$response = $client->delete($params);

		return redirect()->back()->with('message_success', 'the favoried has been deleted');
	}

	public function getSettings() {

		$user_avatar = Auth::user()->avatar;

		if (!empty($user_avatar)) {
			$avatar_src = "/users_content/avatars/".Auth::user()->id.substr($user_avatar, strripos($user_avatar, '/'));
			return view('dashboards.user.setting')->with(compact('avatar_src'));
		}

		return view('dashboards.user.setting');
	}

	public function postSettings($setting) {

		$user_id = Auth::user()->id;
		$user = DB::table('users')->where('id', $user_id);

		switch ($setting) {
			case 'avatar':
				$rules = [
					'avatar' => 'required|mimes:jpg,jpeg,png|max:100'
				];

				$validator = Validator::make(Request::all(), $rules);

				if ($validator->fails()) {
					dd($validator->errors());
				//	return Redirect::back()->withErrors($validator);
				}
				else {			
					$avatar = Request::file('avatar');
					$extension = $avatar->getClientOriginalExtension();
					$destination = public_path()."/users_content/avatars/$user_id";
					$random_string = str_random(10);
					$complete_name = $random_string.".".$extension;
					

					if (!File::exists($destination)) {
						File::makeDirectory($destination);
					}

					$avatar->move($destination, $complete_name);


					$user->update(['avatar' => $destination.'/'.$complete_name]);

					return redirect()->back()->with('message_success', 'Your avatar has been updated');
				}

			break;

			case 'email':

				$rules = [
					'email' => 'required|email',
					'email_confirmation' => 'required|email|same:email'
				];

				$validator = Validator::make(Request::all(), $rules);

				if ($validator->fails()) {
					var_dump($validator->errors());
				}
				else {
					$user->update(['email' => Request::input('email')]);

					return redirect()->back()->with('message_success', 'Your email has been updated');
				}

			break;

			case 'password':

				$rules = [
					'password' => 'required|min:8',
					'password_confirmation' => 'required|same:password'
				];

				$validator = Validator::make(Request::all(), $rules);

				if ($validator->fails()) {
					var_dump($validator->errors());
				}
				else {
					$crypted = bcrypt(Request::input('password'));

					$user->update(['password' => $crypted]);

					return redirect()->back()->with('message_success', 'Your password has been updated');
				}

			break;

			
			default:
				return Redirect::back();
			break;
		};
	}

	public function getEditVideo($id) {

		$video = Video::find($id);

		$tags = [
			'toto', 'test', 'trois quatre', 'lol', 'lolzor', 'megapouet', 'pouet', 'humour',
			'retest2', 'reset', 'toto2'
		];

		$scripts = ['edit_video'];

		return view('dashboards.user.edit')->with(compact('video', 'tags', 'scripts'));
	}

	public function postEditVideo($id) {

		$video = Video::find($id);
		$client = ClientBuilder::create()->build();

		// manage keywords
		if (Request::has('keywords')) {
			$keywords = Request::input('keywords');
			$keywords_list = explode(' ', $keywords);

			$video->tag($keywords_list) || $video->retag($keywords_list);
		}

		// manage tags button
		if (Request::has('tags')) {
			$tags = Request::input('tags');
			$tags_list = explode(',', $tags);
			
			foreach ($tags_list as $tag) {
				$video->tag($tag);
			}
		}

		

		//return redirect('/user')->with('message_success', 'Your video has been edited');
	}

	public function postDeleteVideo($id) {

		$video = Video::find($id);

		$video->delete();
		$video->untag();

		# delete the video from the table favorited
		DB::table('favorited')->where('video_id', $id)->delete();

		# delete the directory
		$destination = public_path()."/users_content/videos/$id";
		if (File::exists($destination)) {
			File::deleteDirectory($destination);
		}
		return redirect('/user')->with('message_success', 'Your video has been deleted');
	}

}