@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans( 'auth.register' )}}</div>
                <div class="panel-body">
                    @if( !empty(session('error')))
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{session()->get('error')}}
                    </div>
                    @endif

                    <div class="alert alert-info fade in">
                        <a href="{{url('/login')}}">Déjà inscrit?  Connexion</a>
                    </div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}" autocomplete="off">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.last_name')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.first_name')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.email')}}</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.email_confirmation')}}</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email_confirmation" value="{{ old('email_confirmation') }}">

                                @if ($errors->has('email_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.password')}}</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">{{trans('validation.attributes.password_confirmation')}}</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-6 control-label">{{trans('userdetails.iamlegal')}}</label>

                            <div class="col-md-1">
                                <input type="checkbox" class="form-control" name="iamlegal">
                            </div>
                        </div>

                        <div class="col-md-6 col-md-offset-4">
                            {!! Recaptcha::render() !!}

                            @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block" style="color:red;">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> {{trans('auth.register')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
