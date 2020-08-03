<?php

namespace App\Repositories;

use App\Http\Model\MailContent;
use App\Http\Model\MailHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MailContentRepository implements MailContentInterface
{
    private $mail_content;

    public function __construct(MailContent $mail_content){
        $this->mail_content = $mail_content;
    }

    public function store($total)
    {
        return $mail_content = $this->mail_content->
        create([
            'total' => $total,
            'created_at' => now()
        ]);
    }

    public function selectLatest(){

        return  $this->mail_content
            ->latest('created_at')
            ->first();
    }

    public function selectArticles($mail_id)
    {
        return $this->mail_content
            ->select(
                'a.id'
                , 'a.title'
                , 'a.url'
                , 'ah.type'
                , 'mar.mail_id')
            ->join('mail_article_relations as mar', 'mar.mail_id', '=', 'mc.id')
            ->join('article_histories as ah', 'ah.id', '=', 'mar.article_history_id')
            ->join('articles as a','a.id', '=', 'ah.article_id')
            ->where('mar.mail_id', '=' ,$mail_id)
            ->get();
    }

    public function selectMailContents(){

        return $this->mail_content
            ->select(
                'mail_contents.id',
                'mail_contents.created_at',
                'mail_contents.total',
                DB::raw("COUNT(if(mail_histories.success = 'Y', mail_histories.success, null)) as success"),
                DB::raw("COUNT(if(mail_histories.success = 'N', mail_histories.success, null)) as fail"))
            ->join('mail_histories', 'mail_histories.mail_id', '=', 'mail_contents.id')
            ->groupBy('mail_histories.mail_id')
            ->orderBy('mail_histories.mail_id', 'desc')
            ->paginate(5);
    }
}
