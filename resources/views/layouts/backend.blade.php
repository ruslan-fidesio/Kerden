@extends ('layouts.app')

@section('navbar')


  <nav class="navbar backend-nav">
    <div class="container">
      <div class="collapse navbar-collapse" id="home-navbar-collapse">
        <ul class="nav navbar-nav">
          @if( Auth::user() && count(Auth::user()->ownedGardens) > 0)
            <li class="dropdown"><a href="#" class="HPMenuLink resaMenu dropdown-toggle" data-toggle="dropdown">Réservations</a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('/reservations') }}">En tant que locataire</a></li>
                <li><a href="{{ url('/owner/reservations') }}">En tant que propriétaire</a></li>
              </ul>
            </li>
          @else    
            <li><a class="HPMenuLink resaMenu" href="/reservations">Réservations</a></li>
          @endif

          @if( Auth::user() && count(Auth::user()->ownedGardens) > 0)
            <li class="dropdown">
              <a class="dropdown-toggle HPMenuLink messageMenu" href="#" data-toggle="dropdown">Messages
              @if(Auth::user()->unreadMessages > 0)
                <sup class="unreadNumber">{{ Auth::user()->unreadMessages }}</sup>
              @endif
              </a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ url('/messages') }}">En tant que locataire
                  @if( Auth::user()->unreadMessagesAsAsker > 0 )
                    - {{Auth::user()->unreadMessagesAsAsker}}
                  @endif
                </a></li>
                <li><a href="{{ url('/owner/messages') }}">En tant que propriétaire
                  @if( Auth::user()->unreadMessagesAsOwner > 0)
                    - {{Auth::user()->unreadMessagesAsOwner}}
                  @endif
                </a></li>
              </ul>
            </li>
          @else
            <li>
              <a class="HPMenuLink messageMenu" href="/messages">Messages
                @if(Auth::user()->unreadMessages > 0)
                  <sup class="unreadNumber">{{ Auth::user()->unreadMessages }}</sup>
                @endif
              </a>
            </li>
          @endif

          @if( Auth::user() && count(Auth::user()->ownedGardens) > 0)
            @if( count(Auth::user()->ownedGardens) ==1 )
              <li><a class="HPMenuLink gardenMenu" href="{{ url('/garden/menu/'.Auth::user()->ownedGardens->first()->id) }}"> Mon jardin</a></li>
              <li><a href="{{url('/garden/dispo/'.Auth::user()->ownedGardens->first()->id)}}" class="HPMenuLink">Calendrier</a></li>
            @else
              <li class="dropdown"><a class="HPMenuLink gardenMenu dropdown-toggle" data-toggle="dropdown" href="#"> Mes jardins</a>
                <ul class="dropdown-menu" role="menu">
                  @foreach(Auth::user()->ownedGardens as $garden)
                   <li><a href="{{url('/garden/menu/'.$garden->id)}}">{{$garden->title}}</a></li>
                  @endforeach
                </ul>
              </li>
            @endif
          @endif

          <li>
            <a class="HPMenuLink userMenu" href="{{url('/userdetails')}}" >Mon compte</a>
          </li>
          

          @if(Auth::user() && Auth::user()->role->role == 'admin')
            <li><a class="HPMenuLink adminMenu"  href=" {{url('/admin/users')}}">Menu ADMIN</a></li>
          @endif

          @if(Auth::user()->id == env('OSCAR_USER_ID'))
            <li><a class="HPMenuLink"  href="{{url('/oscar/menu')}}">Menu OSCAR</a></li>
          @endif
        </ul>
      </div>
    </div>
  </nav>

@endsection



@section('baseHomeScript')
<script>
function showPage2(){
  $('.kerden-page-2').css('left','0');
  $('.kerden-page-2').show();
  $('.kerden-page-1').css('left','-100%');
  if($(document).width() < 767){
    $('.kerden-page-1').hide();
  }
}

function showPage3(){
  $('.kerden-page-3').show();
  if($(document).width() < 767){
    $('.kerden-page-2').css('left','-100%');
    $('div[class*="kerden-page-2-"]').hide();
  }
}

(function($){
  console.log($('.HPMenuLink.active').html());
  setTimeout(function(){$('#homeBrand').html( $('.HPMenuLink.active').html());},10);

  $("[data-toggle='tab']").click(function(){
    $(this).data('kerdenpage') == 3 ? showPage3() : showPage2();
  });

  $('.kerden-back-button').click(function(){
    $('.kerden-page-1').css('left','0');
    $('.kerden-page-1').show();
    $('.kerden-page-2').css('left','100%');
    $('.kerden-page-2').hide();
  });

  $('.kerden-back-button-p3').click(function(){
    $('.kerden-page-3').hide();
    $('div[class*="kerden-page-2-"]').show();
    $('.kerden-page-2').css('left','0');
  });

  $('.left-menu-link').click(function(event){
    if($(this).hasClass('active')){
      event.preventDefault();
      showPage2();
    };
  });

  $('sup').filter(function(){
    return $(this).text() === "0";
  }).hide();

}) (jQuery);
</script>
@endsection






