<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Elasticsearch\ClientBuilder;

class TagsController extends Controller {

	public function getIndex() {

		$client = ClientBuilder::create()->build();

		$params = [
			'index' => 'bdd',
			'type' => 'video',
			'body' => [
				'query' => [
					'match_all' => []
				]
			]
		];
		$response = $client->search($params);
		dd($response);

		return view('dashboards.admin.tags.index');
	}

}
