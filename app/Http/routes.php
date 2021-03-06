<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'ViewLinksAction@show');
Route::get('/links/create', 'PostLinkAction@create');
Route::post('/links/store', 'PostLinkAction@store');
Route::get('/links/upvote/{id}', 'UpvoteLinkAction@vote');
Route::get('/links/downvote/{id}', 'DownvoteLinkAction@vote');

Route::controllers([
    'auth' => 'Auth\AuthController',
]);
