<?php


namespace App\Http\Controllers;




use Illuminate\Support\Facades\Log;

class DashboardService
{
    private $mail_content_controller;
    private $mail_history_controller;
    private $article_controller;

    public function __construct(MailContentController $mail_content_controller
                              , MailHistoryController $mail_history_controller
                              , ArticleController $article_controller){

        $this->mail_content_controller = $mail_content_controller;
        $this->mail_history_controller = $mail_history_controller;
        $this->article_controller = $article_controller;

    }

    public function index()
    {
        $mail_contents = $this->mail_content_controller->selectMailContents();

        $result = [
            'mail_contents' => $mail_contents
        ];

        return $result;
    }

    public function detail($mail_id)
    {
        $articles = $this->article_controller->selectArticles($mail_id);

        Log::info('articles : '.$articles);

        $mail_histories = $this->mail_history_controller->selectMailHistories($mail_id);
        Log::info('histories : '.$mail_histories);


        $result = [
            'mail_histories' => $mail_histories,
            'articles' => $articles
        ];

        return $result;
    }
}
