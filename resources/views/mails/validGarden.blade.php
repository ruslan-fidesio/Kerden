@extends('mails.base')

@section('content')
<tr><td>Félicitations {{$name}},</td></tr>
<tr><td>Votre jardin "{{$gardenName}}" est maintenant validée et disponible sur <a href="http://www.kerden.fr">Kerden.fr</a></td></tr>


@endsection