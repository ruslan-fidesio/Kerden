@extends('layouts.backend')

@section('content')

<div class="container">
	<div class="text-center"><h3>Contactez-nous</h3></div>
	<div class="panel panel-default">
		<div class="panel-heading">Mise en location</div>
		<div class="panel-body">
			{!! Form::open() !!}

			{!! Form::textarea('content',trans('mails.rentMe'),['class'=>'form-control']) !!}

			<div class="text-center">
				{!! Form::submit('Envoyer',['class'=>'btn btn-primary']) !!}
			</div>

			{!! Form::close() !!}
		</div>
	</div>
</div>

@endsection