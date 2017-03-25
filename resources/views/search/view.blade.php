@extends('layouts.app')


@section('headers')
  <link href="{{ asset('slick/slick.css') }}" rel="stylesheet">
  <link href="{{ asset('slick/slick-theme.css') }}" rel="stylesheet">
@endsection


@section('content')


<div class="garden-header">
  <!-- Slideshow -->
  <div class="img-contain">
    @if(count($garden->getPhotosUrls())>1)
      @foreach($garden->getPhotosUrls() as $i=>$url)
        <div class="garden-slide">
          <img src="{{ $url }}">
          <!-- <img src="/images/bg1.jpg"> -->
          <div class="zoomIcon" data-zoomed-img="{{ $url }}" onclick="zoomPreview(event);"><i class="fa fa-search-plus"></i></div>
        </div>
     @endforeach
    

    @else
      <img src="{{ $garden->getFirstPhotoURL() }}" data-zoomed-img="{{ $garden->getFirstPhotoURL() }}" onclick="zoomPreview(event);">
    @endif
  </div>
  <!-- back button -->
  <div class="backbutton-container">
    <div class="container">
      @if(Auth::user() && Auth::user()->role->role == 'admin' && $garden->state != 'validated')
      <a href="{{url('/admin/gardens')}}"><div class="backButton btn " id="backButton"><i class='fa fa-angle-left'></i> Retour à la liste</div></a>
      @elseif(Auth::user() && $garden->owner->id == Auth::user()->id )
      <a href="{{url('/home')}}"><div class="backButton btn " id="backButton"><i class='fa fa-angle-left'></i> Retour à l'espace membre</div></a>
      @else
      <div onclick='history.back()' class="backButton btn " id="backButton"><i class='fa fa-angle-left'></i> Retour aux résultats</div>
    @endif  
    </div>
  </div>
</div>
<div class="garden-title-container">
  <div class="container">
    <div class="row">
      <div class="col-md-3 text-center hidden-xs hidden-sm">
        <div class="icon icon-lieu"></div>
        <h2>{{$garden->fullBlurAddress}}</h2>      
      </div>
      <div class="col-md-6 text-center">
        <h1 class="jumbotron-heading">{{$garden->title}}</h1>
        <div class="garden-note hidden-xs hidden-sm">
          @if($garden->averageNote != -1)
            {!! $garden->getAverageNoteAsFAStars() !!}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-4 text-center visible-xs visible-sm">
        <div class="icon icon-lieu"></div>
        <h2>{{$garden->fullBlurAddress}}</h2>      
      </div>      
      <div class="col-sm-4 visible-xs visible-sm text-center">
        <div class="garden-note">
          @if($garden->averageNote != -1)
            {!! $garden->getAverageNoteAsFAStars() !!}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-4 text-center">
        <div class="icon icon-participants"></div>
        <div class="participants-text">Jusqu'à {{$garden->max_pers}} personnes</div>
      </div>
    </div>
  </div>
</div>



<div class="wood-bg">
  <div class="container">


  	@if(!empty($message))
  		<div class="alert alert-danger text-center" style="font-size:3em">{{$message}}</div>
  	@endif

    <div class="row" >
      <div class="col-sm-8">
        <ul class="garden-activities">          
          @foreach($garden->activities->getAttributes() as $k=>$v)
            @if($k!='id' && $v == 1)
              <li>
                <div class='picto picto-{{$k}}' data-toggle='tooltip' title="{{trans('garden.activities_.'.$k.'.title')}}"></div>
                <div class="activity-title">{{trans('garden.activities_.'.$k.'.title')}}</div>
              </li>
            @endif
          @endforeach
        </ul>
        <div class="clearfix"></div>
        <div class="row garden-details">
          <div class="col-md-4">
            <h3>Description</h3>
          </div>
          <div class="col-md-8">
            <div>{{$garden->description}}</div>
          </div>
        </div>
        <div class="row garden-details">
          <div class="col-md-4">
            <h3>Détails</h3>
          </div>
          <div class="col-md-8">
            <ul>
              <li>Superficie: {{$garden->surface}} m&sup2;</li>
              <li>Accueil maximum: {{$garden->max_pers}} personnes</li>
              <li>Volume sonore accepté: {{ trans('garden.'.$garden->musicLevel->level )}}</li>
              @if($garden->musicLevel->orchestar)
              <li>Présence de musiciens ou orchestre acceptée</li>
              @else
              <li>Pas de présence de musiciens ou orchestre</li>
              @endif
              @if($garden->toilets->wc_in > 0)
              <li>{{$garden->toilets->wc_in}} cabinet WC en intérieur</li>
              @endif
              @if($garden->toilets->wc_out > 0)
              <li>{{$garden->toilets->wc_out}} cabinet WC en extérieur</li>
              @endif
              @if($garden->toilets->wc_in <= 0 && $garden->toilets->wc_out <= 0)
              <li>Pas de cabinet WC à disposition.</li>
              @endif
              @if($garden->kitchen->indoor)
              <li >Cuisine intérieure de {{$garden->kitchen->indoor_surface}} m&sup2;</li>
              @endif
              @if($garden->kitchen->outdoor)
              <li >Cuisine extèrieure de {{$garden->kitchen->outdoor_surface}} m&sup2;</li>
              @endif
              @if( ! ($garden->kitchen->indoor||$garden->kitchen->outdoor) )
              <li style="color:#888"> Pas de cuisine à disposition</li>
              @endif              
            </ul>          
          </div>
        </div>
        <div class="row garden-details">
          <div class="col-md-4">
            <h3>Équipement de jardin</h3>
          </div>
          <div class="col-md-8">
            <ul>
              @forelse($garden->gardenWare as $ware)
              @if( explode('_',$ware->type)[0] == 'Piscine')
              <li>{{$ware->nb}} Piscine </li>
              @else
              @if($ware->nb > 1 &&  $ware->type[strlen(explode('_',$ware->type)[0])-1]!='s' )
              <li>{{$ware->nb}} {{  explode('_',$ware->type)[0] }}s {{  str_replace('_',' ', substr($ware->type,strlen(explode('_',$ware->type)[0]))) }}</li>
              @else
              <li>{{$ware->nb}} {{ str_replace('_'," ",$ware->type) }} </li>
              @endif
              @endif
              @empty
              <li><i class="fa fa-times"></i> Pas d'équipement</li>
              @endforelse   
            </ul>
          </div>
        </div>          
        <div class="row garden-details">
          <div class="col-md-4">
            <h3>Disponibilités</h3>
          </div>
          <div class="col-md-8">
            <ul>
              @foreach( [1,2,3,4,5,6,7] as $k)
                  @if($garden->getSlotsByDay($k) == null)
                    <li style="color:#888"><span class="daySpan">{{ trans( 'base.weekDays' )[$k] }}:</span> Indisponible</li>
                  @else
                    <li><span class="daySpan">{{ trans( 'base.weekDays' )[$k] }}:</span> {{ sprintf('%02d', $garden->getHours($k)->begin_slot%24) }}h00 - {{ sprintf('%02d',$garden->getHours($k)->end_slot%24) }}h00 </li>
                  @endif
                </td>
              @endforeach
            </ul>            
          </div>
        </div>    


        <div class="row garden-details">
          <div class="col-md-4">
            <h3>Règlement intérieur</h3>
          </div>
          <div class="col-md-8">
            <ul class="guidelinesList">
              @if($garden->animal && $garden->animal->animals)
                <li>La présence d'animaux de compagnie est autorisée.</li>
              @else
                <li>La présence d'animaux de compagnie n'est pas autorisée.</li>
              @endif

              @if($garden->getPool())
                @if($garden->getPool()->type == 'Piscine_normes_ok')
                  <li>La Piscine possède au moins un dispositif de sécurité aux normes et peut être uilisée.</li>
                @else
                  <li ><i class="fa fa-exclamation-triangle" style="color:rgba(255, 0, 0, 0.47)"></i> La Piscine n'est pas aux normes de sécurité. Elle ne pourra pas être utilisée.</li>
                @endif
              @endif

              @forelse($garden->guidelines as $k=>$line)
                <li>{{$line->message}}</li>
              @empty
              @endforelse
            </ul>            
          </div>
        </div>    

        @if($garden->staff && ($garden->staff->requiredStaff || $garden->staff->requiredStaffNight))

          <div class="row garden-details">
            <div class="col-md-4">
              <h3>Oscardiens</h3>
              <a style="font-weight:normal;color:black;margin-top: 35px;"href="#" data-toggle="modal" data-target="#OscarModal">Qu'est-ce qu'un Oscardien?</a>
            </div>
            <div class="col-md-8">
              {{trans('search.requiredStaff')}}
                @if($garden->staff->requiredStaffNight && !$garden->staff->requiredStaff)
                  {{trans('search.staffNight')}}
                @else
                  {{trans('search.staffDay')}}
                @endif
              @if($garden->staff->restrictedKitchenAccess)
              <br/>
              {{trans('search.kitchenStaff')}}
              @endif
            </div>
          </div>
        @endif

        @if($garden->notReportedCommentaires->count() > 0)
          <div class="row garden-details">
            <div class="col-md-4">        
              <h3>Livre d'or</h3>
            </div>
            <div class="col-md-8">
              <blockquote>
                <p>{!! $garden->bestCommentaire->getNoteAsFAStars() !!} </p>
                {{$garden->bestCommentaire->content}}
                <footer>{{$garden->bestCommentaire->author->fullName}}</footer>
              </blockquote>
              <a href="#" data-toggle="modal" data-target="#CommentsModal">-voir plus de commentaires-</a>
            </div>
        @endif



        <div class="garden-details">
          <img src="{{$staticImgUrl}}" alt="" class='img-responsive gMapPreview'>
        </div>
      </div>


      <div class="col-sm-4">
        @if( !empty($preview) )
          <div class="resaBloc">
            <div class="text-center">
              <h4>Prévisualisation de l'annonce</h4>
              Impossible de générer des réservations.
            </div>
          </div>
        @else
          <div class="resaBloc">
            <div class="loadingAjax" style='display:none'><img src=" {{ asset('/images/loading.gif') }} "></div>
          <div class="resContent">
            <h2 class="resaTitle">
              Réservation du jardin
            </h2>
            {!! Form::open(['url'=>'/reservation/create','class'=>'form-horizontal']) !!}
            {!! Form::hidden('garden_id',$garden->id) !!}

                    <div class='row'>
                      <div class="col-xs-12 @if($errors->has('date')) has-error @endif">
                        {!! Form::label('date','Date',['class'=>'control-label']) !!}
                    </div>
                    <div class="col-xs-12 icon-label calendrier">
                      <div class="@if($errors->has('date')) has-error @endif">
                {!! Form::text('date',session()->has('date')?session()->get('date'):null,['class'=>'form-control','id'=>'datePicker','placeholder'=>'Choisir une date']) !!}
              </div>
            </div>
          </div>

          
          <div class="row text-center" id='dateError' style='display:none'></div>
          <div class="row" id="hoursRow" style='display:none'>
            <div class="col-xs-12">{!! Form::label('hours','Tranche Horaire',['class'=>'control-label']) !!}</div>
            <div class="col-xs-10 col-xs-offset-1 slider">
              <div id='sliderHours'></div>
              {!! Form::hidden('begin_slot',null,['id'=>'begin_slot'])  !!}
              {!! Form::hidden('end_slot',null,['id'=>'end_slot']) !!}
            </div>
          </div>


          <div class="row"
            @if($errors->has('nb_pers'))
              style='color:red'
            @endif
            >
            <div class="col-xs-12">
              {!!Form::label('nb_pers','Nombre d\'invités',['class'=>'control-label text-right']) !!}
            </div>
            <div class="col-xs-12 icon-label participants">
                {!! Form::number('nb_pers', !empty(session()->get('nb_pers'))?session()->get('nb_pers'):$garden->max_pers ,['id'=>'nb_pers','class'=>'form-control ','min'=>0,'max'=>$garden->max_pers]) !!}
            </div>
          </div>

            <div class="row" id="oscarRow">
              @if($garden->staff->requiredStaff)
                {!! Form::hidden('dayStaff',1,['id'=>'dayStaff']) !!}
              @else
                {!! Form::hidden('dayStaff',0,['id'=>'dayStaff']) !!}
              @endif

              @if($garden->staff->requiredStaffNight)
                {!! Form::hidden('nightStaff',1,['id'=>'nightStaff']) !!}
              @else
                {!! Form::hidden('nightStaff',0,['id'=>'nightStaff']) !!}
              @endif
            </div>
          <div class="priceRow">
            <div class="price-lines">
              <div class="line">Jardin : <span id='gardenPrice'></span></div>
              @if($garden->staff->requiredStaff || $garden->staff->requiredStaffNight)
              <div class="line">  Oscardiens : <span id='staffPrice'></span></div>
              @endif
              </div>
            <div class="price text-right">
              <span id='totalPrice' style="float:none"> </span>€
            </div>
          </div>
          <div class="row">          
            <div class="col-xs-12 text-center resaSubmit">
              @if(Auth::guest())
                <input type="button" class="btn btn-kerden-confirm" value="Demande de réservation" data-toggle="modal" data-target="#connexionModal"/>
              @else
              {!! Form::submit('Réserver',['class'=>' btn btn-kerden-confirm']) !!}
              @endif
            </div>
            <div class="col-xs-12">
              @if(Auth::guest())
                <div class="btn messageButton" data-toggle="modal" data-target="#connexionModal">Envoyer un Message</div>
              @else
              <a href="{{url('/messages/'.$garden->id)}}"><div class="btn btn-kerden-cancel messageButton">Envoyer un Message</div></a>
              @endif
            </div>             
          </div>

          {!! Form::close() !!}
          </div>
        </div>
        @endif
      </div>
    </div>   
  </div>
</div>

@include('footer')



<div class="modal fade" id="OscarModal" tabindex="-1" role="helper" aria-labelledby="OscarlModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="OscarModal">Oscar.fr </h4>
      </div>
      <div class="modal-body kerdenModal">
        Notre agence partenaire <a target="_blank" href="http://www.oscar.fr">Oscar.fr</a> propose des hôtes et Hôtesses de sécurité : Les Oscardiens. <br>Le Propriétaire souhaite sécuriser son environnement lors de la location : Entrée, maison, Jardin, Terrasse et exige de louer son Jardin ou Terrasse uniquement avec la présence d’Oscardiens.<br/>Il est prévu la présence d’1 Oscardien par tranche de 30 invités.<br/>Chaque Oscardien sera facturé 34€ TTC par heure.<br/>Ce Personnel est là en priorité pour assurer la sécurité, il pourra fournir si les conditions le permettent une petite aide pour le service<br/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

@if($garden->notReportedCommentaires->count() > 0)
<div class="modal fade" id="CommentsModal" tabindex="-1" role="helper" aria-labelledby="CommentsModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="CommentsModal">Commentaires </h4>
      </div>
      <div class="modal-body kerdenModal">
      	@foreach($garden->notReportedCommentaires->sortByDesc('note') as $comment)
      		<blockquote>
      			<p style="color:gold">{!! $comment->getNoteAsFAStars() !!} </p>
      			{{$comment->content}}
      			<footer>{{$comment->author->fullName}}</footer>
      			@if(! $comment->ignore_report)
      				<p><i class="fa fa-exclamation-triangle reportBtn" data-reporttype='comment' data-reportid="{{$comment->id}}">Signaler ce message</i></p>
      			@endif
      		</blockquote>
      		@if($comment->answer != null && ( $comment->answer->reported==0 || $comment->answer->ignore_report==1) )
      			<blockquote class="blockquote-reverse">
      				{{$comment->answer->content}}
      				<footer>Réponse du propriétaire</footer>
      				@if(! $comment->answer->ignore_report)
      					<p><i class="fa fa-exclamation-triangle reportBtn" data-reporttype="answer" data-reportid="{{$comment->answer->id}}">Signaler ce message</i></p>
      				@endif
      			</blockquote>
      		@endif
      	@endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ReportModal" tabindex="-1" role="helper" aria-labelledby="ReportModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="ReportModal">Signaler un message </h4>
      </div>
      <div class="modal-body kerdenModal">
      	{!! Form::open(['url'=>'/report']) !!}
      	{!! Form::hidden('reporttype',null) !!}
      	{!! Form::hidden('reportid',null) !!}
      	<h2>Attention</h2>
      	<h4>Ne signalez pas un message uniquement parceque son contenu vous déplait!</h4>
      	La fonction "signaler un message" est là pour empêcher les discours haineux, discriminants, ou insultants. Elle n'est pas un moyen de "trier sur le volet" les commentaires négatifs.<br/>
      	Si votre jardin reçoit des mauvaises critiques, améliorez-le! 
      </div>
      <div class="modal-footer">
      	{!! Form::submit('Signaler le message',['class'=>'btn btn-danger']) !!}
      	{!! Form::button('Fermer',['class'=>'btn btn-default', 'data-dismiss'=>'modal']) !!}
      	{!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endif



<div class="modal fade" id="ZoomModal" tabindex="-1" role="helper" aria-labelledby="ZoomImageLabel">
  <div class="modal-dialog modal-full-screen" role="document">
    <div class="modal-content">
  		<div class="modal-body kerdenModal">
  			<div id="carousel-kerden-view" class="carousel slide" data-ride="carousel" data-interval="false"> 
  				<a class="left carousel-control layout-landscape" href="#carousel-kerden-view" role="button" data-slide="prev" style="z-index:2">
			        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			        <span class="sr-only">Previous</span>
			    </a>
			    <a class="right carousel-control layout-landscape" href="#carousel-kerden-view" role="button" data-slide="next" style="z-index:2">
			        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			        <span class="sr-only">Next</span>
			    </a>
  				<div class="carousel-inner" role="listbox">
	  				@foreach($garden->getPhotosUrls() as $i=>$url)
	  					<div class="item @if($i==0) active @endif">
	  						<img src="{{ $url }}" alt="" class="img-responsive PreviewImageOutput" data-dismiss="modal" style="left:0;right:0;margin:auto;width:100%">
	  					</div>
					@endforeach
				</div>
  			</div>
  		</div>
	  </div>
  </div>
</div>

@endsection

@section('scripts')
  <script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
  @if(App::getLocale() == 'fr')
  <script src="{{ URL::asset('js/bootstrap-datepicker.fr.js') }}"></script>
  @endif

  <script src="{{ URL::asset('slick/slick.min.js') }}"></script>

  <script type="text/javascript">
    function calcPrice(){
    	$.get({
    		url: "{{ url('/jsonAPI/calcPrice') }}",
    		dataType: 'json',
    		data:{
    			gardenId:{{$garden->id}},
    			date:$('#datePicker').val(),
    			begin_slot:$('#begin_slot').val(),
    			end_slot:$('#end_slot').val(),
    			staffDay:$('#dayStaff').val(),
    			staffNight:$('#nightStaff').val(),
    			nb_guests:$('#nb_pers').val()},
    		success:function(xhr,statut){
    			$('#gardenPrice').html( xhr.totalHoursPrice+' €' );
    			$('#staffPrice').html( xhr.totalStaffPrice+' €');
    			$('#totalPrice').html( xhr.totalPrice );
    			$('.resaSubmit').slideDown();
          $('.has-error').removeClass('has-error');
    		},
    		error:function(result,statut,error){
    			$('#gardenPrice').html( '- €' );
    			$('#staffPrice').html( '- €');
    			$('#totalPrice').html( '- ' );
    		}
    	});
    }

    function unsetPrice(){
    	$('#gardenPrice').html( '- €' );
    	$('#staffPrice').html( '- €');
    	$('#totalPrice').html( '- ' );
    }

    function zoomPreview(event){
    	var urlSet = event.target.dataset.zoomedImg || event.target.parentElement.dataset.zoomedImg;
    	$('.PreviewImageOutput').each(function(){
    		$(this).parent().removeClass('active');
    	});
    	$('.PreviewImageOutput[src="'+urlSet+'"]').parent().addClass('active');
    	$('#ZoomModal').modal('show');


    }

    (function($){
    	var nb = {{ !empty(session()->get('nb_pers'))?session()->get('nb_pers'):$garden->max_pers }},
    		wantedBegin_slot = {{ !empty(session()->get('slot_begin'))?session()->get('slot_begin'):0 }},
    		wantedEnd_slot = {{ !empty(session()->get('slot_end'))?session()->get('slot_end'):0 }};

    	$('#begin_slot').val(wantedBegin_slot);
        $('#end_slot').val(wantedEnd_slot);	
    	$('[data-toggle="tooltip"]').tooltip({delay:200, container:'body'});

    	$('#sliderHours').slider({
    		range:true,
    		slide: function( event, ui ) {
    			if(ui.values[1] - ui.values[0] <3) return false;
    	        $('.ui-slider-handle').first().attr('data-hour',(ui.values[0])%24+' h');
    	        $('.ui-slider-handle').last().attr('data-hour',(ui.values[1])%24+' h');
    	        $('#begin_slot').val((ui.values[0]));
    	        $('#end_slot').val((ui.values[1]));
    	        wantedBegin_slot = ui.values[0];
    	        wantedEnd_slot = ui.values[1];
    	      },
    	    stop: function(event, ui){
    	    	calcPrice();
    	    }
    	});


    	$('#datePicker').datepicker({
            language:'fr',
            format:'dd-mm-yyyy',
            startView:'month',
            autoclose:true,
            todayHighlight:true,
            startDate: new Date()
        });

    	//**************************//
        //AJAX CALLS

        //1-date
        $('#datePicker').change( function(event){
        	$('#hoursRow').slideUp();
        	$('#dateError').slideUp();
        	if(event.target.value != ''){
        		$('.loadingAjax').fadeIn();
        		$.get({
        			url: "{{ url('/jsonAPI/gardenHours') }}",
        			type: 'GET',
        			dataType:'json',
        			data:{ gardenId: {{$garden->id}},
        					date: event.target.value },

        			error: function(result,statut,error){
        				$('#dateError').html('Unknown error : '+error);
        				$('#dateError').slideDown();
        			},
        			success:function(xhr, statut){
        				if(xhr.state=='no'){
        					$('#dateError').html(xhr.message);
        					$('#dateError').slideDown();
        					unsetPrice();
        				}else{
        					var setValues;
        					if(wantedBegin_slot >= xhr.begin_slot && wantedEnd_slot<=xhr.end_slot){
        						setValues = [wantedBegin_slot,wantedEnd_slot];
        					}else{
        						setValues = [xhr.begin_slot,xhr.end_slot];
        					}
        					$('#sliderHours').slider({
        						min:xhr.begin_slot,
        						max:xhr.end_slot,
        						values: setValues
        					});
        					$('.ui-slider-handle').first().attr('data-hour',(setValues[0])%24+' h');
        					$('.ui-slider-handle').last().attr('data-hour',(setValues[1])%24+' h');
        					$('#begin_slot').val(setValues[0]);
    	        			$('#end_slot').val(setValues[1]);

        					$('#hoursRow').slideDown();
        					calcPrice();
        					
        				}
        			},
        			complete:function(){
        				$('.loadingAjax').fadeOut();
        			}

        		});
        	}else{
        		unsetPrice();
        	}
        });
    	$('#nb_pers').change(function(){calcPrice()});
    	$('#dayStaff').change(function(){calcPrice()});
    	$('#nightStaff').change(function(){calcPrice()});

    	$('#datePicker').change();
    	calcPrice();

    	$('.reportBtn').click(function(event){
    		$('input[name=reporttype]').val(this.dataset.reporttype);
    		$('input[name=reportid]').val(this.dataset.reportid);
    		$('#CommentsModal').modal('hide');
    		$('#ReportModal').modal('show');
    	});


      $('.messageButton').click(function(event){
        $('#connexionModal form').append('<input type="hidden" value="{{ url('/messages/'.$garden->id) }}" name="redirectTo" />');
        $('.providerLink').each(function(){
          var val = $(this).attr('href');
          $(this).attr('href',val+'?redirectTo=/messages/{{$garden->id}}');
        });
      });

      $('#connexionModal').on('hide.bs.modal',function(){
        $('#connexionModal form input[name="redirectTo"]').remove();
        $('.providerLink').each(function(){
          var val = $(this).attr('href').substr(0, $(this).attr('href').indexOf('?') );
          $(this).attr('href',val);
        });
      });


      $(window).load(function(){
        var newVal = $('.resaBloc').offset().top - 80;
        $('.resaBloc').affix({offset: {top:newVal}});
      });

    }) (jQuery);

    $('.img-contain').slick({
      slidesToShow: 1,
      infinite: true,
      arrows: true,
      centerMode: true,
      variableWidth: true,
      prevArrow: "<a class='slick-nav angle-left'><i class='fa fa-angle-left'></i></a>",
      nextArrow: "<a class='slick-nav angle-right'><i class='fa fa-angle-right'></i></a>",  
      responsive: [
          {
            breakpoint: 991,
            settings: {
              slidesToShow: 1,
              variableWidth: false,
              centerMode: false,
            }
          }
        ]      
    });
  </script>
@endsection
