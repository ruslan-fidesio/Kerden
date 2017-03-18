@extends('layouts.app')


@section('headers')
@endsection

@section('content')

<div class="container-fluid">
	<div class="row header">
			<h1>Rentabilisez votre espace extérieur.</h1>
	</div>
	<div class="row">
		<div class="container-fluid">
            <div class="col-sm-12 rentCall">
                <h2>Choisissez vos invités selon vos critères</h2>
                <hr>
                <h4>C'est vous qui choisissez le type d'évènement que vous acceptez dans votre {{strtolower($gardenType)}}.</h4>
                <h4>C'est vous qui choisissez à qui vous souhaitez louer votre {{strtolower($gardenType)}}.</h4>
                <h4>C'est vous qui déterminez le tarif de votre location.</h4>

                <div class="col-xs-12">
                    <h2>En louant votre {{strtolower($gardenType)}}, vous participez à ce nouveau concept éthique qui s'adresse à tous:</h2>
                </div>
                <hr>

                <div class="row">
                    <div class="col-xs-3"><img src="{{asset('images/transat.png')}}" alt="transat"></div>
                    <div class="col-xs-9 col-sm-7 rentDesc"><span style="margin-top:6px">Embellissez et améliorez le confort de votre {{strtolower($gardenType)}}.</span><br>Nos partenaires vous font bénéficier de 15% de remise : Barbecue, parasols chauffants, mobilier de jardin...</div>
                </div>
                <div class="row">
                    <div class="col-xs-3"><img src="{{asset('images/oscardien.jpg')}}" alt="oscardien"></div>
                    <div class="col-xs-9 col-sm-7 rentDesc"><span style="margin-top:6px">Sécurisez vos locations.</span><br>Oscar notre agence partenaire vous permet de sécuriser votre environnement. Vous pouvez louer en présence d'Oscardiens.</div>
                </div>
                <div class="row">
                    <div class="col-xs-3"><img src="{{asset('images/champagne.png')}}" alt="champagne"></div>
                    <div class="col-xs-9 col-sm-7 rentDesc"><span>Financez l'entretien de votre {{strtolower($gardenType)}}.</span></div>
                </div>
                <div class="row">
                    <div class="col-xs-3"><img src="{{asset('images/bougies.png')}}" alt="bougies"></div>
                    <div class="col-xs-9 col-sm-7 rentDesc"><span>Partagez et faites de nouvelles rencontres.</span></span></div>
                </div>
                <div class="row">
                    <div class="col-xs-3"><img src="{{asset('images/cerises.png')}}" alt="cerises"></div>
                    <div class="col-xs-9 col-sm-7 rentDesc"><span>Aidez l'homme à retrouver la nature.</span></div>
                </div>

                <h2>Louer 
                    @if( $gardenType =='Terrasse')
                        ma
                    @else
                        mon
                    @endif

                    {{strtolower($gardenType)}}</h2>

                <hr>

            </div>
            <div class="col-sm-12 col-md-10 col-md-offset-1 rentForm">
                	{!! Form::open(['url'=>'/rent/create','class'=>'form-horizontal']) !!}

                	<div class="rentForm form-group{{ $errors->has('address')||$errors->has('blur_address') ? ' has-error' : '' }}">
                		{!! Form::label('address',trans('garden.address'),['class'=>'col-md-12 control-label']) !!}
                		<div class='col-md-12'>
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
                    <div id="map" class='col-md-10 col-md-offset-1' style='height:300px'></div>
                    {!! Form::hidden('lat',null,['id'=>'lat']) !!}
                    {!! Form::hidden('lng',null,['id'=>'lng']) !!}
                    {!! Form::hidden('blur_address',null,['id'=>'blur_address']) !!}

                	<div class="form-group{{ $errors->has('surface') ? ' has-error' : '' }}">
                		{!! Form::label('surface',trans('garden.surface'),['class'=>'col-md-12 control-label']) !!}
                		<div class='col-md-12'>
                			{!! Form::number('surface',null,['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                		@if ($errors->has('surface'))
                            <span class="help-block">
                                <strong>{{ $errors->first('surface') }}</strong>
                            </span>
                        @endif
                        </div>
                	</div>

                	<div class="form-group{{ $errors->has('max_pers') ? ' has-error' : '' }}">
                		{!! Form::label('max_pers',trans('garden.max_pers'),['class'=>'col-md-12 control-label']) !!}
                		<div class='col-md-12'>
                			{!! Form::number('max_pers',null,['class'=>'form-control','min'=>'0']) !!}
                		@if ($errors->has('max_pers'))
                            <span class="help-block">
                                <strong>{{ $errors->first('max_pers') }}</strong>
                            </span>
                        @endif
                        </div>
                	</div>

                	<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                		{!! Form::label('description',trans('garden.description'),['class'=>'col-md-12 control-label']) !!}
                		<div class='col-md-12'>
                			{!! Form::textarea('description',null,['class'=>'form-control']) !!}
                		@if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                        </div>
                	</div>

                	<div class="form-group">
                		<a href="/"><div class='col-xs-4 col-xs-offset-4'>{!! Form::button(trans('auth.cancel'),['class'=>'btn btn-kerden-confirm']) !!}</div></a>
                		<div class='col-xs-4'>{!! Form::submit(trans('pagination.next'),['class'=>'btn btn-kerden-cancel']) !!}</div>
                	</div>


                	{!! Form::close() !!}

                </div>
            </div>
            @include('footer')
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
</script>

<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMppXmks4XyF8XMe3_roFbVumAlThb_CY&libraries=places&callback=initMap">
</script>

@endsection