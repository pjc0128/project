<?php

$snoopy = new App\Http\Controllers\Snoopy();

//에듀동아 - 정상작동, 기사 수 적음
$url = "http://edu.donga.com/?p=article&search=top&stx=%EC%B7%A8%EC%97%85";

//연합뉴스
//$url = "https://www.yna.co.kr/search/index?query=%EC%B7%A8%EC%97%85&ctype=A&sort=weight&scope=title&from=20200709&to=20200716&period=1w";

$url = 'http://edu.donga.com/?p=article&ps=view&at_no=20200720104043255555&titleGbn=&page=1';
//$snoopy->fetch($url);
//$txt=$snoopy->results;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response =  curl_exec($ch);

$result = json_decode($response);
\Illuminate\Support\Facades\Log::info($response);
print $response;
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
//
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
//echo "현재 날짜 : ". date("Y-m-d-H-i-s")."<br/>";



?>

