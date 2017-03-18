@if($role == 'new')

<div class="alert alert-warning">
	{!! trans('auth.pleaseconfirmemail',['link'=>url('/sendmailconfirmation')]) !!}
</div>

@else
	@if ($role == 'confirmed')
	<div class="alert alert-warning">
		{!! trans('userdetails.pleasedetails',['link'=>url('/userdetails')]) !!}
	</div>

	@else
		@if($role == 'light')
			@if(Auth::user()->kycDocuments->where('state','asked')->count() > 0)
				<div class="alert alert-info">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Vous avez actuellement une preuve d'identité en attente de validation.<br/>
					Vous serez prévenu par mail de l'acceptation ou du refus de celui-ci.
				</div>
			@else
				@if(Auth::user()->kycDocuments->where('state','refused')->count() > 0)
					<div class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						Vous avez envoyé une preuve d'identité qui a été refusée.<br/>
						Merci de bien vouloir envoyer un autre document.
					</div>
				@endif
			@endif
		@endif
	@endif
@endif



<div>
	Bienvenue dans votre espace membre.
</div>