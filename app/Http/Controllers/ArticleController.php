<?php

namespace App\Http\Controllers;


use App\Article;
use App\ArticleHistory;
use App\Dummy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{

    protected $articles;



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($_article)
    {
        $article = Article::create([
           'title' => $_article['title'],
            'url' => $_article['url'],
            'created_at' => now()
        ]);

        return $article->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function selectArticles($id)
    {
        $values = DB::table('article_histories')
                              ->select(DB::raw("concat(article_histories.article_id,'.', MAX(article_histories.id))"))
                              ->groupBy('article_histories.article_id');

        $latest_history = DB::table('article_histories')
                              ->select('article_histories.id'
                                      , 'article_histories.article_id'
                                      , 'article_histories.type')
                              ->whereIn(DB::raw("concat(article_histories.id, '.' , article_histories.article_id)"), $values);

        $articles = Article::select('articles.id'
                                  , 'articles.title'
                                  , 'ah.type'
                                  , 'mar.mail_id')
                             ->joinSub($latest_history, 'ah', function($join){
                                 $join->on('ah.article_id', '=', 'articles.id');
                             })
                             ->join('mail_article_relations as mar', 'mar.article_history_id', '=', 'ah.id')
                             ->where('mar.mail_id', '=' ,$id)
                             ->get();

        return $articles;
    }

    public function selectLatestArticle(){
//        select *
//        from articles
//        where  DATE(created_at) = DATE_SUB(curdate(), INTERVAL 1 DAY);

        $articles = Article::where(DB::raw('DATE(articles.created_at)'), DB::raw('DATE_SUB(curdate(), INTERVAL 1 DAY)'))
                             ->get();
        Log::info($articles);
    }
}
