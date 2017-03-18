Bonjour, 
Les transferts et payouts relatifs à la réservation N° {{$reservation->id}} ne se sont pas bien déroulés.<br/>
ERREUR : <br/>
{{$exception->getMessage()}}<br>
at Line : {{$exception->getLine()}}<br>
in file : {{$exception->getFile()}}
<br/>
<br/>
Trace : <br/>
{{$exception->getTraceAsString()}}

<br/>
Please contact your service provider or application developper.