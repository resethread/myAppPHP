<?php

Route::group(['middleware' => 'auth'], function () {
	Route::controller('/admin', 'AdminController');

	Route::controller('/user', 'UserController');
});

Route::controller('/', 'PublicController');

