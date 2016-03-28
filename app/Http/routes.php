<?php

// Index
Route::get('/', 'PublicController@getIndex');

Route::get('video/{id}/{slug}', 'PublicController@getVideo');
Route::post('video/{id}/{slug}', 'PublicController@postVideo');
Route::get('comments/{id}', 'PublicController@getComments');
Route::post('add-favorite/{user_id}/{video_id}', 'PublicController@postAddFavorite');
Route::post('rate-video/{user_id}/{video_id}', 'PublicController@postRateVideo');

Route::get('search', 'PublicController@getSearch');

Route::get('tag/{tag}', 'PublicController@getTag');

// Menus
Route::get('news-videos', 'PublicController@getNewsVideos');
Route::get('most-viewed', 'PublicController@getMostViewed');
Route::get('top-rated', 'PublicController@getTopRated');
Route::get('most-favorited', 'PublicController@getMostFavorited');
Route::get('most-commented', 'PublicController@getMostCommented');
Route::get('tags', 'PublicController@getTags');
Route::get('random', 'PublicController@getRandom');
Route::get('stars', 'PublicController@getstars');
Route::get('channels', 'PublicController@getChannels');

Route::get('new-account', 'PublicController@getNewAccount');
Route::post('new-account', 'PublicController@postNewAccount');

Route::get('login', 'PublicController@getLogin');
Route::post('login', 'PublicController@postLogin');

Route::get('contact', 'PublicController@getContact');
Route::post('contact', 'PublicController@postContact');

Route::get('terms-and-conditions', 'PublicController@getTermsAndConditions');


Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
	Route::controller('/users', 'Admin\UsersController');
	Route::controller('/banners', 'Admin\BannersController');
	Route::controller('/tags', 'Admin\TagsController');
	Route::controller('/stars', 'Admin\StarsController');
	Route::controller('/messages', 'Admin\MessagesController');
	Route::controller('/logs', 'Admin\LogsController');
	Route::controller('/', 'AdminController');
	

	Route::controller('user', 'UserController');
});

//Route::controller('/', 'PublicController');


