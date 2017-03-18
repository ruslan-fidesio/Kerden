@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour {{$reservation->garden->owner->firstName}},</td></tr>
<tr><td>Nous vous remercions d'avoir accepté la réservation pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>du lieu : "{{$reservation->garden->title}}".</td> </tr>
<tr><td>La réservation vient d'être payée par le locataire, et est donc confirmée!</td></tr>
<tr><td><a href="{{url('/reservation/ownerView/'.$reservation->id)}}">Retrouvez ici tous les détails de la réservation.</a></td> </tr>

<tr style='margin-top:35px'><td>Afin d'améliorer votre jardin, Kerden.fr vous offre un code promotionnel, valable sur les sites partenaires : <a href="http://www.laboutiquedebob.butagaz.fr">La boutique de Bob</a> et <a href="http://www.enviedeconfort.com">Envie de confort</a> </td></tr>
<tr><td>Ce code vous permet d'obtenir 15% de réuction sur tous vos achats : </td></tr>
<tr style='font-size:2em'><td>KERDEN15</td></tr>
@endsection