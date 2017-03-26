@extends ('layouts.backend')

@section('headers')
<link rel="stylesheet" type="text/css" href="{{asset('css/prices.css')}}">
@endsection

@section('content')
<div class="container">
	<h1 class="jumbotron-heading text-center">{{$garden->title}}</h1>
    <h5 class="text-center">{{$garden->address}}</h5>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Coordonées -> Critères -> Calendrier -> <strong>Tarifs</strong></div>
                <div class="panel-body">
                    <div class='col-xs-12 text-center'>
                        Déterminez votre <strong>tarif</strong> horaire de location.
                        Appliquer un tarif plus bas en semaine peut vous donner de meilleurs résultats.
                    </div>
                    <hr/>
                    <div class='col-md-6'>
                        <div class='panel panel-default'>
                            <div class="panel-heading">Tarifs en semaine</div>
                            <div class='panel-body'>
                                {!! Form::open() !!}
                                <div class="row form-group {{ $errors->has('weekPrices.morning') ? ' has-error' : '' }}">
                                    <div class='col-xs-1 checkbox' data-toggle="tooltip" title="{{trans('garden.acceptSlot')}}">
                                        <label>
                                            {!! Form::hidden('weekAccept[morning]',0) !!}
                                            {!! Form::checkbox('weekAccept[morning]',1,($garden->weekSlotAccept?$garden->weekSlotAccept->morning:null)) !!}
                                        </label>
                                    </div>
                                        {!! Form::label(trans('garden.morningPrice'), trans('garden.morningPrice') ,
                                            ['class'=>'col-xs-7 control-label price-label']) !!}
                                    <div class='col-xs-4 input-group'>
                                        {!! Form::number('weekPrices[morning]',($garden->weekPrices?$garden->weekPrices->morning:null),['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                                        <span class="input-group-addon">€ / heure</span>
                                    </div>
                                </div>
                                <div class="row form-group  {{ $errors->has('weekPrices.afternoon') ? ' has-error' : '' }}">
                                    <div class='col-xs-1 checkbox' data-toggle="tooltip" title="{{trans('garden.acceptSlot')}}">
                                        <label>
                                            {!! Form::hidden('weekAccept[afternoon]',0) !!}
                                            {!! Form::checkbox('weekAccept[afternoon]',1,($garden->weekSlotAccept?$garden->weekSlotAccept->afternoon:null)) !!}
                                        </label>
                                    </div>
                                        {!! Form::label(trans('garden.afternoonPrice'), trans('garden.afternoonPrice') ,
                                            ['class'=>'col-xs-7 control-label price-label']) !!}
                                    <div class='col-xs-4 input-group'>
                                        {!! Form::number('weekPrices[afternoon]',($garden->weekPrices?$garden->weekPrices->afternoon:null),['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                                        <span class="input-group-addon">€ / heure</span>
                                    </div>
                                </div>
                                <div class="row form-group {{ $errors->has('weekPrices.evening') ? ' has-error' : '' }}">
                                    <div class='col-xs-1 checkbox' data-toggle="tooltip" title="{{trans('garden.acceptSlot')}}">
                                        <label>
                                            {!! Form::hidden('weekAccept[evening]',0) !!}
                                            {!! Form::checkbox('weekAccept[evening]',1,($garden->weekSlotAccept?$garden->weekSlotAccept->evening:null)) !!}
                                        </label>
                                    </div>
                                        {!! Form::label(trans('garden.eveningPrice'), trans('garden.eveningPrice') ,
                                            ['class'=>'col-xs-7 control-label price-label']) !!}
                                    <div class='col-xs-4 input-group'>
                                        {!! Form::number('weekPrices[evening]',($garden->weekPrices?$garden->weekPrices->evening:null),['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                                        <span class="input-group-addon">€ / heure</span>
                                    </div>
                                </div>
                                <div class="row form-group {{ $errors->has('weekPrices.night') ? ' has-error' : '' }}">
                                    <div class='col-xs-1 checkbox' data-toggle="tooltip" title="{{trans('garden.acceptSlot')}}">
                                        <label>
                                            {!! Form::hidden('weekAccept[night]',0) !!}
                                            {!! Form::checkbox('weekAccept[night]',1,($garden->weekSlotAccept?$garden->weekSlotAccept->night:null)) !!}
                                        </label>
                                    </div>
                                        {!! Form::label(trans('garden.nightPrice'), trans('garden.nightPrice') ,
                                            ['class'=>'col-xs-7 control-label price-label']) !!}
                                    <div class='col-xs-4 input-group'>
                                        {!! Form::number('weekPrices[night]',($garden->weekPrices?$garden->weekPrices->night:null),['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                                        <span class="input-group-addon">€ / heure</span>
                                    </div>
                                </div>

                                <hr/>

                                <div class="row form-group {{ $errors->has('weekPrices.hour_max') ? ' has-error' : '' }}">
                                        {!! Form::label(trans('garden.hour_max'), trans('garden.hour_max') ,
                                            ['class'=>'col-xs-8 control-label price-label']) !!}
                                        <div class='col-xs-4 input-group'>
                                        {!! Form::number('weekPrices[hour_max]',($garden->weekPrices?$garden->weekPrices->hour_max:null),['class'=>'form-control','min'=>'0','step'=>'1','max'=>'23']) !!}
                                            <span class="input-group-addon">heure</span>
                                        </div>
                                        @if ($errors->has('weekPrices.hour_max'))
                                            <span class="help-block">
                                                <strong>{{ trans('garden.hour_help') }}</strong>
                                            </span>
                                        @endif
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='panel panel-default'>
                            <div class="panel-heading">Tarifs en week-end</div>
                            <div class='panel-body'>
                                <div class="row form-group {{ $errors->has('prices.morning') ? ' has-error' : '' }}">
                                    <div class='col-xs-1 checkbox' data-toggle="tooltip" title="{{trans('garden.acceptSlot')}}">
                                        <label>
                                            {!! Form::hidden('accept[morning]',0) !!}
                                            {!! Form::checkbox('accept[morning]',1,($garden->slotAccept?$garden->slotAccept->morning:null)) !!}
                                        </label>
                                    </div>
                                        {!! Form::label(trans('garden.morningPrice'), trans('garden.morningPrice') ,
                                            ['class'=>'col-xs-7 control-label price-label']) !!}
                                    <div class='col-xs-4 input-group'>
                                        {!! Form::number('prices[morning]',($garden->prices?$garden->prices->morning:null),['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                                        <span class="input-group-addon">€ / heure</span>
                                    </div>
                                </div>
                                <div class="row form-group {{ $errors->has('prices.afternoon') ? ' has-error' : '' }}">
                                    <div class='col-xs-1 checkbox' data-toggle="tooltip" title="{{trans('garden.acceptSlot')}}">
                                        <label>
                                            {!! Form::hidden('accept[afternoon]',0) !!}
                                            {!! Form::checkbox('accept[afternoon]',1,($garden->slotAccept?$garden->slotAccept->afternoon:null)) !!}
                                        </label>
                                    </div>
                                        {!! Form::label(trans('garden.afternoonPrice'), trans('garden.afternoonPrice') ,
                                            ['class'=>'col-xs-7 control-label price-label']) !!}
                                    <div class='col-xs-4 input-group'>
                                        {!! Form::number('prices[afternoon]',($garden->prices?$garden->prices->afternoon:null),['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                                        <span class="input-group-addon">€ / heure</span>
                                    </div>
                                </div>
                                <div class="row form-group {{ $errors->has('prices.evening') ? ' has-error' : '' }}">
                                    <div class='col-xs-1 checkbox' data-toggle="tooltip" title="{{trans('garden.acceptSlot')}}">
                                        <label>
                                            {!! Form::hidden('accept[evening]',0) !!}
                                            {!! Form::checkbox('accept[evening]',1,($garden->slotAccept?$garden->slotAccept->evening:null)) !!}
                                        </label>
                                    </div>
                                        {!! Form::label(trans('garden.eveningPrice'), trans('garden.eveningPrice') ,
                                            ['class'=>'col-xs-7 control-label price-label']) !!}
                                    <div class='col-xs-4 input-group'>
                                        {!! Form::number('prices[evening]',($garden->prices?$garden->prices->evening:null),['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                                        <span class="input-group-addon">€ / heure</span>
                                    </div>
                                </div>
                                <div class="row form-group {{ $errors->has('prices.night') ? ' has-error' : '' }}">
                                    <div class='col-xs-1 checkbox' data-toggle="tooltip" title="{{trans('garden.acceptSlot')}}">
                                        <label>
                                            {!! Form::hidden('accept[night]',0) !!}
                                            {!! Form::checkbox('accept[night]',1,($garden->slotAccept?$garden->slotAccept->night:null)) !!}
                                        </label>
                                    </div>
                                        {!! Form::label(trans('garden.nightPrice'), trans('garden.nightPrice') ,
                                            ['class'=>'col-xs-7 control-label price-label']) !!}
                                    <div class='col-xs-4 input-group'>
                                        {!! Form::number('prices[night]',($garden->prices?$garden->prices->night:null),['class'=>'form-control','min'=>'0','step'=>'1']) !!}
                                        <span class="input-group-addon">€ / heure</span>
                                    </div>
                                </div>

                                <hr/>

                                <div class="row form-group {{ $errors->has('prices.hour_max') ? ' has-error' : '' }}">
                                        {!! Form::label(trans('garden.hour_max'), trans('garden.hour_max') ,
                                            ['class'=>'col-xs-8 control-label price-label']) !!}
                                        <div class='col-xs-4 input-group'>
                                        {!! Form::number('prices[hour_max]',($garden->prices?$garden->prices->hour_max:null),['class'=>'form-control','min'=>'0','step'=>'1','max'=>'23']) !!}
                                            <span class="input-group-addon">heure</span>
                                        </div>
                                        @if ($errors->has('prices.hour_max'))
                                            <span class="help-block">
                                                <strong>{{ trans('garden.hour_help') }}</strong>
                                            </span>
                                        @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        {!! Form::submit(trans('base.save'),['class'=>'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
(function($){
    $('[data-toggle="tooltip"]').tooltip({delay:500});
}) (jQuery);
</script>
@endsection