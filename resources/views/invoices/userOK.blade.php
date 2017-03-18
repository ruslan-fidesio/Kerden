@extends('invoices.factureLayout')

@section('phrase')
Bonjour {{$facture->reservation->user->firstName}},<br/>
Vous venez de réserver le jardin : "{{$facture->reservation->garden->title}}".<br/>
Vous trouverez ci-dessus le montant facturé.
@endsection

@section('content')
<div class="col-xs-12">
	
	<table class="table table-bordered">
		<thead>
			<th>Date</th> <th>Description</th> <th>Montant</th>
		</thead>
	
		<tr>
			<td>{{Carbon\Carbon::parse($facture->reservation->date_begin)->format("d / m / Y")}}</td>
			<td class="text-center">Location du jardin</td>
			<td class="text-right">{{$facture->reservation->location_amount}}€</td>
		</tr>

		@if($facture->reservation->nb_staff > 0)
			<tr>
				<td>{{Carbon\Carbon::parse($facture->reservation->date_begin)->format("d / m / Y")}}</td>
				<td class="text-center">{{$facture->reservation->nb_staff}} Oscardien(s)</td>
				<td class="text-right">{{$facture->reservation->staff_amount}}€</td>
			</tr>
		@endif
	</table>

	<div class="col-xs-6 col-xs-offset-6" style='margin-top:50px'>
		<table class='table'>
			<tr> <td><span>SOUS-TOTAL</span></td> <td class="text-right">{{$facture->reservation->total_amount}}€</td> </tr>
			<tr  style="font-size:1.4em;font-weight:bold"><td><span>TOTAL</span></td><td class="text-right">{{$facture->reservation->total_amount}}€</td></tr>
		</table>
	</div>

	<div class="text-right">
		TVA non applicable - Article 293 B du CGI
	</div>
</div>
@endsection
