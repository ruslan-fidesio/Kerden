@extends('admin.menu')


@section('contentPane')
	<div class="panel panel-kerden-home">
		<div class="panel-heading">Facures et reçus</div>
		<div class="panel-body">
			<table class="table">
			<thead>
				<th>Id</th>
				<th>Date réservation</th>
				<th>Statut</th>
				<th>Locataire</th>
				<th>Propriétaire</th>
			</thead>			

			@foreach($reservations as $resa)
				<tr>
					<td>{{$resa->id}}</td>
					<td>{{$resa->date_begin}}</td>
					<td>{{$resa->state}}</td>
					@if($resa->status == 'done' || $resa->status == "refund_by_user")
						<td><a onClick="setCheck(this)" href="{{url('/invoice/user/'.$resa->id)}}">Facture
							@if( $resa->facture && $resa->facture->admin_generated )
								<i class="fa fa-check"></i>
							@endif
						</a></td>
						<td><a onClick="setCheck(this)" href="{{url('/invoice/owner/'.$resa->id)}}">Reçu
							@if($resa->receipt && $resa->receipt->admin_generated)
								<i class="fa fa-check"></i>
							@endif
						</a></td>
					@elseif($resa->status == 'refund_by_owner')
						<td><a onClick="setCheck(this)" href="{{url('/invoice/userReceipt/'.$resa->id)}}">Reçu
							@if($resa->receipt && $resa->receipt->admin_generated)
								<i class="fa fa-check"></i>
							@endif
						</a></td>
						<td><a href="{{url('/avis/owner/'.$resa->id)}}">Avis</a></td>
					@endif
				</tr>
			@endforeach
			</table>
		</div>

	</div>
</div>
@endsection

@section('scripts')
<script>
	function setCheck(link){
		console.log(typeof link.children[0]);
		if(typeof link.children[0] == 'undefined'){
			var check = document.createElement('i');
			check.className='fa fa-check';
			link.appendChild(check);
		}
	}
</script>
<script>
(function($){
    $('.HPMenuLink').removeClass('active');
    $('.adminMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    @if(isset($unprinted))
    	$('.left-menu-link:nth-child(9)').addClass('active');
    @elseif(isset($byDate))
    	$('.left-menu-link:nth-child(7)').addClass('active');
    @else
    	$('.left-menu-link:nth-child(6)').addClass('active');
    @endif
}) (jQuery);
</script>

@endsection