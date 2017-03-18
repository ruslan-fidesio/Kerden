@extends('invoices.receiptLayout')

@section('phrase')
Bonjour {{$receipt->reservation->garden->owner->firstName}},<br/>
Vous trouverez ci-dessous votre reçu.
@endsection

@section('content')

<div class="col-xs-12">
	
	<table class="table table-bordered">
		<thead>
			<th>Date</th> <th>Description</th> <th>Montant</th>
		</thead>

		<tr>
			<td>{{Carbon\Carbon::parse($receipt->reservation->date_begin)->format("d / m / Y")}}</td>
			<td class="text-center">Location du jardin </td>
			<td class="text-right">{{($receipt->reservation->location_amount * (100-env('KERDEN_FEES_PERCENT')) / 100) }} €</td>
		</tr>

		@if($receipt->reservation->applied_penalities > 0)
			<tr style="background-color:lightgray">
				<td>{{Carbon\Carbon::parse($receipt->reservation->date_begin)->format("d / m / Y")}}</td>
				<td class="text-center">Pénalité annulation</td>
				<td class="text-right">{{ $receipt->reservation->applied_penalities}} €</td>
			</tr>		
		@endif
	</table>

	<div class="col-xs-6 col-xs-offset-6" style='margin-top:50px'>
		<table class='table'>
			<tr> <td><span>SOUS-TOTAL</span></td> <td class="text-right">{{ ($receipt->reservation->location_amount * (100-env('KERDEN_FEES_PERCENT')) / 100) - $receipt->reservation->applied_penalities}}€</td> </tr>
			<tr  style="font-size:1.4em;font-weight:bold"><td><span>TOTAL</span></td><td class="text-right">{{ ($receipt->reservation->location_amount * (100-env('KERDEN_FEES_PERCENT')) / 100) - $receipt->reservation->applied_penalities}}€</td></tr>
		</table>
	</div>

	<div class="text-right">
		TVA non applicable - Article 293 B du CGI
	</div>
</div>

@endsection