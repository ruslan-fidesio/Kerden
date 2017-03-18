@if(Auth::user()->ownedGardens->count()>0)
	@foreach(Auth::user()->ownedGardens as $garden)
		@if($garden->owner_masked)
			<div class="alert alert-warning fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Vous avez choisi de masquer l'annonce du lieu : {{$garden->title}}. <a href="{{url('/garden/unmask/'.$garden->id)}}">Cliquez ici pour la rendre visible.</a>
            </div>
		@endif
	@endforeach
@endif