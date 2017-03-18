<hr/>
<div class="col-xs-12" style="color:red">
	<b>Cette réservation a été annulée le {{ \Carbon\Carbon::parse($reservation->annulation->created_at)->tz('Europe/Paris')->formatLocalized('%A %d %B %Y à %k:%M') }}</b>
</div>
<div class="col-md-6">
	<div class="resumeBloc price">
		<span class="caption">Remboursement</span>
		<table class='table'>
			<tr><td>Oscardiens</td><td>{{$reservation->staff_amount - $reservation->annulation->staff_transfert_amount }}€</td></tr>
			<tr><td>Location jardin</td><td>{{ $reservation->location_amount - $reservation->annulation->owner_transfert_amount - $reservation->annulation->fees}} €</td></tr>
			<tr class='info'><td>Remboursement final</td><td>{{$reservation->annulation->refund_amount - $reservation->annulation->fees}} €</td></tr>
		</table>
	</div>
</div>

<div class="col-md-6">
	<div class="resumeBloc price">
		<span class="caption">Frais non remboursés</span>
		<table class='table'>
			<tr><td>Oscardiens</td><td>{{ $reservation->annulation->staff_transfert_amount }}€</td></tr>
			<tr><td>Commission Kerden</td><td>{{ $reservation->annulation->fees }}€</td></tr>
			<tr><td>Indémnité propriétaire</td><td>{{ $reservation->annulation->owner_transfert_amount }}€</td></tr>
		</table>
	</div>
</div>
