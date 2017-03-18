@extends('layouts.backend')


@section('headers')
<meta http-equiv="pragma" content="no-cache" />
@endsection

@section('content')

<div class="container">
	<span style="display:none">{{ setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
	@if($reservation->status == 'confirmed' || $reservation->status == 'done')
		<div class="alert alert-info">Réservation {{$reservation->state}}</div>
	@else
		<div class="alert alert-warning">Réservation {{$reservation->state}}</div>
	@endif

	@if(!empty($errors->first()))
		<div class="alert alert-danger">{{$errors->first()}}</div>
	@endif

	@if($reservation->status == "done" || $reservation->status == 'refund_by_user')
		<div>
			<a href="{{url('invoice/owner/'.$reservation->id)}}"><div class="btn btn-kerden-confirm"><i class="fa fa-file-text-o"></i>&nbsp;Obtenir mon reçu</div></a>
		</div>
	@elseif($reservation->status == "refund_by_owner")
		<div>
			<a href="{{url('avis/owner/'.$reservation->id)}}"><div class="btn btn-kerden-confirm"><i class="fa fa-file-text-o"></i>&nbsp;Obtenir mon avis de pénalité</div></a>
		</div>
	@endif

	@if($discussion)
	<a href="{{url('/owner/messages/'.$reservation->garden_id.'/'.$reservation->user_id)}}"><i class="fa fa-comments"></i>  Voir la discusion</a>
	@endif

	<h3 class="text-center">{{$reservation->garden->title}}</h3>
		<div class="col-xs-12">
			<div class="thumbnail" style="border:none">
				<img src="{{ asset('storage/'.$reservation->garden->getFirstPhotoURL())}}"  style="max-height:370px">
			</div>
		</div>
		<h3 class="text-center">Récapitulatif de la réservation</h3>
		<hr style="border-width:3px; width:50%">
			<div class="row">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
					<div class="resumeBloc lieu">
						<span class="caption">Lieu : {{$reservation->garden->title}}</span>
					</div>
					<div class="resumeBloc date">
						<span class="caption">Date :  {{ \Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</span>
					</div>
					<div class="resumeBloc">
						<span class="caption">Horaires : De {{ \Carbon\Carbon::parse($reservation->date_begin)->hour. 'h00'}} À {{ \Carbon\Carbon::parse($reservation->date_end)->hour.'h00' }}</span>
					</div>

					<div class="resumeBloc guests">
						<span class="caption">Nombre d'invités : {{$reservation->nb_guests}}</span>
					</div>

					
					<div class="resumeBloc staff">
						<span class="caption">Oscardiens : 
						@if($reservation->nb_staff > 0)
						{{$reservation->nb_staff}} 
							@if($reservation->nb_staff > 1)
								agents "Oscardiens" seront présents
							@else
								agent "Oscardien" sera présent
							@endif
							, entre {{ \Carbon\Carbon::parse($reservation->staff_begin)->hour  }}h et {{\Carbon\Carbon::parse($reservation->date_end)->hour}}h
						@else
						pas d'Oscardiens
						@endif
						</span>
					</div>
			</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-8 col-md-offset-2">
					<h3 class="text-center">Description de l'activité par le locataire</h3>
					<hr style="width:75%;border-width:3px">
					<div class="resumeBloc description">
						<textarea name="ActivityDesc" class="form-control" disabled="disabled">{{$reservation->description_by_user}}</textarea>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-md-8 col-md-offset-2">
				@if($reservation->status == 'canceled_by_user' || $reservation->status == 'canceled_by_owner' ||
						$reservation->status == 'time_canceled')
					<div class="resumeBloc">
						<span style="color:orangered">- Réservation anulée avant facturation -</span>
					</div>
				@else
				<h3 class="text-center">Gains</h3>
				<hr style="width:75%;border-width:3px">				
					<div class="resumeBloc price">
						<table class='table'>
							<tr><td style='border:none'>Location jardin</td><td style='border:none'>{{$reservation->location_amount}} €</td></tr>
							<tr><td>Commission Kerden</td><td>{{ ($reservation->location_amount) * ( env('KERDEN_FEES_PERCENT')/100 )  }} €</td></tr>
						@if($reservation->status == 'done' && $reservation->applied_penalities > 0)
							<tr style='background-color:orangered'><td>Pénalité annulation</td><td>{{ $reservation->applied_penalities }} €</td> </tr>
						@endif
							<tr class='info'><td>Revenu final</td><td>{{ number_format(($reservation->location_amount * ( (100-env('KERDEN_FEES_PERCENT'))/100 ) )-$reservation->applied_penalities,2)}} €</td></tr>
						</table>
					</div>
					@if(($reservation->status=='confirmed'||$reservation->status=='waiting_confirm')&&(Auth::user()->getTotalPenalitesAmount()>0))
						<p style='color:red'><i class="fa fa-warning"></i>Vous avez une pénalité en cours. Le revenu annoncé sera amputé d'une somme allant jusqu'à {{Auth::user()->getTotalPenalitesAmount()}} €</p>
					@endif
				@endif
			</div>

			@if($reservation->owner_confirmed == 0 && $reservation->status == 'waiting_confirm')
				<div class="row">
					<div class="col-xs-6 text-center">
						<button id='btnCancel' class='kerden-flat-btn'>Refuser la demande</button>
					</div>
					<div class="col-xs-6 text-center">
						<button id='btnConfirm' class='kerden-flat-btn'>Accepter la demande</button>
					</div>
				</div>
			@endif

			@if($reservation->status == 'refund_by_user' || $reservation->status == 'refund_by_owner')
			<div class="row">
				<div class="col-xs-12 col-md-8 col-md-offset-2">
					@include('reservation.annulationDetailsForOwner')
				</div>
			</div>
			@elseif($reservation->status == "done")
			<div class="row">
				<div class="col-xs-12">
					@include('reservation.ownerCommentaire')
				</div>
			</div>
			@endif
			@if($reservation->status == 'confirmed')
			<div class="col-xs-12 text-center">
				<a href="{{url('annulation/owner/'.$reservation->id)}}"><div class="btn btn-kerden-cancel">Annuler la réservation</div></a>
			</div>
			@endif
			

			</div>
		</div>
	</div>
</div>

@include('footer')

@endsection


@section('scripts')
<script type="text/javascript">
(function($){
	$('#btnCancel').click(function(e){
		$('#btnCancel').hide();
		$('#btnConfirm').hide();
		document.location = "{{url('/reservation/ownerCancel/'.$reservation->id)}}";
	});
	$('#btnConfirm').click(function(e){
		$('#btnCancel').hide();
		$('#btnConfirm').hide();
		document.location = "{{url('/reservation/ownerConfirm/'.$reservation->id)}}";
	});

}) (jQuery);

</script>
@endsection