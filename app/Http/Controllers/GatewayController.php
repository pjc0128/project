<?php


namespace App\Http\Controllers;


use App\Http\Services\GatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GatewayController
{
    private $gateway_service;

    public function __construct(GatewayService $gateway_service){

        $this->gateway_service = $gateway_service;

    }

    public function show(Request $request){

        //    IPv4 주소 . . . . . . . . . : 172.20.38.65
        //   서브넷 마스크 . . . . . . . : 255.255.255.0
        //   기본 게이트웨이 . . . . . . : 172.20.38.1
        $pre = 'http://edu.donga.com';

        $article_id = $request->input('aid');
        $mail_id = $request->input('mid');
        $user_id = $request->input('uid');

        Log::info('article_id = '.$article_id. ' mail_id = '.$mail_id . ' user_id= '.$user_id);

        $result = $this->gateway_service->show($article_id, $mail_id, $user_id);

        $url = $result['article']->url;
        $path = $pre.$url;

        return redirect()->away($path);
    }

}
