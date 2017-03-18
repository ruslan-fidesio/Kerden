@extends('layouts.backend')

@section('headers')
<link rel="stylesheet" type="text/css" href="{{ asset('css/resume.css') }}">
@endsection

@section('content')
<div class="container">
	<div class="panel panel-kerden-home">
		<div class="panel-heading">Annulation de la réservation</div>
		<div class="panel-body">
			Vous avez demandé l'annulation d'une réservation.<br/>
			Conformément aux <a href="#" data-toggle="modal" data-target="#cguModal">Conditions Générales d'Utilisation</a>, l'intégralité de la somme versée par le locataire lui sera reversée.<br/>
			En outre, vous écopez d'une pénalité forfaitaire de 50€, à retenir sur vos prochains gains.

			<div class="row text-center">
				<div class='checkbox'>
                <label>
                    <input name="understood" type="checkbox" id="understood">
                    <b>J'ai compris et j'accèpte les conditions.</b>
                </label>
            </div>
			</div>
			<div class="row text-center">
				<a href="{{url('/annulation/confirmByOwner/'.$id)}}" onclick='return checkUnderstood()' class='btn btn-kerden-confirm'>Confirmer l'annulation</a>
					<button class="btn btn-kerden-cancel" onclick='history.back()'>Revenir en arrière</button>
			</div>
		</div>
	</div>
</div>

@include('footer')

@endsection

@section('scripts')
<script type="text/javascript">
function checkUnderstood(){
	if(! $('#understood').is(':checked')){
		alert('Merci d\'accepter les conditions de remboursements.');
		return false;
	}
	return true;
}
</script>
@endsection