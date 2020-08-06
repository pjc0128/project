<?php


namespace App\Http\Services;

use App\Repositories\AccessHistoryInterface;
use App\Repositories\ArticleInterface;
use App\Repositories\MailContentInterface;
use App\Repositories\MailHistoryInterface;


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
        return [
            'mail_contents' => $this->mail_content_repository->selectMailContents()
        ];
    }

    public function detail($mail_id)
    {

        return [
            'mail_histories' => $this->mail_history_repository->selectMailHistories($mail_id),
            'articles' => $this->mail_content_repository->selectArticles($mail_id)
        ];
    }

    public function chart()
    {
        return [
            'daily_mail_history' => $this->mail_history_repository->selectDailyMailHistory(),
            'hourly_access_history' => $this->access_history_repository->selectHourlyHistory(),
            'daily_article' => $this->article_repository->selectDailyArticle()
        ];
    }

    public function article()
    {
        return[
            'articles' => $this->article_repository->selectLatestArticles()
        ];

    }
}
