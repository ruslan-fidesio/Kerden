@extends('layouts.app')

@section('headers')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-kerden">
                <div class="panel-heading text-center">Connexion</div>
                <div class="panel-body">
                    @if(isset($errors) && !empty($errors->first()))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{$errors->first()}}
                    </div>
                    @endif
                    <a class="providerLink" href='/google/login'>
                        <div class="provider googleLogin">
                            <img src="https://developers.google.com/identity/images/g-logo.png" >
                            <span>Connexion avec Google</span>
                        </div>
                    </a>

                    <a class="providerLink" href="/facebook/login">
                        <div class="provider facebookLogin" >
                            <img src="{{asset('images/logos/FB_blue.png')}}">
                            <span>Connexion avec Facebook</span>
                        </div>
                    </a>

                    <div class="row or text-center">OU</div>

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Se souvenir de moi
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Connexion
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Mot de passe oublié?</a>
                            </div>
                        </div>
                    </form>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{url('/register')}}">Pas encore inscrit?
                                <div class="btn btn-kerden" style='margin-left:50px'>Inscrivez vous</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
