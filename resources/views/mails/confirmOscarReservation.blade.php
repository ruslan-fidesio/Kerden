@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour ,</td></tr>
<tr><td>Nous vous remercions d'avoir confirmé la présence d'Oscardiens pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>au lieu : "{{$reservation->garden->title}}".</td> </tr>
<tr><td>La réservation vient d'être payée par le locataire, et est donc confirmée!</td></tr>
<tr><td><a href="{{url('/oscar/view/'.$reservation->id)}}">Retrouvez ici tous les détails de la réservation.</a></td> </tr>
@endsection