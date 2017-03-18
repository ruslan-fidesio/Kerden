<style>
	.anniv1 .caption{
		margin-bottom: 2%;
		color: #{{$captionColor}};
	}
	.anniv1 .footer{
	    width: 45%;
	   left: 27.5%;
	   color: black;
	}
	.anniv1 .footer img{
		width: 10%;
	}
	.anniv1 .footer span{
		font-size: 0.7em;
		margin-left: -2%;
	}
	page[size='A4-4'] .anniv1{
	    font-size: 10px;
	}
	page[size='A4-8'] .anniv1{
	    font-size: 8px;
	}
	page[size='A4-16'] .anniv1{
	    font-size: 5px;
	}
</style>

<div class="cardBody anniv1">
		<div class="col-xs-8 col-xs-offset-2" style='margin-top:15%'>
			<div class="caption">ÉVÈNEMENT : </div>
			<div class="info">{{$title}}</div>
		</div>

		<div class="col-xs-8 col-xs-offset-2" style='margin-top:5%'>
			<div class="caption">DATE : </div>
			<div class="info">{{$formatedDate}}</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2" style='margin-top:5%'>
			<div class="caption">HEURE : </div>
			<div class="info">{{$formatedHour}}</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2" style='margin-top:5%'>
			<div class="caption">ADRESSE : </div>
			<div class="info">{{ $reservation->garden->address }}</div>
		</div>

		<div class="col-xs-8 col-xs-offset-2" style='margin-top:5%'>
			<div class="caption">INFORMATIONS UTILES : </div>
			@if( $guestsCanSee && $guestsCanSee->value == "1" )
				<div class="info">
					@foreach( $reservation->garden->locInfos as $info )
						@if($info->type == "USEPHONE" || $info->type=="GUESTSCANSEE" || $info->type=='AUTRE')
							@continue
						@endif

						@if( ! empty($info->value) )
						<div class="row" style="margin-top:3%">
							<div class="col-xs-6" style='white-space:nowrap'>
								{{$info->type}} : 
							</div>
							<div class="col-xs-5">
								<small>{{$info->value}}</small>
							</div>
						</div>
						@endif
					@endforeach
				</div>
			@else
				<div class="info">Contactez {{$reservation->user->firstName}} pour plus d'informations.</div>
				@if($insertMail && $insertMail == 'true')
				<div class="mail">{{$reservation->user->email}}</div>
				@endif
				@if($insertPhone && $insertPhone=='true' && $reservation->user->phone && $reservation->user->phone->phone != 'noPhone')
				<div class="phone">Téléphone : {{  chunk_split($reservation->user->phone->phone,2,' ')  }}</div>
				@endif
			@endif
		</div>

		@if( $guestsCanSee && $guestsCanSee->value == "1" && $reservation->garden->locInfos->where('type','AUTRE')->count() > 0 )
		<div class="col-xs-8 col-xs-offset-2" style='margin-top:5%'>
			<div class="caption">À SAVOIR</div>
			{{ $reservation->garden->locInfos->where('type','AUTRE')->first()->value }}

		</div>
		@endif

		@if( $guestsCanSee && $guestsCanSee->value == "1")
			@if( ($insertMail && $insertMail=='true') || ($insertPhone && $insertPhone == 'true') )
			<div class="col-xs-8 col-xs-offset-2" style='margin-top:4%'>
				<div class="caption">CONTACT</div>
				@if($insertMail && $insertMail == 'true')
				<div class="mail">{{$reservation->user->email}}</div>
				@endif
				@if($insertPhone && $insertPhone=='true' && $reservation->user->phone && $reservation->user->phone->phone != 'noPhone')
				<div class="phone">Téléphone : {{  chunk_split($reservation->user->phone->phone,2,' ')  }}</div>
				@endif
			</div>
			@endif
		@endif

		<div class="footer">
			L'équipe Kerden vous souhaite un bon moment !
			<br>
			<img src="{{url('images/kerden-logo.png')}}" alt=""><span>erden</span>
		</div>
	</div>