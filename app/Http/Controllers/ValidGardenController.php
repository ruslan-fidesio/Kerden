<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ValidGardenController extends Controller
{
    public function index(Request $req){
    	if( session('requestURL')!== null && session('inputFrom')!==null  ){
	    	return view('garden.validWarning')->with(['url'=>session('requestURL'),
	    												'input'=>session('inputFrom'),
	    												'isAdmin'=>($req->user()->role->role=='admin')  ]);
	    }
	    return redirect('/home');
    }
}
