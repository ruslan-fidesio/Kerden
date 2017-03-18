@extends('layouts.backend')


@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">Voire le message signalé</div>
		<div class="panel-body">
			<h3>Message Signalé : </h3>
			<blockquote style="background-color:salmon">
				{{$toSee->content}}
				<footer>{{$toSee->author->fullName}}</footer>
			</blockquote>
			@if($toSee->answer != null && !$toSee->answer->denied)
				<h3>Réponse du propriétaire : </h3>
				<blockquote class="blockquote-reverse" >
					{{$toSee->answer->content}}
					<footer>{{$toSee->answer->author->fullName}}</footer>
				</blockquote>
			@endif
			<div class="row">
				<div class="col-xs-6 text-center">
					<a href="{{url('/admin/ignoreReport/Commentaire/'.$toSee->id)}}"><div class="btn btn-primary">Laisser visible</div></a>
				</div>
				<div class="col-xs-6 text-center">
					<a href="{{url('/admin/acceptReport/Commentaire/'.$toSee->id)}}"><div class="btn btn-danger">Supprimer le message</div></a>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection