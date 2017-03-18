@foreach(Auth::user()->ownedGardens as $garden )

	@foreach($garden->reservations as $resa)
		@if($resa->status=='waiting_confirm' && !$resa->owner_confirmed)
			<div class="alert alert-warning">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			 <i class="fa fa-warning"></i>	Une réservation est en attente de votre confirmation : <a href="{{url('/reservation/ownerView/'.$resa->id)}}">Voir</a>
			</div>
		@endif

		@if($resa->status == 'confirmed' && \Carbon\Carbon::parse($resa->date_begin)->diffInDays(\Carbon\Carbon::now()) <=7 )
			<div class="alert alert-warning">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			 <i class="fa fa-warning"></i>	Une réservation confirmée va avoir lieu bientôt: <a href="{{url('/reservation/ownerView/'.$resa->id)}}">Voir</a>
			</div>
		@endif

	@endforeach

@endforeach


@foreach(Auth::user()->reservations as $resa)

	@if($resa->status == "waiting_payin")
		<div class="alert alert-warning">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		 <i class="fa fa-warning"></i>	Une réservation est en attente de votre paiement : <a href="{{url('/reservation/view/'.$resa->id)}}">Voir</a>
		</div>
	@endif

	@if($resa->status == 'confirmed' && \Carbon\Carbon::parse($resa->date_begin)->diffInDays(\Carbon\Carbon::now()) <=7 )
			<div class="alert alert-warning">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			 <i class="fa fa-warning"></i>	Une réservation confirmée va avoir lieu bientôt: <a href="{{url('/reservation/view/'.$resa->id)}}">Voir</a>
			</div>
		@endif

@endforeach