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
    $('.left-menu-link:nth-child(3)').addClass('active');
    showPage2();

}) (jQuery);
</script>

@endsection
