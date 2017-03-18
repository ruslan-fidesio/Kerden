@extends('layouts.backend')


@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">Modifier la description</div>
		<div class="panel-body">
			<h2>{{$garden->title}}</h2>
			{!! Form::model($garden) !!}

			{!! Form::textarea('description') !!}

			{!!Form::submit('Enregistrer',['class'=>'btn btn-primary']) !!}

			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection