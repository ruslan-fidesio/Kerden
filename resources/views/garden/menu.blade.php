@extends('layouts.backend')



@section('content')

<div class="container-fluid">
	<div class="col-sm-3 left-home-menu kerden-page-1">
    <h4 class="gardenMenuCaption">{{$garden->title}}</h4>
		<ul class="" role="menu">
          <a class="left-menu-link active" href="{{ url('/garden/update/'.$garden->id) }}"><li>Informations</li></a>
          <a class="left-menu-link" href="{{ isset($menuUnavaible)? '#' : url('/garden/infosLoc/'.$garden->id) }}"><li>Infos locataire</li></a>
          <a class="left-menu-link" href="{{ isset($menuUnavaible)? '#' : url('/garden/details/'.$garden->id) }}"><li>Critères</li></a>
          <a class="left-menu-link" href="{{ isset($menuUnavaible)? '#' : url('/garden/prices/'.$garden->id) }}"><li>Tarifs & Créneaux horaires</li></a>
          <a class="left-menu-link" href="{{ isset($menuUnavaible)? '#' : url('/garden/dispo/'.$garden->id) }}"><li>Calendrier</li></a>
          <a class="left-menu-link" href="{{ isset($menuUnavaible)? '#' : url('/garden/staff/'.$garden->id) }}"><li>Oscardiens</li></a>
          <a class="left-menu-link" href="{{ isset($menuUnavaible)? '#' : url('/garden/images/'.$garden->id) }}"><li>Photos</li></a>
          <!-- <a class="left-menu-link" href="{{ url('/garden/reservations/'.$garden->id) }}"><li>Réservations</li></a> -->
          <a class="left-menu-link" href="{{ isset($menuUnavaible)? '#' :url('/view/'.$garden->id)}}"><li>Aperçu de l'annonce</li></a>
          @if($garden->owner_masked)
            <a class="left-menu-link" href="{{ isset($menuUnavaible)? '#' :url('/garden/unmask/'.$garden->id)}}"><li>Rendre mon annonce visible <i class="fa fa-eye"></i></li></a>
          @else
            <a class="left-menu-link" href="{{ isset($menuUnavaible)? '#' :url('/garden/mask/'.$garden->id)}}"><li>Masquer mon annonce <i class="fa fa-eye-slash"></i></li></a>
          @endif
          <a href="{{url('/garden/create')}}"><li>Louer un autre jardin</li></a>
      </ul>
	</div>

  <div class="col-sm-9 kerden-page-2">
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

  @include('footer')

@endsection