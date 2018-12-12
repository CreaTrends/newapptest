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
        $recipients = DB::table('users')
          ->selectRaw('users.id as parent_id,alumnos.id as alumno_id')
          ->join('profiles','profiles.user_id','=','users.id')
          ->join('alumno_parent','alumno_parent.user_id','=','users.id')
          ->join('alumnos','alumnos.id','=','alumno_parent.alumno_id')
          ->join('notebooks','notebooks.alumno_id','=','alumnos.id')
          ->whereNotNull('notebooks.data')
          ->whereDate('notebooks.created_at',Carbon::today()->toDateString())
          ->get();

        $i=0;
        
        foreach($recipients as $recipient){
            $user = User::findorfail($recipient->parent_id);
                $child = Alumno::findorfail($recipient->alumno_id);

                
            try {
                


                Mail::to($user->email)->send(new DailyNotebookReport($child,$user));
                $this->info('Exito , Enviado enviado a '.$user->email.' a las : '.Carbon::now().'');
                $i++;

            } catch (Exception $ex) {

                $this->info('No Enviado enviado a '.$user->email);
                $i--; 
            }
        }
        $this->info('--------------------------------------------');
        $this->info('Daily Report ended at : '.Carbon::now());
        $this->info('total recipients  : '.$recipients->count());
        $this->info('total sent email  : '.$i);
        $this->info('--------------------------------------------');

        \Log::info('scheduler running @' . Carbon::now() );
    }
}
