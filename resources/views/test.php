<?php

$snoopy = new App\Http\Controllers\Snoopy();
$url = "http://edu.donga.com/?p=article&search=top&stx=%EC%82%AC%EB%9E%8C%EC%9D%B8";
$title="";
$urlArr="";
$snoopy->fetch($url);
$txt=$snoopy->results;

$titleRex="/\<strong\>(.*)\<\/strong\>/";
$urlRex="/\<dt\>(.*)\<strong\>/";
preg_match_all($titleRex,$txt, $title);
preg_match_all($urlRex,$txt, $urlArr);



//print $txt;

for($i = 0; $i < count($title) ; $i++){
    for($j = 0 ; $j < count($title[$i]); $j++){
     print '$title['.$i.']['.$j.'] = '.$title[$i][$j].'<br>';
     print '$url['.$i.']['.$j.'] = '.$urlArr[$i][$j].'<br>';
    }
}



//$test = realpath('/windows');
//print $test.'<br>';
//print 'test123';
//echo $_SERVER["DOCUMENT_ROOT"];
//echo "현재 날짜 : ". date("Y-m-d-H-i-s")."<br/>";



?>
<h1>test12312</h1>
