@extends('auth.menu')

@section('contentPane')
	<div class="panel panel-kerden-home">
		<div class="panel-heading">Changer de Mot de Passe</div>
		<div class="panel-body">
			{!! Form::open(['class'=>'form-horizontal']) !!}

			<div class="form-group{{ $errors->has('old_pass') ? ' has-error' : '' }}">
				{!! Form::label('old_pass','Ancien mot de passe',['class'=>'control-label col-md-4']) !!}
				<div class="col-md-6">
					{!! Form::password('old_pass',['class'=>'form-control']) !!}
					@if ($errors->has('old_pass'))
                        <span class="help-block">
                            <strong>{{ $errors->first('old_pass') }}</strong>
                        </span>
                    @endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('new_pass') ? ' has-error' : '' }}">
				{!! Form::label('new_pass','Nouveau mot de passe',['class'=>'control-label col-md-4']) !!}
				<div class="col-md-6">
					{!! Form::password('new_pass',['class'=>'form-control']) !!}
					@if ($errors->has('new_pass'))
                        <span class="help-block">
                            <strong>{{ $errors->first('new_pass') }}</strong>
                        </span>
                    @endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('new_pass_confirmation') ? ' has-error' : '' }}">
				{!! Form::label('new_pass_confirmation','Confirmation Nouveau mot de passe',['class'=>'control-label col-md-4']) !!}
				<div class="col-md-6">
					{!! Form::password('new_pass_confirmation',['class'=>'form-control']) !!}
					@if ($errors->has('new_pass_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('new_pass_confirmation') }}</strong>
                        </span>
                    @endif
				</div>
			</div>

			<div class="col-md-12 text-center">
				{!! Form::submit('Enregistrer',['class'=>'btn btn-kerden-confirm']) !!}
			</div>


			{!! Form::close() !!}
		</div>
	</div>
@endsection

@section('scripts')
<script>
(function($){
    $('.HPMenuLink').removeClass('active');
    $('.userMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(5)').addClass('active');
    showPage2();
}) (jQuery);
</script>
@endsection