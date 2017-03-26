@extends('layouts.backend')


@section('content')

<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">Détails de l'utilisateur</div>
		<div class="panel-body">
			@if($errors->has('listUser'))
			<div class="alert alert-danger">
				{{$errors->first('listUser')}}
			</div>
			@endif
			<div class="row">
				<div class="col-xs-12">
					<a href="{{url('/admin/users')}}"><div class="btn btn-warning">Retour à la liste</div></a>
				</div>
				<div class="col-xs-12">
					<h3>{{$user->fullName}}</h3>
					<span>Statut : </span>{{$user->role->role}}
					<span>Type : </span>{{ $user->details->type}}
				</div>
				<div class="col-xs-12">
					Adresse : {{$user->details->fullAddress}}
				</div>
				<div class="col-xs-12">
					Date de naissance : {{$user->details->birthday}}
				</div>
				<div class="col-xs-12">
					Téléphone : @if( $user->phone && $user->phone->phone != "noPhone" ) {{$user->phone->phone}} @else N/A @endif
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-12">E-mail : {{$user->email}}</div>
				<div class="col-xs-12"> <a href="mailto:{{$user->email}}"><i class="fa fa-envelope"></i>Écrire un mail</a> </div>
			</div>
			<hr>
			<div class="row">
				<a href="{{ url('/admin/proofOfId/'.$user->id) }}">
                    <div class="btn btn-primary">Identité</div>
                </a>
				/
				<a href="{{ url('/admin/bank/'.$user->id) }}">
                    <div class="btn btn-primary">RIB</div>
                </a>
                @if($user->role->role != 'owner' && $user->role->role != 'admin')
                /
                <a href="{{ url('/admin/setOwner/'.$user->id) }}"><div class="btn btn-primary"> Propriétaire </div></a>
                @endif

                @if($user->blocked)
	            <a href="{{url('/admin/unblockUser/'.$user->id)}}"><div class="btn btn-danger">Débloquer</div></a>
	            @else
	            <a href="{{url('/admin/blockUser/'.$user->id)}}"><div class="btn btn-danger">Bloquer</div></a>
	            @endif
			</div>
		</div>
	</div>
</div>

@endsection