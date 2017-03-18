@extends('auth.menu')

@section('contentPane')
<div class="panel panel-kerden-home">
    <div class="kerden-back-button">Retour</div>
    <div class="panel-heading">Détails Avancés</div>
    <div class="panel-body">

    	{!! Form::model($details,['url'=>'/user/advancedDetails','autocomplete'=>'off','class'=>'form-horizontal']) !!}
            {!! csrf_field() !!}


			<div class="form-group{{ $errors->has('occupation') ? ' has-error' : '' }}">
                {!! Form::label('Statut professionel (métier)', null ,
                    ['class'=>'col-md-4 control-label']) !!}

                <div class="col-md-6">
                     {!! Form::text('occupation', null ,['id'=>'occupation',
                                                    'class'=>'form-control'])  !!}

                    @if ($errors->has('occupation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('occupation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

			<div class="form-group{{ $errors->has('income_range') ? ' has-error' : '' }}">
                {!! Form::label('Revenus annuels', null ,
                    ['class'=>'col-md-4 control-label']) !!}

                <div class="col-md-6">
                     {!! Form::select('income_range', $incomeTab ,$details->income_range,['id'=>'income_range',
                                                    'class'=>'form-control'])  !!}

                    @if ($errors->has('income_range'))
                        <span class="help-block">
                            <strong>{{ $errors->first('income_range') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

          <div class="col-xs-12 text-center">

          	{!! Form::submit('Enregistrer',['class'=>'btn btn-kerden-confirm']) !!}
          </div>


        {!! Form::close() !!}
    </div>
</div>
<div class="panel panel-kerden-home">
	<div class="panel-heading">Pourquoi ces données??</div>
	<div class="panel-body">
		Dans le cas de transactions dépassant 2500€ en entrée (payin), ou 1000€ en versements (payout),<br/>
		la loi française nous oblige à collecter ces données, et à les transmettre à notre partenaire bancaire.<br/>
		Celles-ci seront ne seront utilisées qu'en cas de litige, afin notamment de calculer votre éventuel taux d'endettement.
	</div>
</div>


@endsection

@section('scripts')
<script>
(function($){
    $('.HPMenuLink').removeClass('active');
    $('.userMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(2)').addClass('active');
    showPage2();
}) (jQuery);
</script>
@endsection