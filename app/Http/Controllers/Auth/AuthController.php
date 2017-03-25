<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Mail;
use App\User;
use App\UserDetail;
use App\UserRole;
use App\ProviderUser;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers { login as traitLogin; sendFailedLoginResponse as TraitSendFailedLoginResponse;}
    use ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users|confirmed',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => 'recaptcha|required',
            'acceptCGU' => 'required', 
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'firstName' => $data['first_name'],
            'lastName' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /*
    / Create e new user_role instance
    */
    protected function createNewRole($userid){
        return UserRole::create([
            'id' => $userid,
        ]);
    }

    protected function createNewDetails($userid,$islegal){
        $type = $islegal ? 'legal' : 'natural';
        return UserDetail::create([
            'id' => $userid,
            'type' => $type,
        ]);
    }

    public function register(Request $request){
        $validator = $this->validator($request->all());
        if($validator->fails()){
            return redirect('/register')->withErrors($validator)->withInput();
        }else{
            $user = $this->create($request->all());
            $this->createNewRole($user->id);
            $this->createNewDetails($user->id,$request->iamlegal);


            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                return redirect('/sendmailconfirmation');    
            }else{
                return redirect('/');
            }
        }
    }

    public function login(Request $req){
        if(isset($req->redirectTo)){
            $this->redirectPath = $req->redirectTo;
        }else{
            $this->redirectTo = $req->header('referer');
        }
        //if password is empty => test if provider exists
        if(empty($req->password)){
            $providerUser = $this->searchForProviderUser($req->email);
            if($providerUser){
                return redirect('/login')->withErrors('Cette adresse email est associée à un compte '.$providerUser->provider);
            }
        }
        return $this->traitLogin($req);
    }

    public function searchForProviderUser($email){
        return ProviderUser::where('email',$email)->first();
    }

    public function sendFailedLoginResponse(Request $req){
        $providerUser = $this->searchForProviderUser($req->email);
        if($providerUser){
            return redirect()->back()->withInput()->withErrors('Cette adresse email est associé à un compte '.$providerUser->provider);
        }
        return $this->TraitSendFailedLoginResponse($req);
    }
}
