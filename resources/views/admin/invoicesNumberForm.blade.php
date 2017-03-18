@extends('admin.menu')

@section('contentPane')
	<div class="panel panel-kerden-home">
		<div class="panel-heading">Admin -> factures et reçus</div>
		<div class="panel-body">
			{!! Form::open() !!}

			<div class="row">
				<div class="col-xs-2">Référence : </div>
				<div class="col-xs-4">
					{!! Form::text('reference') !!}
				</div>
			</div>

			<div class="row">
				{!! Form::submit('Rechercher',['class'=>'btn btn-kerden-confirm']) !!}
			</div>

			{!! Form::close() !!}
		</div>
	</div>
@endsection


@section('scripts')
<script>
(function($){
	$('.HPMenuLink').removeClass('active');
    $('.adminMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(8)').addClass('active');
}) (jQuery);
</script>
@endsection