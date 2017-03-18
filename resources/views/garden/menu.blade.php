@extends('layouts.backend')



@section('content')

<div class="container-fluid">
	<div class="col-sm-3 left-home-menu kerden-page-1">
    <h4 class="gardenMenuCaption">{{$garden->title}}</h4>
		<ul class="" role="menu">
          <a class="left-menu-link active" href="{{ url('/garden/update/'.$garden->id) }}"><li>Informations</li></a>
          @if(isset($menuUnavaible))
          @else
            <a class="left-menu-link" href="{{ url('/garden/infosLoc/'.$garden->id) }}"><li>Infos locataire</li></a>
            <a class="left-menu-link" href="{{ url('/garden/details/'.$garden->id) }}"><li>Critères</li></a>
            <a class="left-menu-link" href="{{ url('/garden/prices/'.$garden->id) }}"><li>Tarifs & Créneaux horaires</li></a>
            <a class="left-menu-link" href="{{ url('/garden/dispo/'.$garden->id) }}"><li>Calendrier</li></a>
            <a class="left-menu-link" href="{{ url('/garden/staff/'.$garden->id) }}"><li>Oscardiens</li></a>
            <a class="left-menu-link" href="{{ url('/garden/images/'.$garden->id) }}"><li>Photos</li></a>
            <!-- <a class="left-menu-link" href="{{ url('/garden/reservations/'.$garden->id) }}"><li>Réservations</li></a> -->
            <a class="left-menu-link" href="{{url('/view/'.$garden->id)}}"><li>Aperçu de l'annonce</li></a>
            @if($garden->owner_masked)
              <a class="left-menu-link" href="{{url('/garden/unmask/'.$garden->id)}}"><li>Rendre mon annonce visible <i class="fa fa-eye"></i></li></a>
            @else
              <a class="left-menu-link" href="{{url('/garden/mask/'.$garden->id)}}"><li>Masquer mon annonce <i class="fa fa-eye-slash"></i></li></a>
            @endif
            <a href="{{url('/garden/create')}}"><li>Louer un autre jardin</li></a>
          @endif
      </ul>
	</div>

  <div class="col-sm-9 kerden-page-2">
    @yield('contentPane')
  </div>

</div>

  @include('footer')

@endsection