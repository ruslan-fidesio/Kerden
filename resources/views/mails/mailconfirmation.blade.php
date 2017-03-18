@extends('mails.base')

@section('content')

<tr><td>Merci de vous être inscrit</td></tr>
<tr><td>Cliquez sur ce lien pour confirmer votre email : 
<a href="{{ $confirmlink = url('confirmemail', [$id,$token]) }}"> {{ $confirmlink }} </a>
</td></tr>

@endsection