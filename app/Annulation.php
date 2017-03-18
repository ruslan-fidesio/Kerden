<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MangoPayTrait;
use App\KerdenMailer;
use App\Transfert;
use App\PayOut;
use App\Refund;

class Annulation extends Model
{
	use MangoPayTrait;
    protected $guarded = [];

    private static function fromReservation(Reservation $reservation){
    	$result = new Annulation();

    	$result->reservation_id = $reservation->id;
    	return $result;
    }

    public static function fromUserReservation(Reservation $reservation, $intervalInHours){
    	$result = Annulation::fromReservation($reservation);
    	$result->creator = 'user';
    	$result->creator_id = $reservation->user->id;

    	$result->fees = $reservation->location_amount * (0.17);

		if($intervalInHours < 24){
			$result->staff_transfert_amount = $reservation->staff_amount;
			$result->owner_transfert_amount = $reservation->location_amount * (0.23);
			$result->refund_amount = $reservation->location_amount * (0.77);
		}
		else{
            $result->staff_transfert_amount = 0;

			if($intervalInHours < 72){
    			$result->owner_transfert_amount = $reservation->location_amount * (0.23);
    			$result->refund_amount = $reservation->location_amount * (0.77) + $reservation->staff_amount;
			}
			else{
    			$result->owner_transfert_amount = 0;
    			$result->refund_amount = $reservation->location_amount + $reservation->staff_amount;
			}
		}

    	return $result;
    }

    public static function fromOwnerReservation(Reservation $reservation){
    	$result = Annulation::fromReservation($reservation);
    	$result->creator = 'owner'; 

        $result->staff_transfert_amount = 0;
        $result->owner_transfert_amount = 0;
        $result->refund_amount = $reservation->total_amount;
        $result->fees = 0;

    	return $result;
    }

    public function execute(){
    	$this->executeTransferts();
    	$this->executeRefund();
    	$this->executePayouts();
        $this->sendMails();
    }

    private function executeTransferts(){
    	//1-oscar
    	if($this->staff_transfert_amount > 0){
	    	$res = $this->makeTransfert('transfert for canceled reservation :'.$this->reservation_id,
	    	 $this->reservation->user->mangoUser->mangoUserId,
	    	 $this->reservation->user->mangoUser->mangoWalletId,
	    	 env('MANGO_OSCAR_USER_ID'),
	    	 env('MANGO_OSCAR_WALLET_ID'),
	    	 $this->staff_transfert_amount*100,0);

            //makeTransfert($tag, $debitedUserId, $debitedWalletId, $creditedUserId ,$creditedWalletId,$amount,$fees){
            $transfert = Transfert::create([
                        'debited_user_Id'=>$this->reservation->user->id,
                        'mango_debited_user_Id'=>$this->reservation->user->mangoUser->mangoUserId,
                        'mango_debited_wallet_Id'=>$this->reservation->user->mangoUser->mangoWalletId,
                        'credited_user_Id'=>env('OSCAR_USER_ID'),
                        'mango_credited_user_Id'=>env('MANGO_OSCAR_USER_ID'),
                        'mango_credited_wallet_Id'=>env('MANGO_OSCAR_WALLET_ID'),
                        'amount'=>$this->staff_transfert_amount,
                        'fees'=>0,
                         ]);
            $transfert->status = $res->Status;
            $transfert->save();
            $this->staff_transfert_Id = $transfert->id;
            $this->save();
	    }else{
            $this->staff_transfert_Id = 0;
            $this->save();
        }

    	//2-owner
        if($this->owner_transfert_amount > 0){
        	$res = $this->makeTransfert('transfert for canceled reservation:'.$this->reservation_id,
        	 $this->reservation->user->mangoUser->mangoUserId,
        	 $this->reservation->user->mangoUser->mangoWalletId,
        	 $this->reservation->garden->owner->mangoUser->mangoUserId,
        	 $this->reservation->garden->owner->mangoUser->mangoWalletId,
        	 $this->owner_transfert_amount*100,0);

            $transfert = Transfert::create([
                        'debited_user_Id'=>$this->reservation->user->id,
                        'mango_debited_user_Id'=>$this->reservation->user->mangoUser->mangoUserId,
                        'mango_debited_wallet_Id'=>$this->reservation->user->mangoUser->mangoWalletId,
                        'credited_user_Id'=>$this->reservation->garden->owner->id,
                        'mango_credited_user_Id'=>$this->reservation->garden->owner->mangoUser->mangoUserId,
                        'mango_credited_wallet_Id'=>$this->reservation->garden->owner->mangoUser->mangoWalletId,
                        'amount'=>$this->owner_transfert_amount,
                        'fees'=>0,
                         ]);

            $transfert->status = $res->Status;
            $transfert->save();
            $this->owner_transfert_Id = $transfert->id;
            $this->save();
        }else{
            $this->owner_transfert_Id = 0;
            $this->save();
        }
    }

    private function executeRefund(){
    	$res = $this->makeRefund('refund for canceled reservation:'.$this->reservation_id,
    		$this->reservation->payIn->mango_payIn_Id,
    		$this->reservation->user->mangoUser->mangoUserId,
    		$this->refund_amount*100,
    		$this->fees*100);

        $refund = Refund::create([
            'tag'=>'refund for canceled reservation:'.$this->reservation_id,
            'payIn_Id'=>$this->reservation->payIn->mango_payIn_Id,
            'amount'=>$this->refund_amount,
            'fees'=>$this->fees
        ]);
        $refund->status = $res->Status;
        $refund->save();
        $this->user_refund_Id = $refund->id;
        $this->save();
    }

    private function executePayouts(){
    	//1-oscar
    	//makePayOut($tag,$mangoUserId,$mangoWalletId,$amount,$bankAccountId,$fees){
    	if($this->staff_transfert_amount>0){
	    	$res = $this->makePayOut('payout for canceled reservation : '.$this->reservation_id,
	    		env('MANGO_OSCAR_USER_ID'),
	    		env('MANGO_OSCAR_WALLET_ID'),
	    		$this->staff_transfert_amount*100,
	    		env('MANGO_OSCAR_BANK_ID'),
	    		0);

            $payout = Payout::create([
                    'tag'=>'Payout oscar for annulation, reservation : '.$this->reservation_id,
                    'bankWireRef'=>'Kerden',
                    'user_id'=>env('OSCAR_USER_ID'),
                    'mango_user_id'=>env('MANGO_OSCAR_USER_ID'),
                    'mango_debited_wallet_Id'=>env('MANGO_OSCAR_WALLET_ID'),
                    'mango_banck_account_Id'=>env('MANGO_OSCAR_BANK_ID'),
                    'amount'=>$this->staff_transfert_amount
                    ]);
            $payout->status = $res->Status;
            $payout->save();
            $this->staff_payout_Id = $payout->id;
            $this->save();
	    }else{
            $this->staff_payout_Id = 0;
            $this->save();
        }

    	//2-owner
        if($this->owner_transfert_amount > 0){
        	$res = $this->makePayOut('payout for canceled reservation : '.$this->reservation_id,
        		$this->reservation->garden->owner->mangoUser->mangoUserId,
        		$this->reservation->garden->owner->mangoUser->mangoWalletId,
        		$this->owner_transfert_amount*100,
        		$this->reservation->garden->owner->mangoBankAccount->account_id,
        		0);
            $payout = Payout::create([
                    'tag'=>'Payout oscar for annulation, reservation : '.$this->reservation_id,
                    'bankWireRef'=>'Kerden',
                    'user_id'=>$this->reservation->garden->owner->id,
                    'mango_user_id'=>$this->reservation->garden->owner->mangoUser->mangoUserId,
                    'mango_debited_wallet_Id'=>$this->reservation->garden->owner->mangoUser->mangoWalletId,
                    'mango_banck_account_Id'=>$this->reservation->garden->owner->mangoBankAccount->account_id,
                    'amount'=>$this->owner_transfert_amount
                    ]);
            $payout->status = $res->Status;
            $payout->save();
            $this->owner_payout_Id = $payout->id;
            $this->save();
        }else{
            $this->owner_payout_Id = 0;
            $this->save();
        }
    }

    public function sendMails(){
        if($this->creator == 'user'){
            //send mails to owner and oscar
            KerdenMailer::mailNoReply($this->reservation->garden->owner->email , 'refundByUser', ['annulation'=>$this]);
            if($this->reservation->nb_staff > 0){
                KerdenMailer::mailNoReply(env('OSCAR_MAIL'),'oscarRefundByUser',['annulation'=>$this]);
            }
        }else{
            //send mails to user and oscar
            KerdenMailer::mailNoReply($this->reservation->user->email, 'refundByOwner', ['annulation'=>$this]);
            if($this->reservation->nb_staff > 0){
                KerdenMailer::mailNoReply(env('OSCAR_MAIL'),'oscarRefundByOwner',['annulation'=>$this]);
            }
        }
    }


    public function reservation(){
    	return $this->belongsTo('App\Reservation','reservation_id');
    }
}
