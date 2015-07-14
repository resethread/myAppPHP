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
		$scripts = ['dropzone', 'logged'];
		return view('dashboards.user.add_video')->with(compact('scripts'));
	}

	public function postAddVideo() {

		$file = Request::file('file');

		$rules = [
			'file'  => 'required|mimes:mp4,mov,ogg,avi|max:60000'
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
				$destination = public_path()."/users_content/videos/$video->id";	
				if (!File::exists($destination)) {
					File::makeDirectory($destination);

					$folder_thumb = $destination.'/thumbs';
					if (!File::exists($folder_thumb)) {
						File::makeDirectory($folder_thumb);
					}
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

				// ffmpeg
				chdir($destination);

				// if file is not mp4
				if ($extension != 'mp4') {
					exec("ffmpeg -i $filename $random_string.mp4");
					$filename = "$random_string.mp4";
				}
				
				// get duration and save
				function getDuration($media) {
					$total_seconds = shell_exec("ffprobe -i $media -show_format -v quiet | sed -n 's/duration=//p'");
					$duration = $total_seconds / 60;
					return number_format($duration, '1', ':', ',');
				}
				$video->duration = getDuration($file->getClientOriginalName());
				$video->save();

				$total_frames = shell_exec("ffprobe -show_streams '$filename' 2> /dev/null | grep nb_frames | head -n1 | sed 's/.*=//'");
				$numbers = range(10, $total_frames);
				shuffle($numbers);
				$numbers = array_slice($numbers, 0, 16);
				sort($numbers);

				foreach ($numbers as $key => $val) {
					exec("ffmpeg -i $filename -vf 'select=gte(n\,$val)' -vframes 1 thumb_$random_string-$key.jpg");
				}

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

		$list_videos = [];

		foreach($favorited as $fav) {
			echo "<pre>";
			var_dump($fav);
			echo "</pre>";
			array_push($list_videos, 
				DB::table('videos')->where('id', $fav->video_id)->first()
			);
		}

		echo "<hr>";

		echo "<pre>";
		var_dump($list_videos);
		echo "</pre>";




		//return view('dashboards.user.list_favorited')->with(compact('favorited'));
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
		return redirect('/user')->with('message_success', 'Your video has been edited');
	}

	public function postDeleteVideo($id) {

		$video = Video::find($id);

		$video->delete();
		$video->untag();

		$destination = public_path()."/users_content/videos/$id";
		if (File::exists($destination)) {
			File::deleteDirectory($destination);
		}
		return redirect('/user')->with('message_success', 'Your video has been deleted');
	}

}