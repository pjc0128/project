<?php

namespace App\Http\Services;

use App\Http\Enum;
use Illuminate\Support\Facades\Log;

class TelegramService
{


    function telegramSendMessage($parameters) {
        $method = "sendMessage";

        foreach ($parameters as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }

        $url = Enum::API_URL.$method.'?'.http_build_query($parameters);

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);

        return curl_exec($handle);
    }

    public function sendMailErrorMessage($code, $email){
        foreach(Enum::TELEGRAM_CHAT_ID AS $_TELEGRAM_CHAT_ID_STR) {

            $_TELEGRAM_QUERY_STR    = array(
                'chat_id' => $_TELEGRAM_CHAT_ID_STR,
                'text'    =>
                "   [메일발송 실패]
                CODE : {$code}
                대상 : {$email}"
            );

            $this->telegramSendMessage($_TELEGRAM_QUERY_STR);
        }
    }

    public function crawlingErrorMessage(){

    }
}
