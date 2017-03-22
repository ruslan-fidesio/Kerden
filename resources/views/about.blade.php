@extends('layouts.app')

@section('headers')

<!--   <link href="{{ asset('css/slideshow-home.css') }}" rel="stylesheet">
  <link href="{{ asset('slick/slick.css') }}" rel="stylesheet">
  <link href="{{ asset('slick/slick-theme.css') }}" rel="stylesheet"> -->

@endsection

@section('content')
  
<main class="content">
  <div class="martinique"> 
    <div class="header">
      <div class="container"> 
        <h1>Qui sommes-nous ?</h1>
      </div>
    </div>  
  </div> 
  <div class="container">
    <div class="row"> 
      <div class="col-md-9">
        <h2 class="about-subtitle">Histoire</h2>
        <p>Après avoir voyagé en Australie et en Nouvelle-Zélande, j’ai passé la fin de l’année 2015 en Martinique pour y effectuer un stage. Là, mes conditions de logement étaient sommaires : Petit appartement sans climatisation, vue sur le parking et pour colocataires : Les moustiques…</p>
        <p><strong>C’est alors que je me suis mis à rêver d’un jardin frais et ombragé avec piscine et transats !</strong></p>
        <p>La date de mon anniversaire approchait, et je cherchais un moyen d’inviter mes amis à une soirée festive avec Barbecue et musique. J’ai recherché sur internet s’il existait des sites de locations de jardins entre particuliers, mais cela n’existait pas.</p>
        <p>C’est ainsi que mon concept est né et s’est affiné en partant du besoin pour un citadin de renouer avec la nature. L’urbanisation et la société de consommation nous ont éloigné de cet élément, nous ressentons aujourd’hui la nécessité d’un retour à des valeurs saines, universelles communes à tous, favorisant ainsi le partage et le bien être. Faire revivre ce lien privilégié entre la terre et le cosmos est essentiel pour l’homme et se concrétise dans l’élaboration du jardin.</p>
        <p><strong>Selon une étude effectuée par les chercheurs de l’Université de Stanford, le contact de l’homme avec la nature favorise le bien-être, régule notre rythme biologique et renforce notre champ énergétique individuel.</strong></p>
        <p>Le jardin éveille les sens, transcende nos émotions et rend nos souvenirs intemporels. Ce lieu se prête à tous les évènements qui constituent les étapes de l’existence.</p>
      </div>
      <div class="col-md-3">
        <h2 class="about-subtitle">KERDEN</h2>
        <p>Mon nom de famille KERDELHUE d’origine bretonne débute par KER qui signifie : « Un lieu habité ».</p>
        <p>Ce préfixe est utilisé dans de très nombreux noms bretons et identifie l’origine bretonne de ces noms.</p>
        <p>Le jardin, m’évoquait quelque chose de symbolique et d’universel : Le jardin d’Eden.</p>
        <p>C’est en associant mes racines à un concept universel qu’est née ma société KERDEN.</p>
        <p>Kerden ouvre un nouveau paradigme qui relie la technologie, à la nature en y associant tous les membres de la société.</p>
      </div>
    </div>
  </div>
  <div class="tropical-garden">
  </div>
  <div class="container">
    <h2 class="about-subtitle text-center">L'Équipe KERDEN</h2>
    <div class="row">
<!--       <div class="col-sm-4">
        <img class='img-responsive' src="{{asset('/images/team/alex.png')}}" alt="alexandre">    
      </div> -->
      <div class="col-sm-4">
        <h3 class="team-title">ALEXANDRE</h3>          
        <h4 class="team-subtitle">Inventif, créatif, sportif.</h4>
        <p class='text-justify'>Etudiant en Architecture d’intérieur à l’école Penninghen, Alexandre a pris conscience du lien entre ; La création, l’art, et la nature. Il a eu alors l’idée de relier son expérience à un concept plus universel, ouvert à tous, créant grandeur nature un nouvel art de vivre: Un site de location de jardins.<br/>Alexandre aime l’eau des ruisseaux en perpétuel mouvement, se frayant ainsi un chemin à travers les éléments.</p>
      </div>
<!--       <div class="col-sm-4">
        <img style="transform:scale(0.8)" class='img-responsive' src="{{asset('/images/team/alice.png')}}" alt="alice">
      </div> -->
      <div class="col-sm-4">
        <h3 class="team-title">ALICE</h3>
        <h4 class="team-subtitle">Energique, créative, cinéphile.</h4>
        <p class='text-justify'>Etudiante en école de cinéma, et élève des cours Florent, Alice a réalisé avec ses amis la vidéo du site, et est en charge de la communication par l’image : Photo et vidéo.<br/>Sa participation a pour objectif de faire vivre le site et d’inspirer les utilisateurs. Alice est passionnée depuis ses jeunes années par la photographie et le cinéma ; Ses réalisations ont d’abord été le témoin de ses aventures, puis sont devenus un support de développement créatif.
        </p>
      </div>
<!--       <div class="col-sm-4">
        <img style="transform:scale(0.8)" class='img-responsive' src="{{asset('/images/team/camille.png')}}" alt="camille">
      </div> -->
      <div class="col-sm-4">
        <h3 class="team-title">CAMILLE</h3>
        <h4 class="team-subtitle">Voyageuse, créative, brillante.</h4>
        <p class='text-justify'>Diplômée d’une école de Commerce, Camille a voyagé pendant un an en Australie et Nouvelle-Zélande. Elle est responsable du développement marketing et du suivi comptable du site. Camille aime le voyage car il favorise l’ouverture et la richesse intérieure. Elle est également passionnée par l’univers sportif.</p>
      </div>
    </div>
    <div class="row">
<!--       <div class="col-sm-4">
        <img class='img-responsive' src="{{asset('/images/team/liza.png')}}" alt="liza">
      </div>   -->    
      <div class="col-sm-4">
        <h3 class="team-title">LIZA</h3>
        <h4 class="team-subtitle">Poète, artiste, lumineuse.</h4>
        <p class='text-justify'>Diplômée de L’Institut Supérieur des Arts Appliqués, Liza a mis ses talents d’illustratrice au service de KERDEN. Inspirée par la poésie de la nature et la douceur des pastels, elle transforme en dessins ses rêveries champêtres. Lorsqu’elle ne dessine pas, Liza aime sillonner les trottoirs parisiens à la recherche de nouvelles adresses secrètes ou s’adonner à ses autres passions, la décoration d'intérieur et la cuisine scandinave.<br><br></p>
      </div>  
<!--       <div class="col-sm-4">
        <img class='img-responsive' src="{{asset('/images/team/simon.jpg')}}" alt="simon">
      </div> -->
      <div class="col-sm-4">
        <h3 class="team-title">SIMON</h3>
        <h4 class="team-subtitle">Naturel, Ingénieux, imaginatif.</h4>
        <p class='text-justify'>Développeur web, et passionné d'informatique, Simon a développé des sites pour de nombreuses entreprises. Lorsqu’il  a été mis en contact avec Alexandre par un ami commun, Simon a été emballé par son projet. Innovation et simplicité sont ses maîtres mots. Il aime la voile, la pêche, et la bonne cuisine.</p>
      </div>
<!--       <div class="col-sm-4">
        <img class='img-responsive' src="{{asset('/images/team/victoire.png')}}" alt="victoire">      
      </div> -->
      <div class="col-sm-4">
        <h3 class="team-title">VICTOIRE</h3>      
        <h4 class="team-subtitle">Philosophe, joyeuse, curieuse.</h4>
        <p class='text-justify'>Passionnée par la lecture dans toutes ses dimensions, de formation commerciale, ayant une expérience professionnelle variée, Victoire met des mots pour faire partager les concepts et les idées aux utilisateurs. Victoire aime les chansons, Saint-Exupéry, Einstein, Platon, Adrienne Farb, Antonio Canova, le Bocage Normand, et les repas arrosés...</p>
      </div>          
    </div>
  </div>
  <div class="petale-garden">
  </div>  
<!--   <div class="header">
    <div class="container">
      <div class="row">
        <h3 class="text-center">L’ÉQUIPE KERDEN :</h3>
        <p class="text-center">Un concept, une vision, un pragmatisme, de l’art, de la technologie…</p>
      </div>
    </div>
  </div> -->
</main> 


@include('footer')

@endsection


@section('scripts')
  <script type="text/javascript" src=" {{ asset('js/zepto.min.js') }} "></script>
  <script type="text/javascript" src=" {{ asset('js/imagesloaded.pkgd.min.js') }} "></script>
  <script type="text/javascript" src=" {{ asset('js/slideshow-home.js') }} "></script>

  <script type="text/javascript" src=" {{ asset('slick/slick.js') }} "></script>
  <script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
  @if(App::getLocale() == 'fr')
  <script src="{{ URL::asset('js/bootstrap-datepicker.fr.js') }}"></script>
  @endif
  <script type="text/javascript">
  (function($){
    var ua = navigator.userAgent;
    var isiPad = /iPad/i.test(ua) || /iPhone OS 3_1_2/i.test(ua) || /iPhone OS 3_2_2/i.test(ua);

      $('#datePicker').datepicker({
          language:'fr',
          format:'dd-mm-yyyy',
          startView:'month',
          autoclose:true,
          todayHighlight:true,
          startDate: new Date()
      });

      $('#categorySelect').select2({
      minimumResultsForSearch: Infinity,
      width:'100%'
    });
    $('#homeactivitySelect').select2({
      minimumResultsForSearch: Infinity,
      width:'100%'
    });

    // if(isiPad){
    //  $('.vTick').vTicker('init',{
    //    mousePause:false,
    //    startPaused:true,
    //    height:32,
    //  });
    // }else{
    //  $('.vTick').vTicker('init',{
    //    mousePause:false,
    //    startPaused:true,
    //    height:31,
    //  });
    // }

    $('.vTick').vTicker('init',{
      mousePause:false,
      startPaused:true,
      height:32
    });

    /***** VIDEO CONTROL *****/
    var isPlaying = false;
      $('#introVideo').click(function(){
          if(!isPlaying){
              $('#introVideo').get(0).play();
              $('.playerPlay').hide();
              isPlaying = true;
          }
          else{
              $('#introVideo').get(0).pause();
              $('.playerPlay').show();
              isPlaying = false;
          }
      })

      $('.glyphicon-volume-off').click(function(){
          $('#introVideo').get(0).muted = false;
          $('.glyphicon-volume-off').hide();
          $('.glyphicon-volume-up').show();        
      });
      $('.glyphicon-volume-up').click(function(){
          $('#introVideo').get(0).muted = true;
          $('.glyphicon-volume-up').hide();
          $('.glyphicon-volume-off').show();        
      });

      $('#carousel-example-generic').on('slide.bs.carousel',function(event){
        $('.vTick').vTicker('next',{animate:true});
        if(/Terrasse/.test(event.relatedTarget.className)){
          $('#accordTrick').fadeIn();
        }else{
          $('#accordTrick').fadeOut();
        }
      });

      //trick de mise en page
      $(window).load(function(){
        $('#toResizeOne').css('height',$('#baseResizeOne').height());
        $('#toResizeTwo').css('height',$('#baseResizeTwo').height());
    });
    $(window).resize(function(){
        $('#toResizeOne').css('height',$('#baseResizeOne').height());
        $('#toResizeTwo').css('height',$('#baseResizeTwo').height());
    });

    $('#introVideo').on('ended',function(){
      $('#introVideo').autoplay=false;
      $('#introVideo').load();
      $('.playerPlay').show();
    });

    function geoCallback(position){
      //console.log(position);
      $('input[name="geolocPosition"]').val('{ "lat":'+position.coords.latitude+',"lng":'+position.coords.longitude+' }');
      $('#homeSearchForm').submit();
    }
    function errorGeoCallBack(error){
      alert('Une erreur est survenue pendant la geolocalisation : '+error.message);
    }

    $('#geoloc').click(function(){
      if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(geoCallback,errorGeoCallBack);
      }else{
        alert('Votre navigateur ne supporte pas la géolocalisation.');
      }
    });

    $('.garden-idea-slideshow').slick({
      slidesToShow: 4,
      prevArrow: "<a class='slick-nav angle-left'><i class='fa fa-angle-left'></i></a>",
      nextArrow: "<a class='slick-nav angle-right'><i class='fa fa-angle-right'></i></a>",
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3
          }
        },      
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2
          }
        }
      ]    
    });

  }) (jQuery);
  </script>


@endsection 