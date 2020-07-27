<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleHistoryController extends Controller
{
    public function store($_article_history){
        $article_history = ArticleHistory::create([
            'article_id' => $_article_history['article_id'],
            'type' => $_article_history['type'],
            'created_at' => now()
        ]);

        return $article_history->id;
    }

    public function selectLatestHistory(){
        $values = DB::table('article_histories')
            ->select(DB::raw("concat(article_histories.article_id,'.', MAX(article_histories.id))"))
            ->groupBy('article_histories.article_id');

        $latest_history = ArticleHistory::select('article_histories.id'
                , 'article_histories.article_id'
                , 'article_histories.type'
                , 'article_histories.created_at')
            ->whereIn(DB::raw("concat(article_histories.article_id, '.' , article_histories.id)"), $values)
            ->where(DB::raw('DATE(article_histories.created_at)'), '=', DB::raw('DATE(NOW())'))
            ->get();

        return $latest_history;
    }
}
