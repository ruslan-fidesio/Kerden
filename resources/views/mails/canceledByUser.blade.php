@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour, </td></tr>
<tr><td>Nous sommes au regret de vous annoncer que la réservation pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>du lieu : "{{$reservation->garden->title}}",</td> </tr>
<tr><td>A été annulée par {{$reservation->user->fullName}}, le locataire.</td> </tr>

<tr style='margin-top:20px'><td>L'annulation ayant eu lieu avant le paiement, aucun dédommagement n'est possible.</td></tr>

@endsection