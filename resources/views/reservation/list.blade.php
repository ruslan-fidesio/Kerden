@extends('layouts.backend')

@section('headers')
@endsection


@section('content')
<div class="admin-bg">
  <h1 class="text-center">Réservations <br>(en tant que locataire)</h1>
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
                        <a href="#waiting" data-toggle="tab" data-back-btn-content="Locataire - en attente">Réservations en attente
                        	@if(count($waiting)>0)
                        	<span class="badge">{{count($waiting)}}</span>
                        	@endif
                        </a>
                    </li>
                    <li>
                        <a href="#confirmed" data-toggle="tab" data-back-btn-content="Locataire - confirmées">Réservations confirmées
                        	@if(count($confirmed)>0)
                        	<span class="badge">{{count($confirmed)}}</span>
                        	@endif
                        </a>
                    </li>
                    <li>
                        <a href="#passed" data-toggle="tab" data-back-btn-content="Locataire - passées">Réservations passées
                        	@if(count($passed)>0)
                        	<span class="badge">{{count($passed)}}</span>
                        	@endif
                        	</a>
                    </li>
                    <li>
                        <a href="#canceled" data-toggle="tab" data-back-btn-content="Locataire - annulées">Réservations annulées
                        	@if(count($canceled))
                        	<span class="badge">{{count($canceled)}}</span>
                        	@endif
                        	</a>
                    </li>
    		</ul>
    	</div>
      <div class="tab-content col-sm-8 col-sm-offset-1">
      	
      	<div class="tab-first-level tab-pane fade active in" id="waiting">


      			@forelse($waiting as $resa)
      					<div class="resaPreview">
      						<a class="" href="{{ url('/reservation/view/'.$resa->id) }}">
      							<span class="rightArrow">&gt;</span>
      						<span class="caption">{{$resa->garden->title}}</span>
      						<span class="captionDate">{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</span>
      						<span class="sub-caption">{{ $resa->state }}</span>
      						</a>
      					</div>

      			@empty
      				Aucune réservation en attente.
      			@endforelse
      	</div>
      	<div class="tab-first-level tab-pane fade" id="confirmed">

      			@forelse($confirmed as $resa)
      					<div class="resaPreview">
      						<a class="" href="{{ url('/reservation/view/'.$resa->id) }}">
      							<span class="rightArrow">&gt;</span>
      						<span class="caption">{{$resa->garden->title}}</span>
      						<span class="captionDate">{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</span>
      						<span class="sub-caption">{{ $resa->state }}</span>
      						</a>
      					</div>

      			@empty
      				Aucune réservation confirmée.
      			@endforelse
      			</table>
      	</div>
      	<div class="tab-first-level tab-pane fade" id="passed">

      			@forelse($passed as $resa)
      					<div class="resaPreview">
      						<a class="" href="{{ url('/reservation/view/'.$resa->id) }}">
      							<span class="rightArrow">&gt;</span>
      						<span class="caption">{{$resa->garden->title}}</span>
      						<span class="captionDate">{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</span>
      						<span class="sub-caption">{{ $resa->state }}</span>
      						</a>
      					</div>

      			@empty
      				Aucune réservation passée.
      			@endforelse
      	</div>
      	<div class="tab-first-level tab-pane fade" id="canceled">

      			@forelse($canceled as $resa)
      					<div class="resaPreview">
      						<a class="" href="{{ url('/reservation/view/'.$resa->id) }}">
      							<span class="rightArrow">&gt;</span>
      						<span class="caption">{{$resa->garden->title}}</span>
      						<span class="captionDate">{{\Carbon\Carbon::parse($resa->date_begin)->formatLocalized('%A %d %B %Y à %kh')  }}</span>
      						<span class="sub-caption">{{ $resa->state }}</span>
      						</a>
      					</div>

      			@empty
      				Aucune réservation annulée.
      			@endforelse
      	</div>

      		</div>
      	</div>
      </div>
  </div>
</div>

@include('footer')

@endsection

@section('scripts')
<script type="text/javascript">
(function($){
	$('tr[data-href]').click(function(){
		document.location = $(this).data('href') ;
	});

	$('.HPMenuLink').removeClass('active');
	$('.resaMenu').addClass('active');

}) (jQuery);
</script>
@endsection