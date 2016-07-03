<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Elasticsearch\ClientBuilder;

class TagsController extends Controller {

	public function getIndex() {

		return view('dashboards.admin.tags.index');
	}

	public function getSidebar() {
		return view('dashboards.admin.tags.sidebar');
	}


}
