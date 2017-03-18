@extends('mails.base')

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>

<tr><td>Bonjour {{$user->firstName}},</td></tr>

<tr><td>Un document concernant votre identité vient d'être 
@if($success)
accepté
@else
refusé
@endif
.</td></tr>

@if($success)
<tr><td>Si vous souhaitez devenir propriétaire et louer votre jardin, nous vous invitons à remplir vos coordonées bancaires.</td></tr>
@else
<tr><td>Nous vous invitons à envoyer un autre document.</td></tr>
@endif


@endsection