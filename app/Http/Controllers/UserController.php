<?php

namespace App\Http\Controllers;

use App\Http\Model\AccessHistory;
use App\Http\Model\MailContent;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{


    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */


    public function index(){
        $access = DB::table('access_histories')
            ->select('access_histories.mail_history_id'
                           , 'access_histories.created_at')
            ->where('access_histories.created_at', '>', DB::raw('DATE_SUB(SYSDATE(), INTERVAL 7 DAY)'));

        $users = User::select('users.id'
                            , 'users.email'
                            , 'users.name'
                            , DB::raw('MAX(mh.mail_id) as max')
                            , DB::raw('sec_to_time(avg(time_to_sec(access_histories.created_at))) as time'))
            ->addSelect(['last_content' => MailContent::select(DB::raw('MAX(mail_contents.id) as last_content'))])
            ->leftJoin('mail_histories as mh', 'mh.user_id', '=', 'users.id')
            ->leftJoinSub($access, 'access_histories', function($join){
                $join->on('access_histories.mail_history_id', '=', 'mh.id');
            })
            ->groupBy('users.id')
            ->havingRaw('max is null || max != last_content')
            ->get();

        return $users;
    }
}
