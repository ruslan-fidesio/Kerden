@extends ('layouts.app')

@section('navbar')
<div class="navbar navbar-inverse navbar-fixed-left">
  <a class="navbar-brand" href="/home">Espace membre</a>
  <ul class="nav navbar-nav">
   <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Mon compte<span class="caret"></span></a>
     <ul class="dropdown-menu" role="menu">
      <li><a href="{{url('/userdetails')}}">Modifier mes coordonnées</a></li>
      <li class="divider"></li>
      <li><a href="{{url('/user/advancedDetails')}}">Données avancées</a></li>
      <li class="divider"></li>
      <li><a href="{{url('/proofOfId')}}">Prouver mon identité</a></li>
      <li class='divider'></li>
      <li><a href="{{url('/rib')}}">Coordonnées bancaires</a></li>
      <li class='divider'></li>
      <li><a href="{{url('/changePassword')}}">Changer de Mot de Passe</a></li>
     </ul>
   </li>
   <li class="divider"></li>

@if( Auth::user() && count(Auth::user()->ownedGardens) > 0)
   <li><a href="#">
    @if( count(Auth::user()->ownedGardens) ==1 )
      Mon jardin
    @else
      Mes jardins
    @endif
    </a>
   @foreach(Auth::user()->ownedGardens as $garden)
   <div class="btn-group">
     <a href="#" class="garden-menu-title dropdown-toggle" data-toggle='dropdown'>{{$garden->title}}<span class="caret"></span></a>
     <ul class="dropdown-menu" role="menu">
          <li><a href="{{ url('/garden/update/'.$garden->id) }}">Informations</a></li>
          <li><a href="{{ url('/garden/details/'.$garden->id) }}">Critères</a></li>
          <li><a href="{{ url('/garden/prices/'.$garden->id) }}">Tarifs / Créneaux horaires</a></li>
          <li><a href="{{ url('/garden/dispo/'.$garden->id) }}">Calendrier</a></li>
          <li><a href="{{ url('/garden/staff/'.$garden->id) }}">Oscardiens</a></li>
          <li><a href="{{ url('/garden/images/'.$garden->id) }}">Photos</a></li>
          <li><a href="{{ url('/garden/reservations/'.$garden->id) }}">Réservations</a></li>
          <li><a href="{{url('/view/'.$garden->id)}}">Aperçu de l'annonce</a></li>
          @if($garden->owner_masked)
            <li><a href="{{url('/garden/unmask/'.$garden->id)}}">Rendre mon annonce visible</a></li>
          @else
            <li><a href="{{url('/garden/mask/'.$garden->id)}}">Masquer mon annonce</a></li>
          @endif
      </ul>
    </div>
   @endforeach
   </li>
   <li style='font-size:0.8em'><a href="{{url('/garden/create')}}">Louer un autre jardin</a></li>
@else
  @if(Auth::user()->id != env('OSCAR_USER_ID'))
  <li><a href="{{url('/rent')}}">Louer mon jardin</a></li>
  @endif
@endif

<li class="divider"></li>

    <li><a href="/reservations">Mes Réservations</a></li>

<li class="divider"></li>

@if(Auth::user() && Auth::user()->role->role == 'admin')
<li><a href=" {{url('/admin')}}">Menu ADMIN</a></li>
@endif

@if(Auth::user()->id == env('OSCAR_USER_ID'))
<li><a href="{{url('/oscar/menu')}}">Menu OSCAR</a></li>
@endif
  </ul>
</div>
@endsection