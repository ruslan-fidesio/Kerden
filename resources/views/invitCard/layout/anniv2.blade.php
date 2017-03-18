<style>
	.anniv2 .caption{
		margin-bottom: 2%;
		color:#{{$captionColor}};
	}
	.anniv2 .test .row{
		position: absolute;
	}
	page[size^="A4"] .anniv2{
		font-size: 18px;
	}
	page[size="A5"] .anniv2{
		font-size: 12.5px;
	}
	page[size="A6"] .anniv2{
		font-size: 8.5px;
	}

	.anniv2 .locInfo{
		padding-top: 3%!important;
		padding-bottom: 3%!important;
	}
	.anniv2 .locInfo .key{
		display: inline-block;
		width: 60%;
		padding-left: 15px;
	}
	.anniv2 .locInfo .value{
		display: inline;
		width: 40%;
		font-size: 85%;
	}

	.anniv2 .footer{
	   color: black;
	   right:10.5%; 
	   bottom:0.5%; 
	   width:20%;
	}
	.anniv2 .footer .pLine{
		margin-bottom: -12%;
	}
	.anniv2 .footer img{
		width: 13%;
	}
	.anniv2 .footer span{
		font-size: 0.7em;
		margin-left: -2%;
	}
	page[size='A4-4'] .anniv2{
	    font-size: 8px;
	}
	page[size='A4-8'] .anniv2{
	    font-size: 6px;
	}
	page[size='A4-16'] .anniv2{
	    font-size: 4px;
	}
</style>

<div class="cardBody anniv2">

		<div class="col-xs-5 col-xs-offset-1 test" style='margin-top:25%; height:75%;'>
			<div class="row">
				<div class="caption">ÉVÈNEMENT : </div>
				<div class="info">{{$title}}</div>
			</div>
			<div class="row" style="top:11%">
				<div class="caption">DATE : </div>
				<div class="info" style='white-space:nowrap;'>{{$formatedDate}}</div>
			</div>
			<div class="row" style="top:22%">
				<div class="caption">HEURE : </div>
				<div class="info">{{$formatedHour}}</div>
			</div>
			<div class="row" style="top:34%">
				<div class="caption" style="margin-bottom:-1%">ADRESSE : </div>
				<div class="info">{{ $reservation->garden->address }}</div>
			</div>
			@if( $guestsCanSee && $guestsCanSee->value == "1" && $reservation->garden->locInfos->where('type','AUTRE')->count() > 0 )
			<div class="row" style="top:45%">
				<div class="caption">A SAVOIR : </div>
				<div class="info">{{ $reservation->garden->locInfos->where('type','AUTRE')->first()->value }}</div>
			</div>
			@endif
		</div>

		<div class="col-xs-5" style='margin-top:25%; margin-left:-6%'>
			<div class="caption" style='white-space:nowrap'>INFORMATIONS UTILES : </div>
			@if( $guestsCanSee && $guestsCanSee->value == "1" )
				<div class="info">
					@foreach( $reservation->garden->locInfos as $info )
						@if($info->type == "USEPHONE" || $info->type=="GUESTSCANSEE" || $info->type=='AUTRE')
							@continue
						@endif

						@if( ! empty($info->value) )
						<div class="row locInfo">
							<div class="key">
								{{$info->type}} : </div>
							<div class="value">{{$info->value}}</div>
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

		<div class="footer">
			<div class="pLine">L'équipe Kerden vous souhaite un bon moment !</div>
			<br>
			<img src="{{url('images/kerden-logo.png')}}" alt=""><span>erden</span>
		</div>
	</div>