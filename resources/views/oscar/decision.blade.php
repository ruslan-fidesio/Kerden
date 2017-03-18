@extends('layouts.backend')


@section('headers')
<link rel="stylesheet" type="text/css" href="{{ asset('css/resume.css') }}">
<meta http-equiv="pragma" content="no-cache" />
@endsection

@section('content')
{{ setlocale(LC_TIME,'fr_FR.UTF-8') }}

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"> Récapitulatif de la réservation </div>
			<div class="panel-body">
			<div class="col-md-6">

				<div class="resumeBloc identifiant">
					<span class="caption">n° d'identification de la réservation : </span> {{$reservation->id}}
				</div>
				
				<div class="resumeBloc lieu">
					<span class="caption">Lieu : </span>{{$reservation->garden->title}} ,<br/> {{$reservation->garden->address}}
				</div>

				<div class="resumeBloc date">
					<span class="caption">Date : </span> {{ \Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}
				</div>
				<div class="resumeBloc hours">
					<span class="caption">De : </span>{{ \Carbon\Carbon::parse($reservation->staff_begin)->hour . 'h'}}
					<span class="caption">À : </span>{{ \Carbon\Carbon::parse($reservation->date_end)->hour .'h' }}
				</div>

				<div class="resumeBloc guests">
					<span class="caption">Nombre d'invités : </span>{{$reservation->nb_guests}}
				</div>

				
				<div class="resumeBloc staff">
					<span class="caption">Oscardiens : </span>
					@if($reservation->nb_staff > 0)
					<div class="nbStaff">{{$reservation->nb_staff}} 
						@if($reservation->nb_staff > 1)
							agents "Oscardiens" sont demandés
						@else
							agent "Oscardien" est demandé
						@endif
						, entre {{\Carbon\Carbon::parse($reservation->staff_begin)->hour}}h et {{\Carbon\Carbon::parse($reservation->date_end)->hour}}h</div>
					@else
					<div class="nbStaff">pas d'Oscardiens</div>
					@endif
				</div>

				<div class="resumeBloc price">
					<span class="caption">Revenu</span>
					<table class='table'>
						<tr><td>Agents</td><td>{{$reservation->staff_amount}} €</td></tr>
						<tr class='info'><td>Revenu final</td><td>{{ $reservation->staff_amount }} €</td></tr>
					</table>
				</div>
			</div>

			<div class="col-md-6">
				<div class="resumeBloc description">
					<span class="caption">Description de l'activité par le locataire</span>
					<hr/>
					{{$reservation->description_by_user}}
				</div>
				<div>
					<span class='caption'>Statut de la réservation : </span>{{$reservation->state}}
				</div>
			</div>

			@if($reservation->staff_confirmed == 0 && $reservation->status == 'waiting_confirm')
				<div class="row">
					<div class="col-xs-6 col-md-offset-2">
						<a href=" {{ url('/reservation/oscarCancel/'.$reservation->id) }} "><button class='btn btn-danger'>Refuser</button></a>
					</div>
					<div class="col-xs-4">
						<a href=" {{ url('/reservation/oscarConfirm/'.$reservation->id) }} "><button class='btn btn-primary'>Accepter</button></a>
					</div>
				</div>
			@endif
			

			</div>
		</div>
	</div>
</div>

@endsection


@section('scripts')
<script type="text/javascript">
(function($){

}) (jQuery);

</script>
@endsection