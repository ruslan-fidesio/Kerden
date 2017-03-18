@extends('invoices.baseLayout')


@section('intermediate')
	<div class="row" style='margin-bottom:50px'>
		<div class="col-xs-12">
			<span style='font-size:1.5em'>Reçu N°: </span>{{$receipt->id}}<br/>
			<span style='font-size:1.5em'>Référence : </span>{{$receipt->reference}}<br/>
			<br/>
			Nom et prénom du locataire : {{$receipt->reservation->user->fullName}}<br/>
			Nom et prénom du propriétaire : {{$receipt->reservation->garden->owner->fullName}}<br/>
			Devise : EUR (€)
			
		</div>
	</div>

	@yield('content')


@endsection