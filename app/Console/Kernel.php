<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
        // $schedule->command('inspire')->hourly();
        // DB를 참고
        // $db참고내용 =[]

        //9시 크롤링
        $schedule->call(function(){
            Log::info("test");
            Log::warning("test");
        })->at('4:15');


        //매 분 확인
        $schedule->call(function (){
            //$test = App\User::All();


            Log::info("test");
            Log::warning("test");
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
