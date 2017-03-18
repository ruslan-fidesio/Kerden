<style>
.chateau .caption{
	color:#{{$captionColor}};
}
.chateau .footer img{
	width:13%;
}
.chateau .footer{
	width: 33%;
	left: 33%;
}
.chateau .footer .pLine{
	margin-bottom: -10%;
}

.chateau .locInfo{
	padding: 3% 0px!important;
}

.chateau .locInfo .key{
	width: 60%;
	padding-left: 15px;
	display: inline-block;
}
.chateau .locInfo .value{
	width: 40%;
	display: inline;
}

page[size^="A4"] .chateau{
	font-size: 18px;
}
page[size="A5"] .chateau{
	font-size: 12.5px;
}
page[size="A6"] .chateau{
	font-size: 8.5px;
}
page[size='A4-4'] .chateau{
    font-size: 8px;
}
page[size='A4-8'] .chateau{
    font-size: 6px;
}
page[size='A4-16'] .chateau{
    font-size: 4px;
}

page[size^="A4-"] .chateau{
	border:1px solid #ccc;
}
</style>

<div class="cardBody chateau">

		<div class="col-xs-6 col-xs-offset-3" style="margin-top:11%">
			<div class="row" >
				<div class="caption">ÉVÈNEMENT</div>
				<div class="info">{{$title}}</div>
			</div>
			<div class="row" style="margin-top:10%">
				<div class="caption">DATE</div>
				<div class="info">{{$formatedDate}}</div>
			</div>
			<div class="row" style="margin-top:10%">
				<div class="caption">HEURE</div>
				<div class="info">{{$formatedHour}}</div>
			</div>
			<div class="row" style="margin-top:10%">
				<div class="caption">ADRESSE</div>
				<div class="info">{{ $reservation->garden->address }}</div>
			</div>
			<div class="row" style="margin-top:10%">
				<div class="caption">NOMBRE D'INVITÉS</div>
				<div class="info">{{ $reservation->nb_guests }}</div>
			</div>


			<div class="row">
				<div class="caption" style='margin-top:10%'>INFORMATIONS UTILES</div>
				@if( $guestsCanSee && $guestsCanSee->value == "1" )
					<div class="info">
						@foreach( $reservation->garden->locInfos as $info )
							@if($info->type == "USEPHONE" || $info->type=="GUESTSCANSEE" || $info->type=='AUTRE')
								@continue
							@endif

							@if( ! empty($info->value) )
							<div class="row locInfo">
								<div class="key" >
									{{$info->type}} : 
								</div>
								<div class="value">
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
				<div class="row" style="margin-top:11%">
					<div class="caption">A SAVOIR : </div>
					<div class="info">{{ $reservation->garden->locInfos->where('type','AUTRE')->first()->value }}</div>
				</div>
			@endif
		</div>

		<div class="footer">
			<div class="pLine">L'équipe Kerden vous souhaite un bon moment !</div>
			<br>
			<img src="{{url('images/kerden-logo.png')}}" alt=""><span style="margin-left:-2%">erden</span>
		</div>
	</div>