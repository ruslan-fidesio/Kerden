@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour {{$annulation->reservation->user->firstName}},</td></tr>
<tr><td>Nous sommes au regret de vous annoncer que la réservation pour le {{\Carbon\Carbon::parse($annulation->reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>du lieu : "{{$annulation->reservation->garden->title}}",</td> </tr>
<tr><td>A été annulée par le propriétaire.</td> </tr>
<tr> <td>En accord avec les conditions générales d'utilisation, vous êtes remboursé de l'intégralité de la somme, soit : </td> </tr>
<tr><td>{{$annulation->refund_amount}}€</td></tr>

@endsection