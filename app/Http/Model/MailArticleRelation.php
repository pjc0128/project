<?php

namespace App\Http\Model;


use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class MailArticleRelation extends Model
{
    protected $fillable = ['mail_id', 'article_history_id'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function article_history()
    {
        return $this->belongsTo(ArticleHistory::class);
    }

    public function mail_history()
    {
        return $this->belongsTo(MailContent::class);
    }
}
