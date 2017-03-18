@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour {{$reservation->user->firstName}},</td></tr>
<tr><td>Votre demande de réservation pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>du lieu : "{{$reservation->garden->title}}"</td> </tr>
<tr><td>a été acceptée.</td></tr>
<tr style='margin-top:30px'><td>Vous avez jusqu'au {{ \Carbon\Carbon::parse($reservation->autoCancelDate)->formatLocalized('%A %d %B %Y à %R') }} pour payer et ainsi valider votre réservation.</td></tr>
<tr><td>Au delà de cette limite votre réservation sera annulée.</td></tr>

<tr><td><a href="{{ url('/reservation/view/'.$reservation->id) }}">Cliquez ici pour voire les détails de vote réservation,</a></td></tr>
<tr><td><a href="{{ url('/reservation/createPayin/'.$reservation->id) }}">ou ici pour passer directement au paiement.</a></td></tr>

@endsection