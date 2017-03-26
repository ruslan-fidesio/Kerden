@extends('layouts.app')

@section('headers')
<link rel="stylesheet" type="text/css" href="{{asset('css/search.css')}}">
@endsection

@section('content')
<div class="search-params">
	Params recherche:<br/>
	@foreach($params as $par=>$val)
	{{ $par }}=>{{ $val }} <br/>
	@endforeach
</div>

<div class="results-map">
	<div id='map' style='height:100%'></div>
</div>

<div class="search-results">
@if( count($gardens)==0 )
	pas de résultat
@endif
@foreach($gardens as $garden)
	<div class='garden-result'>
		@foreach($garden->getPhotosUrls() as $photo)
			<img class='garden-photo' src="{{ asset('storage/'.$photo) }}">
		@endforeach
		<div class='garden-title text-center'>{{$garden->title}}
		<div class='garden-address text-center'>{{ $garden->address }}</div></div>
		<div class='garden-price'>A partir de <strong>{{ $garden->minPrice }}</strong>€/h</div>
		<div class='reserver-CTA'>Réserver</div>
	</div>

@endforeach
</div>
@endsection

@section('scripts')
<script type="text/javascript">
var map, marker;
function setMarkers(){
	marker = new google.maps.Marker({
		map:map,
		position:{lat: 48.84, lng: 2.36},
		title:'hello',
		draggable:false,
		animation: google.maps.Animation.DROP
	});
}

function initMap() {
   map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 48.84, lng: 2.36},
    zoom: 10,
    disableDefaultUI: true
  });
   setMarkers();
}
</script>
<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMppXmks4XyF8XMe3_roFbVumAlThb_CY&libraries=places&callback=initMap">
</script>

@endsection