@extends('layouts.app')

@section('headers')

<!--   <link href="{{ asset('css/slideshow-home.css') }}" rel="stylesheet">
  <link href="{{ asset('slick/slick.css') }}" rel="stylesheet">
  <link href="{{ asset('slick/slick-theme.css') }}" rel="stylesheet"> -->

@endsection

@section('content')



	<div class="header">
	  <div class="container">	

      <h1>Foire aux questions</h1>
    </div>
  </div>
  <div class="filter-collapse">
    <div class="container">
	  	<ul class="nav nav-pills row no-gutters">
	  		<li class="col-md-2 col-md-offset-4 col-sm-3 col-sm-offset-3 col-xs-6 active">
					<a class="left-faq-tab" href="#tabLoc" data-toggle='tab'>Locataire</a>
				</li> 
				<li class="col-md-2 col-sm-3 col-xs-6">
					<a class="right-faq-tab" href="#tabPro" data-toggle="tab">Propriétaire</a>
				</li>
			</ul>
	  </div>
	</div>
  <div class="side-container">
    <div class="side-bg">

        <div class="col-md-4 grey-bg">

        </div>
        <div class="col-md-8 white-bg">

        </div>
    </div>
  	<div class="container">
  		<div class="tabbable side-padding">
  			<div class="tab-content">
  				<div class="tab-first-level tab-pane fade" id="tabPro">
  					<div class="tabs-left row">
  						<div class="col-sm-3 col-xs-12">
  							<ul class="nav nav-pills-stacked">
  								<li class="active"><a data-faq-tab="ev" href="#evnmts" data-toggle="tab">Evènement</a></li>
  								<li><a data-faq-tab="pa" href="#paiement" data-toggle="tab">Paiement</a></li>
  								<li><a data-faq-tab="pr" href="#prix" data-toggle="tab">Prix</a></li>
  								<li><a data-faq-tab="an" href="#annulation" data-toggle="tab">Annulation</a></li>
  								<li><a data-faq-tab="or" href="#orga" data-toggle="tab">Organisation</a></li>
  							</ul>
  						</div>
  						<div class="tab-content col-xs-12 col-sm-8 col-sm-offset-1">
  							<div class="tab-pane faq-right active fade in" id='evnmts'>
  								<ul>
  									<li>
  										<a href="#collapseQ111" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Pour quel type d’évènement puis-je louer mon jardin ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ111">
  											Je peux louer mon jardin pour tout type d’évènement. Repas, barbecue, réception, fête, activité professionnel… 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ112" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Comment les évènements sont-ils encadrés ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ112">
  											Notre agence partenaire Oscar.fr vous propose des hôtes et hôtesses de sécurité : Les Oscardiens. Si le vous souhaitez sécuriser votre environnement, l’entrée, votre maison, vous pouvez exiger de louer uniquement en présence d’un Oscardien. Il est prévu 1 Oscardien par tranche de 30 invités. Le tarif horaire sera majoré de 34 euros et sera à la charge du locataire.De l’aide pourra être demandée pour le service mais la sécurité des lieux sera leur priorité
  										</div>
  									</li>

  								</ul>
  							</div>
  							<div class="tab-pane faq-right fade" id='paiement'>
  								<ul>
  									<li>
  										<a href="#collapseQ121" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											A partir de quel moment le montant de la location est-il crédité sur mon compte ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ121">
  											Dans les (5) cinq jours suivants la date de l’Evènement.
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ122" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Le locataire doit-il faire l’avance d’un caution ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ122">
  											Non. Chaque partie est détentrice d’une assurance responsabilité civile, qui peut être mise en jeu en cas de litige. 
  										</div>
  									</li>
  								</ul>
  							</div>
  							<div class="tab-pane faq-right fade" id='prix'>
  								<ul>
  									<li>
  										<a href="#collapseQ131" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Comment fixer un prix horaire?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ131">
  											En fonction de la localisation, de l’esthétique, du confort de votre lieu. 
  										</div>
  									</li>
  								</ul>
  							</div>
  							<div class="tab-pane faq-right fade" id='annulation'>
  								<ul>
  									<li>
  										<a href="#collapseQ141" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Que se passe-t-il si j’annule plus de 72h avant le début de l’évènement ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ141">
  											Vous ne percevez aucune rémunération.
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ142" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Puis-je annuler le jour même ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ142">
  											Lorsque vous annulez la réservation moins de 72 heures avant le début de l’évènement, des frais d’annulation de cinquante (50) euros s’appliquent. Ces frais vous sont prélevés lors de la prochaine location et viendront en déduction de la rémunération le Prix de la location.
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ143" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Que se passe-t-il si le locataire annule ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ143">
  											Lorsque le Locataire annule sa réservation plus de 72 heures avant le début de l’Evènement, vous ne percevrez pas de dédommagement.
  											<br>
  											Lorsque le Locataire annule sa réservation moins de 72 heures avant le début de l’Evènement, Kerden verse au Propriétaire 23% du Prix de la Location.
  										</div>
  									</li>

  								</ul>
  							</div>
  							<div class="tab-pane faq-right fade" id='orga'>
  								<ul>
  									<li>
  										<a href="#collapseQ151" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Dois-je fournir tout le matériel nécessaire pour un repas ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ151">
  											Non. C’est le locataire qui prévoir tout le matériel nécessaire au bon déroulement de celui-ci : nappe, assiettes, couverts, verres, serviettes…
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ152" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Dois-je mettre à disposition le matériel nécessaire au fonctionnement du barbecue ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ152">
  											Oui. Vous-devez fournir gaz ou charbon. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ153" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Dois-je mettre à disposition le papier pour l’utilisation des toilettes ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ153">
  											Oui.  
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ154" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Comment dois-je faire si je suis absent ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ154">
  											En cas d’absence, aller dans la rubrique dans votre compte « je serais absent », sélectionner la date de l’évènement, puis renseigner toutes les informations nécessaires au locataire pour qu’il puisse avoir accès au jardin ou à la terrasse. Si l’évènement a lieu avec un Oscardien le message sera directement envoyé à l’Oscardien, c’est lui qui se chargera d’ouvrir et de fermer. 
  										</div>
  									</li>
  								</ul>
  							</div>
  						</div>
  					</div>
  				</div>

  				<div class="tab-first-level tab-pane active fade in" id="tabLoc">
  					<div class="tabbable tabs-left row">
              <div class="col-sm-3 col-xs-12">
    						<ul class="nav nav-pills-stacked">
    							<li class="active"><a data-faq-tab="ev" href="#locevnmts" data-toggle="tab">Evènement</a></li>
    							<li><a data-faq-tab="pa" href="#locpaiement" data-toggle="tab">Paiement</a></li>
    							<li><a data-faq-tab="pr" href="#locprix" data-toggle="tab">Prix</a></li>
    							<li><a data-faq-tab="an" href="#locannulation" data-toggle="tab">Annulation</a></li>
    							<li><a data-faq-tab="or" href="#locorga" data-toggle="tab">Organisation</a></li>		
    						</ul>
              </div>
  						<div class="tab-content col-xs-12 col-sm-8 col-sm-offset-1">
  							<div class="tab-pane faq-right active fade in" id='locevnmts'>
  								<ul>
  									<li>
  										<a href="#collapseQ11" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Pour quel type d’évènement puis-je louer un jardin ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ11">
  											Je peux louer un jardin pour tout type d’évènement. 
  											Repas, barbecue, réception, fête, activité professionnel… 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ12" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Comment les évènements sont-ils encadrés ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ12">
  											Notre agence partenaire Oscar.fr propose aux propriétaires de jardin des hôtes et hôtesses de sécurité : Les Oscardiens. Si le propriétaire souhaite sécuriser son environnement, son entrée, son jardin, sa maison, il peut alors exiger de louer uniquement en présence d’un Oscardien. Il est prévu 1 Oscardien par tranche de 30 invités. Le tarif horaire sera majoré de 34 euros et sera à la charge du locataire.
  											De l’aide pourra être demandée pour le service mais la sécurité des lieux sera leur priorité
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ13" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Puis-je avoir un accès aux toilettes ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ13">
  											Oui, c’est obligatoire. Les toilettes peuvent-être situées à l’intérieur ou à l’extérieur. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ14" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Puis-je avoir un accès à l’ensemble de la maison ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ14">
  											Je ne peux pas avoir accès à l’emble de la maison. En revanche-je peux avoir un accès à la cuisine si le propriétaire a accepté. Vous pouvez voir cela dans la description du jardin. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ15" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Le propriétaire est-il présent sur le lieu de mon évènement ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ15">
  											Le propriétaire peut être présent sur le lieu de l’évènement, mais n’a pas accès au jardin. En cas d’absence, il s’arrangera avec le locataire afin qu’il ait accès au jardin ou à la terrasse. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ16" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Le wifi est-il accessible lors de mon évènement ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ16">
  											L’accès wifi n’est pas présent dans tous les jardins. Son accès est indiqué dans la description du jardin.  
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ17" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Puis-je diffuser de la musique pendant le déroulement de mon évènement ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ17">
  											C’est le propriétaire qui a déterminé cela. Le niveau sonore accepté est indiqué dans la description du jardin.    
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ18" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Les piscines des jardins sont-elles aux normes de sécurité ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ18">
  											Ce critère est indiqué dans la description du jardin.
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ19" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											La présence d’animaux de compagnie est-elle autorisée sur le lieu de mon évènement ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ19">
  											Ce critère est indiqué dans la description du jardin.
  										</div>
  									</li>
  									
  								</ul>
  							</div>
  							<div class="tab-pane faq-right fade" id='locpaiement'>
  								<ul>
  									<li>
  										<a href="#collapseQ21" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											 Puis-je partager le paiement avec plusieurs cartes bancaires ?  
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ21">
  											Non. Une seule carte bancaire doit être utilisée pour le paiement. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ22" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Quel est le mode de paiement accepté par Kerden ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ22">
  											Il n’y qu’un seul moyen de paiement : la carte bancaire. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ23" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Puis-je me faire rembourser du montant de la location ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ23">
  											Sous certaine condition d’annulation vous pouvez obtenir un remboursement partiel ou intégral du montant de la location. <a href="#" data-toggle="modal" data-target="#cguModal">Se référer aux CGU</a>
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ24" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Dois-je faire l’avance d’une caution ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ24">
  											Non. Chaque partie est détentrice d’une assurance responsabilité civile, qui peut être mise en jeu en cas de litige. 
  										</div>
  									</li>
  								</ul>
  							</div>
  							<div class="tab-pane faq-right fade" id='locprix'>
  								<ul>
  									<li>
  										<a href="#collapseQ31" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Qui fixe le prix de la location du jardin ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ31">
  											Le propriétaire. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ32" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Le prix horaire de location peut-il varier pour un même jardin ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ32">
  											Souvent le tarif semaine (lundi, mardi, mercredi, jeudi) est inférieur au tarif week-end (vendredi, samedi, dimanche). En outre, les heures de soirée (après 18h), sont majorées de 20%.
  										</div>
  									</li>
  								</ul>
  							</div>
  							<div class="tab-pane faq-right fade" id='locannulation'>
  								<ul>
  									<li>
  										<a href="#collapseQ41" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Que se passe-t-il si j’annule plus de 72h avant le début de l’évènement ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ41">
  											83% du Prix de la location vous est restitué.
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ42" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ2">
  											Puis-je annuler le jour même ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ42">
  											60% du Prix de la location vous est restitué.
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ43" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ3">
  											Que se passe-t-il si le propriétaire annule ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ43">
  											Vous êtes remboursé intégralement.
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ44" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ4">
  											Que se passe-t-il si j’ai oublié d’annuler mon évènement ?
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ44">
  											A compter du début de l’évènement, aucun remboursement ne peut avoir lieu. Des frais d’annulation de 100% du Prix de la location s’appliquent au locataire.
  										</div>
  									</li>
  								</ul>

  							</div>
  							<div class="tab-pane faq-right fade" id='locorga'>
  								<ul>
  									<li>
  										<a href="#collapseQ51" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Quel matériel apporter sur le lieu de mon évènement ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ51">
  											Si je souhaite organiser un repas, un barbecue, un pique-nique, un goûter… il faut prévoir tout le matériel nécessaire au bon déroulement de celui-ci : nappe, assiettes, couverts, verres, serviettes…
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ52" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Puis-je faire appel à un traiteur sur le lieu de mon évènement ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ52">
  											Oui. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ53" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Puis-je apporter ma propre sono ?  
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ53">
  											Oui. Vérifiez toutefois le niveau sonore accepté par le propriétaire.
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ54" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Dois-je apporter le matériel nécessaire au fonctionnement du barbecue ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ54">
  											Non. Le propriétaire doit fournir gaz ou charbon. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ55" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Dois-je apporter le papier pour l’utilisation des toilettes ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ55">
  											Non. Le propriétaire doit le fournir. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ56" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Dois-je ranger et nettoyer le jardin à la fin de mon évènement ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ56">
  											Le jardin doit-être rendu en l’état trouvé par le locataire au début de l’évènement. 
  										</div>
  									</li>
  									<li>
  										<a href="#collapseQ57" role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" aria-expanded="false" aria-controls="collapseQ1">
  											Dois-je apporter ma serviette de bain ? 
  										</a>
  										<div class="collapse faqCollapse" role="tabpanel" id="collapseQ57">
  											Oui. 
  										</div>
  									</li>
  								</ul>
  							</div>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>


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
