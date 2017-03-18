@foreach(Auth::user()->reservations as $resa)
	@if($resa->status=='done' && $resa->commentaire == null)
		<div class="alert alert-warning">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		 <i class="fa fa-warning"></i>	Vous avez récemment effectué une réservation. Donnez votre avis sur le lieu : <a href="{{url('/reservation/view/'.$resa->id)}}">Postez un commentaire.</a>
		</div>
	@endif

@endforeach