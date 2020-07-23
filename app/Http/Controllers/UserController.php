<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(){
//            select u.id, u.email, u.name, sec_to_time(avg(time_to_sec(ah.created_at))) as time
//            from users u
//            left join mail_histories mh on (mh.user_id = u.id)
//            left join (select mail_history_id, created_at
//                       from access_histories
//            where created_at > DATE_SUB(SYSDATE(), INTERVAL 7 DAY)) ah on (ah.mail_history_id = mh.id)
//            group by u.id;
        $users = User::select('users.id', 'users.email', 'users.name', DB::raw('sec_to_time(avg(time_to_sec(ah.created_at))) as time'))
            ->leftJoin('mail_histories as mh', 'mh.user_id', '=', 'users.id')
            ->leftJoin('access_histories as ah', 'ah.mail_history_id', '=', 'mh.id')
            ->where('ah.created_at', '>', DB::raw('DATE_SUB(SYSDATE(), INTERVAL 7 DAY)'))
            ->groupBy('users.id')
            ->get();

        return $users;
    }
}
