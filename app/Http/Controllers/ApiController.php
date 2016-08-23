<?php

namespace App\Http\Controllers;
use Cache;

class ApiController extends Controller {

    public function getSideTags() {
        $tags = Cache::get('side_tags');
        return response()->json($tags);
    }
}