<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\User;
Use Mail;

class FirstCronTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is the first Cron Job Testing Email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $users = User::findOrFail(4);
        Mail::raw("This is automatically generated Hourly Update", function($message) use ($users){
                $message->from('saquib.gt@gmail.com');
                $message->to($users->email)->subject('Hourly Update at : ');
            });
 
        $this->info('Hourly Update has been send successfully');
        \Log::info('scheduler running @' . \Carbon\Carbon::now() );
    }
}
