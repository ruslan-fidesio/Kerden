@extends('layouts.backend')

@section('headers')
<link rel="stylesheet" type="text/css" href="{{ asset('css/cardForm.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Paiement</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-3">
                    <a href=" {{url('reservation/view/'.$reservation->id)}} ">
                        <div class="btn btn-warning">Retour à la réservation</div>
                    </a>
                </div>
                <div class="cardForm col-xs-6">
                    <div class="caption"><i class="fa fa-lock"></i>&nbsp;Paiement</div>
                    @if(count($errors)>0)
                        <div class="alert alert-danger fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{$errors->first()}}</div>
                    @endif
                    <label>Location de : {{$reservation->garden->title}}</label><br/>
                    <label> par {{$reservation->user->fullName}}</label><br/>
                    <label style="font-size:1.5em"> Montant total {{ $reservation->total_amount}} €</label><br/>

                    <img src="http://www.credit-card-logos.com/images/multiple_credit-card-logos-2/credit_card_logos_40.gif">

                    <form action="{{$cardRegistrationObject->CardRegistrationURL }}" method="post" id='payForm'>
                        <input type="hidden" name="data" value="{{ $cardRegistrationObject->PreregistrationData }}" />
                        <input type="hidden" name="accessKeyRef" value="{{ $cardRegistrationObject->AccessKey }}" />
                        <input type="hidden" name="returnURL" value="{{ url('/confirmCardRegister/'.$payIn->id) }}" />

                        <div class="row">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="cardNumber" value="" placeholder="Numéro de carte"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <input class="form-control" type="text" name="cardExpirationDate" value="" placeholder="MMAA" />
                            </div>
                            <div class="col-xs-6">
                                <input class="form-control" type="text" name="cardCvx" value="" placeholder="Cryptogramme"/>
                            </div>
                        </div>
                        <div class="row text-center">
                            <input class='btn btn-primary' id="submitPay" type="submit" value="Valider" />
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">
(function($){
    $('#submitPay').click(function(e){
        $('#submitPay').attr('disabled','disabled');
        $('body').css('cursor','wait');
        $('#payForm').submit();
    });
}) (jQuery);
</script>
@endsection