{!! Form::open(['url'=>'/newMessage/'.$garden->id,'class'=>'form-horizontal']) !!}
	
@if($errors->has('content'))
<div class="col-xs-12"><span style="color:red">{{$errors->first('content')}}</span></div>
@endif
{!! Form::textarea('content',old('content'),['class'=>'form-control','id'=>'messageContent','placeholder'=>'Écrivez votre message au propriétaire...']) !!}

<div class="col-xs-12 text-right">
{!! Form::submit('Envoyer le message',['class'=>'kerden-flat-btn','style'=>'margin-top:15px']) !!}
</div>

{!! Form::close() !!}