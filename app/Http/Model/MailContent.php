<?php

namespace App\Http\Model;


use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class MailContent extends Model
{
    protected $fillable = ['total'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function mail_article_relations(){

        return $this->hasMany(MailArticleRelation::class);
    }

    public function mail_histories(){

        return $this->hasMany(MailHistory::class);
    }
}
