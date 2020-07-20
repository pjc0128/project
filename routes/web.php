<?php

use App\Article;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestMailController;
use App\Http\Controllers\Clawler;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/testMail', function () {
    $email =' ';
    $articles = Article::all();
    //Log::info(var_dump($articles));
    //$articles = Article::latest()->where('mail_content_id',9)->get();
    $mc = new TestMailController();
    //$mc->testAPI();
    $response = $mc->sendMail($articles, $email);

    return view('testMail', ['response'=>$response]);
});

Route::get('/testClawling', function(){
    $c = new Clawler();

    $articles = $c->clawling();

    return view('testClawling', ['articles'=>$articles]);
});

Route::get('/article', 'ArticleController@index');
Route::get('/article/store', 'ArticleController@store');

