<?php

namespace App\Http\Controllers;

use App\MailArticleRelation;
use Illuminate\Http\Request;

class MailArticleRelationController extends Controller
{
    public function store($mail_id, $article_history_id){
        MailArticleRelation::create([
            'mail_id' => $mail_id,
            'article_history_id' =>$article_history_id
        ]);
    }
}
