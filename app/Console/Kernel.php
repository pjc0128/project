<?php

namespace App\Console;

use App\Article;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleHistoryController;
use App\Http\Controllers\Clawler;
use App\Http\Controllers\MailArticleRelationController;
use App\Http\Controllers\MailContentController;
use App\Http\Controllers\MailHistoryController;
use App\Http\Controllers\TestMailController;
use App\Http\Controllers\UserController;
use App\User;
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
         */
        //9시 크롤링
        $schedule->call(function (){
            $c = new Clawler();
            $ac = new ArticleController();
            $ahc = new ArticleHistoryController();
            $mcc = new MailContentController();
            $marc = new MailArticleRelationController();


            $count = 0;
            $mail_content_id = 0;

            $articles = $c->clawling();

            $min = date("Y-m-d-H-i-s", strtotime("-1 day"));

            foreach ($articles as $article){
                $date = date("Y-m-d-H-i-s", strtotime($article['date']));

                if($date > $min){
                    if($mail_content_id == 0){
                        $mail_content_id = $mcc->store();
                    }

                    $article_id = $ac->store($article);

                    $article_history = (['article_id' => $article_id,
                                         'type' => 'I']);

                    $article_history_id = $ahc->store($article_history);

                    $marc->store($mail_content_id, $article_history_id);

                    $count++;
                }

                if($count>=10){
                    return;
                }
            }
        })->at("9:00");

//        $schedule->call(function (){
//            $ac = new ArticleController();
//            $uc = new UserController();
//            $mc = new TestMailController();
//            $mhc = new MailHistoryController();
//            $mcc = new MailContentController();
//
//
//            $now = now();
//            $users = $uc->index();
//
//            foreach($users as $user){
//
//                if($user->time == null){
//                    $user->time = "10:00:00";
//                }
//
//                if($now > $user->time){
//                    $mail = $mcc->selectLatest();
//
//                    $email = $user->email;
//
//                    $articles = $ac->selectArticles($mail->mail_id);
//
//                    $result = $mc->sendMail($articles, $email);
//
//                    $success = 'N';
//
//                    if($result == 200){
//                        $success = 'Y';
//                    }else{
//                        /**텔레그램 발송 추가 **/
//
//                    }
//
//                    $mail_history = ([
//                        'user_id' => $user->id,
//                        'mail_id' => $mail->mail_id,
//                        'success' => $success
//                    ]);
//
//                    $mhc->store($mail_history);
//                }
//            }
//        })->everyMinute();

        $schedule->call(function (){
            $ac = new ArticleController();
            $c = new Clawler();
            $ahc = new ArticleHistoryController();

            $articles = $ac->selectLatestArticle();

            foreach ($articles as $article){
                $check = $c->checkDelete($article);

                if($check){
                    $article_history = ([
                        'article_id' => $article->id,
                        'type' => 'D'
                        ]);

                    $ahc->store($article_history);
                }
            }


        })->everyMinute();
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
