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

        $article_id = $request->input('aid');
        $mail_id = $request->input('mid');
        $user_id = $request->input('uid');

        $result = $this->gateway_service->show($article_id, $mail_id, $user_id);

        $url = $result['article']->url;
        $path = getenv('PRE').$url;

        return redirect()->away($path);
    }

}
