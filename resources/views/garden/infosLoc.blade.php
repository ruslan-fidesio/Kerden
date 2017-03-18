@extends ('garden.menu')

@section('contentPane')
<div class="kerden-back-button">Retour
</div>
	<h1>{{$garden->title}}</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-kerden-home">
            	@if(isset($message))
                	<div class="alert alert-success fade in">
                		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                		{{$message}}
                	</div>
            	@endif
                <div class="panel-heading">Informations Locataire</div>
                <div class="panel-body infosLocBody">
                    Ces informations seront communiquées au locataire, uniquement lorsqu'une réservation sera confirmée et payée.

				{!! Form::open(['class'=>'form-horizontal']) !!}

				<div class="col-md-6 col-xs-12" style='margin:15px 0px'>
					<label for="digicode" class='control-label col-xs-4'>Digicode :</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="digicode"
						@if($infos->where('type','DIGICODE')->count() > 0)
							value="{{$infos->where('type','DIGICODE')->first()->value}}"
						@else
							placeholder="Informations non obligatoire"
						@endif>
					</div>
				</div>

				<div class="col-md-6 col-xs-12" style='margin:15px 0px'>
					<label for="interphone" class='control-label col-xs-4'>Interphone :</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="interphone" 
						@if($infos->where('type','INTERPHONE')->count() > 0)
							value="{{$infos->where('type','INTERPHONE')->first()->value}}"
						@else
							placeholder="Informations non obligatoire"
						@endif
						>
					</div>
				</div>

				<div class="col-md-6 col-xs-12" style='margin:15px 0px'>
					<label for="etage" class='control-label col-xs-4'>Étage :</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="etage" 
						@if($infos->where('type','ETAGE')->count() > 0)
							value="{{$infos->where('type','ETAGE')->first()->value}}"
						@else
							placeholder="Informations non obligatoire"
						@endif
						>
					</div>
				</div>

				<div class="col-md-6 col-xs-12" style='margin:15px 0px'>
					<label for="batiment" class='control-label col-xs-4'>Bâtiment :</label>
					<div class="col-xs-8">
						<input type="text" class="form-control" name="batiment" 
						@if($infos->where('type','BATIMENT')->count() > 0)
							value="{{$infos->where('type','BATIMENT')->first()->value}}"
						@else
							placeholder="Informations non obligatoire"
						@endif
						>
					</div>
				</div>

				<div class="col-xs-12" style='margin:15px 0px'>
					<label style='margin:8px 0px' for="autre" class='control-label col-xs-12'>Informations complémentaires :</label>
					<div class="col-xs-12">
						<input type="text" class="form-control" name='autre'
						@if($infos->where('type','AUTRE')->count() > 0)
							value="{{$infos->where('type','AUTRE')->first()->value}}"
						@else
							placeholder="Informations non obligatoire"
						@endif
						>
					</div>
				</div>

				<hr>

				<div class="col-xs-12" style='margin:15px 0px'>
					<label for="usephone" class="control-label col-xs-6">J'accèpte que le locataire me contacte par téléphone :</label>
					<div class="col-xs-6">
						<input type="radio" name="usephone" value="1"
						@if($usephone && $usephone->value==='1')
							checked
						@endif> Oui <br>
						<input type="radio" name="usephone" value="0"
						@if($usephone && $usephone->value==='0')
							checked
						@endif
						> Non
					</div>
				</div>

				<div class="col-xs-12" style='margin:15px 0px'>
					<label for="guestscansee" class="control-label col-xs-6">J'accèpte que tous les invités aient ces informations :</label>
					<div class="col-xs-6">
						<input type="radio" name="guestscansee" value="1"
						@if($guestscansee && $guestscansee->value==='1')
							checked
						@endif> Oui <br>
						<input type="radio" name="guestscansee" value="0"
						@if($guestscansee && $guestscansee->value==='0')
							checked
						@endif
						> Non
					</div>
					<span class="helper">Par défaut, seul le locataire a accès à ces infos. Vous pouvez l'authoriser à divulger ces infos à ses invités directement sur les cartes d'invitation créées par Kerden.</span>
				</div>



				<div class="form-group">
                    <a href="/home"><div class='col-xs-6 text-right'>{!! Form::button(trans('auth.cancel'),['class'=>'btn btn-kerden-cancel']) !!}</div></a>
                    <div class='col-xs-6'>{!! Form::submit(trans('base.save'),['class'=>'btn btn-kerden-confirm']) !!}</div>
                </div>

				{!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $('.HPMenuLink').removeClass('active');
    $('.gardenMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(2)').addClass('active');
    showPage2();
</script>
@endsection