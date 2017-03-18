<?php

namespace App\Traits;

use App\MangoUser;

trait MangoPayTrait{
	private static $mangoPayApi;

	private function getApi(){
		if(self::$mangoPayApi == null){
                        self::$mangoPayApi = new \MangoPay\MangoPayApi();
                        self::$mangoPayApi->Config->ClientId = env('MANGO_CLIENT_ID');
                        self::$mangoPayApi->Config->ClientPassword = env('MANGO_KEY');
                        self::$mangoPayApi->Config->TemporaryFolder = storage_path().'/mangopay/'.env('MANGO_ENV');
                        self::$mangoPayApi->Config->BaseUrl = 'https://api.mangopay.com';
                }
		return self::$mangoPayApi;
	}

        private function populateNaturalUser($user,$details){
                $mangoUser = new \MangoPay\UserNatural();
                $mangoUser->PersonType = "NATURAL";
                $mangoUser->Email = $user->email;
                $mangoUser->FirstName = $user->firstName;
                $mangoUser->LastName = $user->lastName;
                $mangoUser->Birthday = strtotime($details->birthday);
                $mangoUser->Nationality = $details->nationality;
                $mangoUser->CountryOfResidence = 'FR';
                $mangoUser->Address = ['AddressLine1'=>$details->addressLine1,
                                        'AddressLine2'=>$details->addressLine2,
                                        'City'=>$details->addressCity,
                                        'PostalCode'=>$details->addressPostalCode,
                                        'Country'=>'FR'];
                return $mangoUser;
        }

        private function populateLegalUser($user,$details,$orga){
                $mangoUser = new \MangoPay\UserLegal();
                $mangoUser->Email = $user->email;
                $mangoUser->Name = $orga->name;
                $mangoUser->LegalPersonType = "ORGANIZATION";
                $mangoUser->HeadquartersAddress = ['AddressLine1' => $orga->headQuartersAddressLine1,
                                                'AddressLine2' => $orga->headQuartersAddressLine2,
                                                'PostalCode' => $orga->headQuartersAddressPostalCode,
                                                'City' => $orga->headQuartersAddressCity,
                                                'Country' => 'FR'];
                $mangoUser->LegalRepresentativeFirstName = $user->firstName;
                $mangoUser->LegalRepresentativeLastName = $user->lastName;
                $mangoUser->LegalRepresentativeAddress = ['AddressLine1'=>$details->addressLine1,
                                        'AddressLine2'=>$details->addressLine2,
                                        'City'=>$details->addressCity,
                                        'PostalCode'=>$details->addressPostalCode,
                                        'Country'=>'FR'];
                $mangoUser->LegalRepresentativeBirthday = strtotime($details->birthday);
                $mangoUser->LegalRepresentativeNationality = $details->nationality;
                $mangoUser->LegalRepresentativeCountryOfResidence = 'FR';
                return $mangoUser;
        } 

        private function storeMangoDetails($userId,$mangoUserId,$mangoWalletId){
                $mangoModel = new MangoUser();
                $mangoModel->id = $userId;
                $mangoModel->mangoUserId = $mangoUserId;
                $mangoModel->mangoWalletId = $mangoWalletId;

                $mangoModel->save();
        }

        private function createUser($user,$details,$orga){
                if($details->type=='natural'){
                        $mangoUser = $this->populateNaturalUser($user,$details);
                }else{
                        $mangoUser = $this->populateLegalUser($user,$details,$orga);
                }
                $mangoUser = $this->getApi()->Users->Create($mangoUser);
                $mangowallet = $this->createWallet($mangoUser->Id);
                //STORE
                $this->storeMangoDetails($user->id,$mangoUser->Id,$mangowallet->Id);
        }

        private function createWallet($mangoUserId){
                $wallet = new \MangoPay\Wallet();
                $wallet->Owners = [$mangoUserId];
                $wallet->Description = "Wallet for Kerden - the garden marketplace";
                $wallet->Currency = "EUR";

                return $this->getApi()->Wallets->Create($wallet);
        }

        private function updateUser($mangoModel,$user,$details,$orga){
                if($details->type=='natural'){
                        $mangoUser = $this->populateNaturalUser($user,$details);
                }else{
                        $mangoUser = $this->populateLegalUser($user,$details,$orga);
                }
                $mangoUser->Id = $mangoModel->mangoUserId;
                return $this->getApi()->Users->Update($mangoUser);
        }

        public function createOrUpdateUser($user,$details,$orga){
                //check if user exists
                $mangoModel = MangoUser::find($user->id);
                if($mangoModel){
                        $this->updateUser($mangoModel,$user,$details,$orga);
                }else{
                        $this->createUser($user,$details,$orga);
                }
        }

        public function storeAdvancedDetails($user, $adDetails){
                $mangoModel = MangoUser::findOrFail($user->id);
                $mangoUser = new \MangoPay\UserNatural();
                $mangoUser->Id = $mangoModel->mangoUserId;
                $mangoUser->Occupation = $adDetails->occupation;
                $mangoUser->IncomeRange = $adDetails->income_range;

                return $this->getApi()->Users->Update($mangoUser);
        }

        private function checkPayInStatus($payInId){
                $res = $this->getApi()->PayIns->Get($payInId);
                return $res;
        }

        private function createDirectPayin($creditedUserId, $creditedWalletId, $amount, $reservationId){
                $PayIn = new \MangoPay\PayIn();
                $PayIn->CreditedWalletId = $creditedWalletId;
                $PayIn->AuthorId = $creditedUserId;
                $PayIn->PaymentType = "CARD";
                $PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
                $PayIn->PaymentDetails->CardType = "CB_VISA_MASTERCARD";
                $PayIn->DebitedFunds = new \MangoPay\Money();
                $PayIn->DebitedFunds->Currency = "EUR";
                $PayIn->DebitedFunds->Amount = $amount * 100;
                $PayIn->Fees = new \MangoPay\Money();
                $PayIn->Fees->Currency = "EUR";
                $PayIn->Fees->Amount = 0;
                $PayIn->ExecutionType = \MangoPay\PayInExecutionType::Web;
                $PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
                $PayIn->ExecutionDetails->ReturnURL = url('/trickFrame/'.$reservationId);
                $PayIn->ExecutionDetails->Culture = "FR";
                //$PayIn->TemplateURLOptions = new \MangoPay\PayInTemplateURLOptions();
                //$PayIn->TemplateURLOptions->PAYLINE = 'https://www.kerden.fr/template_payin';
                
                return $this->getApi()->PayIns->Create($PayIn);
        }

        private function getBankAccounts($userId){
                $bankAcc = $this->getApi()->Users->GetBankAccounts($userId);
                return $bankAcc;
        }

        private function createBankAccount($userId,$details,$fullName,$iban,$bic){
                $bankAcc = new \MangoPay\BankAccount();
                $bankAcc->Type='IBAN';
                $bankAcc->OwnerAddress = ['AddressLine1'=>$details->addressLine1,
                                        'AddressLine2'=>$details->addressLine2,
                                        'City'=>$details->addressCity,
                                        'PostalCode'=>$details->addressPostalCode,
                                        'Country'=>'FR'];
                $bankAcc->OwnerName = $fullName;
                $bankAcc->Details = new \MangoPay\BankAccountDetailsIBAN();
                $bankAcc->Details->IBAN = $iban;
                $bankAcc->Details->BIC = $bic;
                return $this->getApi()->Users->CreateBankAccount($userId,$bankAcc);
        }

        private function createKYCDocument($userId,$documentType){
                $kycDoument = new \MangoPay\KycDocument();
                $kycDoument->Type = $documentType;
                return $this->getApi()->Users->CreateKycDocument($userId,$kycDoument);
        }

        private function createKYCPage($userId,$KYCDocumentId, $file){
                return $this->getApi()->Users->CreateKycPageFromFile($userId, $KYCDocumentId, $file);
        }

        private function updateKYCDocument($userId,$KYCDocumentId,$state){
                $kycDocument = new \MangoPay\KycDocument();
                $kycDocument->Id = $KYCDocumentId;
                $kycDocument->Status = $state;
                return $this->getApi()->Users->UpdateKycDocument($userId,$kycDocument);
        }

        private function makeTransfert($tag, $debitedUserId, $debitedWalletId, $creditedUserId ,$creditedWalletId,$amount,$fees){
                try{
                        $Transfer = new \MangoPay\Transfer();
                        $Transfer->Tag = "transfert for reservation : ".$tag;
                        $Transfer->AuthorId = $debitedUserId;
                        $Transfer->CreditedUserId = $creditedUserId;

                        $Transfer->DebitedFunds = new \MangoPay\Money();
                        $Transfer->DebitedFunds->Currency = "EUR";
                        $Transfer->DebitedFunds->Amount = $amount;
                        $Transfer->Fees = new \MangoPay\Money();
                        $Transfer->Fees->Currency = "EUR";
                        $Transfer->Fees->Amount = $fees;
                        $Transfer->DebitedWalletId = $debitedWalletId;
                        $Transfer->CreditedWalletId = $creditedWalletId;

                        return $this->getApi()->Transfers->Create($Transfer);
                }
                catch(\Exception $e){
                        throw $e;
                }
        }

        private function makePayOut($tag,$mangoUserId,$mangoWalletId,$amount,$bankAccountId,$fees){
                try{
                        $PayOut = new \MangoPay\PayOut();
                        $PayOut->Tag = "payout for reservation : ".$tag;
                        $PayOut->AuthorId = $mangoUserId;
                        $PayOut->DebitedWalletID = $mangoWalletId;
                        $PayOut->DebitedFunds = new \MangoPay\Money();
                        $PayOut->DebitedFunds->Currency = "EUR";
                        $PayOut->DebitedFunds->Amount = $amount;
                        $PayOut->Fees = new \MangoPay\Money();
                        $PayOut->Fees->Currency = "EUR";
                        $PayOut->Fees->Amount = $fees;
                        $PayOut->PaymentType = "BANK_WIRE";
                        $PayOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
                        $PayOut->MeanOfPaymentDetails->BankAccountId = $bankAccountId;
                        
                        return $this->getApi()->PayOuts->Create($PayOut);
                }
                catch(\Exception $e){
                        throw $e;
                }
        }

        private function makeRefund($tag,$payInId,$mangoUserId,$amount,$fees){
                $PayInId = $payInId;

                $Refund = new \MangoPay\Refund();
                $Refund->Tag = $tag;
                $Refund->AuthorId = $mangoUserId;
                $Refund->DebitedFunds = new \MangoPay\Money();
                $Refund->DebitedFunds->Currency = "EUR";
                $Refund->DebitedFunds->Amount = $amount;
                $Refund->Fees = new \MangoPay\Money();
                $Refund->Fees->Currency = "EUR";
                $Refund->Fees->Amount = $fees;
                return  $this->getApi()->PayIns->CreateRefund($PayInId, $Refund);
        }

        private function disactivateCard($cardId){
                $card = new \MangoPay\Card();
                $card->Id = $cardId;
                $card->Active = false;
                $this->getApi()->Cards->Update($card);
        }
        

}


