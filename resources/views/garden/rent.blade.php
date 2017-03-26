@extends('layouts.app')


@section('headers')
  <link href="{{ asset('css/slideshow-home.css') }}" rel="stylesheet">
  <link href="{{ asset('slick/slick.css') }}" rel="stylesheet">
  <link href="{{ asset('slick/slick-theme.css') }}" rel="stylesheet">
@endsection

@section('content')


<div class="header">
    <div class="container">	
		<h1>Rentabilisez votre espace extérieur</h1>
    </div>
</div>
<div class="rent-form-container">	
    <div class="map-rent">	
        <!-- GOOGLE MAPS API -->  
        <div id="map"></div>
        {!! Form::hidden('lat',null,['id'=>'lat']) !!}
        {!! Form::hidden('lng',null,['id'=>'lng']) !!}
        {!! Form::hidden('blur_address',null,['id'=>'blur_address']) !!}
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="rentForm">
                    {!! Form::open(['url'=>'/rent/create','class'=>'form-horizontal']) !!}


                    	<div class="form-group{{ $errors->has('address')||$errors->has('blur_address') ? ' has-error' : '' }}">
                    		{!! Form::label('address',trans('garden.address'),['class'=>'col-md-6 control-label']) !!}
                    		<div class='col-md-6'>
                                <div class="icon-label lieu">
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
                    	</div>

                    	<div class="form-group{{ $errors->has('surface') ? ' has-error' : '' }}">
                    		{!! Form::label('surface',trans('garden.surface'),['class'=>'col-md-6 control-label']) !!}
                        	<div class='col-md-6'>
                                <div class="icon-label surface">
                        			{!! Form::number('surface',null,['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                            		@if ($errors->has('surface'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('surface') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                    	</div>

                    	<div class="form-group{{ $errors->has('max_pers') ? ' has-error' : '' }}">
                    		{!! Form::label('max_pers',trans('garden.max_pers'),['class'=>'col-md-6 control-label']) !!}
                    		<div class='col-md-6'>
                                <div class="icon-label participants">
                        			{!! Form::number('max_pers',null,['class'=>'form-control','min'=>'0']) !!}
                            		@if ($errors->has('max_pers'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('max_pers') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                    	</div>

                    	<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    		{!! Form::label('description',trans('garden.description'),['class'=>'col-md-6 control-label']) !!}
                    		<div class='col-md-6'>
                    			{!! Form::textarea('description',null,['class'=>'form-control']) !!}
                        		@if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                    	</div>

                    	<div class="form-group text-center">
                            <div class='col-sm-6 col-sm-offset-6'>
                                {!! Form::button(trans('auth.cancel'),['class'=>'btn-kerden-cancel']) !!}
                                {!! Form::submit(trans('pagination.next'),['class'=>'btn-kerden-confirm']) !!}
                            </div>
                    	</div>
                    </div>

                    {!! Form::close() !!}
                    <div class="cloud-cache"></div>
                </div>
            </div>
    </div>
</div>
<div class="advantages cloud-border">
  <div class="container">       
    <h2 class="big-title">Vos avantages Kerden</h2>
    <div class="row">
      <div class="col-md-3">
        <div class="advantage">
          <div class="icon">
            <img src="{{asset('images/advantages/bank.png')}}" alt="votre jardin vous rapporte des revenus complementaires">
          </div>
          Bénéficiez de revenus complémentaires
        </div>
      </div>
      <div class="col-md-3">
        <div class="advantage">
          <div class="icon blue">
            <img src="{{asset('images/advantages/watch.png')}}" alt="jardins surveillés pendant les locations">
          </div>
          Sécurisez vos locations avec du personnel surveillant
        </div>
      </div>
      <div class="col-md-3">
        <div class="advantage">
          <div class="icon green">
            <img src="{{asset('images/advantages/coupon.png')}}" alt="réduction partenaires jardins">
          </div>
          Profitez de 15% de réduction chez nos partenaires
        </div>
      </div>
      <div class="col-md-3">
        <div class="advantage">
          <div class="icon lightblue">
            <img src="{{asset('images/advantages/choose.png')}}" alt="conditions de location jardin">
          </div>
          Choisissez vos conditions (horaires, niveau sonore...)
        </div>
      </div>                             
    </div>              
  </div>
</div>

<div class="wood-bg-home">
  <div class="container">
    <h2 class="big-title">Nos partenaires</h2>
    <div class="row">
      <div class="partners-slideshow">
        <a class="partner" href="http://www.enviedeconfort.com/" target="_blank">
            <img src="{{asset('images/partners/envie-de-confort.jpg')}}" alt="logo envie de confort">
        </a>
        
        <a class="partner" href="http://www.oscar.fr/" target="_blank">
            <img src="{{asset('images/partners/oscar.jpg')}}" alt="">
        </a>
        
        <a class="partner" href="http://www.laboutiquedebob.butagaz.fr/" target="_blank">
            <img src="{{asset('images/partners/boutique-bob.jpg')}}" alt="">
        </a>
        
        <a class="partner" href="http://www.favex.fr/" target="_blank">
            <img src="{{asset('images/partners/favex.jpg')}}" alt="">
        </a>
        
        <a class="partner" href="http://www.lepanierdezoe.com/" target="_blank">
            <img src="{{asset('images/partners/panier-de-zoe.jpg')}}" alt="">
        </a>
        
      </div>
    </div>
  </div>
</div>

@include('footer')



@endsection

@section('scripts')
<script type="text/javascript" src=" {{ asset('slick/slick.js') }} "></script>
<script type="text/javascript">
    var map, geocoder, marker, autocomplete, bounds;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 48.84, lng: 2.36},
            zoom: 11,
            scrollwheel: false,
            disableDefaultUI: true,
            scaleControl: true,
            zoomControl: true,
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
    $('.partners-slideshow').slick({
      slidesToShow: 4,
      prevArrow: "<a class='slick-nav angle-left'><i class='fa fa-angle-left'></i></a>",
      nextArrow: "<a class='slick-nav angle-right'><i class='fa fa-angle-right'></i></a>",
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3
          }
        },      
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2
          }
        }
      ]    
    });

</script>

<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMppXmks4XyF8XMe3_roFbVumAlThb_CY&libraries=places&callback=initMap">
</script>

@endsection