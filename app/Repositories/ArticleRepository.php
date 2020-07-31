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
        $article = $this->article->where('articles.id', '=', $article_id)
                                 ->first();

        return $article;
    }
    public function store($_article)
    {
        $article = $this->article->
            create([
               'title' => $_article['title'],
                'url' => $_article['url'],
                'created_at' => now()
            ]);

        return $article->id;
    }

    public function selectArticles($mail_id)
    {
// 쿼리변경예정
//        select *
//        from mail_contents mc
//join mail_article_relations mar on (mc.id = mar.mail_id)
//join article_histories ah on (ah.id = mar.article_history_id)
//join articles a on (a.id = ah.article_id)

/*        $articles =
            DB::table('mail_contents as mc')
                ->select(
                    'a.id'
                    , 'a.title'
                    , 'a.url'
                    , 'ah.type'
                    , 'mar.mail_id')
                ->join('mail_article_relations as mar', 'mar.article_history_id', '=', 'mc.id')
                ->join('article_histories as ah', 'ah.id', '=', 'mar.mail_id')
                ->join('articles as a','a.id', '=', 'ah.article_id')
                ->where('mar.mail_id', '=' ,$mail_id)
                ->get();*/

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

        $articles = $this->article
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
            ->where('mar.mail_id', '=' ,$mail_id)
            ->get();

        return $articles;
    }

    public function selectDailyArticle()
    {
        //select EXTRACT(DAY FROM created_at), count(*)
        //from articles
        //group by EXTRACT(DAY FROM created_at);

        $daily_article = $this->article
            ->select(
                DB::raw("EXTRACT(DAY FROM articles.created_at) as day"),
                DB::raw("COUNT(*) as count"))
            ->groupBy(DB::raw("EXTRACT(DAY FROM articles.created_at)"))
            ->get();

        return $daily_article;
    }
}
