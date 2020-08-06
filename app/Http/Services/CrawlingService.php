<?php


namespace App\Http\Services;


use App\Exceptions\CrawlingFailException;
use App\Http\Controllers\Snoopy;
use App\Repositories\ArticleHistoryInterface;
use App\Repositories\ArticleInterface;
use App\Repositories\MailArticleRelationInterface;
use App\Repositories\MailContentInterface;
use App\Repositories\UserInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CrawlingService
{
    private $snoopy;
    private $article_repository;
    private $article_history_repository;
    private $mail_content_repository;
    private $mail_article_relation_repository;
    private $user_repository;
    private $telegram_service;

    public function __construct(ArticleInterface $article_repository,
                                ArticleHistoryInterface $article_history_repository,
                                MailContentInterface $mail_content_repository,
                                MailArticleRelationInterface $mail_article_relation_repository,
                                UserInterface $user_repository,
                                TelegramService $telegram_service,
                                Snoopy $snoopy)
    {
        $this->article_repository = $article_repository;
        $this->article_history_repository = $article_history_repository;
        $this->mail_content_repository = $mail_content_repository;
        $this->mail_article_relation_repository = $mail_article_relation_repository;
        $this->user_repository = $user_repository;
        $this->telegram_service = $telegram_service;
        $this->snoopy = $snoopy;

    }

    public function crawling($min, $limit)
    {
        $url = getenv('PRE') . getenv('KEYWORD');

        $this->snoopy->fetch($url);
        $txt = $this->snoopy->results;

        $textArr = "";
        $rex = '/\<dt\>(.*)\<\/dt\>/';
        preg_match_all($rex, $txt, $textArr);

        $dateArr = "";
        $rex2 = '/\<dd class="article_desc"\>(.*)\<\/dd\>/';
        preg_match_all($rex2, $txt, $dateArr);

        if (!$textArr) {
            throw new Exception();
        }

        $articles = array();
        $count = 0;

        for ($j = 0; $j < count($textArr[1]); $j++) {
            $created_at = strip_tags($dateArr[1][$j]);

            if ($created_at < $min) {
                continue;
            }

            array_push($articles, [
                'title' => strip_tags($textArr[1][$j]),
                'url' => preg_replace('/<a href="([^"]+)">.+/', '$1', $textArr[1][$j])
            ]);

            $count++;

            if ($count >= $limit) {
                return $articles;
            }
        }
        return $articles;
    }

    public function checkArticle($url)
    {
        $url = getenv('PRE') . $url;

        $this->snoopy->fetch($url);
        $txt = $this->snoopy->results;

        $check = null;
        $rex = '/기사가 존재하지 않습니다/';
        preg_match($rex, $txt, $check);

        if ($check == null) {
            return false;
        }

        return true;
    }

    public function createMailContent()
    {
        $total = $this->user_repository->countUsers()->count;
        return $this->mail_content_repository->store($total)->id;
    }

    public function createMailArticleRelation($mail_content_id, $article_history_id)
    {
        $this->mail_article_relation_repository
            ->store([
                'mail_content_id' => $mail_content_id,
                'article_history_id' => $article_history_id
            ]);
    }

    public function createArticleHistory($article_id, $type)
    {
        return $this->article_history_repository
            ->store([
                'article_id' => $article_id,
                'type' => $type
            ])
            ->id;
    }


    public function updateForm()
    {
        $mail_content_id = $this->createMailContent();
        $latest_histories = $this->article_history_repository->selectLatestHistory();

        foreach ($latest_histories as $latest_history) {
            $this->createMailArticleRelation($mail_content_id, $latest_history->id);
        }
    }

    public function crawlingArticle()
    {
        $dateTime = new \DateTime("-1 day");
        $min = $dateTime->setTime(9, 0)->format('Y-m-d H:i:s');

        $articles = null;

        try {
            $articles = $this->crawling($min, getenv('ARTICLE_LIMIT'));
        } catch (Exception $e) {
            $this->telegram_service->crawlingErrorMessage();
        }

        if (empty($articles)) {
            return;
        }

        $mail_content_id = $this->createMailContent();

        foreach ($articles as $article) {
            DB::beginTransaction();

            try {
                $article_id = $this->article_repository->store($article)->id;
                $article_history_id = $this->createArticleHistory($article_id, getenv('INSERT'));
                $this->createMailArticleRelation($mail_content_id, $article_history_id);
            } catch (Exception $e) {
                DB::rollBack();
            }
        }
        DB::commit();
    }

    public function checkDelete()
    {

        $mail = $this->mail_content_repository->selectLatest();
        $old_articles = $this->mail_content_repository->selectArticles($mail->id);

        $deleted = false;

        foreach ($old_articles as $article) {

            if (!$this->checkArticle($article->url)) {
                continue;
            }

            $deleted = true;
            $this->createArticleHistory($article->id, getenv('DELETE'));
        }

        if ($deleted) {
            $this->updateForm();
        }
    }
}
