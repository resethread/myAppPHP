<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;


class LogsController extends Controller {

	public function getIndex() {
		
		$destination = storage_path('logs');
		chdir($destination);
		$files = scandir($destination);
		$files = array_slice($files, 3);


		//$logs = file_get_contents('laravel.log');

		return view('dashboards.admin.logs.index')->with(compact('files'));
	}

	public function getLog($log) {

		$destination = storage_path('logs');
		chdir($destination);
		$log = file_get_contents($log);

		return view('dashboards.admin.logs.log')->with(compact('log'));
	}
}
