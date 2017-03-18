@extends('layouts.app')


@section('headers')
<link rel="stylesheet" type="text/css" href="{{asset('css/view.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/picto.css')}}">
<link rel="stylesheet" href="{{ URL::asset('css/datepicker3.css') }}">
@endsection


@section('content')

<div class="container-fluid">
	@if(!empty($message))
		<div class="alert alert-danger text-center" style="font-size:3em">{{$message}}</div>
	@endif
	<h1 class="jumbotron-heading text-center">{{$garden->title}}</h1>

	@if($garden->averageNote != -1)
		<div class="text-center" style='color:gold;font-size:1.3em'>{!! $garden->getAverageNoteAsFAStars() !!}</div>
	@endif
    <h5 class="text-center">{{$garden->fullBlurAddress}}</h5>
    	
    <div class="row img-contain">
    	@if(count($garden->getPhotosUrls())>1)
    		<!-- <div id="carousel-kerden-view" class="carousel slide" data-ride="carousel" data-interval="2700">  -->
    		<div id="myVisor" class="visor-carousel slide" data-ride="visor" data-interval="false">
    			<!-- Indicators -->
				<ol class="carousel-indicators">
					@foreach($garden->getPhotosUrls() as $i=>$url)
						<li data-target="#myVisor" data-slide-to="{{$i}}"
						@if($i==0)
							class='active'
						@endif
						></li>
					@endforeach
				</ol>
				<!-- Wrapper for slides -->
  				<div class="carousel-inner" role="listbox">
  					@foreach($garden->getPhotosUrls() as $i=>$url)
  					<div class='item col-xs-9 @if($i==0) active @endif'>
  						<img src="{{ asset('storage/'.$url) }}">
  						<div class="zoomIcon" data-zoomed-img="{{ asset('storage/'.$url) }}" onclick="zoomPreview(event);"><i class="fa fa-search-plus"></i></div>
  					</div>
  					@endforeach
  				</div>
  				<!-- Controls -->
				<a class="left carousel-control layout-landscape" href="#myVisor" role="button" data-slide="prev">
			        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			        <span class="sr-only">Previous</span>
			    </a>
			    <a class="right carousel-control layout-landscape" href="#myVisor" role="button" data-slide="next">
			        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			        <span class="sr-only">Next</span>
			    </a>
    		</div>
    	@else
   			<img src="{{ asset('storage/'.$garden->getFirstPhotoURL()) }}" data-zoomed-img="{{ asset('storage/'.$garden->getFirstPhotoURL()) }}" onclick="zoomPreview(event);">
   		@endif
   	</div>

   	<div class="row ligne2">
   		<div class="col-md-9 col-sm-12 col-gauche">
   			<div class="row description">
   				<div class="caption text-center">Description</div>
   				@if($garden->state != 'validated' && Auth::user()->role->role == 'admin')
   					<a href="{{url('/admin/modifyDesc/'.$garden->id)}}">
   						<div class="btn btn-danger text-center">Modifier</div>
   					</a>
   				@endif
   				<div class="descContent text-left">
   					{{$garden->description}}
   				</div>
   			</div>
   			
   			<div class="row details">
   				<div class="caption text-center">Détails</div>
   				<div class="col-xs-12 col-sm-5 col-sm-offset-1 col-md-offset-2">
	   				<ul>
	   					<li class='checkList'><i class="fa fa-check"></i> Surface : {{$garden->surface}} m&sup2; </li>
	   					<li class='checkList'><i class="fa fa-check"></i> Accueil : {{$garden->max_pers}} invités maximum</li>
		   				@if($garden->kitchen->indoor)
		   				<li class="checklist"><i class="fa fa-check"></i> Cuisine intérieure de {{$garden->kitchen->indoor_surface}} m&sup2;</li>
		   				@endif
		   				@if($garden->kitchen->outdoor)
		   				<li class="checklist"><i class="fa fa-check"></i> Cuisine extèrieure de {{$garden->kitchen->outdoor_surface}} m&sup2;</li>
		   				@endif

		   				@if( ! ($garden->kitchen->indoor||$garden->kitchen->outdoor) )
		   				<li class="nonCheckList"><i class="fa fa-times"></i> Pas de cuisine à disposition</li>
		   				@endif

		   			</ul>
	   			</div>
	   			<div class="col-xs-12 col-sm-5">
	   				<ul>
	   				@if($garden->toilets->wc_in > 0)
	   					<li class='checkList'><i class="fa fa-check"></i> {{$garden->toilets->wc_in}} cabinet WC en intérieur</li>
	   				@endif
	   				@if($garden->toilets->wc_out > 0)
	   					<li class='checkList'><i class="fa fa-check"></i> {{$garden->toilets->wc_out}} cabinet WC en extérieur</li>
	   				@endif

	   				@if($garden->musicLevel->level == 'none')
	   					<li class="nonCheckList"><i class="fa fa-times"></i>
	   				@else
	   					<li class="checkList"><i class="fa fa-check"></i>
	   				@endif
	   				Volume sonore accepté : {{trans('base.'.$garden->musicLevel->level)}}</li>

	   				
   					@if($garden->musicLevel->orchestar)
   						<li class="checkList"><i class="fa fa-check"></i> Présence de musiciens ou orchestre acceptée</li>
   					@else
   						<li class="nonCheckList"><i class="fa fa-times"></i> Présence de musiciens ou orchestre : non</li>
   					@endif
	   				</ul>
	   			</div>
   			</div>
   			<div class="row">
	   			<div class="col-xs-12">
	   				<div class="caption text-center">
	   					Disponibilité 
	   				</div>
	   				<div class="col-xs-12">
		   				<table class="table dispoTable">
		   					<thead>
		   						@foreach(trans('base.weekDays') as $day)
		   							<th>{{$day}}</th>
		   						@endforeach
		   					</thead>
		   					<tbody>
		   						<tr>
		   							@foreach(trans('base.weekDays') as $k=>$day)
		   								<td>
		   									@if($garden->getSlotsByDay($k) == null)
		   										<div class="noDispo">non disponible</div>
		   									@else
			   									@foreach($garden->getSlotsByDay($k) as $slot)
			   										<div class="blockPicto picto-{{$slot}}"  data-toggle='tooltip' title="{{trans('base.'.$slot,['min_hour'=>$garden->getHours($k)->begin_slot,'max_hour'=>$garden->getHours($k)->end_slot%24]) }}"></div>
			   									@endforeach
			   								@endif
		   								</td>
		   							@endforeach
		   						</tr>
		   					</tbody>
		   				</table>
		   			</div>
	   			</div>
	   		</div>
	   		<div class="row">
	   			<div class="col-xs-12 text-center caption">
	   				Activités & Équipement 
	   			</div>
	   			<div class="activities col-xs-12 col-sm-6">
	   				
	   				<div class="pictoLine">
	   					@foreach($garden->activities->getAttributes() as $k=>$v)
	   						@if($k != 'id' && $v==1)
	   							<div class="picto picto-{{$k}}" data-toggle='tooltip' title="{{trans('garden.activities_.'.$k.'.title')}}"></div>
	   						@endif
	   					@endforeach
	   				</div>
	   			</div>
	   			<div class="col-xs-12 col-sm-6 gardenware">
	   				<ul>
		   				@forelse($garden->gardenWare as $ware)
		   					<li>{{ str_replace('_'," ",$ware->type) }} : {{$ware->nb}}</li>
		   				@empty
		   					<li><i class="fa fa-times"></i> Pas d'équipement</li>
		   				@endforelse
	   				</ul>
	   			</div>
	   		</div>
	   		@if($garden->staff->requiredStaff || $garden->staff->requiredStaffNight)
   				<div class="row staff">
   					<div class="caption text-center">Oscardiens <span class="oscarHelp" data-toggle="modal" data-target="#OscarModal">?</span></div>
   					<div class='staffContent text-center'>
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

   			@if($garden->commentaires->count() > 0 && $garden->bestCommentaire!=null)
   			<div class="row comments">
   				<div class="caption text-center">Commentaires</div>
   				<div class="commentairesContent col-xs-12">
   					<caption>Le meilleur commentaire:</caption>
   					<blockquote>
   						<p style='color:gold'>{!! $garden->bestCommentaire->getNoteAsFAStars() !!}</p>
   						{{$garden->bestCommentaire->content}}
   						<footer>{{ $garden->bestCommentaire->author->fullName }}</footer>
   					</blockquote>
   					<a href="#" data-toggle="modal" data-target="#CommentsModal">Voir tous les commentaires</a>
   				</div>
   			</div>
   			@endif
   		</div>
   		<div class="col-md-3 col-sm-12 col-droite">
   			@if( !empty($preview) )
   				<div class="resaBloc">
   					<div class="text-center">
   						<h4>Prévisualisation de l'annonce</h4>
   						Impossible de générer des réservations.
   					</div>
   				</div>
   			@else
   			<div class="resaBloc" data-spy="affix" data-offset-top="580">
   				<div class="loadingAjax" style='display:none'><img src=" {{ asset('/images/loading.gif') }} "></div>
   				<div class="resContent">
   					{!! Form::open(['url'=>'/reservation/create','class'=>'form-horizontal']) !!}
   					{!! Form::hidden('garden_id',$garden->id) !!}

                    <div class='row'>
                    	<div class="col-xs-12 text-center">
                    		{!! Form::label('date','Date',['class'=>'control-label']) !!}
                		</div>
                		<div class="col-xs-8 col-xs-offset-2">
                			<div class="input-group">
                				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								{!! Form::text('date',session()->has('date')?session()->get('date'):null,['class'=>'form-control','id'=>'datePicker','placeholder'=>'Choisir une date']) !!}
							</div>
						</div>
					</div>

					
					<div class="row text-center" id='dateError' style='display:none'></div>
					<div class="row" id="hoursRow" style='display:none'>
						<hr/>
						<div class="col-xs-12 text-center">Tranche horaire</div>
						<div class="col-xs-10 col-xs-offset-1 slider">
							<div id='sliderHours'></div>
							{!! Form::hidden('begin_slot',null,['id'=>'begin_slot'])  !!}
							{!! Form::hidden('end_slot',null,['id'=>'end_slot']) !!}
						</div>
					</div>

					<hr/>

					<div class="row"
					@if($errors->has('nb_pers'))
							style='color:red'
						@endif
						>
						<div class="col-xs-12 text-center">
							{!!Form::label('nb_pers','Nombre d\'invités',['class'=>'control-label text-right']) !!}
						</div>
						<div class="col-xs-8 col-xs-offset-2">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-users"
									@if($errors->has('nb_pers'))
										style='color:red'
									@endif
									></i></span>
								{!! Form::number('nb_pers', !empty(session()->get('nb_pers'))?session()->get('nb_pers'):$garden->max_pers ,['id'=>'nb_pers','class'=>'form-control','min'=>0,'max'=>$garden->max_pers]) !!}
							</div>
						</div>
					</div>

						<hr/>
						<div class="row" id="oscarRow">
							<div class="col-xs-12 text-center">
							{!! Form::label('staff','Oscardiens',['class'=>'control-label']) !!}
							<i class="fa fa-question-circle" data-toggle="modal" data-target="#OscarModal" style="cursor:pointer" ></i>
						</div>
							<div class="col-xs-11 col-xs-offset-1">
								<label		                
				                @if($garden->staff->requiredStaff)
				                	>
				                	{!! Form::hidden('dayStaff',1,['id'=>'dayStaff']) !!}
				                	<i class="fa fa-check"></i>
				                @else
				                	style="color:grey">
				                	{!! Form::hidden('dayStaff',0,['id'=>'dayStaff']) !!}
				                	<i class="fa fa-times"></i>
				                @endif
				                Présence d'Oscardiens dans la journée
				                </label>
				            </div>
				            <div class="col-xs-11 col-xs-offset-1">
				                <label
		                		@if($garden->staff->requiredStaffNight)
		                			>
				                	{!! Form::hidden('nightStaff',1,['id'=>'nightStaff']) !!}
				                	<i class="fa fa-check"></i>
			                	@else
			                		style="color:grey">
			                		{!! Form::hidden('nightStaff',0,['id'=>'nightStaff']) !!}
				                	<i class="fa fa-times"></i>
				                @endif
				                    Présence  d'Oscardiens après 18h
				                </label>
				            </div>
			            </div>

						<hr/>
					<div class="row priceRow">
						<div class="col-xs-6 col-xs-offset-1">Location jardin : </div><div class="col-xs-5 text-right" id='gardenPrice'></div>
						<div class="col-xs-6 col-xs-offset-1">Oscardiens : </div><div class="col-xs-5 text-right" id='staffPrice'></div>
						<div class="col-xs-12 price text-right">Prix Total: <span id='totalPrice'></span> € T.T.C</div>
					</div>
					<div class="row">
						<div class="col-xs-12 text-center resaSubmit" style='display:none'>
							{!! Form::submit('Réserver maintenant',['class'=>'btn btn-primary']) !!}
						</div>
					</div>

   					{!! Form::close() !!}
   				</div>
   			</div>
   			@endif
   		</div>
   	</div>

   	<div class="row">
		@include('footer')
	</div>
   
</div>
@if(Auth::user() && Auth::user()->role->role == 'admin' && $garden->state != 'validated')
<a href="{{url('/admin/gardens')}}"><div class="backButton btn btn-warning" id="backButton" data-spy="affix" data-offset-top="30">&laquo; Retour à la liste</div></a>
@elseif(Auth::user() && $garden->owner->id == Auth::user()->id )
<a href="{{url('/home')}}"><div class="backButton btn btn-warning" id="backButton" data-spy="affix" data-offset-top="30">&laquo; Retour à l'espace membre</div></a>
@else
<div onclick='history.back()' class="backButton btn btn-warning" id="backButton" data-spy="affix" data-offset-top="30">&laquo; Retour aux résultats</div>
@endif
<div class="modal fade" id="OscarModal" tabindex="-1" role="helper" aria-labelledby="OscarlModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="OscarModal">Oscar.fr </h4>
      </div>
      <div class="modal-body kerdenModal">
        Notre agence partenaire <a target="_blank" href="http://www.oscar.fr">Oscar.fr</a> propose des hôtes et Hôtesses de sécurité : Les Oscardiens. <br>
Le Propriétaire souhaite sécuriser son environnement lors de la location : Entrée, maison, Jardin, Terrasse et exige de louer son Jardin ou Terrasse uniquement avec la présence d’Oscardiens.<br/>
Il est prévu la présence d’1 Oscardien par tranche de 30 invités.<br/>
Chaque Oscardien sera facturé 34€ TTC par heure.<br/>
Ce Personnel est là en priorité pour assurer la sécurité, il pourra fournir si les conditions le permettent une petite aide pour le service<br/>
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
  <div class="modal-dialog" role="document">
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
	  						<img src="{{ asset('storage/'.$url) }}" alt="" class="img-responsive PreviewImageOutput" data-dismiss="modal" style="left:0;right:0;margin:auto;width:100%">
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

<script src="{{asset('js/jquery.visor-carousel.min.js')}}"></script>

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
		},
		error:function(result,statut,error){
			$('#gardenPrice').html( '- €' );
			$('#staffPrice').html( '- €');
			$('#totalPrice').html( '-' );
			$('.resaSubmit').slideUp();
		}
	});
}

function unsetPrice(){
	$('#gardenPrice').html( '- €' );
	$('#staffPrice').html( '- €');
	$('#totalPrice').html( '-' );
	$('.resaSubmit').slideUp();
}

function zoomPreview(event){
	var urlSet = event.target.dataset.zoomedImg || event.target.parentElement.dataset.zoomedImg;
	console.log(urlSet);
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

}) (jQuery);
</script>

@endsection
