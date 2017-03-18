@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>

<tr><td>Bonjour ,</td></tr>

<tr><td>Une réservation impliquant des Oscardiens vient d'être demandée.Votre confirmation est requise.</td></tr>

<tr><td style='padding-top:25px'>Date : {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td></tr>
<tr><td>Lieu : {{$reservation->garden->title}}</td></tr>
<tr><td style='margin-left:20px'>Adresse : {{$reservation->garden->address}}</td></tr>
<tr><td>Nombre d'invités : {{$reservation->nb_guests}}</td></tr>
<tr><td>Oscardiens : {{$reservation->nb_staff }}</td> </tr>
<tr><td style='padding-left:35px'>de {{ \Carbon\Carbon::parse($reservation->staff_begin)->hour}}h à {{\Carbon\Carbon::parse($reservation->date_end)->hour}}h</td></tr>

<tr><td>Description de l'évènement par le locataire : </td></tr>
<tr><td style="margin-left:20px">{{ $reservation->description_by_user }}</td></tr>

<tr><td style='padding-top:30px'>Votre gain : <span style='font-size:1.2em;'>{{ $reservation->staff_amount }}€</span></td></tr>

<tr> <td style='padding:25px'> <a style='box-shadow: 2px 1px 2px gray;padding:25px;float:left;background-color:#2cb42c;color:white;' href="{{url('/reservation/oscarConfirm/'.$reservation->id)}}">Je confirme</a>
	<a style='box-shadow: 2px 1px 2px gray;padding:25px;float:right;background-color:#b42c2c;color:white'  href="{{url('/reservation/oscarCancel/'.$reservation->id)}}">Je refuse</a> </td> </tr>

	<tr><td style='paddin-top:30px'> Vous avez jusqu'au {{ \Carbon\Carbon::parse($reservation->autoCancelDate)->formatLocalized('%A %d %B %Y à %R') }} pour accepter la réservation. Au delà, celle-ci sera automatiquement refusée.</td>  </tr>
@endsection