<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use File;

class LogsController extends Controller {

	public function getIndex() {
		
		$destination = storage_path('logs');
		chdir($destination);
		$files = scandir($destination);
		$files = array_slice($files, 3);

		return view('dashboards.admin.logs.index')->with(compact('files'));
	}

	public function getLog($log) {

		$destination = storage_path('logs');
		chdir($destination);
		$log = file_get_contents($log);

		return view('dashboards.admin.logs.log')->with(compact('log'));
	}

	public function getDelete($log) {
		File::delete(storage_path("logs/$log"));

		return redirect()->back();
	}
}
