@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour ,</td></tr>
<tr><td>L'événement pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>situé au lieu : "{{$reservation->garden->title}}", et implquant des Oscardiens est terminé.</td> </tr>
<tr><td>Nous vous informons que le transfert bancaire a été effectué.</td></tr>
<tr><td>Nous vous remercions pour votre confiance et vos services.</td> </tr>
@endsection