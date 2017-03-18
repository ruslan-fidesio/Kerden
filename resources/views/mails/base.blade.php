
<html>
<head>
	<title>Kerden - {{$title}}</title>
</head>
<body>
@yield('gmailButton')

<div style="background-image:url('http://kerden.fr/images/motif_mail.png'); background-size:cover;font-family:'Avenir Next'">
@if(!isset($fromLink) || !$fromLink)
	<p style='text-align:center; font-size:9px;'><a href="{{$link}}">si cet e-mail ne s'affiche pas correctement, merci de cliquer sur ce lien</a></p>
@endif
<table style='text-align:center; width:100%;background-color:#d7f5e3'>
	<tbody>
		<tr><td><span style='font-size:3em;color:#555'>{{$title}}</span></td></tr>
		<tr>
			<td><img alt='Logo' style='width:80px;vertical-align:middle' src="http://kerden.fr/images/kerden-logo.png"><span style='font-weight:400;font-size:3em;vertical-align:middle;color:#888;'>erden</span></td>
		</tr>
	</tbody>
</table>
<table style='max-width:500px; margin:auto;'>
	<tbody>
		@yield('content')

<tr><td style='text-align:center;padding-top:25px'>L’équipe kerden.</td></tr>
<tr><td style='margin:auto;padding-left:73px'>
	<a href="https://www.facebook.com/Kerden-1065052246903303/"><img style='width:50px;height:50px;margin:15px;object-fit:contain' src="http://kerden.fr/images/logos/fb.png"></a>
	<a href="https://twitter.com/kerden_official"><img style='width:50px;height:50px;margin:15px;object-fit:contain' src="http://kerden.fr/images/logos/twitter.png"></a>
	<a href="https://www.instagram.com/kerden.official/"><img style='width:50px;height:50px;margin:15px;object-fit:contain' src="http://kerden.fr/images/logos/instagram.png"></a>
	<a href="https://fr.pinterest.com/kerden_official"><img style='width:50px;height:50px;margin:15px;object-fit:contain' src="http://kerden.fr/images/logos/pinterest.png"></a>
</td></tr>
</tbody>
<table>
</div>
</body>
</html>