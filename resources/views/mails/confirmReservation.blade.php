@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour {{$reservation->user->firstName}},</td></tr>
<tr><td>Votre réservation pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>du lieu : "{{$reservation->garden->title}}"</td> </tr>
<tr><td>a été acceptée et correctement encaissée.</td></tr>
<tr><td><a href="{{url('/reservation/view/'.$reservation->id)}}">Retrouvez ici tous les détails du jardin et de votre réservation.</a></td> </tr>
<tr><td>Nous vous souhaitons un bel évenement!</td> </tr>
@endsection