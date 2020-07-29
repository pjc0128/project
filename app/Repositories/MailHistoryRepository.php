<?php

namespace App\Repositories;

use App\Http\Model\MailHistory;

class MailHistoryRepository implements MailHistoryInterface
{
    protected $fillable = ['mail_id', 'user_id', 'success'];

    private $mail_history;

    public function __construct(MailHistory $mail_history){

        $this->mail_history = $mail_history;

    }

    public function store($mail_history){
        $this->mail_history
            ->create([
                'mail_id' => $mail_history['mail_id'],
                'user_id' => $mail_history['user_id'],
                'success' => $mail_history['success']
            ]);
    }

    public function show($mid, $uid)
    {
        $mail_history = $this->mail_history
            ->where('mail_histories.mail_id', $mid)
            ->where('mail_histories.user_id', $uid)
            ->first();

        return $mail_history;
    }

    public function selectMailHistories($mail_id)
    {
        $mail_histories = $this->mail_history
            ->select('users.email'
                   , 'mail_histories.created_at as send_time'
                   , 'access_histories.created_at as access_time')
            ->join('users', 'users.id', '=', 'mail_histories.user_id')
            ->leftJoin('access_histories', 'access_histories.mail_history_id', '=', 'mail_histories.id')
            ->where('mail_histories.mail_id', '=', $mail_id)
            ->get();

        return $mail_histories;
    }


}
