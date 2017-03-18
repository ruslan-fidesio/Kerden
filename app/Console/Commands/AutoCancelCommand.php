<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reservation;
use Carbon\Carbon;
use App\KerdenMailer;

class AutoCancelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:autoCancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cancel all "not in time confirmed" reservations';

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
        $listToHandle = Reservation::whereIn('status',['waiting_confirm','waiting_payin'])->get();
        foreach($listToHandle as $resa){
            $autoCancelDate = Carbon::parse($resa->autoCancelDate, 'Europe/Paris');
            if($autoCancelDate->isPast()){
                $resa->status = "time_canceled";
                $resa->save();

                KerdenMailer::mailNoReply($resa->user->email,'canceledByTime',['reservation'=>$resa]);
                KerdenMailer::mailNoReply($resa->garden->owner->email,'canceledByTime',['reservation'=>$resa]);
                if($resa->nb_staff > 0 ){
                    KerdenMailer::mailNoReply(env('OSCAR_MAIL'),'canceledByTime',['reservation'=>$resa]);
                }

            }
        }
    }
}
