<div class="cardBody">
		<div class="title">
			<img src="{{url('images/kerden-logo.png')}}" alt=""><span>erden</span>
			<h1 class="text-center">{{$reservation->garden->title}}</h1>
			<hr>
		</div>
		<h2 class='text-center'>De la part
			@if( preg_match("#^[aeiouy]#",$reservation->user->firstName) )
			 d'{{$reservation->user->firstName}}
			@else
			 de {{$reservation->user->firstName}}
			@endif
		</h2>

		<div class="col-xs-5 col-xs-offset-1">
			<div class="row">
				<div class="caption">Évènement : </div>
				<div class="info">{{$title}}</div>
			</div>
			<div class="row" style="margin-top:12%">
				<div class="caption">Date : </div>
				<div class="info">{{$formatedDate}}</div>
			</div>
			<div class="row" style="margin-top:12%">
				<div class="caption">Heure : </div>
				<div class="info">{{$formatedHour}}</div>
			</div>
			<div class="row" style="margin-top:12%">
				<div class="caption">Adresse : </div>
				<div class="info">{{ $reservation->garden->address }}</div>
			</div>
		</div>

		<div class="col-xs-5">
			<div class="caption">Informations utiles : </div>
			@if( $guestsCanSee && $guestsCanSee->value == "1" )
				<div class="info">
					@foreach( $reservation->garden->locInfos as $info )
						@if($info->type == "USEPHONE" || $info->type=="GUESTSCANSEE" )
							@continue
						@endif

						@if( ! empty($info->value) )
							@if($info->type=='AUTRE')
								<div class="col-xs-12 locInfo">
									{{$info->value}}
								</div>
							@else
								<div class="col-xs-12 locInfo">
									{{$info->type}} : <small>{{$info->value}}</small>
								</div>
							@endif
						@endif
					@endforeach
				</div>
			@else
				<div class="info">Contactez {{$reservation->user->firstName}} pour plus d'informations.</div>
			@endif
		</div>

		<div class="footer" style="font-size:0.8em; right:7.5%; bottom:1%; width:26%">
			L'équipe Kerden vous souhaite un bon évènement.
		</div>
	</div>