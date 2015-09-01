<?php namespace App\Http\Controllers;

use DB;
use Carbon;
use Log;
use Request;
use File;

use App\Models\Video;
use App\Models\Comment;
use App\Users;

class AdminController extends Controller {

	public function __construct() {  
		/*
		function getRecordsToday() {
			$today = Carbon\Carbon::toDay()->toDateTimeString();

			$videos_today_count = DB::table('videos')->where('created_at', $today)->where('validated', false)->count();
		

		}
		*/
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

		return view('dashboards.admin.video_to_validate', compact('video'));
	}

	public function postVideoToValidate($id) {
		$validate = Request::input('validate');
		if ($validate == 'yes') {

			$video = Video::find($id);

			//	$video->update(['validated' => true]);

			$destination = public_path('users_content/videos/'.$id);
			chdir($destination);

			$file_path = public_path("$video->path.mp4");
			$file_name = substr($file_path, strrpos($file_path, '/'));
			$real_file_name_mp4 = ltrim($file_name, '/');
			$real_file_no_extension = rtrim($real_file_name_mp4, '.mp4');

			$extensions = ['webm'];

			
				$command = "ffmpeg -i $real_file_name_mp4 $real_file_no_extension.webm";
				exec($command);
		

			//return redirect('/admin/videos-to-validate')->with('message_success', 'the video has been validated');
		}
		else {
			$destination = public_path()."/users_content/videos";
			chdir($destination);
			File::deleteDirectory($id);
			DB::table('videos')->where('id', $id)->delete();
			return redirect('/admin/videos-to-validate')->with('message_error', 'the video has been deleted');
		}
	}

	public function getVideosOnline() {

		$videos = DB::table('videos')->paginate(10);

		return view('dashboards.admin.videos_online', compact('videos'));
	}

	public function getVideosOnlineSearch() {

		$searchZone = Request::input('search-zone');

		dd($searchZone);

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

	public function postValidate($id) {

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
					$elemId = Video::find($element);
					if( !is_null($elemId)) {
						$elemId->delete();

						$destination = public_path()."/users_content/videos/$elemId";
						if (File::exists($destination)) {
							File::deleteDirectory($destination);
						}
					}
				}
				return redirect()->back()->with('message_success', 'Elements has been deleted');		
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
				return redirect()->back()->with('message_success', 'Elements has been deleted');
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
				return redirect()->back()->with('message_success', 'Elements has been deleted');	
			break;
		}
	}

	public function getListUsers() {

	}

	public function getListVideos() {
		
	}

	public function getLogs() {

	}
}