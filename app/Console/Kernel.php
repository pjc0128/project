<?php

namespace App\Console;


use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleHistoryController;
use App\Http\Controllers\Clawler;
use App\Http\Controllers\MailArticleRelationController;
use App\Http\Controllers\MailContentController;
use App\Http\Controllers\MailHistoryController;
use App\Http\Controllers\TestMailController;
use App\Http\Controllers\UserController;
use App\Http\Model\Article;
use App\Http\Model\MailContent;
use App\Http\Model\MailHistory;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mockery\Container;

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
            $ac = new ArticleController(new Article());
            $ahc = new ArticleHistoryController();
            $mcc = new MailContentController(new MailContent());
            $marc = new MailArticleRelationController();


            $count = 0;
            $mail_content_id = 0;

            $articles = $c->clawling();

            $min = date("Y-m-d-H-i-s", strtotime("-1 day"));
            if(!empty($articles)) {
                foreach ($articles as $article) {
                    $date = date("Y-m-d-H-i-s", strtotime($article['date']));

                    if ($date > $min) {
                        if ($mail_content_id == 0) {
                            $mail_content_id = $mcc->store();
                        }

                        $article_id = $ac->store($article);

                        $article_history = (['article_id' => $article_id,
                            'type' => 'I']);

                        $article_history_id = $ahc->store($article_history);

                        $marc->store($mail_content_id, $article_history_id);

                        $count++;
                    }

                    if ($count >= 10) {
                        return;
                    }
                }
            }
        })->at("9:00");


        $schedule->call(function (){
            $ac = new ArticleController(new Article());
            $uc = new UserController();
            $mc = new TestMailController();
            $mhc = new MailHistoryController(new MailHistory());
            $mcc = new MailContentController(new MailContent());


            $now = now();
            $users = $uc->index();

            $articles = null;

            Log::info('users : '.$users);

            foreach($users as $user){

                $time = $user->time;
                if($time == null){
                    $time = "10:00";
                }
                $time = date("Y-m-d H:i:s", strtotime($time));

                Log::info('now : '.$now);
                Log::info('time : '.$time);
                Log::info('check : '.($now > $user->time));

                if($now > $time){

                    $mail = $mcc->selectLatest();
                    Log::info('$mail : '.$mail);

                    $email = $user->email;

                    /* 쿼리 변경 */
                    if($articles == null) {
                        $articles = $ac->selectArticles($mail->id);
                    }

                    Log::info('articles : '.$articles);
                    Log::info('user : '. $user);

                    $result = $mc->sendMail($articles, $user);

                    $success = 'N';

                    if($result == 200){
                        $success = 'Y';
                    }else{
                        /**텔레그램 발송 추가 **/
                    }

                    $mail_history = ([
                        'user_id' => $user->id,
                        'mail_id' => $mail->id,
                        'success' => $success
                    ]);

                    $mhc->store($mail_history);
                }
            }
        })->everyMinute();

        $schedule->call(function (){

            $ac = new ArticleController(new Article());
            $c = new Clawler();
            $ahc = new ArticleHistoryController();
            $mcc = new MailContentController(new MailContent());
            $marc = new MailArticleRelationController();

            $mail = $mcc->selectLatest();
            $old_articles = $ac->selectArticles($mail->id);

            Log::info('oldArticles : '.$old_articles );

            $check = false;
            $mail_content_id = 0;

            foreach ($old_articles as $article) {

                $deleted = $c->checkDelete($article->url);
                Log::info('check1');

                if ($deleted) {
                    $check = true;
                    Log::info('check2');

                    $article_history = ([
                        'article_id' => $article->id,
                        'type' => 'D'
                    ]);

                    $ahc->store($article_history);
                }
            }

            if($check){
                if($mail_content_id == 0){
                    $mail_content_id = $mcc->store();
                }

                $latest_histories = $ahc->selectLatestHistory();

                foreach ($latest_histories as $lh){
                    $marc->store($mail_content_id, $lh->id);
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
