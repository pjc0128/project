<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailContent extends Model
{
    protected $fillable = ['total'];

    public function mail_article_relations(){

        return $this->hasMany(MailArticleRelation::class);
    }

    public function mail_histories(){

        return $this->hasMany(MailHistory::class);
    }
}
