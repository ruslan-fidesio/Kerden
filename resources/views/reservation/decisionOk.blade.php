@extends('layouts.backend')


@section('headers')
@endsection

@section('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">  
				@if($decision == true)
					Acceptation 
				@else
					Refus 
				@endif
			de la réservation</div>
			<div class="panel-body">
				La réservation a bien été
				@if($decision == true)
					acceptée.
				@else
					refusée.
				@endif
				<hr>
				@if($decision == true)
					@if( !empty($charge) && $charge==true)
						Paiement encaissé.
					@else
						Paiement en attente de confirmation.
					@endif
				@endif
			</div>
		</div>
	</div>
</div>

@endsection