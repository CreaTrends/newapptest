<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;



use App\Notebook;
use App\User;
use App\Alumno;
use App\Curso;

use Carbon\Carbon;
use Notification;
use App\Notifications\NewNotebook;
use Mail;
use App\Mail\WelcomeParent;

use App\Mail\DailyReportEmail;
use App\Mail\DailyReport as DailyNotebookReport;

use Illuminate\Support\Facades\DB;

use Auth;

class FirstCronTest extends Command
{

    public $user;
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
        $user = Auth::user();
        $this->info('--------------------------------------------');
        $this->info('Daily Report started at : '.Carbon::now());
        $this->info('--------------------------------------------');
        $this->info('sent by :'.$user);
        $this->info('--------------------------------------------');

        // calculate new statistics
        $users = Alumno::with('parent')->whereHas('notebooks',function($q){
            $q->whereNotNull('notebooks.data')
            ->whereDate('notebooks.created_at',Carbon::today()->toDateString());
        })
        ->withcount('parent')->get();

        
        $i=0;
        foreach($users as $recipient){

            foreach ($recipient->parent as $parent) {
                
                try {

                    Mail::to(trim($parent->email))->send(new DailyNotebookReport($recipient,$parent));
                    $this->info('-------------------------------------------------------------------------------------------------');
                    $this->info('> Enviado a '.trim($parent->email).' a las : '.Carbon::now().' - apoderado de '.$recipient->full_name );
                    $i++;

                } catch (Exception $ex) {
                    $this->info('--------------------------------------------');
                    $this->info('No Enviado enviado a '.trim($parent->email));
                    $i--; 
                }
            }
        }
        $this->info('--------------------------------------------');
        $this->info('Daily Report ended at : '.Carbon::now());
        $this->info('total recipients  : ');
        $this->info('total sent email  : '.$i);
        $this->info('--------------------------------------------');

        \Log::info('scheduler running @' . Carbon::now() );
    }
}
