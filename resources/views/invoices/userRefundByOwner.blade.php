@extends('invoices.receiptLayout')

@section('phrase')
Bonjour {{$receipt->reservation->user->firstName}}, <br/>
Votre réservation vient d’être annuler par le propriétaire du jardin {{$receipt->reservation->garden->title}}.<br/>
Vous êtes donc remboursé de la totalité (Oscardiens compris) de la réservation. 
@endsection

@section('content')
<div class="col-xs-12">
	
	<table class="table table-bordered">
		<thead>
			<th>Date</th> <th>Description</th> <th>Montant</th>
		</thead>
	
		<tr>
			<td>{{Carbon\Carbon::parse($receipt->reservation->annulation->created_at)->format("d / m / Y")}}</td>
			<td class="text-center">Remboursement (100% du prix de la location)</td>
			<td class="text-right">{{$receipt->reservation->annulation->refund_amount}}€</td>
		</tr>

	</table>

	<div class="col-xs-6 col-xs-offset-6" style='margin-top:50px'>
		<table class='table'>
			<tr> <td><span>SOUS-TOTAL</span></td> <td class="text-right">{{$receipt->reservation->annulation->refund_amount}}€</td> </tr>
			<tr  style="font-size:1.4em;font-weight:bold"><td><span>TOTAL</span></td><td class="text-right">{{$receipt->reservation->annulation->refund_amount}}€</td> </tr>
		</table>
	</div>

	<div class="text-right">
		TVA non applicable - Article 293 B du CGI
	</div>
</div>

@endsection