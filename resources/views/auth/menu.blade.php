@extends('layouts.backend')


@section('content')

<div class="container-fluid">
	<div class="col-sm-3 left-home-menu kerden-page-1">

		<ul class="" role="menu">
			<a class="left-menu-link" href="{{url('/userdetails')}}"><li>Modifier mes coordonnées</li></a>
			<a class="left-menu-link" href="{{url('/user/advancedDetails')}}"><li>Données avancées</li></a>
			<a class="left-menu-link" href="{{url('/proofOfId')}}"><li>Prouver mon identité</li></a>
			<a class="left-menu-link" href="{{url('/rib')}}"><li>Coordonnées bancaires</li></a>
			<a class="left-menu-link" href="{{url('/changePassword')}}"><li>Changer de Mot de Passe</li></a>
		</ul>
	</div>

	<div class="col-sm-9 kerden-page-2">
		@yield('contentPane')
	</div>
</div>
@include('footer')

@endsection