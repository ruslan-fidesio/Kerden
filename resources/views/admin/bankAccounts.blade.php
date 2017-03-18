@extends('layouts.backend')

@section('headers')
<style type="text/css">
.bankAcc{
	border:1px solid grey;
}

.bankAcc.active{
	background-color: lightgreen;
}
</style>
@endsection

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">Coordonnées bancaires</div>
		<div class="panel-body">
			<h3>{{$user->fullName}}</h3>
			<h4>Comptes enregistrés :</h4>
			@if(!$active)
				<span style='color:red;font-size:2em'>Pas de compte actif</span>
			@endif

			@if(!empty($accounts) )

				{!! Form::open() !!}
				@foreach($accounts as $account)
					<div class='bankAcc {{$account->Id==$active?"active":""}}'>
						{!! Form::radio('account_id',$account->Id,$account->Id == $active) !!}
						IBAN : {{$account->Details->IBAN}}<br/>
						BIC : {{$account->Details->BIC}}<br/>
					</div>
				@endforeach

				{!! Form::submit('Modifier', ['class'=>'btn btn-primary']) !!}
				{!!Form ::close() !!}
			@else
				Pas de compte enregistré
			@endif




			<hr/>
			<a href="{{url('/admin/addBankAccount/'.$user->id)}}">+ Ajouter un compte</a>
			
		</div>
	</div>
</div>
@endsection