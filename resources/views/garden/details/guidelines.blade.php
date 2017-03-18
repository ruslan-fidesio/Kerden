<div class="panel panel-kerden-home">
	<div class="panel-heading">Consignes</div>
	<div class="panel-body">
		<p>Vous pouvez indiquer des directives qui vous semble importante à porter à la connaissance des locataires.</p>

		<ul id="guidelinesList">
			@forelse($garden->guidelines as $k=>$v)
				<li><i onclick="removeLine(event);" data-line="{{$v->id}}" class="fa fa-times" style="color:red;cursor:pointer;"></i> {{$v->message}}</li>
			@empty
			<li id="emptyListElmt">Pas de consignes</li>
			@endforelse
		</ul>

		<div style='display:none' id="hiddenNewLinesList">
			
		</div>

		<hr>
		<h4>Ajouter une consigne</h4>
		<textarea name="newGuidelineTextArea" id="" cols="30" rows="2" class="form-control"></textarea>
		<div class="text-center">
			<div class="btn btn-kerden-confirm" id="newGuidelineBtn">Ajouter</div>
		</div>

	</div>

</div>