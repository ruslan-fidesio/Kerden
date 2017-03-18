@extends('admin.menu')

@section('contentPane')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-kerden-home">
                <div class="panel-heading">Espace Administrateur -> Liste Jardins</div>
                <div class="panel-body">
                    @if (session('error'))
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {!!session('error')!!}
                    </div>
                    @endif
                    <h4 style="color:green">Jardins validés</h4>
                	<table class="table table-striped">
                		<thead><tr><th>Id</th><th>Titre</th><th>Adresse</th><th>Propriétaire</th><th>Statut</th><th>Actions</th></tr></thead>
                		@foreach($gardens as $garden)
                            @if($garden->state == 'validated')
                    			<tr>
                    				<td>{{ $garden->id }}</td>
                    				<!-- <td><a href="{{url('/view/'.$garden->id)}}">{{ $garden->title }}</a></td> -->
                                    <td>
                                          <a href="#" class="garden-menu-title dropdown-toggle" data-toggle='dropdown'>{{$garden->title}}<span class="caret"></span></a>
     <ul class="dropdown-menu admin-dropdown-menu" role="menu">
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
                                    </td>
                    				<td>{{ $garden->address }}</td>
                    				<td>{{ $garden->owner->fullName }}</td>
                    				<td>
                                        @if($garden->owner->blocked)
                                            <i class="fa fa-times" style="color:red">bloqué</i>
                                        @elseif($garden->owner_masked)
                                            <i class="fa fa-eye-slash" style="color:red">masqué</i>
                                        @else
                                            {{ $garden->state }}
                                        @endif
                                    </td>
                    				<td><a href="{{ url('/admin/garden/photos/'.$garden->id) }}">Photos</a> |
                    				 @if($garden->state == 'validated')
                    				 <a href="{{ url('/admin/garden/unvalidate/'.$garden->id) }}">Invalider</a> |
                    				 @else
                    				 <a href="{{ url('/admin/garden/validate/'.$garden->id) }}">Valider</a> |
                    				 @endif
                    				 <a href="{{ url('/admin/garden/delete/'.$garden->id) }}" onclick="return confirm('{{trans('base.rusure')}}')">Supprimer</a></td>
                    			</tr>
                            @endif
                		@endforeach
					</table>

                    <h4 style="color:red">Jardins en attente</h4>
                    <table class="table table-striped">
                        <thead><tr><th>Id</th><th>Titre</th><th>Adresse</th><th>Propriétaire</th><th>Statut</th><th>Actions</th></tr></thead>
                        @foreach($gardens as $garden)
                            @if($garden->state !='validated')
                                <tr>
                                    <td>{{ $garden->id }}</td>
                                    <!-- <td><a href="{{url('/view/'.$garden->id)}}">{{ $garden->title }}</a></td> -->
                                    <td>
                                                                             <a href="#" class="garden-menu-title dropdown-toggle" data-toggle='dropdown'>{{$garden->title}}<span class="caret"></span></a>
     <ul class="dropdown-menu admin-dropdown-menu" role="menu">
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
                                    </td>
                                    <td>{{ $garden->address }}</td>
                                    <td>{{ $garden->owner->fullName }}</td>
                                    <td>{{ $garden->state }}</td>
                                    <td><a href="{{ url('/admin/garden/photos/'.$garden->id) }}">Photos</a> |
                                     @if($garden->state == 'validated')
                                     <a href="{{ url('/admin/garden/unvalidate/'.$garden->id) }}">Invalider</a> |
                                     @else
                                     <a href="{{ url('/admin/garden/validate/'.$garden->id) }}">Valider</a> |
                                     @endif
                                     <a href="{{ url('/admin/garden/delete/'.$garden->id) }}" onclick="return confirm('{{trans('base.rusure')}}')">Supprimer</a></td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
<script>
(function($){
    $('.HPMenuLink').removeClass('active');
    $('.adminMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(2)').addClass('active');
}) (jQuery);
</script>
@endsection