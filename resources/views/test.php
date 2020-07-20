<?php

$snoopy = new App\Http\Controllers\Snoopy();

//에듀동아 - 정상작동, 기사 수 적음
$url = "http://edu.donga.com/?p=article&search=top&stx=%EC%B7%A8%EC%97%85";

//연합뉴스
//$url = "https://www.yna.co.kr/search/index?query=%EC%B7%A8%EC%97%85&ctype=A&sort=weight&scope=title&from=20200709&to=20200716&period=1w";



//$snoopy->fetch($url);
//$txt=$snoopy->results;
//
////$title="";
////$titleRex="/\<strong\>(.*)\<\/strong\>/";
////preg_match_all($titleRex,$txt, $title);
////for($i = 0; $i < count($title) ; $i++){
////    for($j = 0 ; $j < count($title[$i]); $j++){
////        print '$title['.$i.']['.$j.'] = '.strip_tags($title[$i][$j]).'<br>';
////    }
////}
//
//$urlArr = "";
//$urlRex = '/\<dt\>(.*)\<\/dt\>/';
////$urlRex = '/\<a.*?href="(.*)\>/';
////$urlRex='/^<a.*?href=(["\'])(.*?)\1.*$/';
//preg_match_all($urlRex,$txt, $urlArr);
//
//
//$linkRex ='/\<a.*?href="(.*)\>/';
//
//    for($j = 0 ; $j < count($urlArr[1]); $j++){
//        print '$url[1]['.$j.'] = '.strip_tags($urlArr[1][$j]).'<br>';
//        print '$url[1]['.$j.'] = '.preg_replace('/<a href="([^"]+)">.+/', '$1', $urlArr[1][$j]).'<br>';
//    }



//print '$url['.$i.']['.$j.'] = '.substr($url, strpos($url, '\>'), strrpos($url, '\<') ).'<br>';


//$test = realpath('/windows');
//print $test.'<br>';
//print 'test123';
//echo $_SERVER["DOCUMENT_ROOT"];
//echo "현재 날짜 : ". date("Y-m-d-H-i-s")."<br/>";



?>
<h1>1</h1>
