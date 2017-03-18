<hr/>
<div class="col-xs-12" style="color:red">
	<b>Cette réservation a été annulée le {{ \Carbon\Carbon::parse($reservation->annulation->created_at)->tz('Europe/Paris')->formatLocalized('%A %d %B %Y à %k:%M') }}</b>
</div>
<div class="col-xs-12">
	<div class="resumeBloc price">
		<span class="caption">Indémnités</span>
		<table class='table'>
			<tr><td>Commission Kerden</td><td>{{ $reservation->annulation->fees }}€</td></tr>
			<tr class='info'><td>Indémnité propriétaire</td><td>{{ $reservation->annulation->owner_transfert_amount }}€</td></tr>
		</table>
	</div>
</div>
