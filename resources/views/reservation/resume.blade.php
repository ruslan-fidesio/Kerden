@extends('layouts.backend')


@section('headers')
<meta http-equiv="pragma" content="no-cache" />
@endsection

@section('content')
<div class="container">
	<div style="display:none">{{ setlocale(LC_TIME,'fr_FR.UTF-8') }}</div>
	<div class="row" style='margin:0px'>
		@if($reservation->status == 'confirmed' || $reservation->status == 'done')
			<div class="alert alert-info">Réservation {{$reservation->state}}</div>
		@elseif($reservation->status == 'waiting_payin')
			<div class="alert alert-warning">Réservation en attente de votre paiement</div>
		@else
			<div class="alert alert-warning">Réservation {{$reservation->state}}</div>
		@endif

		@if($reservation->status == 'done' || $reservation->status == 'refund_by_user')
			<div>
				<a href="{{url('invoice/user/'.$reservation->id)}}"><div class="btn btn-kerden-confirm"><i class="fa fa-file-text-o"></i>&nbsp;Obtenir ma facture</div></a>
			</div>
		@elseif($reservation->status == 'refund_by_owner')
			<div>
				<a href="{{url('invoice/userReceipt/'.$reservation->id)}}"><div class="btn btn-kerden-confirm"><i class="fa fa-file-text-o"></i>&nbsp;Obtenir mon reçu</div></a>
			</div>
		@endif

		@if(!empty($errors->first()))
		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			{{$errors->first()}}
		</div>
		@endif

		@if($discussion)
		<a href="{{url('/messages/'.$reservation->garden_id)}}"><i class="fa fa-comments"></i> Voir la discusion</a>
		@endif

		<h3 class="text-center">{{$reservation->garden->title}}</h3>
		<div class="col-xs-12">
			<div class="thumbnail" style="border:none">
				<img src="{{ asset('storage/'.$reservation->garden->getFirstPhotoURL())}}" style="max-height:370px">
			</div>
		</div>

			<h3 class="text-center">Récapitulatif de votre réservation</h3>
			<hr style="width:50%;border-width:3px">
			
				
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
				<div class="col-xs-12 col-md-8 col-md-offset-2">
				@if( (Auth::user()->id == $reservation->user_id) &&  $reservation->status == 'new')
						{!! Form::open(['url'=>'/reservation/userConfirm']) !!}
						<h3 class="text-center">Détails de votre location</h3>
						<hr style="width:75%;border-width:3px">
						<div class="resumeBloc description">
							<h4 class="text-center">{{ trans('reservation.activityHelper') }}</h4>
							<div class="pictoLine text-center">
								@foreach( $reservation->garden->activities->getAttributes() as $k=>$v )
									@if($k != 'id')
										@if($v==1)
											<div class="picto picto-{{$k}}" data-sentence="{{ trans('reservation.autoSentencesBase').trans('reservation.activityAutoSentences.'.$k).trans('reservation.autoSentencesEnding')  }}" 
											onclick='generateSent(this);'></div>
										@endif
									@endif
								@endforeach
							</div>
							@if(session()->has('error'))
								<span style='color:red'><i class="fa fa-exclamation-circle"></i>{{session()->get('error')}}</span>
							@endif
							{!! Form::textarea('description',$reservation->description_by_user,['class'=>'form-control','id'=>'resaDescription','placeholder'=>trans('reservation.descriptionPlaceholder')]) !!}
						</div>
						<div class="col-xs-12 col-md-8 col-md-offset-2 ">

							@if($reservation->status == 'canceled_by_user' || $reservation->status == 'canceled_by_owner' ||
								$reservation->status == 'time_canceled')
							<div class="resumeBloc">
								<span style="color:orangered">- Réservation anulée avant facturation -</span>
							</div>
							@else
							<div class="resumeBloc price ">
								<h3 class="text-center">Prix de la location</h3>
								<hr style="border-width:3px;wifth:75%">
								<table class='table'>
									<tr ><td style='border-top:none'>Location jardin</td><td style='border-top:none'>{{$reservation->location_amount}} €</td></tr>
									<tr><td>Oscardiens</td><td>{{$reservation->staff_amount}} €</td></tr>
									<tr class='info'><td>TOTAL TTC</td><td>{{$reservation->total_amount}} €</td></tr>
								</table>
							</div>
							@endif

							
						</div>
						<div class="col-xs-6 text-center">
							
							<button type='button' class="kerden-flat-btn" onclick='history.back()'>Annuler ma demande</button>
						</div>
						<div class=" col-xs-6 text-center">
							
							{!! Form::hidden('id',$reservation->id) !!}
							<button type="submit" class="kerden-flat-btn">Confirmer ma demande</button>
						</div>
						{!! Form::close() !!}
					@else
						<div class="col-xs-12 col-md-8 col-md-offset-2">
							<div class="resumeBloc price ">
									<h3 class="text-center">Prix de la location</h3>
									<hr style="border-width:3px">
									<table class='table'>
										<tr ><td style='border-top:none'>Location jardin</td><td style='border-top:none'>{{$reservation->location_amount}} €</td></tr>
										<tr><td>Oscardiens</td><td>{{$reservation->staff_amount}} €</td></tr>
										<tr class='info'><td>TOTAL TTC</td><td>{{$reservation->total_amount}} €</td></tr>
									</table>
								</div>
						</div>
						@if( (Auth::user()->id == $reservation->user_id) && ($reservation->status == 'waiting_payin')  )
						<div class="row">
							<div class="col-sm-12">
								<div class='checkbox'>
					                <label>
					                    <input type="checkbox" name="checkCGU" id='checkCGU' value='accept' >
					                    J'accepte les <a href="#" data-toggle="modal" data-target="#cguModal">CGU du site Kerden.fr</a>, ainsi que les <a target="_blank" href="https://www.mangopay.com/terms/end-user-terms-and-conditions/Mangopay_Terms-FR.pdf">CGU de MangoPay.</a>
					                </label>
					            </div>
							</div>
						</div>
							<div class="link col-xs-6 text-center">
								<a href=" {{url('/annulation/user/'.$reservation->id)}} "><button type='button' class='btn btn-kerden-cancel'><span class="main">Annuler</span><span class="helper">et supprimer ma réservation</span></button></a>
							</div>
							<div class="link col-xs-6 text-center">
								<a onclick="return checkCGU()" href=" {{url('/reservation/createPayin/'.$reservation->id)}} "><button type="submit" class="btn btn-kerden-confirm"><span class="main">Confirmer</span><span class="helper">et passer au paiement</span></button></a>
							</div>
							<div class="helperTwo">(*) Vous avez jusqu'au {{ \Carbon\Carbon::parse($reservation->autoCancelDate)->formatLocalized('%A %d %B %Y à %R') }} pour payer et ainsi valider votre réservation.Au delà de cette limite votre réservation sera annulée.</div>						
						@endif
					@endif
					</div>

					@if($reservation->status == 'waiting_confirm'||$reservation->status == 'confirmed')
						<div class="col-xs-12 text-center">
							<a href="{{url('annulation/user/'.$reservation->id)}}"><div class="btn btn-kerden-cancel">Annuler la réservation</div></a>
						</div>
					@endif
				
				
			</div>
			@if($reservation->status == 'confirmed')
				<div class="row">
					@include('reservation.confirmedDetails')
				</div>
			@elseif($reservation->status == 'refund_by_user' || $reservation->status == 'refund_by_owner')
			<div class="row">
				@include('reservation.annulationDetails')
			</div>
			@elseif($reservation->status == 'done')
				@include('reservation.commentaire')
			@endif
	</div>
</div>

@include('footer')

@endsection


@section('scripts')
<script type="text/javascript">
function generateSent(value){
	$('#resaDescription').val($(value).attr('data-sentence'));
}
function checkCGU(){
	var check = $('#checkCGU').is(':checked');
	if(!check){
		alert("Vous devez accepter les CGU pour pouvoir continuer.");
	}
	return check;
}

(function($){
	$('#resaDescription').focus(function(e){
		var str = e.target.value;
		if(str.endsWith('...')){
			str = str.substr(0,str.length -3);
			$('#resaDescription').val(str+' ');
		}
	});

	$('#showTelNumber').click(function(){
	    var number = $('#telNumberValue').html();
	    console.log(number);
	    $(this).html(number);
		$(this).unbind('click');
	});

}) (jQuery);

</script>
@endsection