@extends('invoices.receiptLayout')

@section('phrase')
Bonjour {{$receipt->reservation->garden->owner->firstName}},<br/>
@if($receipt->reservation->annulation->owner_transfert_amount > 0)
Le locataire vient d'annuler la réservation de votre jardin, veuillez trouver ci-dessous le montant de votre indemnité.
@else
Le locataire vient d’annuler la réservation de votre jardin.<br/>
Nous sommes au regret de vous annoncer que vous ne serez pas remboursé.<br/>
@endif
@endsection


@section('content')
<div class="col-xs-12">
	
	<table class="table table-bordered">
		<thead>
			<th>Date</th> <th>Description</th> <th>Montant</th>
		</thead>
	
		
		<tr>
			<td>{{Carbon\Carbon::parse($receipt->reservation->annulation->created_at)->format("d / m / Y")}}</td>
			<td class="text-center">Indemnité propriétaire ({{ ($receipt->reservation->annulation->owner_transfert_amount / $receipt->reservation->location_amount) * 100}}% du prix de la location)</td>
			<td class='text-right'>{{$receipt->reservation->annulation->owner_transfert_amount}}€</td>
		</tr>
	

	</table>

	<div class="col-xs-6 col-xs-offset-6" style='margin-top:50px'>
		<table class='table'>
			<tr> <td><span>SOUS-TOTAL</span></td> <td class="text-right">{{$receipt->reservation->annulation->owner_transfert_amount}}€</td> </tr>
			<tr  style="font-size:1.4em;font-weight:bold"><td><span>TOTAL</span></td><td class="text-right">{{$receipt->reservation->annulation->owner_transfert_amount}}€</td> </tr>
		</table>
	</div>

	<div class="text-right">
		TVA non applicable - Article 293 B du CGI
	</div>
</div>

@endsection