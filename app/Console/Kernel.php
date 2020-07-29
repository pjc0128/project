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
        $schedule->command(
            'command:crawling_article'
        )->at("9:00");

//        $schedule->call(function (){
//            $ac = new ArticleController(new Article());
//            $uc = new UserController();
//            $mc = new TestMailController();
//            $mhc = new MailHistoryController(new MailHistory());
//            $mcc = new MailContentController(new MailContent());
//
//
//            $now = now();
//            $users = $uc->index();
//
//            $articles = null;
//
//            Log::info('users : '.$users);
//
//            foreach($users as $user){
//
//                $time = $user->time;
//                if($time == null){
//                    $time = "10:00";
//                }
//                $time = date("Y-m-d H:i:s", strtotime($time));
//
//                Log::info('now : '.$now);
//                Log::info('time : '.$time);
//                Log::info('check : '.($now > $user->time));
//
//                if($now > $time){
//
//                    $mail = $mcc->selectLatest();
//                    Log::info('$mail : '.$mail);
//
//                    $email = $user->email;
//
//                    /* 쿼리 변경 */
//                    if($articles == null) {
//                        $articles = $ac->selectArticles($mail->id);
//                    }
//
//                    Log::info('articles : '.$articles);
//                    Log::info('user : '. $user);
//
//                    $result = $mc->sendMail($articles, $user);
//
//                    $success = 'N';
//
//                    if($result == 200){
//                        $success = 'Y';
//                    }else{
//                        /**텔레그램 발송 추가 **/
//                    }
//
//                    $mail_history = ([
//                        'user_id' => $user->id,
//                        'mail_id' => $mail->id,
//                        'success' => $success
//                    ]);
//
//                    $mhc->store($mail_history);
//                }
//            }
//        })->everyMinute();

        $schedule->command(
            'command:check_article'
        )->everyMinute();
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
