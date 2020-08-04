<?php


namespace App\Http\Services;


use App\Http\Enum;
use App\Repositories\ArticleInterface;
use App\Repositories\MailContentInterface;
use App\Repositories\MailHistoryInterface;
use App\Repositories\UserInterface;
use Illuminate\Support\Facades\Log;

class MailService
{
    private $article_repository;
    private $user_repository;
    private $mail_history_repository;
    private $mail_content_repository;
    private $telegram_service;

    public function __construct(ArticleInterface $article_repository,
                                UserInterface $user_repository,
                                MailHistoryInterface $mail_history_repository,
                                MailContentInterface $mail_content_repository,
                                TelegramService $telegram_service)
    {
        $this->article_repository = $article_repository;
        $this->user_repository = $user_repository;
        $this->mail_history_repository = $mail_history_repository;
        $this->mail_content_repository = $mail_content_repository;
        $this->telegram_service = $telegram_service;
    }

    public function makeContent($articles, $user){
        $gateway = Enum::GATEWAY;
        $content = '';

        foreach ($articles as $article){
            if($article->type == Enum::INSERT) {
                $content .= "<a href='{$gateway}?aid={$article->id}&mid={$article->mail_id}&uid={$user->id}'>{$article->title}</a><br>";

            }else if($article->type == Enum::DELETE){
                $content .= "<strike>{$article->title}</strike><br>";
            }
        }

        return $content;
    }

    public function send($articles, $user){

        $content = $this->makeContent($articles, $user);

        $data = array(
            'autotype' => Enum::AUTOTYPE,
            'cmpncode' => Enum::CMPNCODE,
            'sender_email' => Enum::SENDER_MAIL,
            'use_event_solution' => Enum::USE_EVENT_SOLUTION,
            'email' => $user->email,
            'title' => date("Y/m/d").'사람인 기사',
            'replace15' => $content
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, Enum::MAIL_REQUEST_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response =  curl_exec($ch);
        $result = json_decode($response);

        return $result->code;
    }

    public function sendMail()
    {

        $now = now();
        $users = $this->user_repository->index();

        if(empty($users)){
            return;
        }



        foreach($users as $user){

            $access_time = !empty($user->time)?$user->time:"10:00";
            $access_time = date("Y-m-d H:i:s", strtotime($access_time));

            if($now < $access_time){
                continue;
            }

            $mail = $this->mail_content_repository->selectLatest();
            $articles = $this->mail_content_repository->selectArticles($mail->id);

            $result = $this->send($articles, $user);

            $success = 'Y';

            if($result != 200){
                $success = 'N';
                $this->telegram_service->sendMailErrorMessage($result, $user->email);
            }

            $this->mail_history_repository
                ->store([
                    'user_id' => $user->id,
                    'mail_id' => $mail->id,
                    'success' => $success
                ]);

        }
    }
}
