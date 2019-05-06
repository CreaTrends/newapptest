<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Console\Commands\FirstCronTest;
use App\Console\Commands\SendActivation;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\FirstCronTest::class,
        Commands\SendActivation::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
            $schedule->command('cron:test')
            ->weekdays(env('MAIL_DAILYREPORT_HOUR', '17:00'))
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/dailyreport-'.\Carbon\Carbon::now()->format('d-m-y').'.log'))
            ->emailWrittenOutputTo('jalbornozdesign@gmail.com');

            //$schedule->call(new SendActivation)->everyMinute();

            
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
