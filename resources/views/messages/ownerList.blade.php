@extends('layouts.backend')

@section('content')

<div class="container" style="max-width:780px">

	<h3 class="text-center" style="margin-bottom:30px">{{$garden->title}}</h3>

	<div class="col-xs-12">
		@foreach($events as $m)
		@if($m instanceof \App\Message)
			@if($m->author_id == $garden->owner->id)
				<div class="KerdenMessage droite">
				<div class="col-xs-4 col-xs-offset-2 date">{{ $m->created_at->format("d/m/Y")}}</div><div style="font-size:1.2em" class="col-xs-6 text-right">Moi</div>				
				<div class="col-xs-10 content">
				{!! str_replace(array("\r\n","\n"),"<br />",$m->content) !!}
				</div>
			@else
				<div class="KerdenMessage gauche">
				<div style="font-size:1.2em" class="col-xs-6 text-left">{{$m->asker->firstName}}</div><div class="col-xs-4 text-right date">{{ $m->created_at->format("d/m/Y")}}</div>
				<div class="col-xs-10 col-xs-offest-2 content">
				{!! str_replace(array("\r\n","\n"),"<br />",$m->content) !!}
				</div>
			@endif

		</div>
		@else
			<a href="{{ url('/reservation/ownerView/'.$m->reservation_id) }}">
			<div class="col-xs-12 KerdenEvent @if(isset($m->danger)) danger @endif">
				<div class="content">
					<div class="text-center col-xs-12 col-sm-10">{{$m->content}}</div>
					<div class="text-right col-xs-2">{{$m->created_at->format("d/m/Y")}}</div>
				</div>
			</div>
			</a>
		@endif
		@endforeach


		@include('messages.newAnswer')

		

	</div>
</div>

@include('footer')
@endsection


@section('scripts')
<script>
(function($){
	$('.HPMenuLink').removeClass('active');
    $('.messageMenu').addClass('active');
}) (jQuery);
</script>
@endsection