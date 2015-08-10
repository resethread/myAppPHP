<?php namespace App\Http\Controllers;

use DB;
use Request;
use Validator;
use Auth;
use Session;
use Redirect;
use Image;
use App\Models\Video;
use App\Models\Comment;
use Log;


class PublicController extends Controller {

	public function getIndex() {

		 $videos = DB::table('videos')->where('validated', true)->orderBy('id', 'desc')->get();

		 $scripts = ['overviews'];

		return view('front.overviews')
			->with(compact('videos', 'scripts'));
	}
	

	public function getVideo($id, $slug) {

		$video = Video::find($id);

		if ($video->slug == $slug) {

			$fullMain = true;

			$scripts = ['application'];

			// get comments
			$comments = DB::table('videos')->join('comments', function($join) {
				$url = Request::url();
				$url_exploded = explode('/', $url);
				$i = array_search('video', $url_exploded);
				$i++;
				$id = $url_exploded[$i];
				
				$join->on('videos.id', '=', 'comments.video_id')
				->where('comments.video_id', '=', $id); 
			})->get();
			
			// check videos in session and increment the number views
			$video_session = Session::get('video_session');
			if (empty($video_session)) {
				$video->increment('nb_views');
				Session::push('video_session', $id);
			}
			else {
				if (!in_array($id, $video_session)) {
					$video->increment('nb_views');
					Session::push('video_session', $id);
				}
			}


			/*
				lateral suggested
			*/
			$nb_suggested = 12;

			// lateral author
			$lateral_last_author = DB::table('videos')->where('user_id', $video->user_id)->take(3)->get();
			$lateral_last_author_public = [];
			foreach ($lateral_last_author as $video_lat) {
				array_push($lateral_last_author_public, 
					[
						'name' => $video_lat->name,
						'img' => "/users_content/videos/$video_lat->id/thumbs/thumb_1.jpg",
						'link' => "/video/$video_lat->id/$video_lat->slug", // cette merde à débugger après manger
						'user' => DB::table('users')->where('id', $video_lat->user_id)->first()->name,
						'duration' => $video_lat->duration,
						'nb_views' => $video_lat->nb_views
					]
				);
			}

			// lateral 

			return view('front.video')->with(compact('video', 'fullMain', 'comments', 'lateral_last_author_public', 'scripts'));	
		}
		else {
			echo "pb dans l'url";
		}
			
	}

	public function postVideo($id) {
		$rules = [
			'content' => 'required|between:3,128'
		];

		$validator = $validator = Validator::make(Request::all(), $rules);

		if($validator->fails()) {
			return redirect()->back()->with('message_error', 'Your message must to be betwenn 3 and 128 characters');
		}
		else {
			if (Auth::check()) {
				$comment = new Comment;
				$comment->user_name = Auth::user()->name;
				$comment->video_id = $id;
				$comment->content = Request::input('content');
				$comment->save();

				DB::table('videos')->where('id', $id)->increment('nb_comments', 1);
				return redirect()->back()->with('message_success', 'good comment');
				
			} else {
				return redirect()->back()->with('message_error', 'You must to be logged to post comments');
			}
			return Redirect::back();
		}
	}

	public function postAddFavorite($user_id, $video_id) {
		if (Auth::guest()) {
			return redirect()->back()->with('message_error', 'You must to be logged to have favorited');
		}
		else {
			$favorited = DB::table('favorited')->where('user_id', Auth::user()->id)->where('video_id', $video_id)->first();

			if (is_null($favorited)) {
				DB::table('favorited')->insert([
					'user_id' => Auth::user()->id,
					'video_id' => $video_id
				]);
				Video::find($video_id)->increment('nb_favorited');
				return redirect()->back()->with('message_success', 'This video is in your favorites');
			}
			else {
				return redirect()->back()->with('message_error', 'This video is already in your favorites');
			}
		}
	}

	public function postRateVideo($user_id, $video_id) {
		if (Auth::guest()) {
			return redirect()->back()->with('message_error', 'You must to be logged to rate a video');
		}
		else {
			$rated = DB::table('rates')->where('user_id', Auth::user()->id)->where('video_id', $video_id)->first();

			if (is_null($rated)) {

				DB::table('rates')->insert([
					'user_id' => Auth::user()->id,
					'video_id' => $video_id,
					'rate' => Request::input('rate')
				]);

				$video = DB::table('videos')->where('id', $video_id);

				$video->increment('nb_total_rate', Request::input('rate'));
				$video->increment('nb_users_rating');

				$nb_total_rate = $video->first()->nb_total_rate;
				$nb_users_rating = $video->first()->nb_users_rating;

				settype($nb_total_rate, 'int');
				settype($nb_users_rating, 'int');

				$rate = $nb_total_rate / $nb_users_rating;
				$video->update(['rate' => $rate]);

				return redirect()->back()->with('message_success', 'This has been rated successful');
			}
			else {
				return redirect()->back()->with('message_error', 'You have already rate this video');
			}
		}
	}

	public function getSearch() {
		
		$searchZone = Request::input('search-zone');

		$videos = Video::where('name', 'LIKE', '%'.$searchZone.'%')->where('validated', true)->get();

		$searchZoneWords = explode(' ', $searchZone);
		$videos_by_tag = Video::withAnyTag($searchZoneWords)->get();

		$scripts = ['application'];

		return view('front.overviews')
			->with(compact('videos', 'searchZone', 'videos_by_tag', 'scripts'));
	}
	
	public function getNewAccount() {
		$fullMain = true;
		return view('front.new-account')->with(compact('fullMain'));
	}

	public function getTermsAndConditions() {
		$fullMain = true;
		return view('front.conditions')->with(compact('fullMain'));
	}

	public function postNewAccount() {

		$name = Request::input('name');	
		$email = Request::input('email');	
		$password = Request::input('password');	
		$password_confirmation = Request::input('password_confirmation');	

		
		$rules = [
			'name' => 'required|string|between:3,32|unique:users',
			'email' => 'required|email|unique:users',
			'password' => 'required|between:8,32',
			'password_confirmation' => 'required|same:password',
			'accepted' => 'required'
		];

		$validator = Validator::make(Request::all(), $rules);
		
		if ($validator->fails()) {
			echo $validator->errors();
		}
		else {
			DB::table('users')->insert([
				'name' => $name,
				'email' => $email,
				'password' => bcrypt($password),
				'ip' => bcrypt(Request::ip())
			]);

			return redirect('/');
		}
	}

	public function getLogin() {
		$fullMain = true;
		return view('front.login')->with(compact('fullMain'));
	}

	public function getLogout() {
		Auth::logout();

		return redirect('/');
	}

	public function postLogin() {

		$login = Request::input('login');
		$password = Request::input('password');

		$authenticate_user_by_name = [
			'name' => $login,
			'password' => $password,
			'status' => 'user'
		];

		$authenticate_user_by_email = [
			'email' => $login,
			'password' => $password,
			'status' => 'user' 
		];

		$authenticate_admin_by_name = [
			'name' => $login,
			'password' => $password,
			'status' => 'admin'
		];

		$authenticate_admin_by_email = [
			'email' => $login,
			'password' => $password,
			'status' => 'admin' 
		];
		
		if ( Auth::attempt($authenticate_user_by_name) || Auth::attempt($authenticate_user_by_email) ) {
			
			return redirect('/user');
		}
		else if ( Auth::attempt($authenticate_admin_by_name) || Auth::attempt($authenticate_admin_by_email) ) {
			return redirect('/admin');
		}
		else {
			return 'pas loged';
		}
		
	}

	
	public function getTag($name) {
		
		$videos = Video::withAnyTag($name)->get();
		
		return view('front.overviews')
			->with(compact('videos'));
	}

	// navTop
	public function getNewsVideos() {

		$videos = DB::table('videos')->where('validated', true)->orderBy('created_at', 'desc')->get();

		$scripts = ['application'];

		return view('front.overviews')
			->with(compact('videos', 'scripts'));
	}
	
	public function getMostViewed() {

		$videos = DB::table('videos')->where('validated', true)->orderBy('nb_views', 'desc')->get();

		$scripts = ['application'];

		return view('front.overviews')
			->with(compact('videos', 'scripts'));
	}
	
	public function getTopRated() {
		$videos = DB::table('videos')->where('validated', true)->orderBy('rate', 'desc')->get();

		return view('front.overviews')
			->with(compact('videos'));
	}
	
	public function getMostFavorited() {
	
		// creer une table favorited 	
		// id, user_id, video_id

		//	à chaque fois qu'un user like une video, nb_favorited++
		$videos = DB::table('videos')->where('validated', true)->orderBy('nb_favorited', 'desc')->get();
		return view('front.overviews')
			->with(compact('videos'));
	}

	public function getMostCommented() {

		$videos = DB::table('videos')->where('validated', true)->orderBy('nb_comments', 'desc')->get();
		return view('front.overviews')
			->with(compact('videos'));
	}

	public function getTags() {
		/*
		$tags_list = [];
		
		sort($tags_list);

		$final_array = [];
		$alphabet = range('a', 'z');
		foreach ($alphabet as $letter) {
			$tags_letter = [];
			foreach ($tags_list as $tag) {
				if ($tag[0] == $letter) {
					array_push($tags_letter, $tag);
				}
			}
			array_push($final_array, [ $letter => $tags_letter ]);
		}
		*/
	
		$tags = DB::table('tagging_tags')->get();

		return view('front.tags')
			->with(compact('tags'));
	}

	public function getRandom() {
		
		$videos = DB::table('videos')->where('validated', true)->orderByRaw("RAND()")->get();		

		return view('front.overviews')
			->with(compact('videos'));
	}
		
	public function getChannels() {
		
		$channels = DB::table('users')->get();

		return view('front.channels')
			->with(compact('channels'));
	}
	

	public function getTest() {

		return view('front.test');
	}

	public function postTest() {

		$rate = Request::input('rate');
		settype($rate, 'int');
		var_dump($rate);
		
	}

	#----------------------------
	#	FOOTER
	#----------------------------

	public function getContact() {

		$fullMain = true;

		$options = [
			'Question about advertising',
			"Question about a video's copyright"

		];

		return view('front.contact')->with(compact('fullMain', 'options'));
	}

	public function postContact(Request $request) {


	}
}

