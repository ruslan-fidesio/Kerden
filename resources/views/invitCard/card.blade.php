<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('css/all.css')}}">

<style>
	.cardBody{
		background-image: url("{{url('/images/cardBG/'.$background.'.jpg')}}");
		background-size: cover;
		background-repeat: no-repeat;
		height: 100%;
		width: 100%;
		position: relative;
		font-family: 'kerdenRegular';
		color:#{{$fontColor}};
	}
	.cardBody h1,h2{
		font-weight: bold;
	}

	.cardBody h2{
		margin: 6%;
	}

	.cardBody .footer{
		position: absolute;
		bottom:3%;
		width: 100%;
		text-align: center;
	}
	.cardBody .caption{
		margin:0px;
	}
	page[size^="A4"] {
	  width: 21cm;
	  height: 29.7cm;
	  font-size:20px;
	  table-layout: fixed;
	}
	page[size^="A4-"]{
		display: table!important;	
	}
	page[size^="A4"] .cardBody .locInfo{
		padding: 10px 0px;
	}
	page[size="A4-4"] .cardBody{
	    display: inline-block;
	    width: 49%;
	    height: 49%;
	}

	page[size="A4-8"]{
		width: 29.7cm!important;
		height: 21cm!important;
	}

	page[size="A4-8"] .cardBody{
	    display: inline-block;
	    width: 24.5%;
	    height: 49%;
	}

	page[size="A4-16"] .cardBody{
		display: inline-block;
	    width: 24.5%;
	    height: 24.5%;
	}


	page[size="A5"] {
	  width: 14.8cm;
	  height: 21cm;
	}
	page[size="A5"] .cardBody .locInfo{
		padding: 10px 0px;
	}
	page[size="A5"] hr{
		margin: 16px auto;
	}

	page[size="A6"] {
		width: 10.5cm;
		height: 14.8cm;
		font-size: 12px;
	}
	page[size="A6"] .cardBody .title h1{
		font-size: 30px;
	}
	page[size="A6"] .cardBody h2{
		font-size: 24px;
		margin: 4%;
	}
	page[size="A6"] .cardBody .locInfo{
		padding: 6px 0px;
	}
	page[size="A6"] hr{
		margin: 8px auto;
	}

	.cardBody .caption{
		font-size: 1.4em;
	}

	.cardBody .title{
		width: 100%;
		font-family: 'kerdenRegular';
		padding-top: 2%;
	}
	.title img{
		width: 6%;
		margin-left: 42%;
	}
	.title span{
		display: inline-block;
		-webkit-transform: translate(-10px,3px);
		-moz-transform: translate(-10px,3px);
		-ms-transform: translate(-10px,3px);
		transform: translate(-10px,3px);
	}
	.title hr{
		border-color: #a1fbbe;
		border-width: 2px;
	}
	.mail{
		color: blue;
		text-decoration: underline;
		font-size: 0.8em;
	}
</style>

<page size="{{$format}}">
	@for ($i = 0; $i < $numberOfCards; $i++)
		@include('invitCard.layout.'.$background)
	@endfor
</page>
