@extends ('garden.menu')

@section('contentPane')
	<h1 class="jumbotron-heading text-center">{{trans('garden.rent')}}</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Informations</strong> -> Critères -> Tarifs / Créneaux horaires -> Calendrier </div>
                <div class="panel-body">
                	{!! Form::open(['url'=>'/garden/create','class'=>'form-horizontal']) !!}

                	<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                		{!! Form::label('title',trans('garden.title'),['class'=>'col-md-4 control-label']) !!}
                		<div class='col-md-6 input-group'>
                            <div id='mySelectDropdown' class="input-group-addon" style='background-color:white'>
                                <span id='titleTrick'>{{old('cat',Request::has('cat')?Request::get('cat'):'Le jardin')}}</span>
                                <i class="fa fa-3 fa-arrow-circle-o-down" style='cursor:pointer'></i>
                            </div>
                            <div class="mySelect" id='titleSelect'>
                                <ul>
                                    @foreach($categories as $cat=>$v)
                                        <li data-myvalue="{{$v}}">{{$cat}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            {!! Form::hidden('cat',old('cat',Request::has('cat')?Request::get('cat'):'Le jardin')) !!}
                			{!! Form::text('title','de '.$name,['class'=>'form-control']) !!}
                		@if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                        </div>
                	</div>

                	<div class="form-group{{ $errors->has('address')||$errors->has('blur_address') ? ' has-error' : '' }}">
                		{!! Form::label('address',trans('garden.address'),['class'=>'col-md-4 control-label']) !!}
                		<div class='col-md-6'>
                			{!! Form::text('address',null,['class'=>'form-control']) !!}
                		@if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                        @if ($errors->has('blur_address'))
                            <span class="help-block">
                                <strong>L'adresse n'est pas assez précise</strong>
                            </span>
                        @endif
                        </div>
                	</div>

                    <!-- GOOGLE MAPS API -->
                    <div id="map" class='col-md-6 col-md-offset-4' style='height:300px'></div>
                    {!! Form::hidden('lat',null,['id'=>'lat']) !!}
                    {!! Form::hidden('lng',null,['id'=>'lng']) !!}
                    {!! Form::hidden('blur_address',null,['id'=>'blur_address']) !!}

                	<div class="form-group{{ $errors->has('surface') ? ' has-error' : '' }}">
                		{!! Form::label('surface',trans('garden.surface'),['class'=>'col-md-4 control-label']) !!}
                		<div class='col-md-6'>
                			{!! Form::number('surface',null,['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                		@if ($errors->has('surface'))
                            <span class="help-block">
                                <strong>{{ $errors->first('surface') }}</strong>
                            </span>
                        @endif
                        </div>
                	</div>

                	<div class="form-group{{ $errors->has('max_pers') ? ' has-error' : '' }}">
                		{!! Form::label('max_pers',trans('garden.max_pers'),['class'=>'col-md-4 control-label']) !!}
                		<div class='col-md-6'>
                			{!! Form::number('max_pers',null,['class'=>'form-control','min'=>'0']) !!}
                		@if ($errors->has('max_pers'))
                            <span class="help-block">
                                <strong>{{ $errors->first('max_pers') }}</strong>
                            </span>
                        @endif
                        </div>
                	</div>

                	<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                		{!! Form::label('description',trans('garden.description'),['class'=>'col-md-4 control-label']) !!}
                		<div class='col-md-6'>
                			{!! Form::textarea('description',null,['class'=>'form-control']) !!}
                		@if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                        </div>
                	</div>

                	<div class="form-group">
                		<a href="/home"><div class='col-xs-4 col-xs-offset-4'>{!! Form::button(trans('auth.cancel'),['class'=>'btn btn-kerden-cancel']) !!}</div></a>
                		<div class='col-xs-4'>{!! Form::submit(trans('pagination.next'),['class'=>'btn btn-kerden-confirm']) !!}</div>
                	</div>


                	{!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script type="text/javascript">
var map, geocoder, marker, autocomplete, bounds;
function initMap() {
   map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 48.84, lng: 2.36},
    zoom: 10,
    scrollwheel: false
  });
   geocoder = new google.maps.Geocoder();
   marker = new google.maps.Marker({map:map});
   bounds = map.getBounds();
   autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'),{bounds:bounds});
   autocomplete.addListener('place_changed',centerMap);
   centerMap();
}

function centerMap(){
    var address = $('#address').val();
    if(address == ''){return;}
    geocoder.geocode( {'address':address} ,function(results, status){
        if(status == google.maps.GeocoderStatus.OK){
            console.log(results);
            var loca = results[0].geometry.location;
            map.setCenter(loca);
            map.setZoom(15);
            marker.setPosition(loca);
            $('#lat').val( loca.lat );
            $('#lng').val( loca.lng );
            //blur address
            var len = results[0].address_components.length;
            var code = results[0].address_components[len-1].short_name;
            $('#blur_address').val(code);
        }else{
            alert( "{{ trans('garden.failaddress') }}" );
        }
    });
}

(function($){
    $('#mySelectDropdown').click(function(){
        $("#titleSelect").slideToggle();
    });
    $('#titleSelect ul li').each(function(){
        $(this).click(function(){
            $('#titleTrick').text($(this).data('myvalue'));
            $('input[name="cat"]').val($(this).data('myvalue'));
            $('#titleSelect').slideUp();
        });
    });

    $('.HPMenuLink').removeClass('active');
    $('.gardenMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(1)').addClass('active');
}) (jQuery);

</script>

<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMppXmks4XyF8XMe3_roFbVumAlThb_CY&libraries=places&callback=initMap">
</script>

@endsection