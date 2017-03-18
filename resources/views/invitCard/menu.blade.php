@extends('layouts.backend')


@section('content')

<div class="container-fluid" >
<h3 class="text-center" style='margin-bottom:50px; font-family:"Avenir Next" '>Carte d'invitation</h3>
<div style='margin-left:15px'>
	<a href="{{ url('/reservation/view/'.$reservation->id) }}">
		<div class="btn btn-kerden-confirm"><< Retour à la réservation</div>
	</a>
</div>

<div class="col-md-4 cardPreviewMenu">
	<form action="#" onsubmit="return false;" id="cardMenu">
		<label class='mainLabel' for="title" style='margin-top:15px'>Intitulé : </label>
		<input type="text" name="title" placeholder="Anniversaire..." class='form-control'>
		<br>
		<hr style='margin:4px 25%;width:50%'>
		<label class='mainLabel' for="format">Format : </label>
		<div class="form-group">
			<div class="radio">
				<label><input type="radio" name="format" value="A4" checked/> A4 (21cm x 29,7cm)</label>
			</div>
			<div class="radio">
				<label><input type="radio" name="format" value="A5"/> A5 (14,8cm x 21cm)</label>
			</div>
			<div class="radio">
				<label><input type="radio" name="format" value="A6"/> A6 - carte postale (10,5cm x 14,8cm)</label>
			</div>
			<div class="radio">
				<label><input type="radio" name="format" value="A4-4"/> A4 planche contact - 4 cartes</label>
			</div>
			<div class="radio">
				<label><input type="radio" name="format" value="A4-8"/> A4 planche contact - 8 cartes</label>
			</div>
			<div class="radio">
				<label><input type="radio" name="format" value="A4-16"/> A4 planche contact - 16 cartes</label>
			</div>
		</div>
		<hr style='margin:4px 25%;width:50%'>
		<label class='mainLabel' for="background">Thème : </label>
		<div class="form-group">
			@foreach( array('anniv1', 'anniv2', 'fleur', 'chateau', 'cocktail') as $k=>$name)
				<div class="form-check">
				  <label class="form-check-label thumbnail">
				    <input class="form-check-input" type="radio" name="background" value="{{$name}}" @if($k==0) checked @endif>
				    <img src="{{ asset('/images/cardBG/'.$name.'.jpg') }}" alt="" class="img-responsive">
				    <span>{{ trans('card.'.$name) }}</span>
				  </label>
				</div>
			@endforeach
		</div>
		<hr style='margin:4px 25%;width:50%'>
		<div class="form-group">
			<label class='mainLabel' for="color">Couleur du texte : </label>
			<input type="text" class='jscolor kerdColorPick' value="000000" name='fontColor'>
		</div>
		<!-- <div class="form-group">
			<label class='mainLabel' for="insertContact">Intégrer mes coordonées : </label><br>
			<label class="checkbox-inline"><input type="checkbox" name='insertMail' value="1">Intégrer mon e-mail</label><br>
			@if($reservation->user->phone && $reservation->user->phone->phone != 'noPhone')
			<label class="checkbox-inline"><input type="checkbox" name='insertPhone' value="1">Intégrer mon téléphone</label>
			@endif
		</div> -->
	</form>
</div>

<div class="col-md-8" id='cardPreview'></div>
	
	<div class="co-xs-12 text-center">
		<a href="#" target="_blank" id='downloadLink'><div class="btn btn-kerden-confirm">Télécharger</div></a>
	</div>

</div>

@include('footer')
@endsection



@section('scripts')
<script type="text/javascript" src=" {{ asset('js/jscolor.min.js') }} "></script>
<script>

var previewURL = '{{ url("/reservation/invitCard/".$reservation->id."/preview?") }}';
function loadPreview(){
	if(/Firefox/.test(navigator.userAgent) && /format=A4-/.test( previewURL ) ){
		$('#cardPreview').html('');
		$('#cardPreview').html( $('<page size="A4">').text("Firefox ne supporte pas la prévisualisation des planches contact.") );
		//$('.container-fluid').attr('style','');
	}
	else{
		$.ajax(previewURL,{
			success: function(data){
				$('#cardPreview').html('');
				//$('.container-fluid').attr('style','padding:0px');
				$('#cardPreview').html(data);
			},
			error: function(data){
				console.log('ERREUR'+data);

			}
		});
	}
	$('#downloadLink').attr('href',previewURL.replace('preview','download'));
}


function checkPreviewSize(){
	var previewW = $('#cardPreview').width();
	var pageW = $('page').width();

	if(pageW > previewW){
		var ratio = Math.round((previewW / pageW) * 100) / 100;
		$('#cardPreview').css('zoom',ratio);
		$('#cardPreview').css('-moz-transform','scale('+ratio+')');
	}
}

(function($){

	$('#cardMenu input').change(function(){
		var param = $(this).attr('name')+'='+$(this).val();
		if( $(this).attr('type') == 'checkbox'){
			param = $(this).attr('name')+'='+$(this).is(':checked');
		}

		var reg = new RegExp( $(this).attr('name')+'=([^&]*)' );
		if( reg.test(previewURL) ){
			previewURL = previewURL.replace(reg,param);
		}
		else{
			previewURL.endsWith('?') ? previewURL+= param : previewURL+='&'+param;
		}
		loadPreview();

	});
	loadPreview();

	$(window).resize(checkPreviewSize);
	checkPreviewSize();

	$('input[name="background"]:checked').parent().addClass('active');
	$('input[name="background"]').change(function(){
		$('input[name="background"]').parent().removeClass('active');
		$(this).parent().addClass('active');
	});
	
}) (jQuery);
</script>

@endsection