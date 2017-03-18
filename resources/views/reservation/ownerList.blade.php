@extends('layouts.backend')


@section('content')


<div class="container-fluid tabbable">
	<div style='display:none'>{{ setlocale(LC_TIME,'fr_FR.UTF-8') }}</div>
<div class="kerden-page-1">
	<h3 class="text-center">En tant que Propriétaire</h3>
	<div class="col-md-4 left-home-sub-menu" style='border:none;font-size:1.3em'>
		<ul class="nav nav-pills-stacked" role="menu">
			<li class="active">
                    <a href="#waiting" data-toggle="tab" data-back-btn-content="Propriétaire - en attente">Réservations en attente
                    	@if($numbers['waiting']>0)
                    	<span class="badge">{{$numbers['waiting']}}</span>
                    	@endif
                    </a>
                </li>
                <li>
                    <a href="#confirmed" data-toggle="tab" data-back-btn-content="Propriétaire - confirmées">Réservations confirmées
                    	@if($numbers['confirmed']>0)
                    	<span class="badge">{{$numbers['confirmed']}}</span>
                    	@endif
                    </a>
                </li>
                <li>
                    <a href="#passed" data-toggle="tab" data-back-btn-content="Propriétaire - passées">Réservations passées
                    	@if($numbers['passed']>0)
                    	<span class="badge">{{$numbers['passed']}}</span>
                    	@endif
                    </a>
                </li>
                <li>
                    <a href="#canceled" data-toggle="tab" data-back-btn-content="Propriétaire - annulées">Réservations annulées
                    	@if($numbers['canceled']>0)
                    	<span class="badge">{{$numbers['canceled']}}</span>
                    	@endif
                    </a>
                </li>
		</ul>
	</div>
	</div>	

<div class="tab-content col-md-8 kerden-page-2">
	<div class="kerden-back-button">Retour
	</div>
	
	<div class="tab-first-level tab-pane fade active in" id="waiting">
			@foreach($list as $title=>$resa)
				<h5>{{$title}}</h5>
				@forelse($resa['waiting'] as $k=>$resa)
					<div class="resaPreview">
						<a class="" href="{{ url('/reservation/ownerDecision/'.$resa->id) }}">
							<span class="rightArrow">&gt;</span>
						<span class="caption">Demande {{$resa->user->firstName}}</span>
						<span class="captionDate countdown" data-seconds="{{\Carbon\Carbon::parse($resa->autoCancelDate,'Europe/Paris')->diffInSeconds(Carbon\Carbon::now('Europe/Paris')) }}"></span>
						</a>
					</div>
				@empty
				Aucune réservation en attente
				@endforelse
			@endforeach
	</div>
	<div class="tab-first-level tab-pane fade" id="confirmed">	
			@foreach($list as $title=>$resa)
				<h5>{{$title}}</h5>
				@forelse($resa['confirmed'] as $k=>$resa)
					<div class="resaPreview">
						<a class="" href="{{ url('/reservation/ownerView/'.$resa->id) }}">
							<span class="rightArrow">&gt;</span>
						<span class="caption">{{$resa->user->fullName}}</span>
						<span class="captionDate">{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</span>
						<span class="sub-caption">{{ $resa->state }}</span>
						</a>
					</div>
				@empty
				Aucune réservation confirmée
				@endforelse
			@endforeach
	</div>
	<div class="tab-first-level tab-pane fade" id="passed">	
			@foreach($list as $title=>$resa)
				<h5>{{$title}}</h5>
				@forelse($resa['passed'] as $k=>$resa)
					<div class="resaPreview">
						<a class="" href="{{ url('/reservation/ownerView/'.$resa->id) }}">
							<span class="rightArrow">&gt;</span>
						<span class="caption">{{$resa->user->fullName}}</span>
						<span class="captionDate">{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</span>
						<span class="sub-caption">{{ $resa->state }}</span>
						</a>
					</div>
				@empty
				Aucune réservation passée
				@endforelse
			@endforeach
	</div>
	<div class="tab-first-level tab-pane fade" id="canceled">
			@foreach($list as $title=>$resa)
				<h5>{{$title}}</h5>
				@forelse($resa['canceled'] as $k=>$resa)
					<div class="resaPreview">
						<a class="" href="{{ url('/reservation/ownerView/'.$resa->id) }}">
							<span class="rightArrow">&gt;</span>
						<span class="caption">{{$resa->user->fullName}}</span>
						<span class="captionDate">{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</span>
						<span class="sub-caption">{{ $resa->state }}</span>
						</a>
					</div>
				@empty
				Aucune réservation annulée
				@endforelse
			@endforeach
	</div>
	

		</div>
	</div>
</div>
</div>

@include('footer')

@endsection

@section('scripts')
<script>
function ActiveCountdowns(){
	console.log('countdown');
	$('.countdown').each(function(){
		var total_secondes = $(this).data('seconds');
		var heures = Math.floor(total_secondes / 3600);
		var minutes = Math.floor((total_secondes - (heures*3600)) / 60);
		$(this).html(heures+'h '+minutes+'m');
	});
};

(function($){
	$('.HPMenuLink').removeClass('active');
	$('.resaMenu').addClass('active');
	ActiveCountdowns();
	setInterval(ActiveCountdowns,30000);
}) (jQuery);
</script>
@endsection