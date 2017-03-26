@extends('layouts.app')

@section('content')
<div class="subscribe-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{trans( 'auth.register' )}}</div>
                    <div class="panel-body">
                        @if( !empty(session('error')))
                        <div class="alert alert-danger fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{session()->get('error')}}
                        </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}" autocomplete="off">
                            {!! csrf_field() !!}


                            <div class="form-group">
                                <label class="col-md-4 control-label">Statut</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="iamlegal">
                                        <option value='false'>Particulier</option>
                                        <option value='true'>Professionnel</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">{{trans('validation.attributes.last_name')}}</label>

                                <div class="col-md-4">
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

                                <div class="col-md-4">
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

                                <div class="col-md-4">
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

                                <div class="col-md-4">
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

                                <div class="col-md-4">
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

                                <div class="col-md-4">
                                    <input type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="checkbox-form-group form-group{{ $errors->has('acceptCGU') ? ' has-error' : '' }}">
                                <div class="col-md-4">
                                    <input class="form-control" type="checkbox" name="acceptCGU">
                                </div>        
                                <div class="col-md-4">                    
                                    <label class="control-label">J'accepte les <a href='/cgu' target="_blank">Conditions Générales d'Utilisation</a> et la <a href='#' data-toggle='modal' data-target='#privacy'>charte de vie privée</a></label>
                                </div>

                            </div>

                            <div class="col-md-4 col-md-offset-4">
                                {!! Recaptcha::render() !!}

                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block" style="color:red;">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4 text-center">
                                    <button type="submit" class="btn btn-kerden-confirm">
                                       Valider
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">

                        <a href="{{url('/login')}}">Déjà inscrit?  Connexion</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
@endsection
