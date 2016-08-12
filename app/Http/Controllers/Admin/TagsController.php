<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagsController extends Controller {

	public function getIndex() {

		return view('dashboards.admin.tags.index');
	}

	public function getSidebar() {
		return view('dashboards.admin.tags.sidebar');
	}

	public function postSidebar(Request $request) {

        $list = $request->input('list');
        $list = json_decode($list, true);
        dd($list);
    }


}
