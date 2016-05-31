<?php 

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use Redirect;
use Image;
use App\Models\Video;
use App\Models\Comment;
use Log;
use File;
use Crypt;
use Carbon\Carbon;
use Elasticsearch\ClientBuilder;
use PHPRedis;
use Storage;
use Cache;


class PublicController extends Controller {

	public function getIndex() {

		PHPRedis::incr('count_pages');

		 $videos = DB::table('videos')->where('validated', true)->orderBy('id', 'desc')->get();

		 $scripts = ['overviews'];

		return view('front.overviews')->with(compact('videos', 'scripts'));
	}
	

	public function getVideo($id, $slug) {

		PHPRedis::incr('count_pages');

		if (PHPRedis::hLen($id)) {
			$video_by_redis = PHPRedis::hGetAll($id);
			
			$video = new Video();
			foreach ($video_by_redis as $key => $value) {
				$video->$key = $value;
			}
		}
		else {
			$video = Video::find($id);
		}


		if ($video->slug == $slug) {

			$fullMain = true;

			$scripts = ['vue', 'vue-resource','video_tpl'];


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

			$client = ClientBuilder::create()->build();

			$params = [
				'index' => 'bdd',
				'type' => 'video',
				'body' => [
					'query' => [
						'match' => [
							'tags' => ''
						]
					]
				]
			];
			$response = $client->search($params);
			
			$id = [];

			foreach ($response['hits']['hits'] as $hit) {
				array_push($id, $hit['_id']);
			}

			$videos = DB::table('videos')->whereIn('id', $id)->where('validated', true)->get();
			// lateral 

			return view('front.video')->with(compact('video', 'fullMain', 'scripts'));	
		}
		else {
			echo "pb dans l'url";
		}
			
	}

	public function getComments($id) {

		// get comments
		/*
		$comments = DB::table('videos')->join('comments', function($join) {
			$url = Request::url();
			$url_exploded = explode('/', $url);
			$i = array_search('video', $url_exploded);
			$i++;
			$id = $url_exploded[$i];
			
			$join->on('videos.id', '=', 'comments.video_id')
			->where('comments.video_id', '=', $id); 
		})->get();
		*/
		$comments = DB::table('comments')->where('video_id', $id)->get();
		
		return $comments;
	}

	public function postVideo($id, Request $request) {
		$rules = [
			'content' => 'required|between:3,128'
		];

		$validator = $validator = Validator::make($request->all(), $rules);

		if($validator->fails()) {
			return redirect()->back()->with('message_error', 'Your message must to be betwenn 3 and 128 characters');
		}
		else {
			if (Auth::check()) {
				$comment = new Comment;
				$comment->user_name = Auth::user()->name;
				$comment->video_id = $id;
				$comment->content = $request->input('content');
				$comment->save();

				DB::table('videos')->where('id', $id)->increment('nb_comments', 1);
				return redirect()->back()->with('message_success', 'good comment');
				
			} else {
				return redirect()->back()->with('message_error', 'You must to be logged to post comments');
			}
			return Redirect::back();
		}
	}

	public function postReportComment($video_id, $comment_id) {
		
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

	public function postRateVideo($user_id, $video_id, Request $request) {
		if (Auth::guest()) {
			return redirect()->back()->with('message_error', 'You must to be logged to rate a video');
		}
		else {
			$rated = DB::table('rates')->where('user_id', Auth::user()->id)->where('video_id', $video_id)->first();

			if (is_null($rated)) {

				DB::table('rates')->insert([
					'user_id' => Auth::user()->id,
					'video_id' => $video_id,
					'rate' => $request->input('rate')
				]);

				$video = DB::table('videos')->where('id', $video_id);

				$video->increment('nb_total_rate', $request->input('rate'));
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

	public function getSearch(Request $request) {

		PHPRedis::incr('count_pages');
		
		$searchZone = $request->input('search-zone');

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

	public function postNewAccount(Request $request) {

		$name = $request->input('name');	
		$email = $request->input('email');	
		$password = $request->input('password');	
		$password_confirmation = $request->input('password_confirmation');	

		
		$rules = [
			'name' => 'required|string|between:3,32|unique:users',
			'email' => 'required|email|unique:users',
			'password' => 'required|between:8,32',
			'password_confirmation' => 'required|same:password',
			'accepted' => 'required'
		];

		$validator = Validator::make($request->all(), $rules);
		
		if ($validator->fails()) {
			echo $validator->errors();
		}
		else {
			DB::table('users')->insert([
				'name' => $name,
				'email' => $email,
				'password' => bcrypt($password),
				'ip' => bcrypt($request->ip())
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

	public function postLogin(Request $request) {

		$login = $request->input('login');
		$password = $request->input('password');

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
		sleep(4);
		
		if ( Auth::attempt($authenticate_user_by_name) || Auth::attempt($authenticate_user_by_email) ) {
			$user_id = Auth::user()->id;
			
			return redirect("/account");
		}
		else if ( Auth::attempt($authenticate_admin_by_name) || Auth::attempt($authenticate_admin_by_email) ) {
			return redirect('/admin');
		}
		else {
			return redirect()->back()->with('error_message', 'Name or user incorrect');
		}
		
	}

	
	public function getTag($tag) {

		PHPRedis::incr('count_pages');
		
		//$videos = Video::withAnyTag($name)->where('validated', true)->get();

		$client = ClientBuilder::create()->build();
		$params = [
			'index' => 'bdd',
			'type' => 'video',
			'body' => [
				'query' => [
					'match' => [
						'tags' => $tag
					]
				]
			]
		];
		$response = $client->search($params);

		$id = [];

		foreach ($response['hits']['hits'] as $hit) {
			array_push($id, $hit['_id']);
		}

		$videos = DB::table('videos')->whereIn('id', $id)->where('validated', true)->get();
	
		return view('front.overviews')->with(compact('videos'));
	}

	// navTop
	public function getNewsVideos() {

		PHPRedis::incr('count_pages');

		$videos = DB::table('videos')->where('validated', true)->orderBy('created_at', 'desc')->get();

		$scripts = ['application'];

		return view('front.overviews')
			->with(compact('videos', 'scripts'));
	}
	
	public function getMostViewed() {

		PHPRedis::incr('count_pages');

		$videos = DB::table('videos')->where('validated', true)->orderBy('nb_views', 'desc')->get();

		$scripts = ['application'];

		return view('front.overviews')
			->with(compact('videos', 'scripts'));
	}
	
	public function getTopRated() {

		PHPRedis::incr('count_pages');

		$videos = DB::table('videos')->where('validated', true)->orderBy('rate', 'desc')->get();

		return view('front.overviews')
			->with(compact('videos'));
	}
	
	public function getMostFavorited() {

		PHPRedis::incr('count_pages');
	
		// creer une table favorited 	
		// id, user_id, video_id

		//	à chaque fois qu'un user like une video, nb_favorited++
		$videos = DB::table('videos')->where('validated', true)->orderBy('nb_favorited', 'desc')->get();
		return view('front.overviews')
			->with(compact('videos'));
	}

	public function getMostCommented() {

		PHPRedis::incr('count_pages');

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

		PHPRedis::incr('count_pages');
		
		$videos = DB::table('videos')->where('validated', true)->orderByRaw("RAND()")->get();		

		return view('front.overviews')
			->with(compact('videos'));
	}
		
	public function getChannels() {

		PHPRedis::incr('count_pages');
		
		$channels = DB::table('users')->get();

		return view('front.channels')
			->with(compact('channels'));
	}

	public function getStars() {

		PHPRedis::incr('count_pages');

		$stars = DB::table('stars')->get();

		return view('front.stars')->with(compact('stars'));
	}

	public function getStar($star) {

		//$star = DB::table('stars')->where('name', $star)->first();

		//dd($star);

		return view('front.star');
	}
	

	#----------------------------
	#	FOOTER
	#----------------------------

	public function getTermsAndConditions() {

		PHPRedis::incr('count_pages');
		
		$fullMain = true;
		return view('front.conditions')->with(compact('fullMain'));
	}

	public function getHowTo() {

		PHPRedis::incr('count_pages');

		$fullMain = true;
		return view('front.how-to')->with(compact('fullMain'));
	}

	public function getContact() {

		PHPRedis::incr('count_pages');

		$fullMain = true;

		$options = [
			'Question about advertising',
			"Question about a video's copyright"

		];

		return view('front.contact')->with(compact('fullMain', 'options'));
	}

	public function postContact(Request $request) {

		//sleep(3);

		$rules = [
			'name' => 'required|min:3|max:20',
			'email' => 'required|email',
			'subject' => 'required',
			'text' => 'required|min:10|max:100'
		];	

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails()) {

			return redirect()->back()->withErrors($validator);
		}
		else {

			$message = [
				'name' => Crypt::encrypt($request->input('name')),
				'email' => Crypt::encrypt($request->input('email')),
				'subject' => Crypt::encrypt($request->input('subject')),
				'text' => Crypt::encrypt($request->input('text')),
				'instant' => Carbon::now(),
				'created_at' => Carbon::now(),
				'ip' => $request->ip()
			];

			DB::table('messages')->insert($message);

			return redirect()->back()->with('message_success', 'Your message has been successfully sent');
		}		
	}

	public function getIp(Request $request) {
		return $request->ip();
	}

	#----------------------------
	#	TEST
	#----------------------------

	public function getTest() {
		
		Cache::store('redis')->put('bar', 'baz', 10);

		//return response()->download('assets/css/app.css');
		
		//return view('front.test');

	}

	public function getTest2() {
		echo 'z';
		return response()->download('assets/css/app.css');
	}

	public function postTest(Request $request) {

		$test = $request->input('toto');
		echo $test;

	}
}

