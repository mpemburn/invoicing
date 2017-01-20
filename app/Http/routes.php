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

Route::auth();
Route::get('/home', 'HomeController@index');
Route::get('/', function () {
    return view('home');
});


// Auth protected routes
Route::group(['middleware' => 'web'], function () {
    Route::get('invoice', [
        'middleware' => ['auth'],
        'uses' => 'InvoicesController@index'
    ]);
    Route::get('/invoice/details', [
        'middleware' => ['auth'],
        'uses' => 'InvoicesController@invoiceDetails'
    ]);
    Route::get('/invoice/details/{id}', [
        'middleware' => ['auth'],
        'uses' => 'InvoicesController@invoiceDetails'
    ]);
});

