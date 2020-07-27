<?php

use App\Article;
use App\ArticleHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

$snoopy = new App\Http\Controllers\Snoopy();

//에듀동아 - 정상작동, 기사 수 적음
//$url = "http://edu.donga.com/?p=article&search=top&stx=%EC%B7%A8%EC%97%85";

//연합뉴스
//$url = "https://www.sedaily.com/NewsVIew/1Z5AUCJ17X";
$undeletedURL = 'http://edu.donga.com/?p=article&ps=view&at_no=20200722102734616014&titleGbn=&page=1';
$deletedURL = 'http://edu.donga123.com/?p=article&ps=view&at_no=20200722102734655555&titleGbn=&page=1';

//$snoopy->fetch($undeletedURL);
//$txt=$snoopy->results;

//Log::info($txt);


//for($i = 0 ; $i < count($test) ; $i++){
//    for($j = 0 ; $j < count($test[$i]) ; $j++){
//        print $i.'-'.$j.'-'.$test[$i][$j];
//    }
//}
//
//if(fopen($undeletedURL, "r")){
//    print '존재하는 url';
//}else{
//    print '없는 url';
//}






?>

