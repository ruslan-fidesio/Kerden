@extends('layouts.backend')


@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">Voire le message signalé</div>
		<div class="panel-body">
			<h3>Message d'origine : </h3>
			<blockquote>
				{{$toSee->commentaire->content}}
				<footer>{{$toSee->commentaire->author->fullName}}</footer>
			</blockquote>
			<h3>Réponse signalée : </h3>
			<blockquote class="blockquote-reverse" style="background-color:salmon">
				{{$toSee->content}}
				<footer>{{$toSee->author->fullName}}</footer>
			</blockquote>
			<div class="row">
				<div class="col-xs-6 text-center">
					<a href="{{url('/admin/ignoreReport/Answer/'.$toSee->id)}}"><div class="btn btn-primary">Laisser visible</div></a>
				</div>
				<div class="col-xs-6 text-center">
					<a href="{{url('/admin/acceptReport/Answer/'.$toSee->id)}}"><div class="btn btn-danger">Supprimer le message</div></a>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection