<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Reservation;
use Carbon\Carbon;
use App\KerdenMailer;
use App\Traits\MangoPayTrait;
use App\Transfert;
use App\PayOut;
use App\GardenDispo;
use App\Penalite;

class CronController extends Controller
{
    protected $oscarMangoUserId;
    protected $oscarMangoWalletId;
    protected $oscarMangoBankAccountId;

    use MangoPayTrait;

    public function __construct(){
        $this->oscarMangoUserId = env('MANGO_OSCAR_USER_ID');
        $this->oscarMangoWalletId = env('MANGO_OSCAR_WALLET_ID');
        $this->oscarMangoBankAccountId = env('MANGO_OSCAR_BANK_ID');
        $this->oscarUserId = env('OSCAR_USER_ID');
    }

    public function schedule(){
        //execute transfert on all confirmed and passed reservations
        $this->executeAllTransferts();
    }

    private function executeAllTransferts(){
        $confirmedReservations = Reservation::where('status','confirmed')->get();
        if($confirmedReservations->count() == 0) return;

        foreach($confirmedReservations as $resa){
            $checkDate = Carbon::parse($resa->date_end, 'Europe/Paris');
            if( $checkDate->isPast() && $checkDate->diffInHours(Carbon::now('Europe/Paris')) >=24 ){
                try{
                    $this->executeTransferts($resa);
                    $this->executePayouts($resa);
                    $resa->status = 'done';
                    $resa->save();
                    $this->sendMails($resa);
                }
                catch(\Exception $e){
                    //send mail to admin$
                    //dd($e);
                    KerdenMailer::mailNoReply(env('KERDEN_ADMIN_MAIL'),'problemReservation',['reservation'=>$resa,'exception'=>$e]);
                }
            }
        }
    }

    private function executeTransferts($resa){
        try{
            $debitedUserId = $resa->user->mangoUser->mangoUserId;
            $debitedWalletId = $resa->user->mangoUser->mangoWalletId;

            $creditedUserId = $resa->garden->owner->mangoUser->mangoUserId;
            $creditedWalletId = $resa->garden->owner->mangoUser->mangoWalletId;

            // 1 - oscar
            if($resa->staff_amount >0){
                $do = true;
                if(!empty($resa->staff_transfert_Id)){
                    $transfert = Transfert::find($resa->staff_transfert_Id);
                    if($transfert->status == "SUCCEEDED"){
                        $do=false;
                    }
                }
                if($do){
                    $res = $this->makeTransfert($resa->id.' to oscar', $debitedUserId, $debitedWalletId, $this->oscarMangoUserId ,$this->oscarMangoWalletId,$resa->staff_amount*100,0);
                    $transfert = Transfert::create([
                        'debited_user_Id'=>$resa->user->id,
                        'mango_debited_user_Id'=>$debitedUserId,
                        'mango_debited_wallet_Id'=>$debitedWalletId,
                        'credited_user_Id'=>$this->oscarUserId,
                        'mango_credited_user_Id'=>$this->oscarMangoUserId,
                        'mango_credited_wallet_Id'=>$this->oscarMangoWalletId,
                        'amount'=>$resa->staff_amount,
                        'fees'=>0,
                         ]);
                    $transfert->status = $res->Status;
                    $transfert->save();
                    $resa->staff_transfert_Id = $transfert->id;
                    $resa->save();
                }
            }

            // 2 - owner
            $do = true;
            if(!empty($resa->owner_transfert_Id)){
                $transfert = Transfert::find($resa->owner_transfert_Id);
                if($transfert->status == "SUCCEEDED"){
                    $do = false;
                }
            }
            if($do){
                $amount = $resa->location_amount*100;
                $fees = $resa->location_amount * env('KERDEN_FEES_PERCENT');

                //check penalties
                $penalties = $resa->garden->owner->getTotalPenalitesAmount();
                $penalties = min($penalties*100, $amount-$fees);

                $fees += $penalties;

                $res = $this->makeTransfert($resa->id, $debitedUserId, $debitedWalletId, $creditedUserId ,$creditedWalletId,$amount,$fees);
                $transfert = Transfert::create([
                        'debited_user_Id'=>$resa->user->id,
                        'mango_debited_user_Id'=>$debitedUserId,
                        'mango_debited_wallet_Id'=>$debitedWalletId,
                        'credited_user_Id'=>$this->oscarUserId,
                        'mango_credited_user_Id'=>$this->oscarMangoUserId,
                        'mango_credited_wallet_Id'=>$this->oscarMangoWalletId,
                        'amount'=>$resa->location_amount,
                        'fees'=>$fees/100,
                         ]);
                $transfert->status = $res->Status;
                $transfert->save();
                $resa->applied_penalities = $penalties / 100;
                $resa->owner_transfert_Id = $transfert->id;
                $resa->save();

                //update penalities
                $peno = Penalite::where('user_id',$resa->garden->owner->id)->first();
                if($peno){
                    $peno->current_amount -= $penalties/100;
                    $peno->save();
                }
            }  
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    private function executePayouts($resa){
        //1-oscar
        if($resa->staff_amount > 0){
            $do=true;
            if(!empty($resa->staff_payout_Id)){
                $payout = PayOut::find($resa->staff_payout_Id);
                if($payout->status == 'SUCCEEDED') $do=false;
            }
            if($do){
                $res = $this->makePayOut($resa->id.' to oscar',$this->oscarMangoUserId,$this->oscarMangoWalletId,$resa->staff_amount*100,$this->oscarMangoBankAccountId,0);
                $payout = Payout::create([
                    'tag'=>'Payout oscar for reservation'.$resa->id,
                    'bankWireRef'=>'Kerden',
                    'user_id'=>$this->oscarUserId,
                    'mango_user_id'=>$this->oscarMangoUserId,
                    'mango_debited_wallet_Id'=>$this->oscarMangoWalletId,
                    'mango_banck_account_Id'=>$this->oscarMangoBankAccountId,
                    'amount'=>$resa->staff_amount
                    ]);
                $payout->status = $res->Status;
                $payout->save();
                $resa->staff_payout_Id = $payout->id;
                $resa->save();
            }
        }

        //2-owner
        $mangoUserId = $resa->garden->owner->mangoUser->mangoUserId;
        $mangoWalletId = $resa->garden->owner->mangoUser->mangoWalletId;
        $bankAccountId = $resa->garden->owner->mangoBankAccount->account_id;
        $amount = ($resa->location_amount * (100 - env('KERDEN_FEES_PERCENT')) ) - $resa->applied_penalities;

        $do = true;
        if(!empty($resa->owner_payout_Id)){
            $payout = PayOut::find($resa->owner_payout_Id);
            if($payout->status == 'SUCCEEDED') $do=false;
        }
        if($do){
            $res = $this->makePayOut($resa->id,$mangoUserId,$mangoWalletId,$amount,$bankAccountId,0);
            $payout = Payout::create([
                    'tag'=>'Payout owner for reservation'.$resa->id,
                    'bankWireRef'=>'Kerden',
                    'user_id'=>$resa->garden->owner->id,
                    'mango_user_id'=>$mangoUserId,
                    'mango_debited_wallet_Id'=>$mangoWalletId,
                    'mango_banck_account_Id'=>$bankAccountId,
                    'amount'=>$amount/100
                    ]);
            $payout->status = $res->Status;
            $payout->save();
            $resa->owner_payout_Id = $payout->id;
            $resa->save();
        }
    }

    private function sendMails($reservation){
        //user
        KerdenMailer::mailNoReply($reservation->user->email,'reservationDone',['reservation'=>$reservation]);
        //owner
        KerdenMailer::mailNoReply($reservation->garden->owner->email,'reservationDoneOwner',['reservation'=>$reservation]);
        //oscar
        if($reservation->staff_amount > 0){
            KerdenMailer::mailNoReply(env('OSCAR_MAIL'),'reservationDoneOscar',['reservation'=>$reservation]);
        }
    }

}
