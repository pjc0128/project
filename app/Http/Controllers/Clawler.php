<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Snoopy;
use Illuminate\Support\Facades\Log;

class Clawler
{
    function clawling()
    {
        $snoopy = new Snoopy();

        $url = "http://edu.donga.com/?p=article&search=top&stx=%EC%B7%A8%EC%97%85";

        $snoopy->fetch($url);
        $txt = $snoopy->results;

        $urlArr = "";
        $rex = '/\<dt\>(.*)\<\/dt\>/';
        preg_match_all($rex, $txt, $urlArr);

        $dateArr = "";
        $rex2 = '/\<dd class="article_desc"\>(.*)\<\/dd\>/';
        preg_match_all($rex2, $txt, $dateArr);


        $articles = array();

        for ($j = 0; $j < count($urlArr[1]); $j++) {
            $articles[$j] = ['title'=> strip_tags($urlArr[1][$j]),
                'url' => preg_replace('/<a href="([^"]+)">.+/', '$1', $urlArr[1][$j]),
                'date' => strip_tags($dateArr[1][$j])];
        }

        return $articles;
    }

    function checkDelete($url)
    {
        $url = "http://edu.donga.com".$url;

        $deleted = false;

        $snoopy = new Snoopy();

        $snoopy->fetch($url);
        $txt = $snoopy->results;

        $check = null;
        $rex = '/기사가 존재하지 않습니다/';
        preg_match($rex, $txt, $check);


        if($check != null){
            $deleted = true;
        }

//        if(!@fopen($url, "r")){
//
//        }else{
//
//        }
//
//        if($deleted){
//            Log::info($url.'삭제');
//        }else{
//            Log::info($url.'변경사항 없음');
//        }

        return $deleted;
    }
}
