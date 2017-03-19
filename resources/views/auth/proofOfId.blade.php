@extends('auth.menu')


@section('contentPane')
	<div class="panel panel-kerden-home">
		<div class="kerden-back-button">Retour</div>
		<div class="panel-heading">Preuve d'identité
			@if(!empty($userFromAdmin))
				pour l'utilisateur {{$userFromAdmin->fullName}}
			@endif
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<h4>Que puis-je envoyer</h4>
					Pour prouver votre identité, envoyez une photocopie de votre carte d'identité recto-verso, ou de votre passeport. Le document envoyé doit être valide et non-expiré.
					<h4>Comment ça marche?</h4>
					Choisissez simplement un fichier avec le bouton ci-dessous, puis cliquez sur 'Envoyer'.
					<br/>
					Votre preuve d'identité peut être aux formats .jpg, .png, .gif ou .pdf.<br/>
					La taille du fichier de doit pas dépasser 7Mb.
					<h4>Que faites-vous de mes données?</h4>
					Nous ne gardons rien! <br/>
					Nous transmettons directement votre document à notre partenaire MangoPay&copy;, qui s'occupe de vérifier MANUELLEMENT la validité de chaque document. Ce procédé prend en moyenne 24h.

					<hr/>
				{!! Form::open(['files'=>true]) !!}

				@if(!empty($userFromAdmin))
					{!! Form::hidden('userIdFromAdmin',$userFromAdmin->Id) !!}
				@endif


				{!! Form::file('proofOfId',['accept'=>'.pdf,.jpeg,.jpg,.gif,.png', 'id'=>'proofOfId']) !!}

				{!! Form::submit('Envoyer',['class'=>'btn btn-kerden-confirm']) !!}

				{!! Form::close() !!}
				</div>
				<div class="col-md-6">
					<div class="thumbnail">
						<img src="" id='preview'>
					</div>
				</div>
			</div>
			

			@if(Auth::user()->role->role == 'admin')
			<div class="row">
				<hr/>
				Document existants
				<table class="table table-striped">
                	<thead><th>ressourceId</th> <th>Date d'envoi</th> <th>Statut</th> </thead>
                	@if(!empty($docs))
	                	@foreach($docs as $doc)
	                		<tr>
	                			<td>{{$doc->ressource_id}}</td>
	                			<td>{{ $doc->created_at}}</td>
	                			<td>{{$doc->state}}
	                				@if(!empty($userFromAdmin))
	                				<a target="_blank" href="https://dashboard.mangopay.com/Users/{{$userFromAdmin->mangoUser->mangoUserId}}/KycDetails/{{$doc->ressource_id}}">Voir</a>
	                				@endif
	                			 </td>
	                		</tr>
	                	@endforeach
	                @endif
                </table>
			</div>
			@endif

			@if (Auth::User()->details->type == 'legal' || (!empty($userFromAdmin) && $userFromAdmin->details->type == 'legal') )
				<div class="row">
					<h2>Documents relatifs à l'entreprise</h2>
					<table class="table">
						<thead><th>Type de document</th><th>Status</th><th>Actions</th></thead>
						<tr>
							<td>Statuts de l'organisation</td>
							<td>
								@if ($statusFile)
									{{$statusFile->Status}}
								@else
									-Pas de fichier-
								@endif
							</td>
							<td>
								@if ($statusFile && ($statusFile->Status == 'VALIDATED' || $statusFile->Status == "VALIDATION_ASKED"))
									<i class="fa fa-hourglass-half"></i>
								@else
									<a href="#" data-toggle="modal" data-target="#sendStatus" class="btn btn-primary">Envoyer</a>
								@endif
							</td>
						</tr>
						<tr>
							<td>Extrait Registre Officiel (KBIS/SIRET/RNA)</td>
							<td>
								@if ($kbisFile)
									{{$kbisFile->Status}}
								@else
									-Pas de fichier-
								@endif
							</td>
							<td>
								@if ($kbisFile && ($kbisFile->Status == 'VALIDATED' || $kbisFile->Status == "VALIDATION_ASKED"))
									<i class="fa fa-hourglass-half"></i>
								@else
									<a href="#" data-toggle="modal" data-target="#sendKBIS" class="btn btn-primary">Envoyer</a>
								@endif
							</td>
						</tr>
						@if ($organization->type == 'BUSINESS')
						<tr>
							<td>Déclaration des propriétaires</td>
							<td>
								@if ($shareHoldFile)
									{{$shareHoldFile->Status}}
								@else
									-Pas de fichier-
								@endif
							</td>
							<td>
								@if ($shareHoldFile && ($shareHoldFile->Status == 'VALIDATED' || $shareHoldFile->Status == "VALIDATION_ASKED"))
									<i class="fa fa-hourglass-half"></i>
								@else
									<a class="btn btn-warning" target="_blank" href="https://www.mangopay.com/terms/shareholder-declaration/Shareholder_Declaration-EN.pdf" download>Télécharger</a>
									<a href="#" data-toggle="modal" data-target="#sendSharehold" class="btn btn-primary">Envoyer</a>
								@endif
							</td>
						</tr>
						@endif
					</table>
				</div>
			@endif

		</div>
	</div>

	<div class="modal fade"  id="sendStatus" tabindex="-1" role="dialog">
	    <div class="modal-dialog" style="font-family:'Avenir Next'">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Status de l'organisation</h4>
	            </div>
	            <div class="modal-body">
	                {!! Form::open(['files'=>true]) !!}

					@if(!empty($userFromAdmin))
						{!! Form::hidden('userIdFromAdmin',$userFromAdmin->Id) !!}
					@endif


					{!! Form::file('status',['accept'=>'.pdf,.jpeg,.jpg,.gif,.png', 'id'=>'status']) !!}

					{!! Form::submit('Envoyer',['class'=>'btn btn-kerden-confirm']) !!}

					{!! Form::close() !!}
	            </div>
	        </div>
	    </div>
	</div>
	<div class="modal fade"  id="sendKBIS" tabindex="-1" role="dialog">
	    <div class="modal-dialog" style="font-family:'Avenir Next'">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Extrait KBIS</h4>
	            </div>
	            <div class="modal-body">
	                {!! Form::open(['files'=>true]) !!}

					@if(!empty($userFromAdmin))
						{!! Form::hidden('userIdFromAdmin',$userFromAdmin->Id) !!}
					@endif


					{!! Form::file('kbis',['accept'=>'.pdf,.jpeg,.jpg,.gif,.png', 'id'=>'kbis']) !!}

					{!! Form::submit('Envoyer',['class'=>'btn btn-kerden-confirm']) !!}

					{!! Form::close() !!}
	            </div>
	        </div>
	    </div>
	</div>
	<div class="modal fade"  id="sendSharehold" tabindex="-1" role="dialog">
	    <div class="modal-dialog" style="font-family:'Avenir Next'">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Déclaration des copropriétaires</h4>
	            </div>
	            <div class="modal-body">
	                {!! Form::open(['files'=>true]) !!}

					@if(!empty($userFromAdmin))
						{!! Form::hidden('userIdFromAdmin',$userFromAdmin->Id) !!}
					@endif


					{!! Form::file('sharehold',['accept'=>'.pdf,.jpeg,.jpg,.gif,.png', 'id'=>'sharehold']) !!}

					{!! Form::submit('Envoyer',['class'=>'btn btn-kerden-confirm']) !!}

					{!! Form::close() !!}
	            </div>
	        </div>
	    </div>
	</div>

@endsection

@section('scripts')
<script type="text/javascript">
function readAndLoadURL(input){
	if(input.files && input.files[0]){
		var rdr = new FileReader();
		rdr.onload = function(e){
			$('#preview').attr('src',e.target.result);
		};
		rdr.readAsDataURL(input.files[0]);
	}
}

(function($){
	$('#proofOfId').change(function(){
		readAndLoadURL(this);
	});
	$('.HPMenuLink').removeClass('active');
    $('.userMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    @if (Auth::User()->details->type == 'legal')
    	$('.left-menu-link:nth-child(2)').addClass('active');
    @else
    	$('.left-menu-link:nth-child(3)').addClass('active');
    @endif
    showPage2();

}) (jQuery);
</script>

@endsection
