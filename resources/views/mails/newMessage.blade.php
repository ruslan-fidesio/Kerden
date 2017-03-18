@extends('mails.base')

@section('gmailButton')
<div itemscope itemtype="http://schema.org/EmailMessage">
  <div itemprop="potentialAction" itemscope itemtype="http://schema.org/ViewAction">
    <link itemprop="target" href="{{url($link)}}"/>
    <meta itemprop="name" content="Voir le message"/>
  </div>
  <meta itemprop="description" content="Voir le message sur Kerden.fr"/>
</div>
@endsection

@section('content')
<span style='font-size:0em'>{{setlocale(LC_TIME,'fr_FR.UTF-8') }}</span>
<tr><td>Bonjour ,</td></tr>
<tr><td>Vous avez reçu un message de la part de {{$sender}} : </td></tr>
<tr><td style='border:1px solid black; border-radius:10px; padding:5px; background-color:rgba(255,255,255,0.7);'>{!! $content !!}</td></tr>
<tr><td><a href="{{ url($link) }}">Cliquez ici pour répondre.</a></td></tr>
@endsection