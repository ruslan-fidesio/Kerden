@extends('layouts.app')

@section('content')
<div class="container">

<div class="panel panel-default">
	<div class="panel-heading">Inscription nécessaire</div>
	<div class="panel-body">
		<div class="alert alert-danger">Vous devez être inscrit et connecté pour pouvoir continuer</div>
		<div class="row">
			<div class="col-xs-12 text-center"><a href=" {{url('/register')}} "><div class="btn btn-primary"><h4>Je m'inscris</h4></div></a></div>
			<hr/>
			<div class="col-xs-12 text-center"><a href=" {{url('/login')}} "><div class="btn btn-info">déjà inscrit? connexion</div></a></div>
		</div>
	</div>
</div>

</div>


@endsection