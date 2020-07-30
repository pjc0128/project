<?php

namespace App\Repositories;

use App\Http\Model\AccessHistory;
use App\Repositories\AccessHistoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccessHistoryRepository implements AccessHistoryInterface
{
    private $access_history;

    public function __construct(AccessHistory $access_history){
        $this->access_history = $access_history;
    }

    public function store($mail_history_id){
        $this->access_history
            ->create([
                'mail_history_id' => $mail_history_id
            ]);
    }

    public function selectDailyHistory()
    {
        //select EXTRACT(HOUR FROM created_at), count(*)
        //from access_histories
        //group by EXTRACT(HOUR FROM created_at);

        $daily_access_history = $this->access_history
            ->select(
                DB::raw("EXTRACT(DAY FROM access_histories.created_at) as day"),
                DB::raw("COUNT(*) as count"))
            ->groupBy(DB::raw("EXTRACT(DAY FROM access_histories.created_at)"))
            ->get();

        return $daily_access_history;
    }
}
