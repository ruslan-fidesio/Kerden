{!! Form::open(['url'=>'/newAnswer/'.$garden->id.'/'.$askerId,'class'=>'form-horizontal']) !!}
	
@if($errors->has('content'))
<div class="col-xs-12"><span style="color:red">Impossible d'envoyer un message vide.</span></div>
@endif
{!! Form::textarea('content','',['class'=>'form-control','id'=>'messageContent','placeholder'=>'Écrivez votre message...']) !!}

<div class="col-xs-12 text-right">
{!! Form::submit('Envoyer le message',['class'=>'kerden-flat-btn','style'=>'margin-top:15px']) !!}
</div>

{!! Form::close() !!}