<?php

namespace App;

use App\Http\Controllers\ArticleHistoryController;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'url'];

    public function article_histories(){

        return $this->hasMany(ArticleHistory::class);
    }
}
