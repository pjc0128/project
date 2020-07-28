<?php

namespace App\Http\Controllers;

use App\Http\Model\MailContent;
use App\Http\Model\MailHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MailContentController extends Controller
{
    private $mail_content;

    public function __construct(MailContent $mail_content){
        $this->mail_content = $mail_content;
    }

    public function store()
    {
        $mail_content = MailContent::create([
            'created_at' => now()
        ]);

        return $mail_content->id;
    }

    public function selectLatest(){
        $mail_contents = MailContent::latest('created_at')->first();

        return $mail_contents;
    }

    public function selectMailContents(){
        $mail_contents = $this->mail_content->select(
            'mail_contents.id',
            'mail_contents.created_at',
            'mail_contents.total',
            DB::raw("COUNT(if(mail_histories.success = 'Y', mail_histories.success, null)) as success"),
            DB::raw("COUNT(if(mail_histories.success = 'N', mail_histories.success, null)) as fail"))
            ->join('mail_histories', 'mail_histories.mail_id', '=', 'mail_contents.id')
            ->groupBy('mail_histories.mail_id')
            ->get();

        return $mail_contents;
    }
}
