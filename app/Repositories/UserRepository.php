<?php

namespace App\Repositories;


use App\Http\Model\MailContent;
use App\Http\Model\User;
use Illuminate\Support\Facades\DB;


class UserRepository implements UserInterface
{
    private $user;

    public function __construct(User $user){

        $this->user = $user;

    }

    public function index(){
        $access = DB::table('access_histories')
            ->select(
                'access_histories.mail_history_id'
                , 'access_histories.created_at')
            ->where('access_histories.created_at', '>', DB::raw('DATE_SUB(SYSDATE(), INTERVAL 7 DAY)'));

        $users = $this->user->
            select(
                'users.id'
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
