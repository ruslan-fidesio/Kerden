@extends('admin.menu')


@section('contentPane')
	
	<div class="panel panel-kerden-home">
		<div class="panel-heading">Message signalés</div>
		<div class="panel-body">
			<h4>Commentaires</h4>
			<ul>
				@foreach($comments as $com)
					<li><a href="{{url('/admin/reported/Commentaire/'.$com->id)}}">{{str_limit($com->content,15)}}</a></li>
				@endforeach
			</ul>
			<hr>
			<h4>Réponses</h4>
			<ul>
				@foreach($answers as $ans)
					<li><a href="{{url('/admin/reported/Answer/'.$ans->id)}}">{{str_limit($ans->content,15)}}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
</div>

@endsection


@section('scripts')
<script>
(function($){
    $('.HPMenuLink').removeClass('active');
    $('.adminMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(4)').addClass('active');
}) (jQuery);
</script>
@endsection