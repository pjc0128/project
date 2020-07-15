<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class TestMailController extends Controller
{

    function testAPI()
    {
        $url = 'http://crm3.saramin.co.kr/mail_api/automails';

        $data = array(
            'autotype' => 'A0188',
            'cmpncode' => 12031,
            /*받는사람*/
            'email' => 'pjc0128@naver.co.kr',
            'sender_email' => 'pcc2242@saramin.co.kr',
            'title' => '외부메일',
            'use_event_solution' => 'y',
            'replace15' => 'testContent'
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
