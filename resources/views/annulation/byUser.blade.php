@extends('layouts.backend')

@section('headers')
<link rel="stylesheet" type="text/css" href="{{ asset('css/resume.css') }}">
@endsection

@section('content')
<div class="container">
	<div class="panel panel-kerden-home">
		<div class="panel-heading">Annulation de la réservation</div>
		<div class="panel-body">

			@if($reservation->status != 'confirmed')
			<div class="row">
				La réservation n'ayant pas été confirmée, votre compte en banque n'a pas été débité.<br/>
				Vous pouvez effectuer cette annulation sans aucune conséquence. 
				<div class="row text-center">
					<a href="{{url('/annulation/confirmByUser/'.$reservation->id)}}" class='btn btn-kerden-confirm'>Confirmer l'annulation</a>
					<button class="btn btn-kerden-cancel" onclick='history.back()'>Revenir en arrière</button>
				</div>
			</div>

			@else 
			<!-- Réservation confirmée -->
			<div class="row">
			<p>La réservation ayant été préalablement encaissée, <br>
			et conformément au <a href="#" data-toggle="modal" data-target="#cguModal">Conditions Générales d'Utilisation</a>, voici comment vous serez remboursé:</p>

			<div class="resumeBloc">
				<span class="caption">Date de l'évenement :</span>{{$reservation->date_begin}}
			</div>
			<div class="resumeBloc">
				<span class="caption">Date de l'annulation : </span>{{\Carbon\Carbon::now('Europe/Paris')}}
			</div>
			<div class="resumeBloc">
				Vous annulez l'évenement {{$interval}} heures avant son début.
			</div>

				<div class="col-md-6">
					<div class="resumeBloc price">
						<span class="caption">Remboursement</span>
						<table class='table'>
							<tr><td>Oscardiens</td><td>{{ $oscarRefund }}€</td></tr>
							<tr><td>Location jardin ({{$percent}}%)</td><td>{{ $locationRefund }} €</td></tr>
							<tr class='info'><td>Remboursement final</td><td>{{ $oscarRefund + $locationRefund }} €</td></tr>
						</table>
					</div>
				</div>
				<div class="col-md-6">
					<div class="resumeBloc price">
						<span class="caption">Frais non remboursés</span>
						<table class='table'>
							<tr><td>Oscardiens</td><td>{{ $reservation->staff_amount - $oscarRefund }}€</td></tr>
							<tr><td>Commission Kerden</td><td>{{ $reservation->location_amount *17/100 }} €</td></tr>
							<tr><td>Indémnité propriétaire</td><td>{{ $reservation->location_amount * ( 83-$percent )/100 }}€</td></tr>
						</table>
					</div>
				</div>

			</div>
			<div class="row text-center">
				<a href="{{url('/annulation/confirmByUser/'.$reservation->id)}}" class='btn btn-kerden-confirm'>Confirmer l'annulation</a>
					<button class="btn btn-kerden-cancel" onclick='history.back()'>Revenir en arrière</button>
			</div>
			@endif
		</div>
	</div>
</div>

@include('footer')

@endsection