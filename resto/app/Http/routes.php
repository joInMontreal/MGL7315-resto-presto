<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Home@welcome');
Route::get('/reserve', 'Reservations@showForm');
Route::get('/reservation/{reservationId}', 'Reservations@single');
Route::get('/reservation/{reservationId}/confirmation', 'Reservations@confirmation');
Route::get('/reservation/{reservationId}/detail', 'Reservations@detail');
Route::post('/reserve', 'Reservations@reserve');
Route::post('/reservation/{reservationId}/confirm', 'Reservations@confirm');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
