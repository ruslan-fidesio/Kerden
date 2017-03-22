<footer>
    <div class="container">
        <div class="row footerRow">
            <div class="col-sm-4">
                <h4>A propos</h4>
                <!-- <a href="#" data-toggle="modal" data-target="#aboutSiteModal">Qui sommes-nous ?</a> -->
                <a href="{{ url('/about') }}">Qui sommes-nous ?</a>
                <a href="{{ url('/faq') }}">Comment ça marche</a>
                <a href="#" data-toggle="modal" data-target="#cguModal" onclick="$('#cguModal').stop().animate({scrollTop:$('#annulationAnchor').offset().top},'slow'); return false;">Politique d'annulation</a>
                <a href="#" data-toggle="modal" data-target="#cguModal">Conditions générales</a>
                <div class="clearfix"></div>
            </div>
            <div class="col-sm-4 text-center">
                <div><img class="logo" src="{{asset('images/kerden-logo.svg')}}"></div>
                <a class="social-link" target="_blank" href="https://www.facebook.com/Kerden-1065052246903303/"><i class="fa fa-facebook"></i></a>
                <a class="social-link" target="_blank" href="https://www.instagram.com/kerden.fr/"><i class="fa fa-instagram"></i></a>
                <a class="social-link" target="_blank" href="https://fr.pinterest.com/kerden_official"><i class="fa fa-pinterest-p"></i></a>
                <a class="social-link" target="_blank" href="https://twitter.com/Kerden_fr"><i class="fa fa-twitter"></i></a>        
            </div>
            <div class="col-sm-4 text-right">
                <h4>Contact</h4>
                <p>Kerden.fr</p>
                <p>25 Bis rue de l’Armorique 75015</p>
                <p>+33 1 43 35 00 50</p>
                <a href="mailto:contact@kerden.fr"><div id='contactButton'>contact@kerden.fr</div></a>
            </div>
            <div class="col-xs-12 footer-legal">
                Kerden© 2017
            </div>
        </div>
    </div>
</footer>





