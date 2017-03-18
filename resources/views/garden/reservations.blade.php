@extends('garden.menu')

@section('headers')
@endsection


@section('contentPane')

	<div style='display:none'>{{ setlocale(LC_TIME,'fr_FR.UTF-8') }}</div>
	<div class="panel panel-kerden-home">
		<div class="panel-heading">{{$garden->title}}</div>
		<div class="panel-body">
			<h3>Réservations en attente</h3>

			<table class='table table-striped table-hover'>
				@if(count($waiting)>0)
					<thead><th>#</th><th>Lieu</th><th>Date</th><th>Statut</th></thead>
					<tbody>
					@foreach($waiting as $resa)
						<tr data-href="{{ url('/reservation/ownerDecision/'.$resa->id) }}">
							<td>{{$resa->id}}</td>
							<td>{{$resa->garden->title}}</td>
							<td>{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</td>
							<td>{{$resa->state}}</td>
						</tr>
					@endforeach
					</tbody>
				@else
					Aucune réservation en attente
				@endif
			</table>

			<h3>Réservations confirmées</h3>
			<table class='table table-striped'>
				@if(count($confirmed)>0)
					<thead><th>#</th><th>Lieu</th><th>Date</th><th>Statut</th></thead>
					<tbody>
					@foreach($confirmed as $resa)
						<tr data-href="{{ url('/reservation/ownerView/'.$resa->id) }}">
							<td>{{$resa->id}}</td>
							<td>{{$resa->garden->title}}</td>
							<td>{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</td>
							<td>{{$resa->state}}</td>
						</tr>
					@endforeach
					</tbody>
				@else
					Aucune réservation confirmée
				@endif
			</table>

			<h3>Réservations passées</h3>
			<table class='table table-striped'>
				@if(count($passed)>0)
					<thead><th>#</th><th>Lieu</th><th>Date</th><th>Statut</th></thead>
					<tbody>
					@foreach($passed as $resa)
						<tr data-href="{{ url('/reservation/ownerView/'.$resa->id) }}">
							<td>{{$resa->id}}</td>
							<td>{{$resa->garden->title}}</td>
							<td>{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</td>
							<td>{{$resa->state}}</td>
						</tr>
					@endforeach
					</tbody>
				@else
					Aucune réservation passée
				@endif
			</table>

			<h3>Réservations annulées</h3>
			<table class='table table-striped'>
				@if(count($canceled)>0)
					<thead><th>#</th><th>Lieu</th><th>Date</th><th>Statut</th></thead>
					<tbody>
					@foreach($canceled as $resa)
						<tr data-href="{{ url('/reservation/ownerView/'.$resa->id) }}">
							<td>{{$resa->id}}</td>
							<td>{{$resa->garden->title}}</td>
							<td>{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</td>
							<td>{{$resa->state}}</td>
						</tr>
					@endforeach
					</tbody>
				@else
					Aucune réservation annulée
				@endif
			</table>
		</div>
	</div>

@endsection

@section('scripts')
<script type="text/javascript">
(function($){
	$('tr[data-href]').click(function(){
		document.location = $(this).data('href') ;
	});

	$('.HPMenuLink').removeClass('active');
    $('.gardenMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(7)').addClass('active');

}) (jQuery);
</script>
@endsection