@extends('layouts.app')

@section('headers')
<link rel="stylesheet" href="{{ URL::asset('css/datepicker3.css') }}">
<link href='https://fonts.googleapis.com/css?family=Dancing+Script:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="{{asset('css/homepage.css')}}">
@endsection
 

@section('content')
<div class="container">
    <div id='page1' >
       {{ php_info() }} 
        <!-- <div class='container center-main-logo'>
            <span class='sr-only'>LOGO</span>
        </div> -->
        @if(Auth::guest())
            <div class="alert alert-warning fade in cookieAlert" data-dismiss="alert" >
             En naviguant sur Kerden.fr, vous acceptez l'utilisation de cookies. Ces derniers sont la pour vous assurer une expérience interactive fluide.
         </div>
        @endif
        <div class="container text-center center-main-phrase">
            Louez un jardin adapté à votre évènement
        </div>  
        <div class='sub-logo text-center'>
            Faîtes de votre évènement un moment unique
        </div>

        <div id='searchFormContainer' class="container" >
            {!! Form::open(['url'=>'/search']) !!}

        <div class="row">
            <div class='col-sm-2 col-sm-offset-2 col-xs-8 col-xs-offset-2'
            @if($errors->has('date'))
                data-toggle='tooltip' data-title="Date trop proche"
            @endif
            >
                {!! Form::text('date',null,['placeholder'=>'Date','class'=>'form-control','id'=>'datePicker']) !!}
            </div>
            <div class='col-sm-2 col-xs-8 col-xs-offset-2 col-sm-offset-0'>
                {!! Form::select('activity',
                ['lunch'=>'Repas','relax'=>'Détente','barbecue'=>'Barbecue','reception'=>'Réception','children'=>'Enfants','party'=>'Fête','nightEvent'=>'Soirée','pro'=>'Pro'],
                null,['placeholder'=>'Activité','class'=>'form-control','id'=>'activitySelect']) !!}
            </div>
            <div class='col-sm-2 col-xs-8 col-xs-offset-2 col-sm-offset-0'>
                {!! Form::number('nb_pers',null,['placeholder'=>'Nb d\'invités','class'=>'form-control','min'=>'0']) !!}
            </div>
            <div class='col-sm-2 col-xs-8 col-xs-offset-2 col-sm-offset-0'>
                {!! Form::text('place','Paris',['placeholder'=>'Paris','class'=>'form-control']) !!}
            </div>
        </div>

        <div class="row">
            <div class='col-sm-12 text-center col-sm-offset-0 col-xs-12'>
                {!! Form::submit('Rechercher un jardin',['class'=>'btn btn-warning btn-welcome-search']) !!}
            </div>
        </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

    <div class='row homePageRow' id="page2">
        <div class='down-arrow'>V</div>
        <div class="up-arrow" style='display:none'>^</div>
        <div class="row introRow">
            <div class="col-sm-4 page2Left"><img src="{{asset('images/kerden-logo-shadow.png')}}"></div>
            <div class="col-sm-8 page2Right">
                <video id="introVideo" width="100%" poster="{{asset('images/placeholder.png')}}" loop>
                    <source src="{{asset('kerden.mp4')}}" type="video/mp4"/>
                    -Video not supported-
                </video>
                <img class='playerPlay' src="{{asset('images/motif_play.png')}}">
                <span class="volume-icon glyphicon glyphicon-volume-off" style='display:none'></span>
                <span class="volume-icon glyphicon glyphicon-volume-up"></span>
            </div>
        </div>

        <div class="row selectedPartnairs">
            <div class="row">
                <div class="col-xs-12 partnairCaption">Séléctionnés par Kerden<hr></div>
            </div>
            <div class="row oscarPartnair">
                <div class="col-xs-12 col-sm-8 oscarDesc">
                    <h4>Organisation évènement</h4>
                    <p>Oscar, agence évènementielle jeune, dynamique et créative, peut décrocher la lune en s'occupant d'une partie ou de l'organisation complète de votre évènement.</p>
                </div>
            </div>
            <div class="row partnairSeparator"></div>
            <div class="row zoePartnair">
                <div class="col-xs-12 col-sm-8 zoeDesc">
                    <h4>Notre traiteur</h4>
                    <p>Le panier de Zoé vous propose de très jolis paniers Bio, plateaux repas ou restaurant nomade.<br/>
                        Leurs produits sont issus du terroir ou de l'agriculture Bio.</p>
                </div>
            </div>
        </div>
        <div class="row otherPartnairs">
            <div class="row">
                <div class="col-xs-12 partnairCaption otherPartnairs">Nos partenaires<hr></div>
            </div>
            <div class="row partnairsLogoLine">
                <a target="_blank" href="http://www.lepanierdezoe.com"><div class="logoLine col-xs-6 col-md-3" style='background-color:#2f1f29; text-align:center'>
                            <img src="http://www.lepanierdezoe.com/wp-content/themes/barletter/img/logo-header-1.png" class="img-responsive" alt="Logo le panier de Zoé, traiteur 9ème arrondissement" style="margin:auto">
                            <span style="font-family:'Dancing Script';color:white; font-size:2em">Le Panier de Zoé</span>
                    </div></a>
                <a target="_blank" href="http://www.oscar.fr"><div class="logoLine col-xs-6 col-md-2">
                        <img src="http://www.oscar.fr/wp-content/uploads/2015/10/logo_OSCAR_300.png" class="img-responsive" alt="Oscar" >
                    </div></a>
                <a href="http://www.enviedeconfort.com" target="_blank"><div class="logoLine col-xs-6 col-md-2">
                        <img class="img-responsive" src="http://www.enviedeconfort.com/skin/frontend/edc/default/images/logo.gif" alt="Bienvenue sur enviedeconfort.com">
                    </div></a>
                <a target="_blank" href="http://www.favex.fr"><div class="logoLine col-xs-6 col-md-2">
                        <img src="http://myfavex.fr/2016/wp-content/uploads/2016/08/logo_favex_1.png" alt="Favex" title="Favex" class="img-responsive">
                    </div></a>
                <!-- <a href="http://www.mangopay.com" target="_blank"><div class="logoLine col-xs-4 col-md-2">
                        <img src="https://www.mangopay.com/wp-content/themes/underscores/img/mangopay.png" alt="MANGOPAY" class="img-responsive">
                    </div></a> -->
                    <a href="http://www.laboutiquedebob.butagaz.fr" target="_blank"><div class="logoLine col-xs-6 col-md-3">
                        <img src="{{asset('images/bob.png')}}" alt="La boutique de Bob" class="img-responsive"> 
                    </div></a>
            </div>
        </div>
        @include('footer')
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
@if(App::getLocale() == 'fr')
<script src="{{ URL::asset('js/bootstrap-datepicker.fr.js') }}"></script>
@endif
<script type="text/javascript">
(function($){
    $('#datePicker').datepicker({
        language:'fr',
        format:'dd-mm-yyyy',
        startView:'month',
        autoclose:true,
        todayHighlight:true,
        startDate: new Date()
    });

    //MISE EN PAGE
    $('#page2').css('margin-top', $(window).height() );
    $('.page2Right').height($('#introVideo').height() );

    $(window).resize(function(e){
        $('#page2').css('margin-top', $(window).height() );
        $('.page2Right').height($('#introVideo').height() );
    });

    //animation
    
    setTimeout(function(){
        $('body,html').stop().animate({scrollTop:96},'slow');
        $('.page2Right').height($('#introVideo').height() );
    },1200);

    var lastScrollVal = 0;
    $(window).scroll(function(event){
        var goingUp = ($(this).scrollTop() > lastScrollVal);
        lastScrollVal = $(this).scrollTop();
        if($(window).scrollTop() > 150 && $(window).scrollTop() < 200 && goingUp){
            $('body,html').css('overflow','hidden');
            $('body,html').stop().animate({scrollTop: $(window).height()+56 },400);
            setTimeout(function(){$('body,html').css('overflow','auto');},1000)
        }

        if($(window).scrollTop() > $(window).height()/2 ){
            $('.down-arrow').fadeOut();
            $('.up-arrow').fadeIn();
        }else{
            $('.down-arrow').fadeIn();
            $('.up-arrow').fadeOut();
        }
    });

    $('.down-arrow').click(function(){
        $('body,html').stop().animate({scrollTop: $(window).height()+56 },400);
    });

    $('.up-arrow').click(function(){
        $('body,html').stop().animate({scrollTop: 96 },'slow');
    });

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

    setTimeout(function(){
        $('.down-arrow').addClass('animated-logo');
    },1700);

    $('[data-toggle="tooltip"]').tooltip({delay:300, container:'body'});



}) (jQuery);
</script>
@endsection