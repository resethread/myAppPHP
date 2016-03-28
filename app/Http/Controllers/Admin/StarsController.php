<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;

class StarsController extends Controller {

	public function __construct() {

	}

	public function getIndex() {

		$stars = DB::table('stars')->get();

		return view('dashboards.admin.stars.index')->with(compact('stars'));
	}
}