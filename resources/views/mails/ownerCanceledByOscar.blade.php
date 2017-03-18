@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour {{$reservation->garden->owner->firstName}},</td></tr>
<tr><td>Nous sommes au regret de vous annoncer que la réservation pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>du lieu : "{{$reservation->garden->title}}",</td> </tr>
<tr><td>A été refusée.</td> </tr>
<tr><td>En effet, Oscar.fr n'est pas en mesure d'assurer la sécurité pour cet évenement.</td></tr>
<tr><td>Par respect des conditions que vous avez défini pour ce lieu, nous annulons la réservation.</td></tr>

@endsection