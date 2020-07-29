<?php


namespace App\Http\Services;


use App\Http\Controllers\Snoopy;
use App\Repositories\ArticleHistoryInterface;
use App\Repositories\ArticleInterface;
use App\Repositories\MailArticleRelationInterface;
use App\Repositories\MailContentInterface;
use Illuminate\Support\Facades\Log;

class CrawlingService
{
    private $snoopy;
    private $article_repository;
    private $article_history_repository;
    private $mail_content_repository;
    private $mail_article_relation_repository;


    public function __construct(ArticleInterface $article_repository,
                                ArticleHistoryInterface $article_history_repository,
                                MailContentInterface $mail_content_repository,
                                MailArticleRelationInterface $mail_article_relation_repository,
                                Snoopy $snoopy)
    {
        $this->article_repository = $article_repository;
        $this->article_history_repository = $article_history_repository;
        $this->mail_content_repository = $mail_content_repository;
        $this->mail_article_relation_repository = $mail_article_relation_repository;
        $this->snoopy =$snoopy;

    }

    public function crawling()
    {
        $url = "http://edu.donga.com/?p=article&search=top&stx=%EC%B7%A8%EC%97%85";

        $this->snoopy->fetch($url);
        $txt = $this->snoopy->results;

        $urlArr = "";
        $rex = '/\<dt\>(.*)\<\/dt\>/';
        preg_match_all($rex, $txt, $urlArr);

        $dateArr = "";
        $rex2 = '/\<dd class="article_desc"\>(.*)\<\/dd\>/';
        preg_match_all($rex2, $txt, $dateArr);


        $articles = array();

        for ($j = 0; $j < count($urlArr[1]); $j++) {
            $articles[$j] = ['title'=> strip_tags($urlArr[1][$j]),
                'url' => preg_replace('/<a href="([^"]+)">.+/', '$1', $urlArr[1][$j]),
                'date' => strip_tags($dateArr[1][$j])];
        }
        return $articles;
    }

    public function crawlingArticle(){
        $mail_content_id = null;
        $min = date("Y-m-d-H-i-s", strtotime("-1 day"));

        $articles = $this->crawling();

        if(!empty($articles)) {
            $mail_content_id = $this->mail_content_repository->store();
        }else{
            return;
        }

        foreach ($articles as $article) {
            $created_at = date("Y-m-d-H-i-s", strtotime($article['date']));

            if ($created_at > $min) {

                $article_id = $this->article_repository->store($article);

                $article_history_id = $this->article_history_repository
                    ->store((['article_id' => $article_id,
                        'type' => 'I'])
                    );

                $this->mail_article_relation_repository
                    ->store($mail_content_id, $article_history_id);

            }
        }
    }

    public function checkDelete($url)
    {
        $url = "http://edu.donga.com".$url;

        $deleted = false;

        $this->snoopy->fetch($url);
        $txt = $this->snoopy->results;

        $check = null;
        $rex = '/기사가 존재하지 않습니다/';
        preg_match($rex, $txt, $check);


        if($check != null){
            $deleted = true;
        }

//        if(!@fopen($url, "r")){
//
//        }else{
//
//        }
//
        return $deleted;
    }

    public function checkArticle(){

        $mail = $this->mail_content_repository->selectLatest();
        $old_articles = $this->article_repository->selectArticles($mail->id);

        Log::info('oldArticles : '.$old_articles );

        $check = false;
        $mail_content_id = 0;

        foreach ($old_articles as $article) {

            $deleted = $this->checkDelete($article->url);

            if ($deleted) {
                $check = true;

                $this->article_history_repository->store(([
                    'article_id' => $article->id,
                    'type' => 'D'
                ]));
            }
        }

        if($check){
            if($mail_content_id == 0){
                $mail_content_id = $this->mail_content_repository->store();
            }

            $latest_histories = $this->article_history_repository->selectLatestHistory();

            foreach ($latest_histories as $lh){
                $this->mail_article_relation_repository->store($mail_content_id, $lh->id);
            }
        }
    }
}
