@extends('layouts.backend')

@section('content')

<div class="container" id="mainContainer">

	<h3 class="text-center" style="margin-bottom:30px">{{$garden->title}}</h3>

	<div class="col-xs-12 col-sm-8 messColLeft">
		@foreach($events as $m)
		@if($m instanceof \App\Message)
			@if($m->author_id == $m->asker_id)
			<div class="KerdenMessage gauche">
				<div style="font-size:1.2em" class="col-xs-6 text-left">Moi</div><div class="col-xs-4 text-right date">{{ $m->created_at->format("d/m/Y")}}</div>
				<div class="col-xs-10 content">
				{!! str_replace(array("\r\n","\n"),"<br />",$m->content) !!}
				</div>
			@else
			<div class="KerdenMessage droite">
				<div class="col-xs-4 col-xs-offset-2 date ">{{ $m->created_at->format("d/m/Y")}}</div><div style="font-size:1.2em" class="col-xs-6 text-right">{{$garden->owner->firstName}}</div>
				<div class="col-xs-10 col-xs-offset-2 content">
				{!! str_replace(array("\r\n","\n"),"<br />",$m->content) !!}
				</div>
			@endif

		</div>
		@else
			<a href="{{ url('/reservation/view/'.$m->reservation_id) }}">
			<div class="col-xs-12 KerdenEvent @if(isset($m->danger)) danger @endif">
				<div class="content">
					<div class="text-center col-xs-12 col-sm-10">{{$m->content}}</div>
					<div class="text-right col-xs-2">{{$m->created_at->format("d/m/Y")}}</div>
				</div>
			</div>
			</a>
		@endif
		
		@endforeach

		@if($newAvaible)
			@include('messages.new')
		@else
		<div class="col-xs-12" style="font-size:0.7em">
			-Impossible d'écrire un autre message pour l'instant. Attendez que le propriétaire réponde.-
		</div>
		@endif
	</div>

	<div class="col-sm-4 col-xs-12 messageResaBloc" data-spy="affix" data-offset-top="82" >
		<img src="{{ asset('storage/'.$garden->getFirstPhotoURL()) }}" alt="" class="img-responsive">

		<a href="{{ url('/view/'.$garden->id) }}" ><div class="btn massResaBtn">Réserver maintenant</div></a>
		
	</div>
</div>

@include('footer')
@endsection


@section('scripts')
<script>
(function($){
	$('.HPMenuLink').removeClass('active');
    $('.messageMenu').addClass('active');

    $(window).on('scroll resize',function(event){
    	var w = $('#mainContainer').width();
    	$('.messageResaBloc').css('width',w/3.);
    	var p = $('#mainContainer').css('padding-left').replace('px',"");
    	var m = $('#mainContainer').css('margin-left').replace('px','');
    	$('.messageResaBloc').css('left',eval(p)+eval(m)+ (2*w/3.));
    });
    $(window).load(function() {
	  $("html, body").animate({ scrollTop: $('.KerdenMessage .content').last().offset().top - 111 }, 1000);
	});
}) (jQuery);
</script>
@endsection