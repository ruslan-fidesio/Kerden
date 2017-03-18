@if(Auth::user()->getActivePenalites()->count() > 0)

	<h3>Penalité d'annulation</h3>
	<p>Vous avez récement annulé une ou plusieurs réservation concernant un de vos jardins. Vous avez donc une pénalité  : </p>
		<table class='table'>
			<thead><th>Montant Original</th> <th>Montant restant</th> </thead>
		@foreach( Auth::user()->getActivePenalites() as $pen )
			<tr> <td>{{$pen->total_amount}}€</td><td>{{$pen->current_amount}}€</td> </tr>
		@endforeach
		</table>

	Nous déduirons automatiquement toute pénalité de votre prochain versement.

@endif