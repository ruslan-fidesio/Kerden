<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Commentaire;
use App\Answer;

class AdminMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function listReport(){
    	$comms = Commentaire::where('reported',1)->where('denied',0)->where('ignore_report',0)->get();
    	$answ = Answer::where('reported',1)->where('denied',0)->where('ignore_report',0)->get();
    	return view('admin.messages.list',['comments'=>$comms,'answers'=>$answ]);
    }

    public function seeReport($type, $id){
    	$cName = 'App\\'.$type;
    	$toSee = $cName::find($id);
    	return view('admin.messages.'.$type,['toSee'=>$toSee]);
    }

    public function acceptReport($type,$id){
    	$cName = 'App\\'.$type;
    	$toSee = $cName::find($id);
    	$toSee->denied = 1;
    	$toSee->save();
    	return redirect('/admin/report/list');
    }

    public function ignoreReport($type,$id){
    	$cName = 'App\\'.$type;
    	$toSee = $cName::find($id);
    	$toSee->ignore_report = 1;
    	$toSee->save();

    	return redirect('/admin/report/list');
    }
}

