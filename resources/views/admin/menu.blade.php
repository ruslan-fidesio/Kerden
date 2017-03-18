@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="col-md-3 left-home-menu">
        <ul role="menu">
            <a class="left-menu-link" href="{{url('/admin/users')}}"><li>Liste utilisateurs</li></a>
            <a class="left-menu-link" href="{{ url('/admin/gardens')}}"><li>Liste jardins</li></a>
            <a class="left-menu-link" href="{{ url('/admin/sendMails')}}"><li>Envoi de mails</li></a>
            <a class="left-menu-link" href="{{ url('/admin/report/list')}}"><li>Commentaires signalés <sup class="unreadNumber">{{ App\Commentaire::where('reported','1')->where('denied','0')->where('ignore_report','0')->count() }}</sup></li></a>
            <a class="left-menu-link" href="#"><li style="border-top:2px solid #bbb">Factures</li></a>
            <a class="left-menu-link" href="{{url('/admin/invoices/tab')}}"><li>=>Tableau des réservations</li></a>
            <a class="left-menu-link" href="{{url('/admin/invoices/byDate')}}"><li>=>Sélection par date</li></a>
            <a class="left-menu-link" href="{{url('/admin/invoices/byNumber')}}"><li>=>Sélection par numéro/reference</li></a>
            <a class="left-menu-link" href="{{url('/admin/invoices/unprinted')}}"><li>=>Uniquement les non-imprimés</li></a>
        </ul>
    </div>

    <div class="col-md-9">
        @yield('contentPane')
    </div>


</div>

@endsection