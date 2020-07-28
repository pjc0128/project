<?php

namespace App\Http\Model;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class ArticleHistory extends Model
{
    protected $fillable = ['article_id', 'type'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function article(){

        return $this->belongsTo(Article::class);
    }

    public function article_histories(){

        return $this->hasMany(ArticleHistory::class);
    }


}
