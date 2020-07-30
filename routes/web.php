<?php


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'DashboardController@index');

Route::get('/dashboard', 'DashboardController@index');

Route::get('/dashboard/detail', 'DashboardController@detail');

Route::get('/dashboard/chart', 'DashboardController@chart');

Route::get('/gateway', 'GatewayController@show');

Route::get('/test', function () {
    return view('test');
});



