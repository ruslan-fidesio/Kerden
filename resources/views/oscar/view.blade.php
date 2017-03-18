@extends('layouts.backend')


@section('headers')
<link rel="stylesheet" type="text/css" href="{{ asset('css/resume.css') }}">
<meta http-equiv="pragma" content="no-cache" />
@endsection

@section('content')

<div class="container">
	<div style="display:none">{{ setlocale(LC_TIME,'fr_FR.UTF-8') }}</div>
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"> Récapitulatif de la réservation </div>
			<div class="panel-body">
				@if($reservation->status == 'confirmed' || $reservation->status == 'done')
					<div class="alert alert-info">Réservation {{$reservation->state}}</div>
				@else
					<div class="alert alert-warning">Réservation {{$reservation->state}}</div>
				@endif

				@if(!empty($errors->first()))
				<div class="alert alert-danger">
					{{$errors->first()}}
				</div>
				@endif
				<div class="row">
			<div class="col-md-6">

				<div class="resumeBloc identifiant">
					<span class="caption">n° d'identification de la réservation : </span> {{$reservation->id}}
				</div>
				
				<div class="resumeBloc lieu">
					<span class="caption">Lieu : </span>{{$reservation->garden->title}} , <br/>{{$reservation->garden->address}}
				</div>

				<div class="resumeBloc date">
					<span class="caption">Date : </span> {{ \Carbon\Carbon::parse($reservation->staff_begin)->formatLocalized('%A %d %B %Y') }}
				</div>
				<div class="resumeBloc hours">
					<span class="caption">De : </span>{{ (\Carbon\Carbon::parse($reservation->staff_begin)->hour) . 'h'}}
					<span class="caption">À : </span>{{ (\Carbon\Carbon::parse($reservation->date_end)->hour) .'h' }}
				</div>

				<div class="resumeBloc guests">
					<span class="caption">Nombre d'invités : </span>{{$reservation->nb_guests}}
				</div>

				
				<div class="resumeBloc staff">
					<span class="caption">Oscardiens : </span>
					@if($reservation->nb_staff > 0)
					<div class="nbStaff">{{$reservation->nb_staff}} 
						@if($reservation->nb_staff > 1)
							agents "Oscardiens" seront présents
						@else
							agent "Oscardien" sera présent
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
			</div>

			@if($reservation->staff_confirmed == 0 && $reservation->status == 'waiting_confirm')
				<div class="row">
					<div class="col-xs-6 col-md-offset-2">
						<a href=" {{ url('/reservation/ownerCancel/'.$reservation->id) }} "><button class='btn btn-danger'>Refuser</button></a>
					</div>
					<div class="col-xs-4">
						<a href=" {{ url('/reservation/ownerConfirm/'.$reservation->id) }} "><button class='btn btn-primary'>Accepter</button></a>
					</div>
				</div>
			@endif

			@if($reservation->status == 'refund_by_user' || $reservation->status == 'refund_by_owner')
			<div class="row">
				<hr/>
				<div class="col-xs-12" style="color:red">
					<b>Cette réservation a été annulée le {{ \Carbon\Carbon::parse($reservation->annulation->created_at)->formatLocalized('%A %d %B %Y à %k:%M') }}</b>
				</div>
				<div class="col-md-6">
					<div class="resumeBloc price">
						<span class="caption">Indémnités</span>
						<table class='table'>
							<tr class='info'><td>Indémnités annulation</td><td>{{ $reservation->annulation->staff_transfert_amount }}€</td></tr>
						</table>
					</div>
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