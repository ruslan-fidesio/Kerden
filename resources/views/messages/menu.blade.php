@extends('layouts.backend')

@section('content')
<div class="admin-bg">
  <h1 class="text-center">Messages</h1>
</div>
<div class="container" style='max-width:860px'>
	@forelse($groups as $mess)
	<a href="{{url('/messages/'.$mess->garden_id)}}">
	<div class="KerdenMessageGroup row">
		<div class="col-xs-6 col-sm-9">
			<div class="col-xs-12 text-right date">{{$mess->created_at->format('d/m/Y')}}</div>

			<div class="col-xs-12 col-sm-6 title">
			@if($mess->red)
				<i class="fa fa-envelope-open-o"></i>
			@else
				<i class="fa fa-envelope-o"></i>
			@endif
				{{$mess->garden->title}}</div>
			<div class="col-sm-6 hidden-xs text-right statut">{{$mess->garden->owner->fullName}}</div>
		</div>
		<div class="col-xs-6 col-sm-3"><img src="{{ asset('storage/'.$mess->garden->getFirstPhotoUrl()) }}" alt="" class="img-responsive"></div>
		
	</div>
	</a>
	@empty
	<h3 class="text-center">Pas de messages.</h3>
	@endforelse
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