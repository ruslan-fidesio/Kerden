@extends ('admin.menu')


@section ('contentPane')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-kerden-home">
                <div class="panel-heading">Espace Administrateur -> Envoi de mail</div>
                <div class="panel-body">
                	{!! Form::open() !!}
                	<div class="row">
                		<div class="form-group">
	                		{!! Form::label('mail_type','Type de mail',['class'=>'col-xs-3 text-right control-label']) !!}
	                		<div class='col-xs-3'>
	                			{!! Form::select('mail_type',
	                			['contact'=>'Prise de Contact'],
	                			null,['class'=>'form-control']) !!}	                		
	                        </div>
	                	</div>
                	</div>

                	<div class="row">
                		<div class="form-group">
                			{!! Form::label('adresses','Adresses (une par ligne)',['class'=>'col-xs-3 text-right control-label']) !!}
                			<div class="col-xs-4">
								{!! Form::textarea('adresses',null,['class'=>'form-control']) !!}
							</div>
						</div>	
					</div>

					<div class="row">
						<div class="col-xs-2 col-xs-offset-3">
							{!! Form::submit('Envoyer',['class'=>'btn btn-kerden-confirm']) !!}
						</div>	
					</div>
					{!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
<script>
(function($){
    $('.HPMenuLink').removeClass('active');
    $('.adminMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(3)').addClass('active');
}) (jQuery);
</script>
@endsection