@extends('layouts.backend')

@section('content')
<div class="admin-bg">
  <h1 class="text-center">Espace membre</h1>
</div>

<div class="container">
    <div class="side-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-kerden-home">
                    @if (isset($message))
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {!!$message!!}
                    </div>
                    @endif
                    @if (isset($error))
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {!!$error!!}
                    </div>
                    @endif

                    @if($needNewPass)
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle" style='font-size:2em'></i>
                            Vous utilisez toujours le mot de passe par défaut du site!!!<br/>
                            <a href=" {{ url('/changePassword') }} ">Changez de mot de passe!</a>
                        </div>
                    @endif

                    <div class="panel-body">
                        @include('rolecheck')
                        
                        @if(Auth::user()->ownedGardens->count()>0 &&
                         ( Auth::user()->role->role != 'owner' && Auth::user()->role->role != 'admin' ) )
                        <hr/>
                            <h2>Location de votre jardin</h2>
                            <h4>Merci d'avoir enregistré votre jardin sur Kerden.fr</h4>
                            @if( Auth::user()->role->role == 'light' )
                            <p>
                                Avant que votre jardin soit visible sur le site, nous devons nous assurer que vous êtes réellement le propriétaire de cet endroit.<br/>
                                <a href="{{url('/proofOfId')}}">Cliquez ici pour prouver votre identité.</a>
                            </p>
                            @endif
                            @if( ! Auth::user()->mangoBankAccount )
                            <p>
                                Afin que les revenus générés vous soient versés, nous avons aussi besoin de vos coordonées bancaires.<br/>
                                Pour que nous puissions recueillir ces informations, <a href="{{url('/rib')}}">Cliquez ici</a>.<br/>
                            </p>
                            @endif
                            N'hésitez pas à <a href="mailto:contact@kerden.fr">nous contacter</a> pour obtenir de l'aide.
                            <hr/>
                        @endif

                        @include('maskedGardens')

                        @include('checkReservations')

                        @include('checkCommentaires')

                        @include('checkPenalite')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')

@endsection


