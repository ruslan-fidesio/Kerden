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
				<div class="row">
					<div class="col-md-6">

						<div class="resumeBloc identifiant">
							<span class="caption">n° d'identification de la réservation : </span> {{$reservation->id}}
						</div>
						
						<div class="resumeBloc lieu">
							<span class="caption">Lieu : </span>{{$reservation->garden->title}} , {{$reservation->garden->fullBlurAddress}}
						</div>

						<div class="resumeBloc date">
							<span class="caption">Date : </span> {{ \Carbon\Carbon::createFromTimestamp($reservation->date)->formatLocalized('%A %d %B %Y') }}
						</div>
						<div class="resumeBloc hours">
							<span class="caption">De : </span>{{ ($reservation->slot_begin % 24) . 'h'}}
							<span class="caption">À : </span>{{ ($reservation->slot_end % 24) .'h' }}
						</div>

						<div class="resumeBloc guests">
							<span class="caption">Nombre d'invités : </span>{{$reservation->nb_guests}}
						</div>

						
						<div class="resumeBloc staff">
							<span class="caption">Oscardiens : </span>
							@if($reservation->staff_slot_begin > 0)
							<div class="nbStaff">{{$reservation->nb_staff}} 
								@if($reservation->nb_staff > 1)
									agents "Oscardiens" seront présents
								@else
									agent "Oscardien" sera présent
								@endif
								, entre {{$reservation->staff_slot_begin%24}}h et {{$reservation->staff_slot_end%24}}h</div>
							@else
							<div class="nbStaff">pas de personnel</div>
							@endif
						</div>

						<div class="resumeBloc price">
							<span class="caption">Revenu</span>
							<table class='table'>
								<tr><td>Location jardin</td><td>{{$reservation->total_amount - $reservation->staff_amount}} €</td></tr>
								<tr><td>Commission Kerden</td><td>{{ ($reservation->total_amount - $reservation->staff_amount) /10}} €</td></tr>
								<tr class='info'><td>Revenu final</td><td>{{ ($reservation->total_amount - $reservation->staff_amount) * 0.9  }} €</td></tr>
							</table>
						</div>
					</div>

					<div class="col-md-6">
						<div class="resumeBloc description">
							<span class="caption">Description de l'activité par le locataire</span>
							<hr/>
							{{$reservation->description_by_user}}
						</div>
					</div>
				</div>

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