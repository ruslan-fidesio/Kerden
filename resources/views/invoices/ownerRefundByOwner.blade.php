@extends('invoices.baseLayout')

@section('phrase')

Bonjour {{$name}},<br/>
Vous venez d'annuler une réservation préalablement confirmée.<br/>
Vous serez facturé de 50 euros de frais d'annulation lors de la prochaine réservation de votre jardin.<br>
<br>
A très bientôt.<br>
<span style='font-style:italic'>L'équipe Kerden</span>
<br>
<br>
<br>
<br>
<p style="font-style:italic">
	N.B : Les frais d'annulation peuvent être prélevés en plusieurs fois si vos bénéfices ne sont pas suffisants lors de votre prochaine réservation. De plus, les frais d'annulation sont cumulables.
</p>


@endsection