@extends('layouts.backend')

@section('headers')
<link rel="stylesheet" type="text/css" href="{{ asset('css/linktable.css') }}">
@endsection

@section('content')

<div class="container">
	<div style='display:none'>{{ setlocale(LC_TIME,'fr_FR.UTF-8') }}</div>
	<div class="panel panel-default">
		<div class="panel-heading">Oscar.fr</div>
		<div class="panel-body">
			<div class="row">
				<h4 style='color:red'>Réservations en attente de confirmation</h4>
				<table class='table table-striped table-hover'>
				@if(count($waitingForConfirm)>0)
					<thead><th>#</th><th>Lieu</th><th>Date</th><th>Statut</th></thead>
					<tbody>
					@foreach($waitingForConfirm as $resa)
						<tr data-href="{{ url('/oscar/decision/'.$resa->id) }}">
							<td>{{$resa->id}}</td>
							<td>{{$resa->garden->title}}</td>
							<td>{{\Carbon\Carbon::parse($resa->staff_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</td>
							<td>{{$resa->state}}</td>
						</tr>
					@endforeach
					</tbody>
				@else
					Aucune réservation en attente
				@endif
				</table>
			</div>

			<div class="row">
				<h4 style="color:green">Réservation confirmées</h4>
				<table class='table table-striped table-hover'>
				@if(count($confirmed)>0)
					<thead><th>#</th><th>Lieu</th><th>Date</th><th>Statut</th></thead>
					<tbody>
					@foreach($confirmed as $resa)
						<tr data-href="{{ url('/oscar/view/'.$resa->id) }}">
							<td>{{$resa->id}}</td>
							<td>{{$resa->garden->title}}</td>
							<td>{{\Carbon\Carbon::parse($resa->staff_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</td>
							<td>{{$resa->state}}</td>
						</tr>
					@endforeach
					</tbody>
				@else
					Aucune réservation confirmée
				@endif
				</table>
			</div>

			<div class="row">
				<h4>Réservations passées</h4>
				<table class='table table-striped table-hover'>
				@if(count($passed)>0)
					<thead><th>#</th><th>Lieu</th><th>Date</th><th>Statut</th></thead>
					<tbody>
					@foreach($passed as $resa)
						<tr data-href="{{ url('/oscar/view/'.$resa->id) }}">
							<td>{{$resa->id}}</td>
							<td>{{$resa->garden->title}}</td>
							<td>{{\Carbon\Carbon::parse($resa->staff_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</td>
							<td>{{$resa->state}}</td>
						</tr>
					@endforeach
					</tbody>
				@else
					Aucune réservation passée
				@endif
				</table>
			</div>

			<div class="row">
				<h4>Réservations annulées</h4>
				<table class='table table-striped table-hover'>
				@if(count($canceled)>0)
					<thead><th>#</th><th>Lieu</th><th>Date</th><th>Statut</th></thead>
					<tbody>
					@foreach($canceled as $resa)
						<tr data-href="{{ url('/oscar/view/'.$resa->id) }}">
							<td>{{$resa->id}}</td>
							<td>{{$resa->garden->title}}</td>
							<td>{{\Carbon\Carbon::parse($resa->staff_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</td>
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
	</div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
(function($){
	$('tr[data-href]').click(function(){
		document.location = $(this).data('href') ;
	})

}) (jQuery);
</script>
@endsection