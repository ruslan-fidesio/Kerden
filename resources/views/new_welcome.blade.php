@extends('layouts.app')

@section('headers')

  <link href="{{ asset('css/slideshow-home.css') }}" rel="stylesheet">
  <link href="{{ asset('slick/slick.css') }}" rel="stylesheet">
  <link href="{{ asset('slick/slick-theme.css') }}" rel="stylesheet">

@endsection

@section('content')

<!-- <div class="alert alert-black">
	<a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:beige">&times;</a>
	En naviguant sur Kerden.fr, vous acceptez l'utilisation de cookies. Ces derniers sont la pour vous assurer une expérience interactive fluide.
	<a href="#" data-dismiss="alert"><h3 class="text-right" > J'ai compris</h3></a>
</div> -->

<nav class="navbar navbar-default home-navbar" data-spy="affix" data-offset-top="150">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand navbar-brand-top" href="{{ url('/') }}">
                <img class="logo" src="{{asset('images/kerden-logo.svg')}}">
                <img class="logo-homepage" src="{{asset('images/kerden-logo-homepage.svg')}}">
                <div class="logo-text">erden</div>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a class="blue-menu" href="#" data-toggle="modal" data-target="#inscriptionModal">{{trans('auth.register')}}</a></li>
                    <li><a class="green-menu" href="#" data-toggle="modal" data-target="#connexionModal">{{trans('auth.login')}}</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Mon Espace <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/home') }}"><i class='fa fa-btn fa-user'></i>Espace membre</a> </li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Déconnexion</a></li>
                        </ul>
                    </li>
                @endif  
                
                @if(Auth::user())
                    <li>
                      <a href="{{ url('/home') }}">Espace Membre
                        @if(Auth::user()->unreadMessages > 0)
                            <i class="fa fa-envelope-o"></i><sup class="unreadNumber">{{ Auth::user()->unreadMessages }}</sup>
                        @endif
                        <i class="fa fa-envelope-o"></i><sup class="unreadNumber">3</sup>
                      </a>
                    </li>
                @endif                              
                <!-- Authentication Links -->
                <li><a class="rentCTA" 
                    @if(Auth::guest())
                        href="/rent"
                    @else
                        @if(count(Auth::user()->ownedGardens)>0)
                            href="{{url('/garden/update/'. Auth::user()->ownedGardens[0]->id )}}" 
                        @else
                            href="/rent"
                        @endif
                    @endif
                >{{trans('base.rent')}}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="homepage-container">
  <div class="slideshow-home">
    <div class="page-view">
      <div class="project">
        <div class="text">
          <h2>Louer une terrasse pour une soirée...</h2>
        </div>
      </div>
      <div class="project">
        <div class="text">
          <h2>Louer un domaine pour un mariage...</h2>
        </div>
      </div>
      <div class="project">
        <div class="text">
          <h2>Louer un parc pour un anniversaire...</h2>
        </div>
      </div>
      <div class="project">
        <div class="text">
          <h2>Louer un jardin pour un barbecue...</h2>
        </div>
      </div>

      <nav class="arrows">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="arrow previous">
                <i class="fa fa-angle-left"></i>
              </div>
              <div class="arrow next">
                <i class="fa fa-angle-right"></i>
              </div>
            </div>
          </div>
        </div>
      </nav>
      <div class="homepage-searchRow">
      
        {!! Form::open(['url'=>'/search','id'=>'homeSearchForm']) !!}
          <div class='col-sm-5 col-sm-offset-0 col-xs-10 col-xs-offset-1'>
              {!! Form::text('place','',['placeholder'=>'Lieu','class'=>'form-control place-form-control']) !!}
              {!! Form::hidden('geolocPosition',null) !!}
          </div>
          <div class='col-sm-3 col-sm-offset-0 col-xs-10 col-xs-offset-1'>
              {!! Form::text('date',null,['placeholder'=>'Date','class'=>'form-control','id'=>'datePicker']) !!}
          </div>
          <div class="col-sm-4 col-xs-10 col-xs-offset-1 col-sm-offset-0">
            {!! Form::submit('Rechercher',['class'=>'btn-search-inline','style'=>'width:100%']) !!}
          </div>
        {!! Form::close() !!}
        <div class='col-sm-5 col-sm-offset-0 col-xs-10 col-xs-offset-1'>
          <div id="geoloc" class="btn-geoloc">Rechercher autour de moi ></div>
        </div>      
      </div>      
    </div> 
  </div>
</div>
<div class="advantages cloud-border">
  <div class="container">		
    <h2 class="big-title">Vous aussi, proposez votre jardin à la location !</h2>
    <div class="row">
      <div class="col-md-3 col-sm-6">
        <div class="advantage">
          <div class="icon">
            <img src="{{asset('images/advantages/bank.png')}}" alt="votre jardin vous rapporte des revenus complementaires">
          </div>
          Bénéficiez de revenus complémentaires
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="advantage">
          <div class="icon blue">
            <img src="{{asset('images/advantages/watch.png')}}" alt="jardins surveillés pendant les locations">
          </div>
          Sécurisez vos locations avec du personnel surveillant
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="advantage">
          <div class="icon green">
            <img src="{{asset('images/advantages/coupon.png')}}" alt="réduction partenaires jardins">
          </div>
          Profitez de réductions chez nos partenaires
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="advantage">
          <div class="icon lightblue">
            <img src="{{asset('images/advantages/choose.png')}}" alt="conditions de location jardin">
          </div>
          Choisissez vos conditions (horaires, niveau sonore...)
        </div>
      </div>    
      <div class="col-md-12 text-center">
        <a href="{{url('/rent')}}" class="bigRentCTA">{{trans('base.rent')}}</a>
      </div>                          
    </div>  			
  </div>
</div>

<div class="wood-bg-home">
  <div class="container">
    <h2 class="big-title">Des locations d’espaces pour toutes vos envies...</h2>
    <div class="row homepage-subRow">
      <div class="garden-idea-slideshow">
        <div class="garden-idea">
          <a href="{{url('/search?category=Jardin')}}">
            <div class="unloaded">
              <img src="{{asset('images/homepage/idea-jardin.jpg')}}" alt="">
              <h3>Jardins</h3>
            </div>
          </a>
        </div>
        <div class="garden-idea">
          <a href="{{url('/search?category=Jardin')}}">
            <div class="unloaded">
              <img src="{{asset('images/homepage/idea-terrasse.jpg')}}" alt="location de terrasse">
              <h3>Terrasses</h3>
            </div>
          </a>
        </div>        
        <div class="garden-idea">
          <a href="{{url('/search?category=Jardin')}}">
            <div class="unloaded">
              <img src="{{asset('images/homepage/idea-chateau.jpg')}}" alt="location de châteaux">
              <h3>Châteaux</h3>
            </div>
          </a>
        </div>
        <div class="garden-idea">
          <a href="{{url('/search?category=Jardin')}}">
            <div class="unloaded">
              <img src="{{asset('images/homepage/idea-parc.jpg')}}" alt="location de parcs et domaines">
              <h3>Parcs & domaines</h3>
            </div>
          </a>
        </div>     
        <div class="garden-idea">
          <a href="{{url('/search?category=Jardin')}}">
            <div class="unloaded">
              <img src="{{asset('images/homepage/idea-piscine.jpg')}}" alt="location de piscine">
              <h3>Piscines</h3>
            </div>
          </a>
        </div>                                         
      </div>
    </div>
  </div>
</div>



@include('footer')

@endsection


@section('scripts')
  <script type="text/javascript" src=" {{ asset('js/zepto.min.js') }} "></script>
  <script type="text/javascript" src=" {{ asset('js/imagesloaded.pkgd.min.js') }} "></script>
  <script type="text/javascript" src=" {{ asset('js/slideshow-home.js') }} "></script>

  <script type="text/javascript" src=" {{ asset('slick/slick.js') }} "></script>
  <script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
  @if(App::getLocale() == 'fr')
  <script src="{{ URL::asset('js/bootstrap-datepicker.fr.js') }}"></script>
  @endif
  <script type="text/javascript">
  (function($){
  	var ua = navigator.userAgent;
  	var isiPad = /iPad/i.test(ua) || /iPhone OS 3_1_2/i.test(ua) || /iPhone OS 3_2_2/i.test(ua);

      $('#datePicker').datepicker({
          language:'fr',
          format:'dd-mm-yyyy',
          startView:'month',
          autoclose:true,
          todayHighlight:true,
          startDate: new Date()
      });

      $('#categorySelect').select2({
  	  minimumResultsForSearch: Infinity,
  	  width:'100%'
  	});
  	$('#homeactivitySelect').select2({
  	  minimumResultsForSearch: Infinity,
  	  width:'100%'
  	});

  	// if(isiPad){
  	// 	$('.vTick').vTicker('init',{
  	// 		mousePause:false,
  	// 		startPaused:true,
  	// 		height:32,
  	// 	});
  	// }else{
  	// 	$('.vTick').vTicker('init',{
  	// 		mousePause:false,
  	// 		startPaused:true,
  	// 		height:31,
  	// 	});
  	// }

  	$('.vTick').vTicker('init',{
  		mousePause:false,
  		startPaused:true,
  		height:32
  	});

  	/***** VIDEO CONTROL *****/
  	var isPlaying = false;
      $('#introVideo').click(function(){
          if(!isPlaying){
              $('#introVideo').get(0).play();
              $('.playerPlay').hide();
              isPlaying = true;
          }
          else{
              $('#introVideo').get(0).pause();
              $('.playerPlay').show();
              isPlaying = false;
          }
      })

      $('.glyphicon-volume-off').click(function(){
          $('#introVideo').get(0).muted = false;
          $('.glyphicon-volume-off').hide();
          $('.glyphicon-volume-up').show();        
      });
      $('.glyphicon-volume-up').click(function(){
          $('#introVideo').get(0).muted = true;
          $('.glyphicon-volume-up').hide();
          $('.glyphicon-volume-off').show();        
      });

      $('#carousel-example-generic').on('slide.bs.carousel',function(event){
      	$('.vTick').vTicker('next',{animate:true});
      	if(/Terrasse/.test(event.relatedTarget.className)){
      		$('#accordTrick').fadeIn();
      	}else{
      		$('#accordTrick').fadeOut();
      	}
      });

      //trick de mise en page
      $(window).load(function(){
  	    $('#toResizeOne').css('height',$('#baseResizeOne').height());
  	    $('#toResizeTwo').css('height',$('#baseResizeTwo').height());
  	});
  	$(window).resize(function(){
  	    $('#toResizeOne').css('height',$('#baseResizeOne').height());
  	    $('#toResizeTwo').css('height',$('#baseResizeTwo').height());
  	});

  	$('#introVideo').on('ended',function(){
  	  $('#introVideo').autoplay=false;
  	  $('#introVideo').load();
  	  $('.playerPlay').show();
  	});

  	function geoCallback(position){
  		//console.log(position);
  		$('input[name="geolocPosition"]').val('{ "lat":'+position.coords.latitude+',"lng":'+position.coords.longitude+' }');
  		$('#homeSearchForm').submit();
  	}
  	function errorGeoCallBack(error){
  		alert('Une erreur est survenue pendant la geolocalisation : '+error.message);
  	}

  	$('#geoloc').click(function(){
  		if(navigator.geolocation){
  			navigator.geolocation.getCurrentPosition(geoCallback,errorGeoCallBack);
  		}else{
  			alert('Votre navigateur ne supporte pas la géolocalisation.');
  		}
  	});

    $('.garden-idea-slideshow').slick({
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
            slidesToShow: 1
          }
        }
      ]    
    });

  }) (jQuery);
  </script>


@endsection


