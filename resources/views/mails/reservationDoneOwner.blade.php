@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour {{$reservation->garden->owner->firstName}},</td></tr>
<tr><td>L'événement pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>du lieu : "{{$reservation->garden->title}}" est terminé.</td> </tr>
<tr><td>Nous vous informons que le transfert bancaire vient d'être effectué. Votre argent devrait être disponible sur votre compte bancaire dans moins de 48h.</td></tr>
<tr><td>Nous vous remercions pour votre confiance.</td> </tr>

@endsection