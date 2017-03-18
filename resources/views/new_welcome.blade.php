@extends('layouts.app')

@section('headers')
<link href='http://fonts.googleapis.com/css?family=Dancing+Script:400,700' rel='stylesheet' type='text/css'>
@endsection

@section('content')

<!-- <div class="alert alert-black">
	<a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:beige">&times;</a>
	En naviguant sur Kerden.fr, vous acceptez l'utilisation de cookies. Ces derniers sont la pour vous assurer une expérience interactive fluide.
	<a href="#" data-dismiss="alert"><span class="text-right" > J'ai compris</span></a>
</div> -->

<div class="container-fluid homepage-container">
	<div class="row img-contain">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="4700" data-pause="true">
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class='item active'><img src="{{ asset('images/homepage/jardin.jpg') }}"></div>
				<div class='item'><img src="{{ asset('images/homepage/lac.jpg') }}"></div>
				<div class='item itemTerrasse'><img src="{{ asset('images/homepage/terrasse.jpg') }}"></div>
			</div>
		</div>

		<div class="row text-center homepage-caption">
			<h1>Louez <span class="vTick" style='display:inline-block;width:226px'><ul><li>un Jardin</li><li>un Domaine</li><li>une Terrasse</li></ul></span> adapté<span style='display:none' id="accordTrick">e</span> à votre évènement</h1>

			<h2 class='hidden-xs'>Faites de votre évènement un moment unique</h2>
			
		</div>

		 <div class="row homepage-searchRow">
		 	<div class='row'>
			 	{!! Form::open(['url'=>'/search','id'=>'homeSearchForm']) !!}
	            <div class='col-sm-2 col-sm-offset-0-et-demi col-xs-4 col-xs-offset-1'>
	                {!! Form::text('date',null,['placeholder'=>'Date','class'=>'form-control','id'=>'datePicker']) !!}
	            </div>
	            <div class='col-sm-2 col-xs-4 col-xs-offset-2 col-sm-offset-0'>
	                {!! Form::select('activity',
	                ['lunch'=>'Repas','relax'=>'Détente','barbecue'=>'Barbecue','reception'=>'Réception','children'=>'Enfants','party'=>'Fête','nightEvent'=>'Soirée','pro'=>'Pro'],
	                null,['placeholder'=>'Activité','class'=>'form-control','id'=>'homeactivitySelect']) !!}
	            </div>
	            <div class='col-sm-2 col-xs-4 col-xs-offset-1 col-sm-offset-0'>
	                {!! Form::select('category',
	                ['Jardin'=>'Jardin','Terrasse'=>'Terrasse','Domaine'=>'Domaine','Jardin d\'hiver'=>'Jardin d\'hiver','Jardin restaurant'=>'Jardin restaurant','Château'=>'Château'],
	                null,['placeholder'=>'Catégorie','class'=>'form-control','id'=>'categorySelect']) !!}
	            </div>
	            <div class='col-sm-3 col-xs-4 col-xs-offset-2 col-sm-offset-0'>
	                {!! Form::text('place','',['placeholder'=>'Où','class'=>'form-control place-form-control']) !!}
	                {!! Form::hidden('geolocPosition',null) !!}
	            </div>
	            <div class="col-sm-2 col-xs-8 col-xs-offset-2 col-sm-offset-0">
	            	{!! Form::submit('Rechercher',['class'=>'btn btn-search-inline btn-welcome','style'=>'width:100%']) !!}
	            </div>
	            {!! Form::close() !!}
            </div>
            <div class="row text-center" style='color:white;font-size:1.3em;margin:10px'>
	        	OU
	        </div>
        	<div class="row text-center">
        		<div id="geoloc" class="btn btn-welcome btn-geoloc text-center">Rechercher autour de moi</div>
        	</div>
        </div>

   	</div>
</div>

<div class="container homepage-grid-container">
	<h3 class="text-center" style='margin-bottom:20px'>Organiser un évènement pour</h3>

	<div class="homepage-scroller" >
		<div class='homepage-scroller-inner'>
		
			<div class="homepage-subRow" style="margin-bottom:25px" >
				<a href="{{url('/search?activity=party')}}">
					<div class="col-xs-1 col-xs-1-et-demi col-sm-4 col-sm-offset-1  unloaded unloaded-left">
						<img src="{{asset('images/homepage/anniversaire.jpg')}}" alt="" class="img-responsive" id="baseResizeOne">
						<span>Un anniversaire</span>
					</div>
				</a>
				<a href="{{url('/search?activity=barbecue')}}">
					<div class="col-xs-2 col-sm-6 unloaded unloaded-right" >
						<img src="{{asset('images/homepage/barbecue.jpg')}}" alt="" class="img-responsive" id="toResizeOne">
						<span>Un barbecue</span>
					</div>
				</a>
			</div>
		
			<div class="homepage-subRow" style="margin-bottom:25px">
				<a href="{{url('/search?activity=pro')}}">
					<div class="col-xs-2 col-sm-5 col-sm-offset-1 unloaded unloaded-left">
						<img src="{{asset('images/homepage/reunion.jpg')}}" alt="" class="img-responsive">
						<span>Une réunion professionnelle</span>
					</div>
				</a>
				<a href="{{url('/search?activity=nightEvent')}}">
					<div class="col-xs-2 col-sm-5 unloaded unloaded-right">
						<img src="{{asset('images/homepage/soiree.jpg')}}" alt="" class="img-responsive">
						<span>Une soirée</span>
					</div>
				</a>
			</div>
		
			<div class="homepage-subRow" style="margin-bottom:25px" >
				<a href="{{url('/search?activity=reception')}}">
					<div class="col-xs-2 col-sm-5 col-sm-offset-1 unloaded unloaded-left">
						<img src="{{asset('images/homepage/afterwork.jpg')}}" alt="" class="img-responsive" id="toResizeTwo">
						<span>Un after work</span>
					</div>
				</a>
				<a href="{{url('/search?activity=party')}}">
					<div class="col-xs-2 col-sm-5 unloaded unloaded-right">
						<img src="{{asset('images/homepage/mariage.jpg')}}" alt="" class="img-responsive" id='baseResizeTwo'>
						<span>Un mariage</span>
					</div>
				</a>
			</div>
			
		</div>
	</div>

	<div class="row">
		<h3 class="text-center" style="margin-bottom:20px">Faîtes de votre évènement un moment unique</h3>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">
			<video id="introVideo" width="100%" poster="{{asset('images/placeholder.png')}}">
			        <source src="{{asset('kerden.mp4')}}" type="video/mp4"/>
			        -Video not supported-
			    </video>
			    <img class='playerPlay' src="{{asset('images/motif_play.png')}}">
			    <span class="volume-icon glyphicon glyphicon-volume-off" style='display:none'></span>
			    <span class="volume-icon glyphicon glyphicon-volume-up"></span>
		</div>
	</div>
</div>
<div class="container">
	<h3 class="text-center col-xs-12" style="margin-bottom:20px;font-family:'kerdenRegular'">Nos partenaires</h3>
</div>
<div class="container">
	
	<div class="row partnairsLogoLine" style='box-shadow:none'>
	        <a target="_blank" href="http://www.lepanierdezoe.com"><div class="logoLine col-xs-6 col-sm-2 col-sm-offset-1" style='background-color:#2f1f29; text-align:center'>
	                    <img src="http://www.lepanierdezoe.com/wp-content/themes/barletter/img/logo-header-1.png" class="img-responsive" alt="Logo le panier de Zoé, traiteur 9ème arrondissement" style="margin:auto">
	                    <span style="font-family:'Dancing Script';color:white; font-size:1.8em">Le Panier de Zoé</span>
	            </div></a>
	        <a target="_blank" href="http://www.oscar.fr"><div class="logoLine col-xs-6 col-sm-2">
	                <img src="http://www.oscar.fr/wp-content/uploads/2015/10/logo_OSCAR_300.png" class="img-responsive" alt="Oscar" >
	            </div></a>


	        <a href="http://www.enviedeconfort.com" target="_blank"><div class="logoLine col-xs-6 col-sm-2">
	                <img class="img-responsive" src="http://www.enviedeconfort.com/skin/frontend/edc/default/images/logo.gif" alt="Bienvenue sur enviedeconfort.com">
	            </div></a>
	        <a target="_blank" href="http://www.favex.fr"><div class="logoLine col-xs-6 col-sm-2">
	                <img src="http://myfavex.fr/2016/wp-content/uploads/2016/08/logo_favex_1.png" alt="Favex" title="Favex" class="img-responsive">
	            </div></a>
	        <!-- <a href="http://www.mangopay.com" target="_blank"><div class="logoLine col-xs-4 col-md-2">
	                <img src="https://www.mangopay.com/wp-content/themes/underscores/img/mangopay.png" alt="MANGOPAY" class="img-responsive">
	            </div></a> -->
	            <a href="http://www.laboutiquedebob.butagaz.fr" target="_blank"><div class="logoLine col-xs-12 col-sm-2">
	                <img src="{{asset('images/bob.png')}}" alt="La boutique de Bob" class="img-responsive"> 
	            </div></a>
	    </div>
</div>

@include('footer')

@endsection


@section('scripts')
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

}) (jQuery);
</script>
@endsection