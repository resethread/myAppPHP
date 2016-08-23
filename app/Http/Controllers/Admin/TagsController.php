<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;

class TagsController extends Controller {

	public function getIndex() {

		return view('dashboards.admin.tags.index');
	}

	public function getSidebar() {
		return view('dashboards.admin.tags.sidebar');
	}

	public function postSidebar(Request $request) {

        $side_tags = $request->input('side_tags');
        $side_tags = json_decode($side_tags, true);
        Cache::forever('side_tags', $side_tags);

        return redirect()->back()->with('message_success', 'Tags updated');
    }


}
