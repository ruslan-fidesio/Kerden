<hr/>
<h3>Commentaire</h3>
@if( $reservation->commentaire  != null)
Vous avez déjà commenté cette réservation : 
<blockquote>
	{{$reservation->commentaire->content }} 
	<footer>Note : {{$reservation->commentaire->realNote}}</footer>
</blockquote>
	
	@if($reservation->commentaire->answer != null)
	<p class="text-right">Le propriétaire à répondu :</p>
	<blockquote class="blockquote-reverse">
		{{$reservation->commentaire->answer->content}}
	</blockquote>
	@endif

@else
Votre réservation ayant été effectuée, vous pouvez maintenant commenter et noter ce jardin.
<div class="row">
	<div class="col-xs-12">
		{!! Form::open(['url'=>'/comment/post/','class'=>'form-horizontal']) !!}

		{!! Form::hidden('reservationId',$reservation->id) !!}

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

    	<div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
    		{!! Form::label('note','Note : ',['class'=>'col-xs-2 control-label']) !!}
    		<div class='col-xs-10'>
    			<div class="zeroClick" style='display:inline;cursor:pointer'>0</div>
    			@for($i=0; $i<5; $i++)
    				<i class="fa fa-star-o notationStar" data-star="{{$i}}" style='font-size:2.7em;cursor:pointer;color:gold'></i>
    			@endfor
    			{!! Form::hidden('note',0) !!}
    		@if ($errors->has('note'))
                <span class="help-block">
                    <strong>{{ $errors->first('note') }}</strong>
                </span>
            @endif
            </div>
    	</div>

    	<div class="row form-group">
    		<div class="col-xs-6 text-center">
    			{!! Form::submit('Enregistrer',['class'=>'btn btn-kerden-confirm','onclick'=>'return surePostForm()']) !!}
    		</div>
    	</div>


		{!! Form::close() !!}
	</div>
</div>

@endif


@section('scripts')
<script>
function surePostForm(){
	var note = $('input[name=note]').val();
	if(note == 0){
		return confirm("Êtes vous sur de vouloir mettre la note de zéro?");
	}
	return true;
}
	(function(){
		$('.notationStar').click(function(event){
			var note = parseInt(event.target.dataset.star);
			if(event.offsetX < event.target.clientWidth/2){
				note = note + 0.5;
			}else{
				note = note + 1;
			}
			$('input[name=note]').val(note);
			for(var i=0; i<5; i++){
				if(i<note){
					if(note-i == 0.5){
						$('.notationStar[data-star='+i+']').removeClass('fa-star-o fa-star-half-o').addClass('fa-star-half-o');
					}else{
						$('.notationStar[data-star='+i+']').removeClass('fa-star-o fa-star-half-o').addClass('fa-star');
					}
				}else{
					$('.notationStar[data-star='+i+']').removeClass('fa-star fa-star-half-o').addClass('fa-star-o');
				}
			}
		});
		$('.zeroClick').click(function(event){
			$('input[name=note]').val(0);
			$('.notationStar').removeClass('fa-star fa-star-half-o').addClass('fa-star-o');
		});


	})(jQuery);
</script>
@endsection