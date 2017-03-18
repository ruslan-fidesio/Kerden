<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Reservation;
use App\Facture;
use App\Receipt;
use Carbon\Carbon;

class AdminInvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }


    public function tab(){
    	$reservations = Reservation::whereIn('status',['done','refund_by_owner','refund_by_user'])->get();

    	return view('admin.invoicesTab',['reservations'=>$reservations]);
    }

    public function dateForm(){
    	return view('admin.invoicesDateForm');
    }

    public function dateTab(Request $req){
    	$begin = Carbon::parse($req->dateBegin);
    	$end = Carbon::parse($req->dateEnd);

    	$reservations = Reservation::whereDate('date_end','>=',$begin)->whereDate('date_end','<=',$end)->get();
    	return view('admin.invoicesTab',['reservations'=>$reservations, 'byDate'=>true]);
    }

    public function numberForm(){
    	return view('admin.invoicesNumberForm');
    }

    public function numberTab(Request $req){
    	$reference = $req->reference;

    	$factures = Facture::where('reference','like','%'.$reference.'%')->get();
    	$receipts = Receipt::where('reference','like','%'.$reference.'%')->get();

    	return view('admin.invoicesByNumber',['factures'=>$factures, 'receipts'=>$receipts]);
    }

    public function unprinted(){
    	$firstList = Reservation::whereIn('status',['done','refund_by_owner','refund_by_user'])->get();
    	$reservations = [];

    	foreach ($firstList as $resa) {
    		if($resa->status == 'refund_by_owner'){
    			if( $resa->receipt && $resa->receipt->admin_generated ){
    				//nothing
    			}else{
    				$reservations[] = $resa;
    			}
    		}
    		else{
	    		if( $resa->facture && $resa->facture->admin_generated ){
	    			if($resa->receipt && $resa->receipt->admin_generated){
	    				//nothing
	    			}else{
	    				$reservations[] = $resa;
	    			}
	    		}else{
	    			$reservations[] = $resa;
	    		}
	    	}
    	}

    	return view('admin.invoicesTab',['reservations'=>$reservations,'unprinted'=>true]);
    }

}
