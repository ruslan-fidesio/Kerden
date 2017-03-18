@extends('layouts.backend')


@section('headers')
@endsection

@section('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"> Demande de réservation </div>
			<div class="panel-body">
				Votre demande de réservation à été envoyée au propriétaire du jardin.<br>
				Ce dernier a 7 jours pour valider votre réservation, au delà de cette limite la réservation sera automatiquement annulée.<br>
				Vous serait prévenu par mail de la décision du propriétaire.<br>
				Votre compte ne sera débité que lorsque le propriétaire aura accépté votre réservation.<br>
			</div>
		</div>
	</div>
</div>



@endsection