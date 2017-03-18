@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>

<tr><td>Bonjour {{$reservation->garden->owner->firstName}},</td></tr>

<tr><td>{{$reservation->user->fullName}} vient de poster un commentaire sur votre jardin, à propos de la réservation du {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}.</td></tr>

<tr><td><a href="{{url('/reservation/ownerView/'.$reservation->id)}}">Cliquez ici</a> pour le voir, et éventuellement lui répondre.</td></tr>


@endsection