@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour {{$reservation->user->firstName}},</td></tr>
<tr><td>Votre réservation pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>du lieu : "{{$reservation->garden->title}}"</td> </tr>
<tr><td>vient de se terminer.</td></tr>
<tr><td>N'hésitez pas à faire part de votre avis sur ce lieu en postant un commentaire. Pour cela <a href="{{url('/reservation/view/'.$reservation->id)}}">cliquez ici!</a></td> </tr>
<tr><td>Nous vous remercions de votre confiance et ésperons vous revoir vite!</td> </tr>
@endsection