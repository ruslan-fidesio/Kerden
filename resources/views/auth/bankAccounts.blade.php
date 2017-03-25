@extends('auth.menu')

@section('headers')
<style type="text/css">
.bankAcc{
	border:1px solid grey;
	padding:7px;
}

.bankAcc.active{
	background-color: lightgreen;
}
</style>
@endsection

@section('contentPane')
	<div class="panel panel-kerden-home">
		<div class="kerden-back-button" >Retour</div>
		<div class="panel-heading">Coordonnées bancaires</div>
		<div class="panel-body">
			<h3>{{$user->fullName}}</h3>
			<h4>Comptes enregistrés :</h4>
			@if(!$active)
				<span style='color:red;font-size:2em'>Pas de compte actif</span>
			@endif

			@if(!empty($accounts) )

				@foreach($accounts as $account)
					<div class='bankAcc {{$account->Id==$active?"active":""}}'>
						IBAN : {{$account->Details->IBAN}}<br/>
						BIC : {{$account->Details->BIC}}<br/>
						@if($account->Id == $active)
						<div class="btn btn-kerden" style='cursor:default'>Compte actif</div>
						@else
						{!! Form::open() !!}
						{!! Form::hidden('account_id',$account->Id) !!}
						{!! Form::submit('Choisir comme compte actif',['class'=>'btn btn-primary']) !!}
						{!! Form::close() !!}
						@endif
					</div>
				@endforeach

			@else
				Pas de compte enregistré
			@endif




			<hr/>
			<a href="{{url('/addBankAccount/')}}">+ Ajouter un compte</a>
			
		</div>
	</div>
@endsection

@section('scripts')
<script>
(function($){
    $('.HPMenuLink').removeClass('active');
    $('.userMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    @if (Auth::user() && Auth::user()->details && Auth::user()->details->type == 'natural')
    	$('.left-menu-link:nth-child(4)').addClass('active');
    @else
    	$('.left-menu-link:nth-child(3)').addClass('active');
    @endif
    showPage2();
}) (jQuery);
</script>
@endsection