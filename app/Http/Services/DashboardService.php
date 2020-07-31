<?php


namespace App\Http\Services;

use App\Repositories\AccessHistoryInterface;
use App\Repositories\ArticleInterface;
use App\Repositories\MailContentInterface;
use App\Repositories\MailHistoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class DashboardService
{
    private $mail_content_repository;
    private $mail_history_repository;
    private $article_repository;
    private $access_history_repository;

    public function __construct(MailContentInterface $mail_content_repository
                              , MailHistoryInterface $mail_history_repository
                              , ArticleInterface $article_repository
                              , AccessHistoryInterface $access_history_repository)
    {

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

        //메일 성공 / 실패
        $daily_mail_history = $this->mail_history_repository->selectDailyMailHistory();

        Log::info('daily_mail_history : '. $daily_mail_history);

        //시간대별 메일 발송 현황
        $hourly_mail_history = $this->mail_history_repository->selectHourlyMailHistory();

        Log::info('hourly_mail_history : '.$hourly_mail_history);

        //메일 시간대별 유입 현황
        $hourly_access_history = $this->access_history_repository->selectDailyHistory();

        Log::info('hourly_access_history : '.$hourly_access_history);

        //등록 기사 수
        $daily_article = $this->article_repository->selectDailyArticle();

        Log::info('daily_article : '. $daily_article);

        $result = [
            'daily_mail_history' => $daily_mail_history,
            'hourly_mail_history' => $hourly_mail_history,
            'hourly_access_history' => $hourly_access_history,
            'daily_article' => $daily_article
        ];

        return $result;
    }
}
