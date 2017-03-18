@extends('admin.menu')

@section('contentPane')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-kerden-home">
                <div class="panel-heading">Liste Utilisateurs</div>
                <div class="panel-body">
                    @if($errors->has('listUser'))
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        Impossible d'effectuer l'opération : {{$errors->first('listUser')}}
                    </div>
                    @endif

                    <form action="" id="userFilter">
                        <label for="userStatus">Afficher : </label>
                        <select name="userStatus" id="userStatus" onChange="document.getElementById('userFilter').submit()">
                            <option value="all" {{ $userStatus=='all'?'selected':'' }}>Tous</option>
                            <option value="admins" {{ $userStatus=='admins'?'selected':'' }}>Admin</option>
                            <option value="owners" {{ $userStatus=='owners'?'selected':'' }}>Propriétaires</option>
                            <option value="notOwners" {{ $userStatus=='notOwners'?'selected':'' }}>Locataires</option>
                        </select>
                    </form>

                    <hr>

                	<table class="table table-striped">
                		<thead><th>Id</th><th>Nom</th><th>Statut</th><th>Actions</th><th></th></thead>
                		@foreach($users as $user)
                			<tr>
                				<td>{{$user->id}}</td>
                				<td><a href="{{url('/admin/user/'.$user->id)}}">{{$user->fullName}}</a></td>
                				<td>@if($user->blocked)
                                        <i class="fa fa-times" style='color:red'>bloqué</i>
                                    @else
                                    {{$user->role->role}}
                                    @endif
                                </td>
                				<td>
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

                				</td>
                                <td>
                                    @if($user->blocked)
                                    <a href="{{url('/admin/unblockUser/'.$user->id)}}"><div class="btn btn-danger">Débloquer</div></a>
                                    @else
                                    <a href="{{url('/admin/blockUser/'.$user->id)}}"><div class="btn btn-danger">Bloquer</div></a>
                                    @endif
                                </td>

                			</tr>
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
    $('.left-menu-link:nth-child(1)').addClass('active');
}) (jQuery);
</script>
@endsection