<?php


// Route::get('/', 'PublicController@getIndex');

// Route::get('video/{id}/{slug}', 'PublicController@getVideo');
// Route::post('video/{id}/{slug}', 'PublicController@postVideo');
// Route::get('comments/{id}', 'PublicController@getComments');
// Route::post('add-favorite/{user_id}/{video_id}', 'PublicController@postAddFavorite');
// Route::post('rate-video/{user_id}/{video_id}', 'PublicController@postRateVideo');

// Route::get('search', 'PublicController@getSearch');

// Route::get('new-account', 'PublicController@getNewAccount');
// Route::post('new-account', 'PublicController@postNewAccount');

// Route::get('login', 'PublicController@getLogin');
// Route::post('login', 'PublicController@postLogin');


Route::group(['middleware' => 'auth'], function () {
	Route::controller('/admin', 'AdminController');

	Route::controller('/user', 'UserController');
});

Route::controller('/', 'PublicController');


