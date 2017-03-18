<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="{{asset('css/app.css')}}">
	<style>
		.page{
			page-break-after: always;
			border: 2px solid transparent;
			min-height: 1004px;
		}
		.cgu{
			font-size:7px!important;			
		}
		.cgu p{
			margin-top:5px;
			margin-bottom: 0px!important;
		}
		.cgu h2{
			font-size: 12px!important;
			font-weight: bolder;
			text-decoration: underline;
		}
		.cgu h3{
			font-size:12px!important;
			font-weight: bold;
			margin-top:8px!important;
			margin-bottom:0px!important;
		}
		.cgu h4{
			font-size: 10px!important;
			font-weight: bold;
			margin-top:3px!important;
			margin-bottom: 0px!important;
		}
		.header img{
			min-height: 50px;
			max-height: 50px;
		}
		.footer{
			text-align: center;
			color: lightgrey;
			font-size:10px!important;
			position: relative;
			top:0;
		}
		.logoImg{
			max-height: 95px;
		}
		.logoSpan{
		    display: inline;
		    font-family: 'kerdenRegular';
		    font-size: 3em;
		    position: absolute;
		    top: 16px;
		    left: 80px;
		}
	</style>
</head>
	<body>		
<div class="container">
	<div class="page">
		<div class="row">
			<div class="col-xs-4">
				<img src="{{url('images/kerden-logo.png')}}" alt="" class="img-responsive logoImg">
				<span class="logoSpan">erden</span>
			</div>

			<div class="col-xs-4 col-xs-offset-4" style='color:green; margin-top:30px'>
				<p style='font-size:1.5em'>
					ADENOR SAS
				</p>
				25 Bis, Rue de l'Armorique<br/>
				75015 Paris<br/>
				FRANCE
				<hr style="width:50%">
				www.kerden.fr<br/>
				Téléphone : 06.35.36.86.45<br/>
				E-mail : contact@kerden.fr
			</div>
		</div>

		<div style='font-size:1.2em; margin-bottom:25px'>
			@yield('phrase')
		</div>
		<hr style="width:50%">

		@yield('intermediate')

		<div class="footer" style='position:absolute; top:954px;left:42px'>
			ADENOR, 25 Bis rue de l'Armorique, 75015 Paris, RCS Paris 820 157 717 est une société par actions simplifiée au capital de 500 euros.
		</div>
	</div>

</div>

<div class="container">
	@include('invoices.invoiceCGU')
</div>
	</body>
</html>