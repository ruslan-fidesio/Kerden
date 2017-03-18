@extends('auth.menu')



@section('contentPane')
	<div class="panel panel-kerden-home">
		<div class="panel-heading"><div class="kerden-back-button"></div>Coordonnées bancaires / nouveau compte</div>
		<div class="panel-body">
			<h3>{{$user->fullName}}</h3>

			{!! Form::open() !!}
			<div class="row form-group{{ $errors->has('iban') ? ' has-error' : '' }}">
				{!! Form::label('IBAN','IBAN',['class'=>'control-label col-md-1']) !!}
				<div class="col-md-8">
					{!! Form::text('iban',null ,['class'=>'form-control'])  !!}
				</div>
				@if ($errors->has('iban'))
                    <span class="help-block">
                        <strong>{{ $errors->first('iban') }}</strong>
                    </span>
                @endif
			</div>

			<div class="row form-group{{ $errors->has('bic') ? ' has-error' : '' }}">
				{!! Form::label('BIC','BIC',['class'=>'control-label col-md-1']) !!}
				<div class="col-md-6">
					{!! Form::text('bic',null,['class'=>'form-control']) !!}
				</div>
				@if ($errors->has('bic'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bic') }}</strong>
                    </span>
                @endif
			</div>

			<div class="row form-group">
				{!! Form::submit('Ajouter',['class'=>'btn btn-kerden-confirm']) !!}
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
    $('.left-menu-link:nth-child(4)').addClass('active');

    showPage2();
}) (jQuery);
</script>
@endsection