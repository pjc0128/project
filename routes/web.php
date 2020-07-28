<?php

use App\Article;
use App\Http\Controllers\AccessHistoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MailHistoryController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard/detail', 'DashboardController@detail');



Route::get('/gateway', function(){

//    IPv4 주소 . . . . . . . . . : 172.20.38.65
//   서브넷 마스크 . . . . . . . : 255.255.255.0
//   기본 게이트웨이 . . . . . . : 172.20.38.1

    $ac = new ArticleController();
    $ahc = new AccessHistoryController();
    $mhc = new MailHistoryController();

    $aid = $_GET['aid'];


    Log::info($aid);

    $mid = $_GET['mid'];
    $uid = $_GET['uid'];
    Log::info('aid = '.$aid. ' mid = '.$mid . ' uid= '.$uid);

    $mail_history = $mhc->show($mid, $uid);

    Log::info($mail_history);

    $ahc->store($mail_history->id);

    $pre = 'http://edu.donga.com';
    $article = $ac->show($aid);
    $url = $article->url;
    $path = $pre.$url;

    return redirect()->away($path);
});



//Route::get('/testMail', function () {
//    $email =' ';
//    $articles = Article::all();
//    //Log::info(var_dump($articles));
//    //$articles = Article::latest()->where('mail_content_id',9)->get();
//    $mc = new TestMailController();
//    //$mc->testAPI();
//    $response = $mc->sendMail($articles, $email);
//
//    return view('testMail', ['response'=>$response]);
//});
//
//Route::get('/testClawling', function(){
//    $c = new Clawler();
//
//    $articles = $c->clawling();
//
//    return view('testClawling', ['articles'=>$articles]);
//});

