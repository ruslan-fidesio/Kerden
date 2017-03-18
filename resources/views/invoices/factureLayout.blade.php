@extends('invoices.baseLayout')

@section('intermediate')
	<div class="row" style='margin-bottom:50px'>
		<div class="col-xs-12">
			<span style='font-size:1.5em'>Facture N°: </span>{{$facture->id}}<br/>
			<span style='font-size:1.5em'>Référence : </span>{{$facture->reference}}<br/>
			<br/>
			Nom et prénom du locataire : {{$facture->reservation->user->fullName}}<br/>
			Nom et prénom du propriétaire : {{$facture->reservation->garden->owner->fullName}}<br/>
			Devise : EUR (€)
			
		</div>
	</div>

<div class="row">@yield('content')</div>
	
@endsection