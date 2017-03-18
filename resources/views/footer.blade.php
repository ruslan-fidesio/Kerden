<div class="row footerRow">
    <div class="col-xs-12 text-center kerdenLogoRow">
        <img src="{{asset('images/kerden-logo.png')}}" style="max-width:50px;margin-bottom:10px">
    </div>
    <div class="col-xs-4 text-center">
        <span>Politique</span>
        <a href="#" data-toggle="modal" data-target="#cguModal" onclick="$('#cguModal').stop().animate({scrollTop:$('#annulationAnchor').offset().top},'slow'); return false;"><p>Politique d'annulation</p></a>
        <a href="#" data-toggle="modal" data-target="#cguModal"><p>Conditions générales d'utilisation</p></a>
    </div>
    <div class="col-xs-4 text-center">
        <span>&Agrave; propos de</span>
        <a href="#" data-toggle="modal" data-target="#aboutSiteModal"><p>Kerden.fr</p></a>
        <a href="#" data-toggle="modal" data-target="#teamModal"><p>L'équipe</p></a>
        <a href="#" data-toggle="modal" data-target="#faqModal"><p>F.A.Q</p></a>
    </div>
    <div class="col-xs-4 text-center">
        <span>Contact</span>
        <p><i class="fa fa-phone"></i>+33 1 43 35 00 50</p>
        <a href="mailto:contact@kerden.fr"><i class="fa fa-envelope"></i>&nbsp;<div id='contactButton'>contact@kerden.fr</div></a>
    </div>
    <div class="col-xs-12 text-center logoRow">
        <a target="_blank" href="https://www.facebook.com/Kerden-1065052246903303/"><img src="{{asset('images/logos/fb.png')}}"></a>
        <a target="_blank" href="https://www.instagram.com/kerden.fr/"><img src="{{asset('images/logos/instagram.png')}}"></a>
        <a target="_blank" href="https://fr.pinterest.com/kerden_official"><img src="{{asset('images/logos/pinterest.png')}}"></a>
        <a target="_blank" href="https://twitter.com/Kerden_fr"><img src="{{asset('images/logos/twitter.png')}}"></a>
    </div>
</div>

<div class="modal fade"  id="aboutSiteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="font-family:'Avenir Next'">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">&Agrave; propos</h4>
            </div>
            <div class="modal-body">
                @include('about')
            </div>
        </div>
    </div>
</div>

<div class="modal fade"  id="faqModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="font-family:'Avenir Next'">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title faqTitle">F.A.Q.</h4>
            </div>
            <div class="modal-body" id="faqBody">
                @include('faq')
            </div>
        </div>
    </div>
</div>

<div class="modal fade"  id="teamModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="font-family:'Avenir Next'">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">L'Équipe</h3>
            </div>
            <div class="modal-body">
                @include('theTeam')
            </div>
        </div>
    </div>
</div>