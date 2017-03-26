@extends('layouts.backend')


@section('content')
<div class="admin-bg">
  <h1 class="text-center">Réservations <br>(en tant que propriétaire)</h1>
</div>
<div class="side-container">
  <div class="side-bg">
      <div class="col-md-4 grey-bg">
      </div>
      <div class="col-md-8 white-bg">
      </div>
  </div>
  <div class="container">
    <div class="tabbable side-padding row">
    	<div style='display:none'>{{ setlocale(LC_TIME,'fr_FR.UTF-8') }}</div>
      
        <div class="col-sm-3">
    		  <ul class="nav nav-pills-stacked" role="menu">
            <li class="active">
              <a href="#waiting" data-toggle="tab" data-back-btn-content="Propriétaire - en attente">
                Réservations en attente
              	@if($numbers['waiting']>0)
                  <span class="badge">{{$numbers['waiting']}}</span>
                @endif
              </a>
            </li>
            <li>
              <a href="#confirmed" data-toggle="tab" data-back-btn-content="Propriétaire - confirmées">
                Réservations confirmées
              	@if($numbers['confirmed']>0)
              	 <span class="badge">{{$numbers['confirmed']}}</span>
              	@endif
              </a>
            </li>
            <li>
              <a href="#passed" data-toggle="tab" data-back-btn-content="Propriétaire - passées">
                Réservations passées
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

        <div class="tab-content col-sm-8 col-sm-offset-1">        	
        	<div class="tab-first-level tab-pane fade active in" id="waiting">
        			@foreach($list as $title=>$resa)
                <div class="resa-container">
          				<h5 class="admin-subtitle">{{$title}}</h5>
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
                </div>
        			@endforeach
        	</div>
        	<div class="tab-first-level tab-pane fade" id="confirmed">	
        			@foreach($list as $title=>$resa)
                <div class="resa-container">
          				<h5 class="admin-subtitle">{{$title}}</h5>
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
                </div>
        			@endforeach
        	</div>
        	<div class="tab-first-level tab-pane fade" id="passed">	
        			@foreach($list as $title=>$resa)
                <div class="resa-container">
          				<h5 class="admin-subtitle">{{$title}}</h5>
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
                </div>
        			@endforeach
        	</div>
        	<div class="tab-first-level tab-pane fade" id="canceled">
        			@foreach($list as $title=>$resa)
              <div class="resa-container">              
        				<h5 class="admin-subtitle">{{$title}}</h5>
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
              </div>
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