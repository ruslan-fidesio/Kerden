@extends('layouts.backend')

@section('content')
<div class="admin-bg">
  <h1 class="text-center">{{$garden->title}}</h1>
</div>

<div class="side-container">
  <div class="side-bg">
    <div class="col-md-4 grey-bg">
    </div>
    <div class="col-md-8 white-bg">
    </div>
  </div>
  <div class="container">
    <div class="tabbable side-padding">
    	<div class="col-sm-3">
    		<ul class="nav nav-pills-stacked" role="menu">
              <li class="left-menu-link active"><a href="{{ url('/garden/update/'.$garden->id) }}">Informations</a></li>
                <li class="left-menu-link"><a href="{{ isset($menuUnavaible)? '#' : url('/garden/infosLoc/'.$garden->id) }}">Infos locataire</a></li>
                <li class="left-menu-link"><a href="{{ isset($menuUnavaible)? '#' : url('/garden/details/'.$garden->id) }}">Critères</a></li>
                <li class="left-menu-link"><a href="{{ isset($menuUnavaible)? '#' : url('/garden/prices/'.$garden->id) }}">Tarifs & Créneaux horaires</a></li>
                <li class="left-menu-link"><a href="{{ isset($menuUnavaible)? '#' : url('/garden/dispo/'.$garden->id) }}">Calendrier</a></li>
                <li class="left-menu-link"><a href="{{ isset($menuUnavaible)? '#' : url('/garden/staff/'.$garden->id) }}">Oscardiens</a></li>
                <li class="left-menu-link"><a href="{{ isset($menuUnavaible)? '#' : url('/garden/images/'.$garden->id) }}">Photos</a></li>
                <!-- <li class="left-menu-link" href="{{ url('/garden/reservations/'.$garden->id) }}"><li>Réservations</a></li> -->
                <li class="left-menu-link"><a href="{{isset($menuUnavaible)? '#' : url('/view/'.$garden->id)}}">Aperçu de l'annonce</a></li>
                @if($garden->owner_masked)
                  <li class="left-menu-link"><a href="{{isset($menuUnavaible)? '#' : url('/garden/unmask/'.$garden->id)}}">Rendre mon annonce visible <i class="fa fa-eye"></i></a></li>
                @else
                  <li class="left-menu-link"><a href="{{isset($menuUnavaible)? '#' : url('/garden/mask/'.$garden->id)}}">Masquer mon annonce <i class="fa fa-eye-slash"></i></a></li>
                @endif
                <li><a href="{{isset($menuUnavaible)? '#' : url('/garden/create')}}">Louer un autre jardin</a></li>
          </ul>
    	</div>

      <div class="col-sm-8 col-sm-offset-1">
         @if(isset($message))
              <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{$message}}
              </div>
          @endif
          @if(isset($error))
              <div class="alert alert-danger fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{$error}}
              </div>
          @endif
        @yield('contentPane')
      </div>
    </div>
  </div>
</div>

  @include('footer')

@endsection