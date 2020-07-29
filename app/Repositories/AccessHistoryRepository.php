<?php

namespace App\Repositories;

use App\Http\Model\AccessHistory;
use App\Repositories\AccessHistoryInterface;
use Illuminate\Http\Request;

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
}
