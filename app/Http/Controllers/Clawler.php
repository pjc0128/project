<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Snoopy;

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
}
