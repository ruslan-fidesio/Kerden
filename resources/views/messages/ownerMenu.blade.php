@extends('layouts.backend')

@section('content')

<div class="container" style='max-width:860px'>
	<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="gardenMessageNavs">
    @foreach($groups as $gardenId=>$mess)
    	<li role="presentation"  ><a href="#tab{{$gardenId}}" role="tab" data-toggle="tab">{{$titles[$gardenId]}}
        @if( Auth::user()->getUnreadMessagedForGarden($gardenId) > 0 )
          <i class="fa fa-envelope-o"></i><sup class="unreadNumber">{{ Auth::user()->getUnreadMessagedForGarden($gardenId) }}</sup>
        @endif
      </a></li>
    @endforeach
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    @foreach($groups as $gardenId=>$mess)
    	<div role="tabpanel" class="tab-pane gardenMessagePanes" id="tab{{$gardenId}}">
    		<h3>{{$titles[$gardenId]}}
        </h3>
    		@forelse($mess as $m)
			<a href="{{url('/owner/messages/'.$m->garden_id.'/'.$m->asker_id)}}">
			<div class="KerdenMessageGroup row">
				<div class="col-xs-12">
					<div class="col-xs-6 title">
            @if($m->red)
              <i class="fa fa-envelope-open-o"></i>
            @else
              <i class="fa fa-envelope-o"></i>
            @endif
            {{$m->asker->firstName}}</div>
					<div class="col-xs-6 text-right date">{{$m->created_at->format('d/m/Y')}}</div>
					<div class="col-xs-12">{{ mb_substr($m->content,0,30) }}...</div>
				</div>
			</div>
			</a>
			@empty
				<h5>Pas de messages.</h5>
			@endforelse
    	</div>
    @endforeach
  </div>

</div>

@include('footer')

@endsection

@section('scripts')
<script>
(function($){
	$('.HPMenuLink').removeClass('active');
    $('.messageMenu').addClass('active');

    $('#gardenMessageNavs li').first().addClass('active');
    $('.gardenMessagePanes').first().addClass('active');
}) (jQuery);
</script>
@endsection