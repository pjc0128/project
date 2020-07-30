<?php


namespace App\Http\Services;


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

    public function send($articles, $user){
        $gateway = 'http://127.0.0.1:8000/gateway';
        $url = 'http://crm3.saramin.co.kr/mail_api/automails';
        $autotype = 'A0188';
        $cmpncode = 12031;
        $sender_email = 'pcc2242@saramin.co.kr';
        $use_event_solution = 'y';

        $content = '';
        foreach ($articles as $article){
            //$content .= "<a href='".$pre.$article['url']."'>".$article['title']."</a><br>";

            Log::info("type : ".$article->type);

            if($article->type == 'I') {
                $content .= "<a href='" . $gateway . "?aid=" . $article->id ."&mid=".$article->mail_id."&uid=".$user->id. "'>" . $article->title ."</a><br>";

            }else if($article->type == 'D'){
                $content .= "<strike>$article->title</strike><br>";
            }
        }

        $data = array(
            'autotype' => $autotype,
            'cmpncode' => $cmpncode,
            'sender_email' => $sender_email,
            'use_event_solution' => $use_event_solution,
            'email' => $user->email,
            'title' => date("Y/m/d").'사람인 기사',
            'replace15' => $content
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
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

        $articles = null;

        Log::info('users : '.$users);

        if(empty($users)){
            return;
        }

        foreach($users as $user){

            $access_time = $user->time;

            if($access_time == null){
                $time = "10:00";
            }

            $access_time = date("Y-m-d H:i:s", strtotime($access_time));

            Log::info('now : '.$now);
            Log::info('time : '.$access_time);
            Log::info('check : '.($now > $user->time));

            if($now > $access_time){

                $mail = $this->mail_content_repository->selectLatest();

                if($articles == null) {
                    $articles = $this->article_repository->selectArticles($mail->id);
                }

                Log::info('articles : '.$articles);
                Log::info('user : '. $user);

                $result = $this->send($articles, $user);

                $success = 'N';

                if($result == 200){
                    $success = 'Y';
                }else{
                    $this->telegram_service->sendMailErrorMessage($result, $user->email);
                }

                $this->mail_history_repository
                    ->store($mail_history = ([
                        'user_id' => $user->id,
                        'mail_id' => $mail->id,
                        'success' => $success
                    ]));
            }
        }
    }
}
