<?php

namespace App\Http\Services;

class TelegramService
{
    const TELEGRAM_CHAT_ID = ['1336061434'];


    function telegramSendMessage($parameters)
    {
        $method = "sendMessage";

        foreach ($parameters as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }

        $url = getenv('API_URL') . $method . '?' . http_build_query($parameters);

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);

        return curl_exec($handle);
    }

    public function sendMailErrorMessage($code, $user)
    {
        foreach (self::TELEGRAM_CHAT_ID as $_TELEGRAM_CHAT_ID_STR) {

            $_TELEGRAM_QUERY_STR = [
                'chat_id' => $_TELEGRAM_CHAT_ID_STR,
                'text' =>
                    "   [메일발송 실패]
                CODE : {$code}
                대상 : {$user->email}({$user->name})"
            ];

            $this->telegramSendMessage($_TELEGRAM_QUERY_STR);
        }
    }

    public function crawlingErrorMessage()
    {
        foreach (self::TELEGRAM_CHAT_ID as $_TELEGRAM_CHAT_ID_STR) {

            $_TELEGRAM_QUERY_STR = [
                'chat_id' => $_TELEGRAM_CHAT_ID_STR,
                'text' =>
                    "   [크롤링 실패]
                구조 변경으로 인한 크롤링 실패"
            ];

            $this->telegramSendMessage($_TELEGRAM_QUERY_STR);
        }
    }
}
