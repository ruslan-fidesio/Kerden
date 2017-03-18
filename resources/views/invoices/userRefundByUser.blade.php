@extends('invoices.factureLayout')

@section('phrase')
Bonjour {{$facture->reservation->user->firstName}},<br/>
Vous venez d'annuler la réservation du jardin "{{$facture->reservation->garden->title}}", vous trouverez ci-dessous le montant qui vous a été facturé.<br/>

@if($facture->reservation->annulation->staff_transfert_amount > 0)
Si vous aviez réservé des Oscardiens pour votre évènement, le montant vous sera intégralement facturé.
@else
Si vous aviez réservé des Oscardiens pour votre évènement, le montant ne vous sera pas facturé.
@endif

@endsection

@section('content')
<div class="col-xs-12">
	
	<table class="table table-bordered">
		<thead>
			<th>Date</th> <th>Description</th> <th>Montant</th>
		</thead>
	
		<tr>
			<td>{{Carbon\Carbon::parse($facture->reservation->annulation->created_at)->format("d / m / Y")}}</td>
			<td class="text-center">Frais d'annulation (17% du prix de la location)</td>
			<td class="text-right">{{$facture->reservation->annulation->fees}}€</td>
		</tr>

		@if($facture->reservation->annulation->owner_transfert_amount > 0 )
			<tr>
				<td>{{Carbon\Carbon::parse($facture->reservation->annulation->created_at)->format("d / m / Y")}}</td>
				<td class="text-center">Indemnité propriétaire ({{ ($facture->reservation->annulation->owner_transfert_amount / $facture->reservation->location_amount) * 100}}% du prix de la location)</td>
				<td class='text-right'>{{$facture->reservation->annulation->owner_transfert_amount}}€</td>
			</tr>
		@endif

		@if($facture->reservation->annulation->staff_transfert_amount > 0 )
			<tr>
				<td>{{Carbon\Carbon::parse($facture->reservation->annulation->created_at)->format("d / m / Y")}}</td>
				<td class="text-center">{{$facture->reservation->nb_staff}} Oscardien(s)</td>
				<td class='text-right'>{{$facture->reservation->annulation->staff_transfert_amount}}€</td>
			</tr>
		@endif

	</table>

	<div class="col-xs-6 col-xs-offset-6" style='margin-top:50px'>
		<table class='table'>
			<tr> <td><span>SOUS-TOTAL</span></td> <td class="text-right">{{$facture->reservation->annulation->fees + $facture->reservation->annulation->owner_transfert_amount + $facture->reservation->annulation->staff_transfert_amount}}€</td> </tr>
			<tr  style="font-size:1.4em;font-weight:bold"><td><span>TOTAL</span></td><td class="text-right">{{$facture->reservation->annulation->fees + $facture->reservation->annulation->owner_transfert_amount + $facture->reservation->annulation->staff_transfert_amount}}€</td> </tr>
		</table>
	</div>

	<div class="text-right">
		TVA non applicable - Article 293 B du CGI
	</div>
</div>

@endsection