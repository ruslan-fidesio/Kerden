<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Http\Requests;
use App\Reservation;
use App\Facture;
use App\Receipt;
use PDF;

class InvoiceController extends Controller
{
    public function __construct(){
    	$this->middleware(['auth']);
    }

    public function userInvoice($id, Request $req){
    	$reservation = Reservation::findOrFail($id);
    	if($req->user()->role->role != 'admin' && $reservation->user->id != $req->user()->id){
    		return redirect('/home')->with('error','Cette réservation ne vous concerne pas!');
    	}
    	
    	$facture = Facture::findOrCreateByReservationID($id);
        $this->checkIsAdmin($req,$facture);

        $view = 'userOK';
        if($reservation->status == 'refund_by_user'){
            $view = 'userRefundByUser';
        }

        return PDF::loadView('invoices.'.$view,['facture'=>$facture])->setOption('encoding','utf-8')->download('facture_Kerden_'.$facture->reference.'.pdf');
    	//return view('invoices.'.$view,['facture'=>$facture]);
    }

    public function userReceipt($id, Request $req){
        $reservation = Reservation::findOrFail($id);
        if($req->user()->role->role != 'admin' && $reservation->user->id != $req->user()->id){
            return redirect('/home')->with('error','Cette réservation ne vous concerne pas!');
        }

        $receipt = Receipt::findOrCreateByReservationID($id);
        $this->checkIsAdmin($req,$receipt);


        return PDF::loadView('invoices.userRefundByOwner',['receipt'=>$receipt])->setOption('encoding','utf-8')->download('recu_Kerden_'.$receipt->reference.'.pdf');
        //return view('invoices.userRefundByOwner',['receipt'=>$receipt]);
    }

    public function ownerReceipt($id, Request $req){
    	$reservation = Reservation::findOrFail($id);
    	if($req->user()->role->role != 'admin' && $reservation->garden->owner->id != $req->user()->id){
    		return redirect('/home')->with('error','Cette réservation ne vous concerne pas!');
    	}

    	$receipt = Receipt::findOrCreateByReservationID($id);
        $this->checkIsAdmin($req,$receipt);

        $view = 'ownerOK';
        if($reservation->status == 'refund_by_user'){
            $view = 'ownerRefundByUser';
        }

    	return PDF::loadView('invoices.'.$view,['receipt'=>$receipt])->setOption('encoding','utf-8')->download('recu_Kerden_'.$receipt->reference.'.pdf');
    	//return view('invoices.'.$view,['receipt'=>$receipt]);
    }

    public function ownerAvis($id, Request $req){
        $reservation = Reservation::findOrFail($id);
        if($req->user()->role->role != 'admin' && $reservation->garden->owner->id != $req->user()->id){
            return redirect('/home')->with('error','Cette réservation ne vous concerne pas!');
        }
        if($reservation->status != 'refund_by_owner'){
            return redirect('/home')->with('error','Cette réservation n\'a pas le bon statut!');
        }

        return PDF::loadView('invoices.ownerRefundByOwner',['name'=>$reservation->garden->owner->firstName])->setOption('encoding','utf-8')->download('Kerden_avis_penalite.pdf');
    }


    public function checkIsAdmin(Request $req, Model $mod){
        if($req->user()->role->role == 'admin'){
            $mod->admin_generated = true;
            $mod->save();
        }
    }
}
