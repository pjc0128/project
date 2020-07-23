<?php

namespace App\Http\Controllers;

use App\ArticleHistory;
use Illuminate\Http\Request;

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
}
