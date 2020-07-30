<?php

namespace App\Repositories;

use App\Http\Model\MailHistory;
use Illuminate\Support\Facades\DB;

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
            ->select(
                'users.email'
                , 'mail_histories.created_at as send_time'
                , 'access_histories.created_at as access_time')
            ->join('users', 'users.id', '=', 'mail_histories.user_id')
            ->leftJoin('access_histories', 'access_histories.mail_history_id', '=', 'mail_histories.id')
            ->where('mail_histories.mail_id', '=', $mail_id)
            ->get();

        return $mail_histories;
    }


    public function selectDailyMailHistory()
    {
        //        select EXTRACT(DAY FROM created_at)
        //          , count(if(success = 'Y', success, null)) as success
        //          , count(if(success = 'N', success, null)) as success
        //        from mail_histories
        //        group by EXTRACT(DAY FROM created_at);
        $daily_mail_history = $this->mail_history
            ->select(
                DB::raw("EXTRACT(DAY FROM mail_histories.created_at) as day"),
                DB::raw("COUNT(if(mail_histories.success = 'Y', mail_histories.success, null)) as success"),
                DB::raw("COUNT(if(mail_histories.success = 'N', mail_histories.success, null)) as fail"))
            ->groupBy(DB::raw("EXTRACT(DAY FROM mail_histories.created_at)"))
            ->get();

        return $daily_mail_history;
    }

    public function selectHourlyMailHistory()
    {
//        select EXTRACT(HOUR FROM created_at), count(*)
//        from mail_histories
//        group by EXTRACT(HOUR FROM created_at);

        $hourlyMailHistory = $this->mail_history
            ->select(
                DB::raw("EXTRACT(HOUR FROM mail_histories.created_at) as hour"),
                DB::raw("COUNT(*) as count"))
            ->groupBy(DB::raw("EXTRACT(HOUR FROM mail_histories.created_at)"))
            ->get();

        return $hourlyMailHistory;
    }
}
