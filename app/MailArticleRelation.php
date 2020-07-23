<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailArticleRelation extends Model
{
    public function article_history(){

        return $this->belongsTo(ArticleHistory::class);
    }

    public function mail_history(){

        return $this->belongsTo(MailContent::class);
    }
}
