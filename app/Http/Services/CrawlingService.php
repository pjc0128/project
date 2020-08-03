<?php


namespace App\Http\Services;


use App\Http\Controllers\Snoopy;
use App\Http\Enum;
use App\Repositories\ArticleHistoryInterface;
use App\Repositories\ArticleInterface;
use App\Repositories\MailArticleRelationInterface;
use App\Repositories\MailContentInterface;
use App\Repositories\UserInterface;

class CrawlingService
{
    private $snoopy;
    private $article_repository;
    private $article_history_repository;
    private $mail_content_repository;
    private $mail_article_relation_repository;
    private $user_repository;

    public function __construct(ArticleInterface $article_repository,
                                ArticleHistoryInterface $article_history_repository,
                                MailContentInterface $mail_content_repository,
                                MailArticleRelationInterface $mail_article_relation_repository,
                                UserInterface $user_repository,
                                Snoopy $snoopy)
    {
        $this->article_repository = $article_repository;
        $this->article_history_repository = $article_history_repository;
        $this->mail_content_repository = $mail_content_repository;
        $this->mail_article_relation_repository = $mail_article_relation_repository;
        $this->user_repository = $user_repository;
        $this->snoopy =$snoopy;

    }

    public function crawling($min, $limit)
    {
        $url = Enum::PRE.Enum::KEYWORD;

        $this->snoopy->fetch($url);
        $txt = $this->snoopy->results;

        $textArr = "";
        $rex = '/\<dt\>(.*)\<\/dt\>/';
        preg_match_all($rex, $txt, $textArr);

        $dateArr = "";
        $rex2 = '/\<dd class="article_desc"\>(.*)\<\/dd\>/';
        preg_match_all($rex2, $txt, $dateArr);

        $articles = array();
        $count = 0;

        for ($j = 0; $j < count($textArr[1]) ; $j++) {
            $created_at = strip_tags($dateArr[1][$j]);
            if ($created_at < $min){
                continue;
            }

            array_push($articles, [
                'title'=> strip_tags($textArr[1][$j]),
                'url' => preg_replace('/<a href="([^"]+)">.+/', '$1', $textArr[1][$j])
            ]);

            $count++;

            if($count >= $limit){
                return $articles;
            }
        }
        return $articles;
    }

    public function crawlingArticle(){
        $dateTime  = new \DateTime("-1 day");
        $min = $dateTime->setTime(9, 0)->format('Y-m-d-H-i-s');

        $limit = Enum::ARTICLE_LIMIT;

        $articles = $this->crawling($min, $limit);

        if(empty($articles)){
            return;
        }

        $total = $this->user_repository->countUsers()->count;
        $mail_content_id = $this->mail_content_repository->store($total)->id;

        foreach ($articles as $article) {

            $article_id = $this->article_repository->store($article)->id;

            $article_history_id = $this->article_history_repository
                ->store([
                    'article_id' => $article_id,
                    'type' => Enum::INSERT
                ])
                ->id;

            $this->mail_article_relation_repository
                ->store([
                    'mail_id' => $mail_content_id,
                    'article_history_id' =>$article_history_id
                ]);
        }
    }

    public function checkDelete($url)
    {
        $url = Enum::PRE.$url;

        $this->snoopy->fetch($url);
        $txt = $this->snoopy->results;

        $check = null;
        $rex = '/기사가 존재하지 않습니다/';
        preg_match($rex, $txt, $check);

        if($check == null){
            return false;
        }

        return true;
    }

    public function updateForm(){
        $total = $this->user_repository->countUsers()->count;
        $mail_content_id = $this->mail_content_repository->store($total)->id;

        $latest_histories = $this->article_history_repository->selectLatestHistory();

        foreach ($latest_histories as $lh){
            $this->mail_article_relation_repository
                ->store([
                    'mail_content_id' => $mail_content_id,
                    'article_history_id' =>$lh->id
                ]);
        }
    }

    public function checkArticle(){

        $mail = $this->mail_content_repository->selectLatest();
        $old_articles = $this->mail_content_repository->selectArticles($mail->id);

        $deleted = false;

        foreach ($old_articles as $article) {

            if (!$this->checkDelete($article->url)) {
                continue;
            }

            $deleted = true;

            $this->article_history_repository
                ->store([
                    'article_id' => $article->id,
                    'type' => Enum::DELETE
                ]);
        }

        if($deleted){
            $this->updateForm();
        }
    }
}
