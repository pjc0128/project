<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleHistory extends Model
{
    public function article(){

        return $this->belongsTo(Article::class);
    }

    public function article_histories(){

        return $this->hasMany(ArticleHistory::class);
    }


}
