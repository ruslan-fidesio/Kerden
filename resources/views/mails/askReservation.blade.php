@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>

<tr><td>Bonjour {{$reservation->garden->owner->firstName}},</td></tr>

<tr><td>Nous avons le plaisir de vous indiquer que {{$reservation->user->fullName}} souhaite réserver votre jardin "{{$reservation->garden->title}}"</td></tr>

<tr><td style='padding-top:25px'>Date : {{\Carbon\Carbon::parse($reservation->date_begin)->formatLocalized('%A %d %B %Y') }}</td></tr>
<tr><td>Plage horaire : de {{\Carbon\Carbon::parse($reservation->date_begin)->hour}}h à {{\Carbon\Carbon::parse($reservation->date_end)->hour}}h</td></tr>
<tr><td>Nombre d'invités : {{$reservation->nb_guests}}</td></tr>
<tr><td>Oscardiens : {{$reservation->nb_staff>0?$reservation->nb_staff:'non'}}</td> </tr>
@if($reservation->nb_staff>0)
<tr><td style='padding-left:35px'>de {{\Carbon\Carbon::parse($reservation->staff_begin)->hour}}h à {{\Carbon\Carbon::parse($reservation->date_end)->hour}}h</td></tr>
@endif

<tr><td style='padding-top:30px'>Message du locataire : {{$reservation->description_by_user}}</td></tr>

<tr><td style='padding-top:30px'>Votre gain : <span style='font-size:1.2em;'>{{ ($reservation->location_amount)*( (100-env('KERDEN_FEES_PERCENT'))/100 )}}€</span></td></tr>

<tr> <td style='padding:25px'> <a style='box-shadow: 2px 1px 2px gray;padding:25px;float:left;background-color:#2cb42c;color:white;' href="{{url('/reservation/ownerConfirm/'.$reservation->id)}}">Je confirme</a>
	<a style='box-shadow: 2px 1px 2px gray;padding:25px;float:right;background-color:#b42c2c;color:white'  href="{{url('/reservation/ownerCancel/'.$reservation->id)}}">Je refuse</a> </td> </tr>

<tr><td style='paddin-top:30px'> Vous avez jusqu'au {{ \Carbon\Carbon::parse($reservation->autoCancelDate)->formatLocalized('%A %d %B %Y à %R') }} pour accepter la réservation. Au delà, celle-ci sera automatiquement refusée.</td>  </tr>

@endsection