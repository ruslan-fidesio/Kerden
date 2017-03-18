@extends('layouts.app')

@section('headers')
@endsection

@section('content')
<div class="container-fluid" id='mainResult'>
	<div class="row visible-xs">
		<div class="col-xs-6 phoneToggler active" id='phoneParamToggler'>Critères</div>
		<div class="col-xs-6 phoneToggler" id="phoneMapToggler">Carte</div>
	</div>

	<div class="row">
		<div class="col-sm-5 left-col">
			<div class="row search-params">
				{!! Form::open(['url'=>'/search','id'=>'searchForm']) !!}

				<div class="form-group row" style='margin-top:10px'>
					<div class="col-xs-4">
						{!! Form::label('Date', 'Date' ,['class'=>'text-center control-label','style'=>'width:100%']) !!}
						{!! Form::text('date',isset($params['date'])?$params['date']:'',['class'=>'form-control','id'=>'datePicker','placeholder'=>'jj-mm-aaaa']) !!}
					</div>

					<div class="col-xs-4">
						{!! Form::label('place','Lieu',['class'=>'text-center control-label','style'=>'width:100%']) !!}
						{!! Form::text('place',!empty($params['place'])?$params['place']:'Paris',['id'=>'hiddenPlace','class'=>'form-control', 'placeholder'=>'Lieu'] ) !!}
					</div>

					<div class="col-xs-4">
						{!! Form::label('Nb Pers', 'Nombre d\'invités' ,['class'=>'col-xs-4 text-center control-label','style'=>'width:100%;white-space:nowrap']) !!}
						{!! Form::number('nb_pers',isset($params['nb_pers'])?$params['nb_pers']:null,['placeholder'=>'Nb d\'invités','class'=>'form-control','min'=>'0']) !!}
					</div>

				</div>

				<hr/>

				<div class="form-group row">
					<div class="col-xs-4">
						{!! Form::label('Activity','Activité',['class'=>'text-center control-label','style'=>'width:100%'])  !!}
						{!! Form::select('activity',
					        ['lunch'=>'Repas','relax'=>'Détente','barbecue'=>'Barbecue','reception'=>'Réception','children'=>'Enfants','party'=>'Fête','nightEvent'=>'Soirée','pro'=>'Pro'],
					        isset($params['activity'])?$params['activity']:null,['placeholder'=>'','class'=>'form-control','id'=>'activitySelect']) !!}
					</div>
					
					<div class="col-xs-4">
						{!! Form::label('Catégorie','Catégorie',['class'=>'text-center control-label','style'=>'width:100%']) !!}
						<select name="category" id="catSelect" class="form-control">
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
					
					<div class="col-xs-4" id="col-search-ware-params">
						{!! Form::label('Ware','Équipement',['class'=>'text-center control-label','style'=>'width:100%']) !!}
						{!! Form::select('ware[]',$ware,null,['class'=>'form-control','id'=>'wareSelect','multiple']) !!}
					</div>

				</div>

				<hr/>

				<div class="form-group row" id="priceRow">
					{!! Form::label('Price', 'Prix ' ,['class'=>'col-xs-2 text-left control-label','style'=>'margin-top:3px;text-indent:15px;']) !!}
					<div class="col-xs-9 col-xs-offset-1"> <div id="price-slider"></div> </div>
				</div>

				<div class="form-group row" id='hoursRow'>
					{!! Form::label('Hours', 'Horaires' ,['class'=>'col-xs-2 text-left control-label','style'=>'margin-top:3px;text-indent:15px;']) !!}
					<div class="col-xs-9 col-xs-offset-1"> <div id="slider-range"></div> </div>
					{!! Form::hidden('slot_begin',!empty($params['slot_begin'])?$params['slot_begin']:null,['id'=>'slot_begin']) !!}
					{!! Form::hidden('slot_end',!empty($params['slot_end'])?$params['slot_end']:null,['id'=>'slot_end']) !!}
				</div>

				<!-- <div class="col-xs-6 col-xs-offset-4">
					{!! Form::submit(trans('base.update'),['class'=>'btn btn-primary']) !!}
				</div> -->


				{!! Form::close() !!}

				
			</div>
			<div class="row map-container">
				<div class=" results-map" id="map">MAP</div>
				<div class="input-group mapSearchInput">
					<input type="text" class=" form-control" id="mapInput" value="{{isset($params['place'])?$params['place']:null}}">
					<span class="input-group-addon mapSearchShow"><i class="fa fa-search"></i></span>
				</div>
			</div>
			
		</div>
		<div class="col-sm-7 right-col">
			<div class='row'>
				@if( !is_array($gardens) )
					<div class="alert alert-danger">{{trans('search.'.$gardens)}}</div>
					
				@else
				<ul id="gardenList">
					@foreach($gardens as $garden)
					<li class="garden-sortable-link" data-price="{{$garden->getMinPrice($params['date'])}}" data-note="{{$garden->getAverageNoteAttribute()}}">
					<a href="{{ url('/view/'.$garden->id) }}" >
						<div class="col-xs-12 garden-result-item" data-item-id="{{$garden->id}}">
							<div class="col-xs-12 col-sm-7 thumbnail">
								<img src="{{ asset('storage/'.$garden->getFirstPhotoURL()) }}">
								<div class="priceCall">À partir de <span>
									{{$garden->getMinPrice($params['date'])}}
									€</span></div>
								<div class="note">{!! $garden->getAverageNoteAsFAStars() !!}</div>
							</div>
							<div class="col-xs-12 col-sm-5 garden-result-details">
								<div class="row"><h4>{{$garden->title}}</h4>
									@if( in_array($garden->id, $imperfect) )
										<div class="notperfect" data-toggle='tooltip' data-placement='bottom' title="{{trans('search.notperfect')}}">
											<span class="glyphicon glyphicon-alert"></span>
										</div>
									@endif
								</div>
								<div class="row"><h5>{{ $garden->fullBlurAddress }}</h5></div>
								<div class="row"><hr/></div>
								<div class="row"><div class="caption">Accueil max : {{$garden->max_pers}} invités</div></div>
								<div class="row"><hr/></div>
								<div class="row"><div class="caption">Activités:</div>
								<div class='activitiesPicto'>
									@foreach($garden->activities->getAttributes() as $k=>$v)
										@if($k!='id' && $v == 1)
											<div class='picto picto-{{$k}}' data-toggle='tooltip' title="{{trans('garden.activities_.'.$k.'.title')}}"></div>
										@endif
									@endforeach
									@if($garden->allowedActivitiesNumber > 5)
									 <span data-toggle='tooltip' title="et plus..." style="font-size:1.4em;font-weight:bolder;margin-left:7px;color:#888">+</span>
									@endif
								</div></div>
								<div class="row"><hr/></div>
								<div class="row"><div class="caption">Disponibilité :</div>
								@if( ! empty($params['date']) )
									<div class="dispoPicto">
										@foreach( $garden->getSlots($params['date']) as $slot )
											<div class='picto picto-{{$slot}}' data-toggle='tooltip' title="{{trans('base.'.$slot,['min_hour'=>$garden->getHoursByDate($params['date'])->begin_slot,'max_hour'=>$garden->getHoursByDate($params['date'])->end_slot%24]) }}"></div>
										@endforeach
									</div>
								@else
									<span style='font-size:0.6em'>-choisir une date-</span>
								@endif
								</div>
							</div>
						</div>
					</a>
					</li>
					@endforeach
					</ul>
					<div class="alert alert-danger noGeolocResults">Aucun bien disponible dans ce secteur géographique. Bougez la carte ou cliquez sur la loupe pour chercher une adresse.</div>
				@endif
			</div>
		</div>


	</div>
</div>	
<!-- <div class="container-fluid hiddenFooter">
	<div class='down-arrow'>^</div>
    <div class="up-arrow" style='display:none'>V</div>
</div> -->	
@endsection

@section('scripts')
<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
@if(App::getLocale() == 'fr')
<script src="{{ URL::asset('js/bootstrap-datepicker.fr.js') }}"></script>
@endif

<script type="text/javascript">
var map,markers=[],circles=[],greenPin;

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
		strokeColor: "#000",
		strokeOpacity: 0.8,
		strokeWeight: 1,
		fillColor: "#33FF22",
		fillOpacity: 0.4,
		map:map,
		center: {lat:pLat, lng:pLng},
		radius:180,
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
	streetViewControl:false
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
   greenPin = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|457A09",
        new google.maps.Size(21, 34),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 34));

	@if(is_array($gardens) && count($gardens)>0)	
		@foreach($gardens as $k=>$garden)
			dropMarker({{$garden->location->lat}},{{$garden->location->lng}},{{$garden->id}},greenPin);
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
		$('#hoursRow').html('<label class="control-label col-xs-2" style="text-indent:15px;">Horaires</label><label class="control-label col-xs-9 col-xs-offset-1">Choisissez une date pour pouvoir selectionner des horaires</label>');
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
		$('.left-col').css('min-height',0);
		$('.map-container').css('left','100%');
		$('.search-params').toggle();
		$('#phoneParamToggler').toggleClass('active');
	});

	$('#phoneMapToggler').click(function(){
		$('#phoneParamToggler').removeClass('active');
		$('.search-params').hide();

		if($('.map-container').offset().left < 10 ){
			$('.map-container').css('left','110%');
			$('.left-col').css('min-height','0');
			$('#phoneMapToggler').removeClass('active');
		}else{
			$('.map-container').css('left','3%');
			$('.left-col').css('min-height','270px');
			$('#phoneMapToggler').addClass('active');
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