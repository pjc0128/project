<?php


namespace App\Http\Controllers;

use App\Repositories\AccessHistoryInterface;
use App\Repositories\ArticleInterface;
use App\Repositories\MailContentInterface;
use App\Repositories\MailHistoryInterface;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    private $mail_content_repository;
    private $mail_history_repository;
    private $article_repository;
    private $access_history_repository;

    public function __construct(MailContentInterface $mail_content_repository
                              , MailHistoryInterface $mail_history_repository
                              , ArticleInterface $article_repository
                              , AccessHistoryInterface $access_history_repository){

        $this->mail_content_repository = $mail_content_repository;
        $this->mail_history_repository = $mail_history_repository;
        $this->article_repository = $article_repository;
        $this->access_history_repository = $access_history_repository;
    }

    public function index()
    {
        $mail_contents = $this->mail_content_repository->selectMailContents();

        $result = [
            'mail_contents' => $mail_contents
        ];

        return $result;
    }

    public function detail($mail_id)
    {
        $articles = $this->article_repository->selectArticles($mail_id);

        Log::info('articles : '.$articles);

        $mail_histories = $this->mail_history_repository->selectMailHistories($mail_id);
        Log::info('histories : '.$mail_histories);


        $result = [
            'mail_histories' => $mail_histories,
            'articles' => $articles
        ];

        return $result;
    }

    public function chart()
    {
//        //메일 성공 / 실패
//        select EXTRACT(DAY FROM created_at)
//    , count(if(success = 'Y', success, null)) as success

//    , count(if(success = 'N', success, null)) as success
//from mail_histories
//group by EXTRACT(DAY FROM created_at);

////시간대별 메일 발송 현황
//select EXTRACT(HOUR FROM created_at), count(*)
//from mail_histories
//group by EXTRACT(HOUR FROM created_at);

////메일 시간대별 유입 현황
//select EXTRACT(HOUR FROM created_at), count(*)
//from access_histories
//group by EXTRACT(HOUR FROM created_at);
//
////등록 기사 수
//select EXTRACT(DAY FROM created_at), count(*)
//from articles
//group by EXTRACT(DAY FROM created_at);
        //메일 성공 / 실패

        //메일 시간대별 발송

        //메일 시간대별 유입시간

        //등록 기사 수

        return null;
    }
}
