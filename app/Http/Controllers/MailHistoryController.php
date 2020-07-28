<?php

namespace App\Http\Controllers;

use App\MailHistory;
use Illuminate\Http\Request;

class MailHistoryController extends Controller
{
    protected $fillable = ['mail_id', 'user_id', 'success'];

    public function store($mail_history){
        MailHistory::create([
            'mail_id' => $mail_history['mail_id'],
            'user_id' => $mail_history['user_id'],
            'success' => $mail_history['success']
        ]);
    }

    public function show($mid, $uid)
    {
        $mail_history = MailHistory::where('mail_histories.mail_id', $mid)
                                    ->where('mail_histories.user_id', $uid)
                                    ->first();

        return $mail_history;
    }


}
