<hr>
<h3>Commentaire</h3>
@if($reservation->commentaire != null)

{{$reservation->user->fullName}} a écrit :
<blockquote>
{{$reservation->commentaire->content}}	
<footer>Note : {{$reservation->commentaire->realNote}}</footer>
</blockquote>
	@if($reservation->commentaire->answer != null)
	<p class="text-right">Vous avez répondu:</p>
	<blockquote class="blockquote-reverse">
		{{$reservation->commentaire->answer->content}}
	</blockquote>
	@else
	<a id="answerBtn" href="#" class='btn btn-primary'>Répondre au commentaire</a>

	<div class="row" id='answerRow' style='display:none'>
		{!! Form::open(['url'=>'/answer/post/','class'=>'form-horizontal']) !!}

			{!! Form::hidden('commentId',$reservation->commentaire->id) !!}

			<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
	    		{!! Form::label('content','Message : ',['class'=>'col-md-2 control-label']) !!}
	    		<div class='col-md-10'>
	    			{!! Form::textarea('content',null,['class'=>'form-control']) !!}
	    		@if ($errors->has('content'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('content') }}</strong>
	                </span>
	            @endif
	            </div>
	    	</div>

	    	<div class="row form-group">
	    		<div class="col-xs-6 text-center">
	    			{!! Form::submit('Enregistrer',['class'=>'btn btn-primary']) !!}
	    		</div>
	    	</div>

			{!! Form::close() !!}

	</div>
	@endif



@else
-Le locataire n'a pas encore posté de commentaire sur cette réservation.-
@endif


@section('scripts')
<script>
	(function(){
		$('#answerBtn').click(function(e){
			$('#answerRow').show();
			$('#answerBtn').hide();
		});
	})(jQuery);
</script>
@endsection