<?php

$snoopy = new App\Http\Controllers\Snoopy();

//에듀동아 - 정상작동, 기사 수 적음
$url = "http://edu.donga.com/?p=article&search=top&stx=%EC%B7%A8%EC%97%85";

//****url 확인 https://darkangelus.tistory.com/65;
HttpWebRequest request = new Web

//연합뉴스
//$url = "https://www.yna.co.kr/search/index?query=%EC%B7%A8%EC%97%85&ctype=A&sort=weight&scope=title&from=20200709&to=20200716&period=1w";


$snoopy->fetch($url);
$txt=$snoopy->results;

print $txt;

//$title="";
//$titleRex="/\<strong\>(.*)\<\/strong\>/";
//preg_match_all($titleRex,$txt, $title);
//for($i = 0; $i < count($title) ; $i++){
//    for($j = 0 ; $j < count($title[$i]); $j++){
//        print '$title['.$i.']['.$j.'] = '.strip_tags($title[$i][$j]).'<br>';
//    }
//}

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
//print '$url[1]['.$j.'] = '.substr($url, strpos($url, '\>'), strrpos($url, '\<') ).'<br>';


//-----------------시간테스트
//$testDate1 = "2020-01-01";
//$testDate2 = "2021-01-01";
//
//$testDate3 = "01-02";
//
//$newDate1 = date("YY-mm-dd", strtotime($testDate1));
//$newDate2 = date("YY-mm-dd", strtotime($testDate2));
//$newDate3 = date("Y-m-d", strtotime($testDate3));
//
//print 'testDate3 : '.$newDate3;
//
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
<h1>1</h1>
