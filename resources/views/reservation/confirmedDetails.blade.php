<h3 style='margin-top:50px' class="text-center">Détails de votre location</h3>
<hr style="border-width:3px;width:50%">

<div class="col-xs-12">
  <h4><i class="fa fa-map-marker"></i> Adresse complète du jardin : </h4>{{$reservation->garden->address}}
</div>
<div class="col-xs-12" id='map' style="height:300px"></div>
@if( $reservation->garden->locInfos->count()>0 )

  @foreach( $reservation->garden->locInfos as $k=>$info )
    @if( $info->type == "USEPHONE" || $info->type=="GUESTSCANSEE" || empty($info->value) )
      @continue
    @endif
    <div class="col-md-6" style="margin:10px 0px">
      <strong>{{ $info->type }} : </strong>{{ $info->value }}
    </div>
  @endforeach

@endif


<div class="col-xs-12 text-center">
  <h3 style='margin-top:50px' class="text-center">Contacter le propriétaire</h3>
  <hr style="border-width:3px;width:50%">

  @if( $reservation->garden->locInfos->where('type','USEPHONE')->count()>0 &&
       $reservation->garden->locInfos->where('type','USEPHONE')->first()->value == "1" )

       <div class="hidden" id="telNumberValue">
        @if( $reservation->garden->owner->phone && $reservation->garden->owner->phone->phone !='noPhone' )
          <i class="fa fa-phone"></i> {{ $reservation->garden->owner->phone->phone }}
        @else
          Le propriétaire n'a pas de téléphone ou ne souhaite pas divulger son numéro.
        @endif
      </div>

       <div class="text-center btn btn-kerden-confirm" id="showTelNumber">Afficher le numéro de téléphone</div>

       <div class="separator" style="margin:15px"></div>

  @endif
  <a href="{{ url('/messages/'.$reservation->garden_id) }}"><div class="text-center btn btn-kerden-confirm">Envoyer un message</div></a>
</div>


<div class="col-xs-12 text-center">
  <h3 style="margin-top:50px" class="text-center">Carte d'Invitation</h3>
  <hr style="border-width:3px;width:50%">
  <a href="{{ url('reservation/invitCard/'.$reservation->id) }}"> <div class="btn btn-kerden-confirm">Créer la carte d'invitation</div> </a>
</div>




<script type="text/javascript">
var map, marker;
var loca = {lat: {{$reservation->garden->location->lat}}, lng: {{$reservation->garden->location->lng}} }
function initMap() {
   map = new google.maps.Map(document.getElementById('map'), {
    center: loca,
    zoom: 18,
    scrollwheel: false,
    navigationControl: false,
    mapTypeControl: false,
    scaleControl: false,
    draggable: false
  });
   marker = new google.maps.Marker({
   	map:map,
   	position:loca,
   	title:" {{$reservation->garden->title}} "
   });
}
</script>

<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMppXmks4XyF8XMe3_roFbVumAlThb_CY&libraries=places&callback=initMap">
</script>