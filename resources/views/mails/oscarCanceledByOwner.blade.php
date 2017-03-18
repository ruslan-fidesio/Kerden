@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour,</td></tr>
<tr><td>Nous sommes au regret de vous annoncer que la réservation pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>du lieu : "{{$reservation->garden->title}}",</td> </tr>
<tr><td>Et impliquant {{$reservation->nb_staff}} Oscardiens,</td></tr>
<tr><td>A été refusée par le propriétaire.</td> </tr>


@endsection