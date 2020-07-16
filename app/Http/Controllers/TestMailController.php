<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


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
            'replace15' => "코로나19로 일상 전반에 걸쳐 ‘언택트’"
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        //POST설정 전에 데이터설정할시 실패*순서중요
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        $response = curl_exec($ch);

        return view('testMail', ['response' => $response]);
    }
}
