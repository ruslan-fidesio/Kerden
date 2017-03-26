<?php

use App\Reservation;
use App\User;
use App\Annulation;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('new_welcome');
});
Route::get('/home', 'HomeController@index');

Route::get('/cgu',function(){
	return view('cgu');
});
Route::get('/faq',function(){
	return view('faq');
});

Route::get('/privacy',function(){
	return view('privacy');
});

Route::get('/about',function(){
	return view('about');
});
Route::get('/theTeam',function(){
	return view('theTeam');
});

//USERS
Route::auth();
Route::get('/sendmailconfirmation', 'MailConfirmationController@send')->middleware('auth');
Route::get('/confirmemail/{id}/{token}','MailConfirmationController@confirm');
Route::get('/userdetails','UserDetailController@create');
Route::post('/userdetails','UserDetailController@store');
Route::get('/user/advancedDetails','UserAdvancedDetailsController@create');
Route::post('/user/advancedDetails','UserAdvancedDetailsController@store');
Route::get('/proofOfId','ProofOfIdController@entryPoint');
Route::post('/proofOfId','ProofOfIdController@send');
Route::get('/changePassword','ChangePasswordController@create');
Route::post('/changePassword','ChangePasswordController@store');
Route::get('/rib','BankAccountController@create');
Route::post('/rib','BankAccountController@setActive');
Route::get('/addBankAccount','BankAccountController@addNewForm');
Route::post('/addBankAccount','BankAccountController@addNewAccount');

//OAUTH
Route::get('/{provider}/login','OAuthController@login');

//GARDENS
Route::get('/garden/menu/{id}','GardenController@menu')->middleware('owner');

Route::get('/garden/create','GardenController@create');
Route::post('/garden/create','GardenController@store');
Route::get('/garden/update/{id}','GardenController@edit')->middleware('owner');
Route::post('/garden/update/{id}','GardenController@update')->middleware('owner');

Route::get('/garden/details/{id}','GardenDetailsController@create');
Route::post('/garden/details/{id}','GardenDetailsController@store');

Route::get('/garden/dispo/{id}', 'GardenDispoController@create');
Route::post('/garden/dispo/{id}','GardenDispoController@store');
Route::get('/garden/dispo/{id}/ok','GardenDispoController@update');

Route::get('/garden/prices/{id}','GardenPricesController@create');
Route::post('/garden/prices/{id}','GardenPricesController@store');

Route::get('/garden/staff/{id}','GardenStaffController@create');
Route::post('/garden/staff/{id}','GardenStaffController@store');

Route::get('/garden/infosLoc/{id}','GardenInfoLocController@show');
Route::post('/garden/infosLoc/{id}','GardenInfoLocController@store');

Route::get('/garden/images/{id}','GardenImagesController@create');

Route::get('/garden/reservations/{id}','GardenReservationController@index');

Route::get('/rent','RentCTAController@create');
Route::post('/rent/create','RentCTAController@store');

Route::get('/garden/mask/{id}','GardenMaskController@mask');
Route::get('/garden/unmask/{id}','GardenMaskController@unmask');

Route::get('/owner/reservations','OwnerReservationController@listReservationsInOwnedGardens');

//Valid garden warning
Route::get('/validWarning','ValidGardenController@index');

//ADMIN
Route::get('/admin','AdminController@create');
Route::get('/admin/users','AdminController@listUsers');
Route::get('/admin/user/{id}','AdminController@userDetails');
Route::get('/admin/bank/{id}','AdminController@userBank');
Route::post('/admin/bank/{id}','AdminController@setActiveUserBank');
Route::get('/admin/addBankAccount/{id}','AdminController@formAddBankAccount');
Route::post('/admin/addBankAccount/{id}','AdminController@addBankAccount');
Route::get('/admin/proofOfId/{id}','ProofOfIdController@adminCreate')->middleware('admin');
Route::get('/admin/gardens','AdminController@listGardens');
Route::get('/admin/garden/delete/{id}','AdminController@deleteGarden');
Route::get('/admin/garden/validate/{id}','AdminController@validateGarden');
Route::get('/admin/garden/unvalidate/{id}','AdminController@unvalidateGarden');
Route::get('/admin/garden/photos/{id}','AdminController@photos');
Route::post('/admin/garden/photos/{id}','AdminController@addPhoto');
Route::get('/admin/delphotos','AdminController@delPhoto');
Route::get('/admin/setOwner/{id}','AdminController@setOwner');
Route::get('/admin/blockUser/{id}','AdminController@blockUser');
Route::get('/admin/unblockUser/{id}','AdminController@unblockUser');
Route::get('/admin/modifyDesc/{id}','AdminController@modifyGardenDesc');
Route::post('/admin/modifyDesc/{id}','AdminController@saveGardenDesc');
Route::get('/admin/defautImg/{id}/{file_name}','AdminController@defautImg');


Route::get('/admin/sendMails','AdminSendMailController@create');
Route::post('/admin/sendMails','AdminSendMailController@send');

Route::get('/admin/invoices/tab','AdminInvoicesController@tab');
Route::get('/admin/invoices/byDate','AdminInvoicesController@dateForm');
Route::post('/admin/invoices/byDate','AdminInvoicesController@dateTab');
Route::get('/admin/invoices/byNumber','AdminInvoicesController@numberForm');
Route::post('/admin/invoices/byNumber','AdminInvoicesController@numberTab');
Route::get('admin/invoices/unprinted','AdminInvoicesController@unprinted');

//OSCAR 
Route::get('/oscar/menu','OscarController@menu');
Route::get('/oscar/view/{id}','OscarController@view');
Route::get('/oscar/decision/{id}','OscarController@decision');
Route::get('/reservation/oscarCancel/{id}','ReservationController@oscarCancel')->middleware(['auth','oscar']);
Route::get('/reservation/oscarConfirm/{id}','ReservationController@oscarConfirm')->middleware(['auth','oscar']);

//SEARCH ENGINE
Route::post('/search','SearchController@search');
Route::get('/search','SearchController@search');

Route::get('/view/{id}','GardenViewController@show');

//RESERVATIONS
Route::get('/reservations','ReservationController@index');

Route::post('/reservation/create','ReservationController@create')->middleware('resa.session');
Route::get('/reservation/create','ReservationController@createFromSession');
Route::get('/reservation/view/{id}','ReservationController@show');

Route::get('/reservation/userCancel/{id}','ReservationController@userCancel');
Route::post('/reservation/userConfirm','ReservationController@userConfirm');

Route::get('/reservation/ownerDecision/{id}','ReservationController@ownerShow');
Route::get('/reservation/ownerConfirm/{id}','ReservationController@ownerConfirm');
Route::get('/reservation/ownerCancel/{id}','ReservationController@ownerCancel');
Route::get('/reservation/ownerView/{id}','ReservationController@ownerShow');

Route::get('/reservation/createPayin/{id}','ReservationController@createPayin');
Route::get('/trickFrame/{id}','ReservationController@trickFrame');
Route::get('/backFromWebPay/{id}','ReservationController@backFromWebPay');


Route::get('/annulation/user/{id}','AnnulationController@byUser');
Route::get('/annulation/confirmByUser/{id}','AnnulationController@confirmByUser');

Route::get('/annulation/owner/{id}','AnnulationController@byOwner');
Route::get('annulation/confirmByOwner/{id}','AnnulationController@confirmByOwner');

//INVOICES AND RECEIPTS
Route::get('invoice/user/{id}','InvoiceController@userInvoice');
Route::get('invoice/owner/{id}','InvoiceController@ownerReceipt');
Route::get('invoice/userReceipt/{id}','InvoiceController@userReceipt');
Route::get('avis/owner/{id}','InvoiceController@ownerAvis');

//INVITATION CARDS
Route::get('/reservation/invitCard/{id}','InvitationCardController@create');
Route::get('/reservation/invitCard/{id}/preview','InvitationCardController@sendPreview');
Route::get('/reservation/invitCard/{id}/download','InvitationCardController@sendDocument');


//COMMENTS
Route::post('/comment/post','CommentController@postComment')->middleware('auth');
Route::post('/answer/post','CommentController@postAnswer')->middleware('auth');
Route::post('/report','CommentController@report');
Route::get('/admin/report/list','AdminMessageController@listReport');
Route::get('/admin/reported/{type}/{id}','AdminMessageController@seeReport');
Route::get('/admin/ignoreReport/{type}/{id}','AdminMessageController@ignoreReport');
Route::get('/admin/acceptReport/{type}/{id}','AdminMessageController@acceptReport');

//MAILS
Route::get('/contactMail',function(Request $req){
	return view('mails.contact',['fromLink'=>true]);
});

Route::get('/seeMail/{type}',function($type){
	$resa = new Reservation();
	$resa->user_id=1;
	$resa->garden_id = 1;
	$resa->date_begin = 'now';

	$user = User::findOrFail(1);
	$annulation = Annulation::fromUserReservation($resa, 45);
	$annulation->reservation = $resa;
	return view('mails.'.$type, array_merge(Request::all(),['fromLink'=>true,'title'=>trans('mails.titles.'.$type),
		'reservation'=>$resa, 'user'=>$user, 'success'=>true, 'id'=>0, 'token'=>'AAA',
		'link'=>'link', 'content'=>'Ceci est un message','email'=>$user->email,
		'sender'=>'Jean TEST', 'annulation'=>$annulation, 'name'=>$user->name, 'garden'=>$resa->garden, 'gardenName'=>$resa->garden->name]) );
});

Route::get('/seeAllMails',function(){
	$full_path = app_path().'/../resources/views/mails/';
	$files = scandir($full_path);
	unset($files[0]);
	unset($files[1]);
	if(($key = array_search('base.blade.php', $files)) !== false) {
		unset($files[$key]);
	}
	if(($key = array_search('contact.blade.php', $files)) !== false) {
		unset($files[$key]);
	}
	if(($key = array_search('seeAllMails.blade.php', $files)) !== false) {
		unset($files[$key]);
	}
 
	return view('mails.seeAllMails',['files'=>$files]);
})->middleware(['auth','admin']);

//CONTACT FORMS
Route::get('/contact/rent','ContactController@rent');
Route::post('/contact/rent','ContactController@sendRent');
Route::post('/offlineContact','ContactController@sendQuestion');

//Messages
Route::get('/messages','MessagesController@menu');
Route::post('/newMessage/{gardenId}','MessagesController@storeMessage');
Route::get('/messages/{gardenId}','MessagesController@listMessage');

Route::get('/owner/messages','MessagesController@ownerMenu');
Route::get('/owner/messages/{gardenId}/{askerId}','MessagesController@ownerListMessage');
Route::post('newAnswer/{gardenId}/{askerId}','MessagesController@storeAnswer');


//JSON for Ajax
Route::get('/jsonAPI/gardenHours', 'JSONApiController@gardenHours');
Route::get('/jsonAPI/calcPrice','JSONApiController@calcPrice');


//hooks for mangoPay
Route::get('/mangoHooks','MangoHooksController@start');

//template view for payin forms
Route::get('/template_payin',function(){
	return view('payin.template');
});
Route::post('/template_payin',function(){
	return view('payin.template');
});



