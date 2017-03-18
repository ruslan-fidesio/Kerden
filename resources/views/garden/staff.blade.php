@extends('garden.menu')

@section('contentPane')
<div class="kerden-back-button">Retour
</div>
    <h1>{{$garden->title}}</h1>
    <div class='panel panel-kerden-home'>
        <div class='panel-heading'>{{trans('garden.securitystaff')}}</div>
        <div class='panel-body'>
            <div>{{ trans('garden.staffHelper') }}</div>
            <div style="margin-left:15px">
                <h3>Nombre</h3>
                <div>{{ trans('garden.staffHelper4') }}</div>
    
                <h3>Service</h3>
                <div>{{ trans('garden.staffHelper2') }}</div>
    
                <h3>Coût</h3>
                <div>{{ trans('garden.staffHelper3') }}</div>
                <div>{{ trans('garden.staffHelper3.2') }}</div>
            </div>

            <hr/>
        	
            {!! Form::model($garden->staff) !!}

            <div class='checkbox'>
                <label>
                    {!! Form::checkbox('requiredStaff') !!}
                    {{ trans('garden.staffrequired') }}
                </label>
            </div>

            <div class='checkbox'>
                <label>
                    {!! Form::checkbox('requiredStaffNight') !!}
                    {{ trans('garden.staffrequiredNight') }}
                </label>
            </div>

            <div class='checkbox'>
                <label>
                    {!! Form::checkbox('restrictedKitchenAccess') !!}
                    {{ trans('garden.cookrequired') }}
                </label>
            </div>

            <div class="col-xs-12 text-center">
                {!! Form::submit(trans('base.save'),['class'=>'btn btn-kerden-confirm']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
<script>
(function($){
    $('.HPMenuLink').removeClass('active');
    $('.gardenMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(6)').addClass('active');
    showPage2();
}) (jQuery);
</script>
@endsection