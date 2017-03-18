<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;
use File;
use App\Http\Requests;
use App\Garden;
use App\GardenDefaultImg;
use App\User;
use App\UserDetail;
use App\MangoBankAccount;
use App\Traits\MangoPayTrait;
use App\KerdenMailer;
use App\Commentaire;

class AdminController extends Controller
{
    use MangoPayTrait;

    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function create(){
    	return view('admin.menu',[
    		'message'=>session()->get('message'),
            'error'=>session()->get('error')]);
    }

    public function listGardens(){
    	$gardens = Garden::all();
    	return view('admin.gardens', ['gardens'=>$gardens]);
    }

    public function validateGarden($id, Request $req){
    	$garden = Garden::find($id);
        //check if at least one photo exists
        $photos = Storage::files($id);
        if(count($photos) == 0){
            return redirect()->back()->with('error','Pas de photo, ajoutez au moins une photo pour pouvoir valider le jardin');
        }
        if($garden->owner->role->role !='owner' && $garden->owner->role->role !='admin'){
            return redirect()->back()->with('error','Le propriétaire du jardin n\'a pas le statut "propriétaire"');
        }
    	$garden->state = "validated";
    	$garden->save();
        KerdenMailer::mailNoReply($garden->owner->email, 'validGarden',
            ['name'=>$garden->owner->firstName, 'gardenName'=>$garden->title]);
    	return redirect('/admin/gardens');
    }

	public function unvalidateGarden($id, Request $req){
    	$garden = Garden::find($id);
    	$garden->state = "prices_ok";
    	$garden->save();
    	return redirect('/admin/gardens');
    }

    public function deleteGarden($id, Request $req){
    	$garden = Garden::find($id);
    	$garden->delete();
    	return redirect('/admin')->with('message',trans('garden.deleted'));
    }

    public function photos($id, Request $req){
        $garden = Garden::find($id);
        //check if folder exists (and eventually create it)
        $dirs = Storage::directories();
        if( !in_array($id,$dirs) ){
            Storage::makeDirectory($id);
        }
        //get all files
        $photos = Storage::files($id);

        return view('admin.photos',['garden'=>$garden, 'photos'=>$photos]);
    }

    public function addPhoto($id, Request $req){
        $garden = Garden::find($id);
        $photos = Storage::files($id);
        if($req->hasFile('image') ){
            $file = $req->file('image');
            $nbI = 1;
            $name = $nbI.'.'.$file->getClientOriginalExtension();
            while(Storage::has($id.'/'.$name) ){
                $nbI++;
                $name = $nbI.'.'.$file->getClientOriginalExtension();
            }
            Storage::put($id.'/'.$name, File::get($file));
            return redirect()->back();
        }
        elseif ($req->has('b64Image')) {
            $b64 = explode(',',$req->get('b64Image'))[1];
            $nbI = 1;
            $name = $nbI.'.jpg';
            while(Storage::has($id.'/'.$name) ){
                $nbI++;
                $name = $nbI.'.jpg';
            }
            Storage::put($id.'/'.$name, base64_decode($b64));
            return redirect()->back();
        }
        else{
            return view('admin.photos',['garden'=>$garden, 'photos'=>$photos])->withErrors(['upload'=>$req->file('image')->getErrorMessage()]);
        }
    }

    public function delPhoto(Request $req){
        if(! isset($req->path)){
            return redirect()->back();
        }
        $id = explode('/',$req->path)[0];
        Storage::delete($req->path);
        return redirect()->back();
    }

    public function defautImg($id,$file_name,Request $req){
        $defautImg = GardenDefaultImg::firstOrCreate(['garden_id'=>$id]);
        $defautImg->file_name = $file_name;
        $defautImg->save();
        
        return redirect()->back();
    }

    public function listUsers(Request $req){
        $users = User::all();
        if($req->has('userStatus')){
            if($req->userStatus=='owners') $users = array_filter($users->all(),array($this,'filterOwners'));
            if($req->userStatus=='notOwners') $users = array_filter($users->all(),array($this,'filterNotOwners'));
            if($req->userStatus=='admins') $users = array_filter($users->all(),array($this,'filterAdmins'));
        }
        return view('admin.listUsers',['users'=>$users,'userStatus'=>$req->userStatus]);
    }

    public function userDetails($id, Request $req){
        $user = User::find($id);
        $details = UserDetail::findOrCreate($id);
        if(!$details->exists) $details->save();
        return view('admin.userDetails',['user'=>$user]);
    }

    public function userBank($id, Request $req){
        $user = User::find($id);
        if($user->role->role == 'new' || $user->role->role == 'confirmed'){
            return redirect()->back();
        }
        $mangoId = $user->mangoUser->mangoUserId;
        $accounts  = $this->getBankAccounts($mangoId);
        $active = !empty($user->mangoBankAccount)?$user->mangoBankAccount->account_id:0;
        return view('admin.bankAccounts',['user'=>$user,'accounts'=>$accounts,'active'=>$active]);
    }

    public function setActiveUserBank($id, Request $req){
        if(!$req->has('account_id')) return redirect()->back();
        $account = MangoBankAccount::firstOrCreate(['user_id'=>$id]);
        $account->account_id = $req->account_id;
        $account->save();
        return redirect()->back();
    }

    public function formAddBankAccount($id){
        $user = User::findOrFail($id);
        return view('admin.addBankAccount',['user'=>$user]);
    }

    public function addBankAccount($id, Request $req){
        $user = User::find($id);
        $mangoId = $user->mangoUser->mangoUserId;
        $res = $this->createBankAccount($mangoId,$user->details, $user->fullName, $req->iban, $req->bic);
        return redirect('/admin/bank/'.$id);
    }

    public function setOwner($id,Request $req){
        $user = User::find($id);
        if($user->role->role != 'regular'){
            return redirect()->back()->withErrors(['listUser'=>'pas de preuve d\'identité valide']);
        }
        if(empty($user->mangoBankAccount)){
            return redirect()->back()->withErrors(['listUser'=>'pas de compte en banque actif']);
        }

        $user->role->role = 'owner';
        $user->role->save();
        return redirect()->back();
    }

    public function blockUser($id, Request $req){
        $user = User::find($id);
        if($user->role->role == 'admin'){
            return redirect()->back()->withErrors(['listUser'=>'Impossible de bloquer des administrateurs']);
        }
        $user->blocked = true;
        $user->save();
        return redirect()->back();
    }

    public function unblockUser($id, Request $req){
        $user = User::find($id);
        $user->blocked = false;
        $user->save();
        return redirect()->back();
    }

    public function modifyGardenDesc($id, Request $req){
        $garden = Garden::find($id);
        return view('admin.modifyDesc',['garden'=>$garden]);
    }

    public function saveGardenDesc($id, Request $req){
        if($req->has('description')){
            if(strlen($req->description)==0){
                return redirect()->back();
            }
            $garden = Garden::find($id);
            $garden->description = $req->description;
            $garden->save();
            return redirect('/view/'.$garden->id);
        }
        return redirect()->back()->withInput();

    }

    private function filterOwners($user){
        return $user->role->role == 'owner';
    }
    private function filterNotOwners($user){
        return ($user->role->role != 'owner' && $user->role->role != 'admin');
    }
    private function filterAdmins($user){
        return $user->role->role=='admin';
    }
}
