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


//        select a.id, a.title, ah.type, mar.mail_id
//            from articles a
//            join (select  id, article_id, type
//                  from article_histories
//                  where (id, article_id) in (select max(id) as id, article_id
//                                             from article_histories ah
//                                             group by article_id))ah on (a.id = ah.article_id)
//            join mail_article_relations mar on(mar.article_history_id = ah.id)
//            where mar.mail_id = $mail_id

        $values = DB::table('article_histories')
                              ->select(DB::raw('MAX(article_histories.id) as id')
                                     , 'article_histories.article_id'
                                     , DB::raw("concat(article_histories.article_id,'.', MAX(article_histories.id)) as temp"))
                              ->groupBy('article_histories.article_id');

        Log::info($values);

        $latest_history = DB::table('article_histories')
                              ->select('article_histories.id'
                                      , 'article_histories.article_id'
                                      , 'article_histories.type'
                                      , DB::raw("concat(article_histories.id, '.' , article_histories.type)) as temp"))
                              ->whereIn('temp', $values);







//        Log::info($latest_history);

//        $articles = Article::select('article.id'
//                                  , 'article.title'
//                                  , 'article_histories.type')
//                            ->subJon()
//
//        return $articles;
    }
}
