@extends('admin.menu')

@section('headers')
<link rel="stylesheet" href="{{ URL::asset('css/datepicker3.css') }}">
@endsection


@section('contentPane')
	<div class="panel panel-kerden-home">
		<div class="panel-heading">Admin -> factures et reçus</div>
		<div class="panel-body">
			{!! Form::open() !!}
			
			<div class="row">
				<div class="col-xs-4">
			 		{!! Form::text('dateBegin',null,['placeholder'=>'Date de début','class'=>'form-control','id'=>'datePicker1']) !!}
			 	</div>
			 </div>
			 <div class="row">
			 	<div class="col-xs-4">
			 		{!! Form::text('dateEnd',null,['placeholder'=>'Date de fin','class'=>'form-control','id'=>'datePicker2']) !!}
			 	</div>
		 	</div>

		 	<div class="row">
			 	<div class="col-xs-4">
				 	{!! Form::submit('Rechercher', ['class'=>'btn btn-primary']) !!}
				 </div>
			</div>

			{!! Form::close() !!}
		</div>
	</div>
@endsection


@section('scripts')
<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap-datepicker.fr.js') }}"></script>
<script>
(function($){
	$('#datePicker1, #datePicker2').datepicker({
        language:'fr',
        format:'dd-mm-yyyy',
        startView:'month',
        autoclose:true,
        todayHighlight:true,
    });
    $('.HPMenuLink').removeClass('active');
    $('.adminMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(7)').addClass('active');
}) (jQuery);
</script>
@endsection