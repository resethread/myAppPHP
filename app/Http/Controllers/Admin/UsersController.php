<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;

class UsersController extends Controller {

	public function __construct() {

	}

	public function getIndex() {

		$users = DB::table('users')->paginate(10);

		return view('dashboards.admin.users.users', compact('users'));
	}

	public function getUser($id) {
		$user = DB::table('users')->where('id', $id)->first();

		return view('dashboards.admin.users.user', compact('user'));
	}

}