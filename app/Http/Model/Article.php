<?php

namespace App\Http\Model;

use App\Http\Controllers\ArticleHistoryController;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'url'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function article_histories(){

        return $this->hasMany(ArticleHistory::class);
    }
}
