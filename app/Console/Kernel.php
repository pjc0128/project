<?php

namespace App\Console;

use App\Article;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Clawler;
use App\Http\Controllers\MailContentController;
use App\Http\Controllers\TestMailController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
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
         * 24시간 이내 기사만
         */
        //9시 크롤링
        $schedule->call(function(){
            $c = new Clawler();
            $articles = $c->clawling();

            $mcc = new MailContentController();
            $mail_request = new Request();
            $mail_request->setMethod('POST');
            $mail_request->request->add(['type'=>'D']);

            $last_index = $mcc->store($mail_request);

            $ac = new ArticleController();
            foreach ($articles as $article){
                $article_request = new Request();
                $article_request->setMethod('POST');
                $article_request->request->add(['title'=>$article['title'],
                                                'url'=>$article['url'],
                                                'mail_content_id'=>$last_index
                ]);
                $ac->store($article_request);
            }
        })->at('9:00');


        //매 분 확인
//        $schedule->call(function (){
//            //$test = App\User::All();
//
//            Log::info('test!@#!@#!@');
//            Log::info("test");
//            Log::warning("test");
//            Log::info("현재 날짜 : ". date("Y-m-d-H-i-s")."<br/>");
//        })->everyMinute();

//메일 테스트
        $schedule->call(function (){
            $email ='pjc0128@naver.com';
            $articles = Article::all();

            $mc = new TestMailController();

            $response = $mc->sendMail($articles, $email);

            if($response->code == 200){

            }else{

            }



        })->everyMinute();



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
