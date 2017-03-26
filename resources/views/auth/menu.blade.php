@extends('layouts.backend')


@section('content')

<div class="container-fluid">
	<div class="col-sm-3 left-home-menu kerden-page-1">

		<ul class="" role="menu">
			<a class="left-menu-link" href="{{url('/userdetails')}}"><li>Modifier mes coordonnées</li></a>
			@if (Auth::user() && Auth::user()->details && Auth::user()->details->type == 'natural')
				<a class="left-menu-link" href="{{url('/user/advancedDetails')}}"><li>Données avancées</li></a>
			@endif
			<a class="left-menu-link" href="{{url('/proofOfId')}}"><li>Prouver mon identité</li></a>
			<a class="left-menu-link" href="{{url('/rib')}}"><li>Coordonnées bancaires</li></a>
			<a class="left-menu-link" href="{{url('/changePassword')}}"><li>Changer de Mot de Passe</li></a>
		</ul>
	</div>

	<div class="col-sm-9 kerden-page-2">
		@if(isset($message))
	        <div class="alert alert-success fade in">
	          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	          {{$message}}
	        </div>
	    @endif
	    @if(isset($error))
	        <div class="alert alert-danger fade in">
	          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	          {{$error}}
	        </div>
	    @endif
		@yield('contentPane')
	</div>
</div>
@include('footer')

@endsection