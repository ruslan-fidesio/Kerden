@extends('layouts.app')

@section('headers')
<link rel="stylesheet" href="{{ URL::asset('css/datepicker3.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans( 'userdetails.details' )}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/userdetails') }}" autocomplete="off">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.birthday')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="birthday" id="birthday"
                                 value="{{ old('birthday') }}" placeholder="jj-mm-aaaa">

                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.nationality')}}</label>

                            <div class="col-md-6">
                                <select size="1" class="form-control" name="nationality" id="nationality" >
                                    @foreach ($paysCodes as $code)
                                        <option value="{{ $code->alpha2 }}"
                                            @if ($code->alpha2 == old('nationality') )
                                                selected
                                            @endif
                                        >{{ $code->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('nationality'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nationality') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" data-toggle="tooltip" 
                                 title="{{trans('userdetails.countrylimitation')}}">{{trans('validation.attributes.countryOfResidence')}} *</label>

                            <div class="col-md-6">
                                <select size="1" class="form-control" name="countryOfResidence" id="countryOfResidence"
                                 value="{{ old('countryOfResidence') }}" disabled >
                                 <option value="FR" selected>France</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('addressLine1') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.address')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="addressLine1" id="addressLine1"
                                 value="{{ old('addressLine1') }}">

                                @if ($errors->has('addressLine1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('addressLine1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.addressComp')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="addressLine2" id="addressLine2"
                                 value="{{ old('addressLine2') }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('postalCode') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.postalCode')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="postalCode" id="postalCode"
                                 value="{{ old('postalCode') }}">

                                @if ($errors->has('postalCode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('postalCode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.city')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="city" id="city"
                                 value="{{ old('city') }}">

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-6 col-md-offset-2 control-label">{{trans('userdetails.iamlegal')}}</label>
                            <div class="col-md-1">
                                <input type="checkbox" class="form-control" name="iamlegal" id="iamlegal" value="true" 
                                @if ( old('iamlegal') )
                                    checked
                                @endif
                                >
                            </div>
                        </div>




                        <div class="panel panel-default" id="organizationaddressPanel" 
                        @if (! old('iamlegal'))
                            hidden 
                        @endif
                        >
                            <div class="panel-heading">{{trans( 'userdetails.organizationdetails' )}}</div>
                            <div class="panel-body">

                                <div class="form-group{{ $errors->has('organizationname') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">{{trans('validation.attributes.name')}}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="organizationname" id="organizationname"
                                         value="{{ old('organizationname') }}">

                                        @if ($errors->has('organizationname'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('organizationname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('organizationaddress') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">{{trans('validation.attributes.address')}}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="organizationaddress" id="organizationaddress"
                                         value="{{ old('organizationaddress') }}">

                                        @if ($errors->has('organizationaddress'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('organizationaddress') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('validation.attributes.addressComp')}}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="organizationaddress2" id="organizationaddress2"
                                         value="{{ old('organizationaddress2') }}">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('organizationPostalCode') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">{{trans('validation.attributes.postalCode')}}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="organizationPostalCode" id="organizationPostalCode"
                                         value="{{ old('organizationPostalCode') }}">

                                        @if ($errors->has('organizationPostalCode'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('organizationPostalCode') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('organizationCity') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">{{trans('validation.attributes.city')}}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="organizationCity" id="organizationCity"
                                         value="{{ old('organizationCity') }}">

                                        @if ($errors->has('organizationCity'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('organizationCity') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">{{trans('auth.validate')}}</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{url('/home')}}" class="btn btn-danger">{{trans('auth.cancel')}}</a>
                            </div>
                        </div>

                    <form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/jquery.inputmask.js') }}"></script>
<script>
(function($){

    $('#birthday').datepicker({
        format:'dd-mm-yyyy',
        startView:'decade',
        autoclose:true
    });

    $('[data-toggle="tooltip"]').tooltip(); 

    $('#iamlegal').click(function(){
        $('#organizationaddressPanel').fadeToggle();
    });
}) (jQuery);
</script>
@endsection