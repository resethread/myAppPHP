<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;

class MessagesController extends Controller {

	public function getIndex() {
		$messages = DB::table('messages')->get();

		return view('dashboards.admin.messages.messages')->with(compact('messages'));
	}

	public function getMessage($id) {
		$message = DB::table('messages')->where('id', $id)->first();

		return view('dashboards.admin.messages.message')->with(compact('message'));
	}
}