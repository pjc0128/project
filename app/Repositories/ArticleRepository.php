<?php

namespace App\Repositories;


use App\Http\Model\Article;
use App\Http\Model\ArticleHistory;
use App\Dummy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleRepository implements ArticleInterface
{
    private  $article;

    public function __construct(Article $article){

        $this->article = $article;

    }

    public function show($article_id){

        return $this->article
            ->where('articles.id', '=', $article_id)
            ->first();
    }

    public function store($_article)
    {

        return $this->article->
        create([
            'title' => $_article['title'],
            'url' => $_article['url'],
            'created_at' => now()
        ]);
    }

    public function selectLatestArticles(){
        $values =
            DB::table('article_histories')
                ->select(DB::raw("concat(article_histories.article_id,'.', MAX(article_histories.id))"))
                ->groupBy('article_histories.article_id');

        $latest_history =
            DB::table('article_histories')
                ->select(
                    'article_histories.id'
                    , 'article_histories.article_id'
                    , 'article_histories.type')
                ->whereIn(DB::raw("concat(article_histories.article_id, '.' , article_histories.id)"), $values);

            return $this->article
                ->select(
                    'articles.id'
                    , 'articles.title'
                    , 'articles.url'
                    , 'ah.type'
                    , 'mar.mail_id')
                ->joinSub($latest_history, 'ah', function($join){
                    $join->on('ah.article_id', '=', 'articles.id');
                })
                ->join('mail_article_relations as mar', 'mar.article_history_id', '=', 'ah.id')
                /*->where('mar.mail_id', '=' ,$mail_id)*/
                ->get();
    }

    public function selectDailyArticle()
    {
        return $this->article
            ->select(
                DB::raw("EXTRACT(DAY FROM articles.created_at) as day"),
                DB::raw("COUNT(*) as count"))
            ->groupBy(DB::raw("EXTRACT(DAY FROM articles.created_at)"))
            ->get();
    }


}
