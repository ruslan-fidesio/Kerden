@extends('layouts.app')

@section('headers')
@endsection

@section('content')

<div id='mainResult'>
	<div class="container">
		<div class="row visible-xs">
			<div class="col-xs-6 phoneToggler active" id='phoneParamToggler'>Critères</div>
			<div class="col-xs-6 phoneToggler" id="phoneMapToggler">Carte</div>
		</div>
	</div>
<div class="search-params">
  {!! Form::open(['url'=>'/search','id'=>'searchForm']) !!}
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
              
            {!! Form::label('Date', 'Date' ,['class'=>'text-center control-label']) !!}
        
          
            {!! Form::text('date',isset($params['date'])?$params['date']:'',['class'=>'form-control','id'=>'datePicker']) !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('place','Lieu',['class'=>'text-center control-label']) !!}
        
          
            {!! Form::text('place',!empty($params['place'])?$params['place']:'Paris',['id'=>'hiddenPlace','class'=>'form-control'] ) !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">            
            {!! Form::label('Nb Pers', 'invités' ,['class'=>'control-label','style'=>'width:100%;white-space:nowrap']) !!}
        
            {!! Form::number('nb_pers',isset($params['nb_pers'])?$params['nb_pers']:null,['class'=>'form-control','min'=>'0', 'id'=>'nb-invite']) !!}
          </div>
        </div>
        <div class="col-sm-3">
          <a class="more-filters collapsed" role="button" data-toggle="collapse" href="#morefilters" aria-expanded="false" aria-controls="collapseExample">
            Critères
            <span class="plus">
              <i class="fa fa-plus"></i>
            </span>
          </a>
        </div>
      </div>
    </div>
    <div class="collapse filter-collapse" id="morefilters">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              {!! Form::label('Activity','Activité',['class'=>'control-label'])  !!}
              {!! Form::select('activity',
                    ['lunch'=>'Repas','relax'=>'Détente','barbecue'=>'Barbecue','reception'=>'Réception','children'=>'Enfants','party'=>'Fête','nightEvent'=>'Soirée','pro'=>'Pro'],
                    isset($params['activity'])?$params['activity']:null,['placeholder'=>'','id'=>'activitySelect']) !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              {!! Form::label('Catégorie','Catégorie',['class'=>'control-label']) !!}
              <select name="category" id="catSelect">
                 <option selected="selected" value></option>
                @foreach($categories as $k=>$v)
                  <option
                  @if(isset($params['category']) && $params['category']==$k)
                    selected="selected"
                  @endif
                  >{{$k}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group" id="col-search-ware-params">
              {!! Form::label('Ware','Équipement',['class'=>'text-center control-label']) !!}
              {!! Form::select('ware[]',$ware,null,['id'=>'wareSelect','multiple']) !!}
            </div>
          </div>
        </div>
        <div class="row" id="priceRow">         
          <div class="col-md-3">
            <div class="form-group">
              {!! Form::label('Price', 'Prix ' ,['class'=>'text-left control-label']) !!}
            </div>
          </div>
          <div class="col-md-6"> <div id="price-slider"></div> </div>
        </div>
        <div class="row" id='hoursRow'>
          <div class="col-md-3">
            <div class="form-group">
              {!! Form::label('Hours', 'Horaires' ,['class'=>'text-left control-label']) !!}
            </div>
          </div>
          <div class="col-md-6">
            <div id="slider-range"></div>
            {!! Form::hidden('slot_begin',!empty($params['slot_begin'])?$params['slot_begin']:null,['id'=>'slot_begin']) !!}
            {!! Form::hidden('slot_end',!empty($params['slot_end'])?$params['slot_end']:null,['id'=>'slot_end']) !!}
          </div>
        </div>
        <!-- <div class="col-xs-6 col-xs-offset-4">
          {!! Form::submit(trans('base.update'),['class'=>'btn btn-primary']) !!}
        </div> -->        
        </div>
      </div>
    </div>
  {!! Form::close() !!}
</div>
	
	<div class="left-col" data-spy="affix" data-offset-top="80" data-offset-bottom="230">
		<div class="map-container">
			<div class=" results-map" id="map">MAP</div>
<!-- 			<div class="input-group mapSearchInput">
				<input type="text" class=" form-control" id="mapInput" value="{{isset($params['place'])?$params['place']:null}}">
				<span class="input-group-addon mapSearchShow"><i class="fa fa-search"></i></span>
			</div> -->
		</div>
		
	</div>
	<div class="right-col">
		
			@if( !is_array($gardens) )
				<div class="alert alert-danger">{{trans('search.'.$gardens)}}</div>
			@else
				<ul id="gardenList">
					@foreach($gardens as $garden)
						<li class="garden-sortable-link" data-price="{{$garden->getMinPrice($params['date'])}}" data-note="{{$garden->getAverageNoteAttribute()}}">
							<a class="col-lg-4 col-sm-6 garden-sortable-link garden-result-item" data-item-id="{{$garden->id}}" href="{{ url('/view/'.$garden->id) }}" >
								
									<div class="thumbnail">
										<img src="{{ $garden->getFirstPhotoURL() }}">
										<!-- <img src="/images/bg1.jpg"> -->
										<div class="priceCall">
											À partir de<br><span> {{$garden->getMinPrice($params['date'])}} €</span>
										</div>
									</div>
									<div class="garden-result-details">
										<h3>{{$garden->title}}</h3>
										@if( in_array($garden->id, $imperfect) )
											<div class="notperfect" data-toggle='tooltip' data-placement='bottom' title="{{trans('search.notperfect')}}">
												<span class="glyphicon glyphicon-alert"></span>
											</div>
										@endif
										<div class="note">{!! $garden->getAverageNoteAsFAStars() !!}</div>
										<div class="adress">{{ $garden->fullBlurAddress }}</div>
										<div class="invited">Jusqu'à {{$garden->max_pers}} invités</div>										
										<div class='activitiesPicto'>
											@foreach($garden->activities->getAttributes() as $k=>$v)
												@if($k!='id' && $v == 1)
													<div class='picto picto-{{$k}}' data-toggle='tooltip' title="{{trans('garden.activities_.'.$k.'.title')}}"></div>
												@endif
											@endforeach
<!-- 											@if($garden->allowedActivitiesNumber > 5)
											 <span data-toggle='tooltip' title="et plus..." style="font-size:1.4em;font-weight:bolder;margin-left:7px;color:#888">+</span>
											@endif -->
										</div>
<!-- 										<div class="caption">Disponibilité :
											@if( ! empty($params['date']) )
												<div class="dispoPicto">
													@foreach( $garden->getSlots($params['date']) as $slot )
														<div class='picto picto-{{$slot}}' data-toggle='tooltip' title="{{trans('base.'.$slot,['min_hour'=>$garden->getHoursByDate($params['date'])->begin_slot,'max_hour'=>$garden->getHoursByDate($params['date'])->end_slot%24]) }}"></div>
													@endforeach
												</div>
											@else
												<span style='font-size:0.6em'>-choisir une date-</span>
											@endif
										</div> -->
									</div>
							</a>
						</li>
					@endforeach
					<li class="clearfix"></li>
				</ul>
				<div class="alert alert-danger noGeolocResults">
					Aucun bien disponible dans ce secteur géographique. Bougez la carte ou cliquez sur la loupe pour chercher une adresse.
				</div>
			@endif
	</div>
	<div class="clearfix"></div>


	</div>
</div>	
<!-- <div class="container-fluid hiddenFooter">
	<div class='down-arrow'>^</div>
    <div class="up-arrow" style='display:none'>V</div>
</div> -->	
@include('footer')
@endsection

@section('scripts')
<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
@if(App::getLocale() == 'fr')
<script src="{{ URL::asset('js/bootstrap-datepicker.fr.js') }}"></script>
@endif

<script type="text/javascript">
var map,markers=[],circles=[],customPin;

function sortItemsByMapBounds(){
	var bounds = map.getBounds();
	var atLeastOne = false;
	for (var i=0; i < markers.length; i++){
		if(bounds.contains(markers[i].getPosition())){
			$('.garden-result-item[data-item-id="'+markers[i].id+'"]').fadeIn();
			atLeastOne = true;
		}else{
			$('.garden-result-item[data-item-id="'+markers[i].id+'"]').fadeOut();
		}
	}
	if(atLeastOne){
		$('.noGeolocResults').hide();
	}else{
		$('.noGeolocResults').show(1000);
	}
}

function dropMarker(pLat, pLng,id,image){
	var mark = new google.maps.Marker({
	    map: map,
	    draggable: false,
	    animation: google.maps.Animation.DROP,
	    position: {lat: pLat, lng:pLng },
	    icon:image,
	    id:id
	});
	var circle = new google.maps.Circle({
		strokeColor: "#cceebb",
		strokeOpacity: 0,
		strokeWeight: 0,
		fillColor: "#7cbc91",
		fillOpacity: 0.4,
		map:map,
		center: {lat:pLat, lng:pLng},
		radius:320,
		id:id,
	});

	markers.push(mark);
	circles.push(circle);
	mark.addListener('click',function(){
		var obj = $('.garden-result-item[data-item-id="'+this.id+'"]');
		obj.addClass('hovering');
		$('body').animate({
			scrollTop: obj.offset().top - 60
		});
		setTimeout(function(){ obj.removeClass('hovering'); }, 1500)
	});
	circle.addListener('click',function(){
		var obj = $('.garden-result-item[data-item-id="'+this.id+'"]');
		obj.addClass('hovering');
		$('body').animate({
			scrollTop: obj.offset().top - 60
		});
		setTimeout(function(){ obj.removeClass('hovering'); }, 1500)
	});
	circle.setVisible(false);
}
function initMap() {
	var width = window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth;
	var initialZoom = width > 767? 7 : 6;
   map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 48.84, lng: 2.36},
    zoom: initialZoom,
    scrollwheel: true,
    streetViewControl:false,
    disableDefaultUI: true,
    scaleControl: true,
    zoomControl: true,
     zoomControlOptions: {
        position: google.maps.ControlPosition.LEFT_TOP
    },
    styles: [
        {
            "featureType": "all",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative.province",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "all",
            "stylers": [
                {
                    "hue": "#0066ff"
                },
                {
                    "saturation": 74
                },
                {
                    "lightness": 100
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "simplified"
                },
                {
                    "weight": 0.6
                },
                {
                    "saturation": -85
                },
                {
                    "lightness": 61
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "on"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.text",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "on"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "simplified"
                },
                {
                    "color": "#5f94ff"
                },
                {
                    "lightness": 26
                },
                {
                    "gamma": 5.86
                }
            ]
        }
    ]		
  });

   @if( !empty($place) && $place != 'Paris' && $place!='Où')
	centerMap("{{$place}}");
	@elseif( !empty($params["geolocPosition"]) )
	centerMap("{{$params['geolocPosition']}}");
	@endif

   google.maps.event.addListener(map, 'zoom_changed', function() {
	    var zoom = map.getZoom();
	    // iterate over markers and call setVisible
	    for (i = 0; i < markers.length; i++) {
	        markers[i].setVisible(zoom <= 12);
	        circles[i].setVisible(zoom > 12);
	    }
	});

   customPin = new google.maps.MarkerImage("/images/map-pin.png",
        new google.maps.Size(22, 50),
        new google.maps.Point(0,0),
        new google.maps.Point(11, 25));
	@if(is_array($gardens) && count($gardens)>0)	
		@foreach($gardens as $k=>$garden)
			dropMarker({{$garden->location->lat}},{{$garden->location->lng}},{{$garden->id}},customPin);
		@endforeach
	@endif

	google.maps.event.addListener(map,'idle',sortItemsByMapBounds);

}

function centerMap(address){
    if(address == ''){return;}
    if(address.startsWith('{') && address.endsWith('}') ){
    	var center= JSON.parse(address.replace(/&quot;/ig,'"'));
    	map.setCenter(center);
    	return;
    }
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( {'address':address} ,function(results, status){
        if(status == google.maps.GeocoderStatus.OK){
            // var loca = results[0].geometry.location;
            // map.setCenter(loca);
            // map.setZoom(10);
            map.fitBounds(results[0].geometry.bounds);
            $('#mapInput').css('padding','0px');
			$('#mapInput').animate({width:'0'});
        }else{
            alert( "{{ trans('garden.failaddress') }}" );
        }
    });
}

function makeDataNumber(){
	var number = $('ul.select2-selection__rendered').find('li').size()-1;
	$('ul.select2-selection__rendered').attr('data-number',number);
}


function sortByPrice(minVal, maxVal){
	$('.garden-sortable-link').each(function(){
		var p = $(this).data('price');
		if(p<minVal || p>maxVal ){
			$(this).hide();
		}else{
			$(this).show();
		}
	});
}


(function($){
	$('#datePicker').datepicker({
        language:'fr',
        format:'dd-mm-yyyy',
        startView:'month',
        autoclose:true,
        todayHighlight:true,
        startDate: new Date()
    });
    $('#datePicker').on('change',function(e){
		if($('#datePicker').val()==''){
			$('#slider-range').slider('disable');
		}else{
			$('#slider-range').slider('enable');
		}
		$('#searchForm').submit();
	});
    $('#slider-range').slider({
    	range:true,
    	min:0,
    	max:19,
    	values:{{ !empty($params['slot_begin']) ?  '['.(($params['slot_begin']-9)%24).','.(($params['slot_end']-9+24)%24).']' :'[0,9]'}},
    	slide: function( event, ui ) {
	        $('#slider-range .ui-slider-handle').first().attr('data-hour',(ui.values[0]+9)%24);
	        $('#slot_begin').val((ui.values[0]+9));
	        $('#slider-range .ui-slider-handle').last().attr('data-hour',(ui.values[1]+9)%24);
	        $('#slot_end').val((ui.values[1]+9));
	      },
	    stop: function(event, ui){
	    	$('#searchForm').submit();
	    }
    });
    $('#slider-range .ui-slider-handle').first().attr('data-hour',($('#slider-range').slider('values',0)+9)%24);
	$('#slider-range .ui-slider-handle').last().attr('data-hour',($('#slider-range').slider('values',1)+9)%24);
	$('[data-toggle="tooltip"]').tooltip({delay:500, container:'body'});
	$('#activitySelect').select2({minimumResultsForSearch:Infinity,width:'100%'});
	$('#activitySelect').on("select2:select",function(e){
		$('#searchForm').submit();
	});
	$('#wareSelect').select2({minimumResultsForSearch:Infinity,width:'100%'});
	$('#wareSelect').on("select2:select",function(e){
		$('#searchForm').submit();
	});
	$('#wareSelect').on("select2:unselect",function(e){		
		$('#searchForm').submit();
	});

	$('#catSelect').select2({minimumResultsForSearch:Infinity,width:'100%'});
	$('#catSelect').on("select2:select",function(e){
		$('#searchForm').submit();
	});

	$('#price-slider').slider({
		range:true,
		min:0,
		max:1000,
		step:10,
		values:[0,500],
		slide: function(event, ui){
			$('#price-slider .ui-slider-handle').first().attr('data-price',ui.values[0]);
	        $('#price-slider .ui-slider-handle').last().attr('data-price',ui.values[1]);
		},
		stop:function (event, ui){
			sortByPrice(ui.values[0],ui.values[1]);
		}
	});
	$('#price-slider .ui-slider-handle').first().attr('data-price',0);
    $('#price-slider .ui-slider-handle').last().attr('data-price',500);


	@if(isset($params['ware']))
		$('#wareSelect').select2().val([
			@foreach($params['ware'] as $k=>$v)
				"{!!$v!!}",
			@endforeach
		]).trigger('change');
	@else
		$('#wareSelect').select2().val([]);
	@endif

	@if( empty(session()->get('date')) )
		$('#hoursRow').html('<div class="col-md-3"><label class="control-label">Horaires</label></div><div class="col-md-6"><label class="control-label choose-date">Choisissez une date pour pouvoir selectionner des horaires</label></div>');
	@endif

	$('.btn-toggleToMap').on('click',function(){
		$('.search-params').animate({left:'-103%'});
		$('.map-container').animate({left:'13px'});
	});
	$('.btn-toggleToParams').on('click',function(){
		$('.search-params').animate({left:'0'});
		$('.map-container').animate({left:'100%'});
	});

	$('.mapSearchShow').on('click',function(){
		var obj = $('#mapInput');
		obj.css('padding','6px 13px');
		obj.animate({width:'100%'});
		obj[0].setSelectionRange(0, obj.val().length)
		obj.focus();
	});
	$('#mapInput').on('blur',function(){
		centerMap($('#mapInput').val());
		$('#hiddenPlace').val($('#mapInput').val());
	});
	$('#mapInput').on('keypress',function(e){
		if(e.keyCode ==13){
			$('#mapInput').blur();
		}
	});

	$('input[name="place"]').on('change',function(){
		$('#mapInput').val($('input[name="place"]').val());
		centerMap($('input[name="place"]').val());
	});

	$('.down-arrow').on('click',function(){
		$('.hiddenFooter').addClass('notSoHidden');
		$('.down-arrow').fadeOut();
		$('.up-arrow').fadeIn();
	});
	$('.up-arrow').on('click',function(){
		$('.hiddenFooter').removeClass('notSoHidden');
		$('.down-arrow').fadeIn();
		$('.up-arrow').fadeOut();
	});
	
	$("#phoneParamToggler").click(function(){
		$('#phoneMapToggler').removeClass('active');
		$('.left-col').removeClass('visible');
		$('.search-params').toggle();
		$('#phoneParamToggler').toggleClass('active');
	});

	$('#phoneMapToggler').click(function(){
    console.log('test');
    $('#phoneMapToggler').toggleClass('active');
		$('#phoneParamToggler').removeClass('active');
		$('.search-params').hide();

		if($('.map-container').offset().left < 10 ){
			$('.left-col').toggleClass('visible');
		}else{
			$('.map-container').css('left','3%');
			$('.left-col').removeClass('visible');
		}
	});

	makeDataNumber();

	$(window).resize(function(){
		if($(window).width()> 767){
			$('.search-params').show();
			$('.map-container').show();
		}
		$('#wareSelect').select2({minimumResultsForSearch:Infinity,width:'100%'});
	});
}) (jQuery);

function resetSelects(){
	$('#wareSelect').select2().val([]);
};


</script>


<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMppXmks4XyF8XMe3_roFbVumAlThb_CY&libraries=places&callback=initMap">
</script>

@endsection