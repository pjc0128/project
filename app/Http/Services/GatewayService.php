<?php


namespace App\Http\Services;


use App\Repositories\AccessHistoryInterface;
use App\Repositories\ArticleInterface;
use App\Repositories\MailHistoryInterface;
use Illuminate\Support\Facades\Log;

class GatewayService
{
    private $article_repository;
    private $access_history_repository;
    private $mail_history_repository;

    public  function __construct(ArticleInterface $article_repository,
                                 AccessHistoryInterface $access_history_repository,
                                 MailHistoryInterface $mail_history_repository)
    {
        $this->article_repository = $article_repository;
        $this->access_history_repository = $access_history_repository;
        $this->mail_history_repository = $mail_history_repository;
    }

    public function show($article_id, $mail_id, $user_id)
    {
        $article = $this->article_repository->show($article_id);

        $mail_history = $this->mail_history_repository->show($mail_id, $user_id);

        Log::info($mail_history);

        $this->access_history_repository->store($mail_history->id);

        $result = [
            'article' => $article
        ];

        return $result;
    }
}
