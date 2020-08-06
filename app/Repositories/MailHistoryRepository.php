<?php

namespace App\Repositories;

use App\Http\Model\MailHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class MailHistoryRepository implements MailHistoryInterface
{
    protected $fillable = ['mail_id', 'user_id', 'success'];

    private $mail_history;

    public function __construct(MailHistory $mail_history)
    {
        $this->mail_history = $mail_history;
    }

    public function store($mail_history)
    {
        $this->mail_history
            ->create([
                'mail_id' => $mail_history['mail_id'],
                'user_id' => $mail_history['user_id'],
                'success' => $mail_history['success']
            ]);
    }

    public function show($mid, $uid)
    {
        return $this->mail_history
            ->where('mail_histories.mail_id', $mid)
            ->where('mail_histories.user_id', $uid)
            ->first();
    }

    public function selectMailHistories($mail_id)
    {
        return $this->mail_history
            ->select(
                'users.email'
                , 'mail_histories.created_at as send_time'
                , 'access_histories.created_at as access_time')
            ->join('users', 'users.id', '=', 'mail_histories.user_id')
            ->leftJoin('access_histories', 'access_histories.mail_history_id', '=', 'mail_histories.id')
            ->where('mail_histories.mail_id', '=', $mail_id)
            ->orderBy('access_histories.created_at', 'desc')
            ->paginate(10);;
    }


    public function selectDailyMailHistory()
    {
        return $this->mail_history
            ->select(
                DB::raw("EXTRACT(DAY FROM mail_histories.created_at) as day"),
                DB::raw("COUNT(if(mail_histories.success = 'Y', mail_histories.success, null)) as success"),
                DB::raw("COUNT(if(mail_histories.success = 'N', mail_histories.success, null)) as fail"))
            ->groupBy(DB::raw("EXTRACT(DAY FROM mail_histories.created_at)"))
            ->get();
    }

    public function selectHourlyMailHistory()
    {
        return $this->mail_history
            ->select(
                DB::raw("EXTRACT(HOUR FROM mail_histories.created_at) as hour"),
                DB::raw("COUNT(*) as count"))
            ->groupBy(DB::raw("EXTRACT(HOUR FROM mail_histories.created_at)"))
            ->get();
    }
}
