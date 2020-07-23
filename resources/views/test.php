<?php

$snoopy = new App\Http\Controllers\Snoopy();

//에듀동아 - 정상작동, 기사 수 적음
$url = "http://edu.donga.com/?p=article&search=top&stx=%EC%B7%A8%EC%97%85";
$url2 = "http://edu.donga.com/";
//연합뉴스
//$url = "https://www.sedaily.com/NewsVIew/1Z5AUCJ17X";
//
//$snoopy->fetch($url);
//$txt=$snoopy->results;
//
//print $txt;
$deletedURL = 'http://edu.donga.com/?p=article&ps=view&at_no=20200721111551855555&titleGbn=&page=1';




//if(!@fopen($deletedURL, "r")){
//
//}else{
//    $c = new \App\Http\Controllers\Clawler();
//
//    $c->clawling2($url2);
//
//
//    print '존재함';
//}

//삭제된url??
//if($response){
//    print 'testO';
//}else{
//    print 'testX';
//};

//-----------------시간테스트
//$testDate1 = "2020-01-01";
//$testDate2 = "2021-01-01";
//$testDate3 = "01-02";
//
//$newDate1 = date("YY-mm-dd", strtotime($testDate1));
//$newDate2 = date("YY-mm-dd", strtotime($testDate2));
//$newDate3 = date("Y-m-d", strtotime($testDate3));
//print 'testDate3 : '.$newDate3.'-123-123';
//$ymd = DateTime::createFromFormat('m-d', '10-20')->format('Y-m-d');
//$ymd2 = DateTime::createFromFormat('m-d', '10-24')->format('Y-m-d');
//
//print '$ymd : '.$ymd;
//
//if($newDate1<$newDate2){
//    print '안보이는것도';
//}else{
//    print '보이는것만';
//}
//$test = realpath('/windows');
//print $test.'<br>';
//print 'test123';
//echo $_SERVER["DOCUMENT_ROOT"];
echo "현재 날짜 : ". date("Y-m-d-H-i-s")."<br/>";

?>

