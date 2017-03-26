@extends('layouts.backend')


@section('content')

<div class="side-container">
  <div class="side-bg">
    <div class="col-md-4 grey-bg">
    </div>
    <div class="col-md-8 white-bg">
    </div>
  </div>
  <div class="container">
    <div class="tabbable side-padding">
    	<div class="col-sm-3">
    		<ul class="nav nav-pills-stacked" role="menu">
					<li class="left-menu-link"><a href="{{url('/userdetails')}}">Modifier mes coordonnées</a></li>
					@if (Auth::user() && Auth::user()->details && Auth::user()->details->type == 'natural')
					<li class="left-menu-link"><a href="{{url('/user/advancedDetails')}}">Données avancées</a></li>
					@endif
					<li class="left-menu-link"><a href="{{url('/proofOfId')}}">Prouver mon identité</a></li>
					<li class="left-menu-link"><a href="{{url('/rib')}}">Coordonnées bancaires</a></li>
					<li class="left-menu-link"><a href="{{url('/changePassword')}}">Changer de Mot de Passe</a></li>
				</ul>
			</div>
			<div class="col-sm-8 col-sm-offset-1 kerden-page-2">
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
</div>
@include('footer')

@endsection