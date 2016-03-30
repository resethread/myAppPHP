<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\User;

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

	public function getSearch(Request $request) {
		$searchZone = $request->input('search-zone');

		$users = User::where('name', 'LIKE', '%'.$searchZone.'%')->get();

		return view('dashboards.admin.users.users', compact('users'));
	}

}