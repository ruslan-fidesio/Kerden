@extends('layouts.backend')


@section('headers')
@endsection

@section('content')

<div class="container">
	<div class="row">
		<div class="panel panel-kerden-home">
			<div class="panel-heading"> Demande de réservation </div>
			<div class="panel-body">
				Votre demande de réservation à été envoyée au propriétaire du jardin.<br>
				Ce dernier a jusqu'au <strong>{{ \Carbon\Carbon::parse($reservation->autoCancelDate)->formatLocalized('%A %d %B %Y à %R') }}</strong> pour valider votre réservation, au delà de cette limite la réservation sera automatiquement annulée.<br>
				Vous serait prévenu par mail de la décision du propriétaire.<br>
				<a href="{{url('/search')}}">Retouner à la recherche</a><br>
			</div>
		</div>
	</div>
</div>

@include('footer')

@endsection