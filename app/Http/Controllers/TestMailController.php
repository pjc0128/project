<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TestMailController extends Controller
{

    function testAPI()
    {
        $url = 'http://crm3.saramin.co.kr/mail_api/automails';
        $autotype = 'A0188';
        $cmpncode = 12031;
        $sender_email = 'pcc2242@saramin.co.kr';
        $use_event_solution = 'y';

        $data = array(
            'autotype' => $autotype,
            'cmpncode' => $cmpncode,
            'sender_email' => $sender_email,
            'use_event_solution' => $use_event_solution,
            'email' => 'pjc0128@naver.com',
            'title' => '외부메일',
            'replace15' => "<a href='www.naver.com'>네이버</a>"
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        //POST설정 전에 데이터설정할시 실패*순서중요
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($curl_exec, )

        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        $response = curl_exec($ch);

        return view('testMail', ['response' => $response]);
    }

    function sendMail($articles, $email){

        $pre = 'http://edu.donga.com';
        $url = 'http://crm3.saramin.co.kr/mail_api/automails';
        $autotype = 'A0188';
        $cmpncode = 12031;
        $sender_email = 'pcc2242@saramin.co.kr';
        $use_event_solution = 'y';

        $content = '';
        foreach ($articles as $article){
            $content .= "<a href='".$pre.$article['url']."'>".$article['title']."</a><br>";
        }

        $data = array(
            'autotype' => $autotype,
            'cmpncode' => $cmpncode,
            'sender_email' => $sender_email,
            'use_event_solution' => $use_event_solution,
            'email' => 'pjc0128@naver.com',
            'title' => date("Y/m/d").'사람인 기사',
            'replace15' => $content
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response =  curl_exec($ch);


//        Log::info(json_decode($response,1));
//        Log::info(print_r($response,1));
//        trigger_error($response);

//        if(curl_error($ch)){
//            $curl_data = null;
//        } else {
//            $curl_data = $response;
//        }
//        curl_close($ch);
//
//        $json_data = json_decode($curl_data, true);
//        if($json_data["code"==200]){
//            Log::info("메일발송성공");
//        }else{
//            Log::info("메일발송실패");
//        }



        return $response;
    }
}
