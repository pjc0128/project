<?php

namespace App\Console;

use App\Article;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Clawler;
use App\Http\Controllers\MailContentController;
use App\Http\Controllers\MailHistoryController;
use App\Http\Controllers\TestMailController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */


    protected function schedule(Schedule $schedule)
    {
        /*
         * 트랜젝션처리
         * 시간설정
         */
        //9시 크롤링
        $schedule->call(function(){
            $c = new Clawler();
            $articles = $c->clawling();

            $mcc = null;
            $last_index = 0;
            $count = 0;

            $ac = new ArticleController();

            $min =date("Y-m-d-H-i-s", strtotime("-1 day"));
            foreach ($articles as $article){
                $date = date("Y-m-d-H-i-s", strtotime($article['date']));

                if($date > $min){
                    if($mcc == null){
                        $mcc = new MailContentController();
                        $mail_request = new Request();
                        $mail_request->setMethod('POST');
                        $mail_request->request->add(['type'=>'D']);

                        $last_index = $mcc->store($mail_request);
                    }

                    $article_request = new Request();
                    $article_request->setMethod('POST');
                    $article_request->request->add(['title'=>$article['title'],
                        'url'=>$article['url'],
                        'mail_content_id'=>$last_index
                    ]);

                    $ac->store($article_request);
                    $count++;
                }

                if($count>10){
                    return;
                }
            }
        })->at('9:00');


        //매 분 확인
        /*
         * articles 전부 -> 최근일자
         * 메일발송 전부 -> 발송내역 없는 인원에게
         *
         */
        $schedule->call(function (){
            $now = now();
            $result = DB::select('select u.id, u.email, u.name, sec_to_time(avg(time_to_sec(ah.created_at))) as time
                                        from users u
                                        left join mail_histories mh on (mh.user_id = u.id)
                                        left join access_histories ah on (ah.mail_history_id = mh.id)
                                        group by u.id');
            $mc = null;
            $mhc = null;

            foreach($result as $user){
                if($now > $user->time){
                    $email = $user->email;

                    $articles = Article::all();

                    //mail_id
                    $mail_id = 1;

                    if($mc == null){
                        $mc = new TestMailController();
                    }

                    $result = $mc->sendMail($articles, $email);

                    if($mhc == null){
                        $mhc = new MailHistoryController();
                    }

                    $success = 'N';

                    if($result == 200){
                        $success = 'Y';
                    }else{
                        /**텔레그램 발송 추가 **/

                    }

                    DB::insert('insert into mail_histories (user_id, mail_id, success)
                                      value('.$user->id.', '.$mail_id.', \''.$success.'\')');
                }
            }
        })->everyMinute();

//메일 테스트
        /*
         * guzzle
         */
//        $schedule->call(function (){
//            $email ='pjc0128@naver.com';
//            $articles = Article::all();
//
//            $mc = new TestMailController();
//
//            $result = $mc->sendMail($articles, $email);
//
//            $mh = new MailHistoryController();
//            if($result == 200){
//
//            }else{
//
//            }
//
//
//
//        })->everyMinute();



//        for($db참고내용){

//            $schedule->call()-> dailyAt($db참고내영[1]);
//        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
