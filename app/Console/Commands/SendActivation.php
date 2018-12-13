<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use Carbon\Carbon;
use Mail;

use App\Mail\SendActivation as SendActivationToParent;

class SendActivation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:sendactivation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Notification for unsucribed users';

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

        $users = User::whereRoleis('parent')
        ->where('first_login','=','0')
        ->whereHas('profile',function($q){
            $q->where('status','=','0');
        })->get();


        $this->info('--------------------------------------------');
        foreach($users as $recipient){

            $password = $this->Sendpassword();
            
            Mail::to(trim($recipient->email))->send(new SendActivationToParent($recipient,$password));
            $this->info('> Recordatorio Enviado a '.trim($recipient->email));

        }
        $this->info('total : '.$users->count());
        $this->info('--------------------------------------------');

        \Log::info('scheduler running @' . Carbon::now() );

        //Mail::to(trim($user->email))->send(new SendActivationToParent($user,$new_password));
    }

    public function Sendpassword(){

        # set the manual password
        $length = 10;
        $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        $password = $str;
        return $password;

    }
}
