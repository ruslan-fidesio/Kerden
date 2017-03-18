@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour {{$reservation->user->firstName}},</td></tr>
<tr><td>Nous sommes au regret de vous annoncer que votre réservation pour le {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td> </tr>
<tr> <td>du lieu : "{{$reservation->garden->title}}",</td> </tr>
<tr><td>A été refusée par le propriétaire.</td> </tr>

<tr><td>Nous vous invitons à continuer vos recherches en suivant <a href="http://www.kerden.fr">ce lien</a></td></tr>
@endsection