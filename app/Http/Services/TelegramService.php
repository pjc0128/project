<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;

class TelegramService
{
    const BOT_TOKEN = '1355338404:AAGMfbvp_gQaBBEU56C4cyjnSQalDQ4hBlA';
    const API_URL = 'https://api.telegram.org/bot'.self::BOT_TOKEN.'/';
    const TELEGRAM_CHAT_ID = array('1336061434');

    function telegramSendMessage($parameters) {
        $method = "sendMessage";

        foreach ($parameters as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }

        $url = self::API_URL.$method.'?'.http_build_query($parameters);

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($handle);

        Log::info($response);

        return $response;
    }

    public function sendMailErrorMessage($code, $email){
        foreach(self::TELEGRAM_CHAT_ID AS $_TELEGRAM_CHAT_ID_STR) {

            $_TELEGRAM_QUERY_STR    = array(
                'chat_id' => $_TELEGRAM_CHAT_ID_STR,
                'text'    =>
                "   [메일발송 실패]
                CODE : ".$code."
                대상 : ".$email
            );

            $this->telegramSendMessage($_TELEGRAM_QUERY_STR);
        }
    }

    public function crawlingErrorMessage(){

    }
}
