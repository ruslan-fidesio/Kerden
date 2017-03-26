<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kerden.fr est une plateforme communautaire qui permet de louer son jardin à des particuliers pour y réaliser des évènements."/>
    <meta name="google-site-verification" content="Ge2zJVCY_iOdVrIiG-Wa9kaV9-qst3qbKheF4w0SeFs" />



    <title>Kerden - Louez un jardin adapté à votre événement</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png')}}" />
    <link href='https://fonts.googleapis.com/css?family=Roboto:500' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700|Pacifico" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
    <link href=" {{ asset('css/popr.css') }}" rel="stylesheet"> -->
    <link href="{{asset('css/select2.min.css')}}" rel= "stylesheet" />
    <link href="https://file.myfontastic.com/wQHy3VRZHwQQpoT8LekPbE/icons.css" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    @yield('headers')

    <!-- ReCaptcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body id="app-layout" onbeforeunload="resetSelects();">
    <div id="loader">
        <div class="loader-logo"></div>
        <div class="loader-caption">...</div>
    </div>

    <header class="{{ Request::path() == '/' ? 'homepage-header' : '' }}">       
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand navbar-brand-top" href="{{ url('/') }}">
                        <img class="logo" src="{{asset('images/kerden-logo.svg')}}">
                        <img class="logo-homepage" src="{{asset('images/kerden-logo-homepage.svg')}}">
                        <div class="logo-text">erden</div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a class="blue-menu" href="#" data-toggle="modal" data-target="#inscriptionModal">{{trans('auth.register')}}</a></li>
                    <li><a class="green-menu" href="#" data-toggle="modal" data-target="#connexionModal">{{trans('auth.login')}}</a></li>
                @else
<!--                     <li class="dropdown">
                        <a href="#" class="blue-menu dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            @if(Auth::user()->unreadMessages > 0)
                                <span class="badge"{{ Auth::user()->unreadMessages }}</span>
                            @endif    
                            Mon espace
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/home') }}"><i class='fa fa-btn fa-user'></i> Espace membre</a> </li>
                            <li><a href="#"><i class='fa fa-shield'></i> Espace Ker'house</a> </li>
                            <li><a href="{{ url('/logout') }}">Déconnexion</a></li>
                        </ul>
                    </li> -->
                    <li class="spe-size"><a class="blue-menu" href="{{ url('/home') }}">Mon espace</a></li>
                    <li class="spe-size"><a class="green-menu" href="{{ url('/logout') }}">Déconnexion</a></li>
                @endif  
                <li class="separator-line"></li>
                @if(Auth::user())

                @endif                              
                <!-- Authentication Links -->
                <li><a class="rentCTA" 
                    @if(Auth::guest())
                        href="/rent"
                    @else
                        @if(count(Auth::user()->ownedGardens)>0)
                            href="{{url('/garden/update/'. Auth::user()->ownedGardens[0]->id )}}" 
                        @else
                            href="/rent"
                        @endif
                    @endif
                >{{trans('base.rent')}}</a>
                </li>
            </ul>
                </div>
            </div>
        </nav>
        @if (Request::path() == '/')
            <h1 class="home-title">Location de jardins et terrasses</h1>        
        @endif
    </header>

    <main class="{{ Request::path() == '/' ? 'homepage-content' : 'content' }}">
        @yield('navbar')
        @yield('content')
    </main>
    

    @if(Auth::User() && Auth::user()->role->role == 'admin')
        <div class="adminChat"></div>
        <div class="modelChat" style='display:none'>
    @else
        <div class="liveChat">
    @endif
        <div class="title"><div class="logo"></div> <span>Besoin d'aide ?</span> <i class="fa fa-expand liveExpandIcon"></i></div>
        <div class="content" style='display:none'>

            <div id='noServerWarning' style='display:none;'>
                @if(session()->has('questionSent'))
                    Votre message a été envoyé. L'équipe vous recontactera au plus vite.
                @else
                <ul><li><div class="pseudo">L'équipe Kerden</div><div class="mess">Bonjour, comment pouvons-nous vous aider?</div></li></ul>
                <form action="/offlineContact" method="POST" id="offlineForm">
                    {!! csrf_field() !!}
                    <textarea name="content" id="content" cols="15" rows="4">{{old('content')}}</textarea>
                    
                <div id="offLineFormPartTwo" @if ($errors->has('email') || $errors->has('g-recaptcha-response')) style="display:block" @else style="display:none" @endif>
                    <span>Le serveur est actuellement hors ligne. Merci de renseigner votre adresse e-mail, notre équipe vous recontactera au plus vite.</span>
                    <input type="text" id="senderMail" name="email" placeholder="Votre email" value="{{ old('email')? old('email') :( Auth::guest()?'':Auth::user()->email ) }}"/>
                    @if ($errors->has('email'))
                        <span class="help-block" style="color:red;">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    

                </div>
                <button class='btn-kerden-confirm' style="border-style:none">Envoyer</button>


                </form>
                @endif
            </div>

            <ul id="liveChatMessagesList">
                <li><div class="pseudo">L'équipe Kerden</div><div class="mess">Bonjour, comment pouvons-nous vous aider?</div></li>
            </ul>

            <form action="" id="liveChatNewMessageForm" class="newMessageForm" onsubmit="return false;">
                <textarea class="newChatMessageArea" name="liveChatArea" id="liveChatNewMessageInput" cols="30" rows="3" placeholder="Tapez votre message..."></textarea>
                <button class='btn-kerden-confirm' style="border-style:none">Envoyer</button>
            </form>
        </div>

    </div>

    <div class="modal fade" id="connexionModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4>Connexion</h4>
          </div>
          <div class="modal-body">
                        <a class="providerLink" href='/google/login'>
                            <div class="provider googleLogin">
                                <img src="{{asset('images/logos/g-logo.png')}}" >
                                <span>Connexion avec Google</span>
                            </div>
                        </a>

                        <a class="providerLink" href="/facebook/login">
                            <div class="provider facebookLogin" >
                                <img src="{{asset('images/logos/FB_blue.png')}}">
                                <span>Connexion avec Facebook</span>
                            </div>
                        </a>

                        <div class="row or text-center">OU</div>

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}" id='mainLoginForm'>
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label col-xs-12">Adresse E-Mail</label>

                                <div class="col-xs-12">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label col-xs-12 text-left">Mot de passe</label>

                                <div class="col-xs-12">
                                    <input type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-kerden-confirm">
                                        Connexion
                                    </button>
                                </div>
                            </div>
                        </form>
                        <hr/>
                        <div class="modal-sublink row text-center">
                            <div class="col-xs-6">
                                <a href="#" id="switchModal">
                                    <div>Pas de compte ? Inscrivez-vous</div>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a href="{{ url('/password/reset') }}">Mot de passe oublié?</a>
                            </div>
                        </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" id="inscriptionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>Inscription</h4>
                </div>
                <div class="modal-body">
                    <a class="providerLink" href='/google/login'>
                            <div class="provider googleLogin">
                                <img src="{{asset('images/logos/g-logo.png')}}" >
                                <span>Continuer avec Google</span>
                            </div>
                        </a>

                        <a class="providerLink" href="/facebook/login">
                            <div class="provider facebookLogin" >
                                <img src="{{asset('images/logos/FB_blue.png')}}">
                                <span>Continuer avec Facebook</span>
                            </div>
                        </a>
                    <div class="row or text-center">OU</div>

                    <a class="providerLink" href="/register">
                        <div class="provider mailRegister">
                            <img src="{{ asset('images/mail_inscription.png') }}">
                            <span>Inscription avec un Email</span>
                        </div>
                    </a>
                    <br>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="privacy" tabindex="-1" role="dialog">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>Vie privée</h4>
                </div>
                <div class="modal-body">

                    <h3>CHARTE DE PROTECTION DES DONNEES PERSONNELLES</h3>


                    <p>La société Adenor attache une grande importance à la protection de votre vie privée et des informations vous concernant.</p>

                    <p>Nous nous engageons, dans le cadre de nos activités et conformément à la législation en vigueur en France et en Europe, à assurer l’intégrité, la confidentialité́ et, d’une manière générale, la sécurité des données à caractère personnel des utilisateurs de nos services.</p>

                    <p>Vous êtes invité à lire attentivement la présente charte de protection des données personnelles (ci-après, la « Charte »).</p>

                    <p>L’objectif de notre Charte est de définir les règles applicables aux données à caractère personnel (ci-après les « Données Personnelles ») que nous collectons, traitons et conservons à partir du Service Kerden.</p>

                    <p>La présente Charte fait partie intégrante des Conditions d’utilisation du Service Kerden. La Charte s’applique aux utilisateurs inscrits au Service Kerden, quelle que soit leur catégorie : Locataire, Propriétaire et Ker-House.</p>


                    <h3>Table des matières</h3>

                    <ul>
                    <li>1. Entrée en vigueur et mise à jour de la Charte</li>
                    <li>2. Loi applicable et responsabilités</li>
                    <li>3. Données personnelles recueillies par le Service Kerden</li>
                    <li>4. Utilisation des Données Personnelles </li>
                    <li>5. Sécurité des Données Personnelles </li>
                    <li>6. Droits des Utilisateurs</li>
                    <li>7. Questions</li>
                    </ul>

                    <h3>Article 1. Entrée en vigueur et mise à jour de la Charte</h3>

                    <p>La présente Charte entre en vigueur à compter du 15 mars 2017.</p>

                    <p>Nous nous réservons le droit de modifier la présente Charte à tout moment en mettant en ligne sur le Site Kerden la nouvelle version. Cette nouvelle version de la Charte entrera en vigueur dès votre inscription si vous êtes un nouvel utilisateur, et 15 jours après sa mise en ligne si vous êtes déjà utilisateur de nos services. Si vous êtes un Utilisateur déjà inscrit, une fenêtre pop-up apparaîtra lors de votre connexion sur le Site Kerden vous notifiant la modification de la Charte. Si vous refusez la nouvelle version de la Charte, vous ne pourrez plus accéder au Service Kerden à l’issue de la période de 15 jours. </p>

                    <p>Nous communiquons la Charte modifiée à l’Utilisateur afin que vous soyez toujours pleinement informé des catégories de Données Personnelles recueillies, de la manière dont elles sont utilisées, et des circonstances dans lesquelles elles peuvent être communiquées. </p>

                    <p>D’une manière générale, la Charte est facilement accessible via les différentes pages du Site Kerden.</p>

                    <h3>Article 2. Loi applicable et responsabilités</h3>

                    <p>Le traitement des Données Personnelles des Utilisateurs inscrits au Service Kerden est soumis à la loi française, notamment à la loi dite Informatique et Libertés n°78-17 du 6 janvier 1978, modifiée.</p>

                    <p>Conformément aux dispositions de ladite Loi, le traitement des Données Personnelles des Utilisateurs du Service Kerden a dûment été déclaré à la Commission Nationale Informatique et Libertés (CNIL), sous le numéro 2012473.</p>

                    <p>Le responsable du traitement des Données Personnelles des Utilisateurs du Service Kerden est :
                    <ul>
                        <li>Société ADENOR</li>
                        <li>RCS Paris n° 820 157 717 </li>
                        <li>25 bis rue de l’Armorique - 75015 Paris</li>
                    </ul>
                    </p>

                    <p>Le prestataire d’hébergement des Données Personnelles des Utilisateurs du Service Kerden, agissant en qualité de sous-traitant, est :</p>

                    <p>Société HEROKU<br>
                    650 7th St - San Francisco,<br>
                    CA 94103 - États-Unis
                    </p>
                    <p>
                    Les tiers : le Service Kerden peut intégrer des liens hypertextes en direction de sites internet tiers, y compris des sites de partenaires commerciaux. Si vous vous inscrivez sur des sites tiers, la collecte et l’utilisation de vos Données Personnelles sur ces sites sera soumise à leurs propres conditions d’utilisation. L’application de la présente Charte ne s’étend pas aux sites tiers. Nous ne sommes pas responsables de la façon dont ces sites utilisent vos Données Personnelles.
                    </p>

                    <h3>Article 3. Données personnelles recueillies par le Service Kerden</h3>

                    <h4>3.1 Conditions de collecte</h4>

                    <p>Vous n’avez pas besoin de vous inscrire sur le Site Kerden pour y accéder et naviguer sur ses différentes pages. </p>

                    <p>Nous collectons uniquement les Données Personnelles des internautes qui :
                    <ul>
                        <li>-   Souhaitent obtenir des informations complémentaires sur nos activités et les newsletters de Kerden ; </li>
                        <li>-   Souhaitent réserver un espace extérieur (jardin, terrasse, domaine, etc.) (« Espace extérieur ») ;</li>
                        <li>-   Souhaitent louer un Espace extérieur.</li>
                        <li>-   Reçoivent une invitation à un Evènement par le biais de la plateforme Kerden</li>
                        <li>-   Exécutent des prestations de services en qualité de Ker-House</li>
                    </ul>
                    </p>

                    <p>Dans ces conditions, l’accès et l’utilisation du Service Kerden impliquent un traitement de vos Données Personnelles (nom, prénom, adresse e-mail, mot de passe, numéro de téléphone, etc.).</p>

                    <p>L’inscription au Service Kerden peut se réaliser de deux façons, soit via un formulaire d’inscription, soit via un service tiers (Google ou Facebook).</p>

                    <p>Le formulaire d’inscription comprend une rubrique relative à la possibilité pour la société Adenor d’utiliser vos Données Personnelles à des fins marketing ou commerciales (tel que newsletter, questionnaire et informations sur des services similaires). </p>

                    <h4>3.2 Cookies </h4>

                    <p>Des cookies sont utilisés sur le Site Kerden. Les cookies (ou « traceurs ») sont des programmes (ou petits fichiers textes), stockées sur votre ordinateur, ne permettant pas de vous identifier. Ils servent à enregistrer vos informations de navigation sur le Site Kerden. </p>

                    <p>Lors de vos visites sur le Service Kerden, un cookie peut s’installer automatiquement sur votre logiciel de navigation. Ces cookies permettent une navigation personnalisée de l’Utilisateur et sont également utilisés à des fins statistiques et publicitaires. Ces cookies nous permettent de reconnaître les Utilisateurs lors de leur retour sur le Site Kerden, de mémoriser les données que vous avez saisies lors de votre navigation sur notre Service Kerden (choix de la langue, type de navigateur, etc.) et de ne pas vous demander les mêmes informations plusieurs fois lors de votre visite sur notre Site Kerden. </p>

                    <p>Vous serez averti de leur existence et de leur(s) finalité(s) dès votre connexion sur le Site Kerden par la présence d’un bandeau placé en bas ou en haut de la page d’accueil, indiquant « En poursuivant votre navigation, vous acceptez l’utilisation de cookies pour vous proposer une navigation personnalisée et réaliser des statistiques de visites. ». Le dépôt et la lecture des cookies sur votre terminal nécessitent votre consentement préalable, en cliquant sur « J’accepte ». Vous pouvez toutefois configurer votre navigateur pour refuser les cookies ou personnaliser les paramètres des cookies en cliquant sur un lien « En savoir plus ». En cas de refus des cookies, nous vous informons que le Site Kerden peut ne pas fonctionner dans son intégralité ou être bloqué. Si vous acceptez l’utilisation de cookies, votre accord aura une durée de validité de 13 mois. Il sera alors nécessaire de renouveler votre accord à l’expiration de cette durée. </p>

                    <p>En outre, des cookies peuvent être placés de temps à autres sur certaines pages du Site Kerden par des tiers (annonceurs publicitaires ou autres). Nous vous informons que nous n’exerçons aucun contrôle sur l’utilisation de cookies par les tiers. </p>
                     
                    <h3>Article 4. Utilisation des Données Personnelles</h3>

                    <p>Les Données Personnelles concernant l’Utilisateur sont collectées et traitées de manière loyale et licite pour des finalités déterminées, explicites et légitimes, sans être traitées ultérieurement de manière incompatible avec ces finalités, sous une forme permettant l’identification des Utilisateurs pendant une durée qui n’excède pas la durée nécessaire aux finalités pour lesquelles elles sont collectées et traitées.</p>

                    <h4>4.1 Finalités du traitement </h4>

                    <p>Les Données Personnelles des Utilisateurs sont collectées et traitées selon une finalité définie et précise, telle que déclarée à la Commission nationale de l’informatique et des libertés (CNIL). </p>

                    <p>A ce titre, nous collectons vos données pour les finalités générales suivantes :
                    <ul>
                        <li>•   Gérer votre inscription et votre compte, notamment pour votre accès à notre Service et son utilisation</li>
                        <li>•   Communiquer avec vous en général</li>
                        <li>•   Répondre à vos questions et commentaires éventuels</li>
                        <li>•   Mesurer votre intérêt pour nos services et notre Site et les améliorer</li>
                        <li>•   Vous informer des produits et services que nous proposons et qui peuvent vous intéresser d'après vos préférences</li>
                        <li>•   Collecter des renseignements auprès de vous, notamment à travers des enquêtes de satisfaction par exemple</li>
                        <li>•   Résoudre des litiges ou des problèmes entre Utilisateurs par exemple</li>
                        <li>•   Empêcher d'éventuelles activités interdites ou illégales via notre Site Kerden.</li>
                    </ul>
                    </p>
                    <h4>4.2 Durée de conservation</h4>

                    <p>Les Données Personnelles sont conservées pour la durée nécessaire aux finalités du traitement. Les données collectées, la durée de leur conservation ainsi que leurs destinataires sont déterminés en fonction de ces finalités. </p>

                    <p>Nous nous engageons à conserver vos Données Personnelles uniquement pendant la durée strictement nécessaire au(x) traitement(s) envisagé(s) ou pour satisfaire aux obligations légales, et en toute hypothèse dans les limites imposées par la loi. </p>

                    <p>Nous nous engageons à effacer les données de nos bases de données à l’issue de cette durée. Toutefois, nous pouvons conserver certaines informations pour une période postérieure à la clôture de votre compte Utilisateur, par exemple si cela s'avérait nécessaire pour remplir nos obligations légales ou en vue d'exercer, de défendre ou de faire valoir nos droits.</p>

                    <h4>4.3 Campagnes marketing</h4>

                    <p>Nous vous recommandons de nous autoriser à utiliser vos Données Personnelles (adresse e-mail, adresse postale, numéro de téléphone) dans le cadre de nos campagnes marketing et promotionnelles, mais également à des fins purement statistiques sur l’utilisation des services proposés par la société Adenor. Nos actions de marketing et d’études statistiques ont pour objet d’améliorer nos services. Vous pouvez, par ailleurs, modifier vos préférences de notification à tout moment, en acceptant ou en refusant que vos Données Personnelles soient utilisées dans le cadre de nos actions marketing ou promotionnelles en vous rendant sur les paramètres de votre compte Utilisateur. </p>

                    <h4>4.4 Partage d’informations</h4>

                    <p>Vous reconnaissez et acceptez que vos données puissent, le cas échéant, être transmises à des tiers sous-traitants intervenant dans la fourniture du Service Kerden. La société Adenor s’engage à ne communiquer vos Données Personnelles qu’à ses prestataires habilités et s’assure qu’ils respectent des conditions strictes de confidentialité, d’usage et de protection des données. </p>

                    <p>Par ailleurs, les Données Personnelles pourront être divulguées à un tiers si la société Adenor y est contrainte par la loi, une disposition réglementaire, ou une ordonnance judiciaire, ou encore si cette divulgation est rendue nécessaire pour les besoins d’une enquête ou d’une procédure judiciaire, sur le territoire national ou à l’étranger.</p>

                    <h4>4.5 Résolution des litiges</h4>

                    <p>Outre les Données Personnelles collectées à partir du formulaire d’inscription que vous avez rempli, nous pouvons être amenés à utiliser les informations vous concernant à partir de vos activités sur le Site Kerden pour résoudre tout litige éventuel ou régler tout problème dans le cadre de l’utilisation du Service Kerden.</p>

                    <h3>Article 5. Sécurité des données personnelles</h3>

                    <p>Les données de connexions (identifiant et/ou mot de passe) vous permettant de vous connecter au Service Kerden sont personnelles et confidentielles. Pour des raisons de sécurité, vous ne divulguerez pas votre identifiant ni votre mot de passe à quiconque. Vous êtes seul responsable pour toutes les conséquences de nature contractuelle, financière ou autres, qui pourraient résulter de toute utilisation non autorisée de vos données de connexion par des tiers et vous garantissez la société Adenor contre toute demande à ce titre. La société Adenor se réserve le droit de suspendre votre compte au cas où nous aurions des raisons de croire que vos données de connexion ont été diffusées de votre fait, volées ou utilisées sans votre accord. </p>

                    <p>Vos Données Personnelles sont stockées sur des serveurs situés en France et dans l’Union européenne. La société Adenor accorde la plus haute importance à la sécurité de vos informations À cet effet, la société Adenor et ses prestataires d’hébergement ont déployé des mesures appropriées pour assurer la sécurité et la confidentialité de vos Données Personnelles. Nous ne pouvons cependant assurer que vos communications et autres Données Personnelles ne seront pas interceptées ou divulguées par un tiers. </p>

                    <h3>Article 6. Droits des Utilisateurs </h3>

                    <p>Vous disposez d’un droit d’accès, d’un droit de rectification, d’un droit de suppression et de portabilité de vos Informations Personnelles. De même, vous bénéficiez du droit de vous opposer à la collecte et au traitement de tout ou partie de celles-ci à des fins de prospection commerciale, y compris de profilage dans la mesure où il est lié à une telle prospection. </p>

                    <p>Vous pouvez exercer ces droits à tout moment afin de :
                    <ul>
                    <li>(1)   Mettre à jour ou corriger les données vous concernant</li>
                    <li>(2)   Vérifier les données vous concernant que nous conservons</li>
                    <li>(3)   Modifier vos préférences relativement aux communications et aux autres informations que vous recevez de notre part</li>
                    <li>(4)  Demander la fermeture de votre compte Utilisateur à tout moment ainsi que la suppression et le transfert (chez vous ou chez un prestataire tiers) de vos Données Personnelles.</li>
                    </ul>
                    </p>

                    <p>Si vous exercez ces droits, nous nous efforçons de répondre à vos demandes dans les meilleurs délais. En cas de demande de suppression, nous détruirons les données vous concernant. Nous nous réservons cependant le droit de conserver certaines catégories de données qui pourraient être nécessaires en cas de réclamation ou de litige ultérieur, et ce pendant la durée de conservation légalement autorisée. Ces données seront cependant désactivées et ne seront plus accessibles en ligne.</p>

                    <p>Pour exercer ses droits, vous pouvez (i) soit vous rendre sur les paramètres de votre compte Utilisateur, (ii) soit adresser un courrier postal à l’adresse mentionnée à l’article 2 ci-dessus, (iii), soit envoyer un e-mail à support@kerden.fr.  </p>

                    <h3>Article 7. Questions</h3>

                    <p>Pour toute question, commentaires ou remarques concernant la présente Charte, et d’une manière générale sur la collecte et le traitement de vos Données Personnelles par la société Adenor, veuillez nous envoyer un message à l’adresse e-mail suivante : support@kerden.fr. </p>




                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mentions" tabindex="-1" role="dialog">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>Mentions légales</h4>
                </div>
                <div class="modal-body">

                    <p>Le service accessible à l’URL http://kerden.fr est proposé par la société ADENOR, SAS au capital social de 15.000 euros, inscrite au RCS de Paris sous le numéro 822 675 963, dont le siège social est situé au 25 bis rue de l’Armorique – 75015 Paris - France (ci-après, le « Site Kerden » ou le « Service Kerden » ou la « Société » ou « Kerden »).</p>
                    <p>Le responsable du traitement des Données Personnelles des Utilisateurs du Service Kerden est : <br>
                        Société ADENOR<br>
                        RCS Paris n° 820 157 717 <br>
                        25 bis rue de l’Armorique - 75015 Paris<br>
                    </p>
                    <p>Le prestataire d’hébergement des Données Personnelles des Utilisateurs du Service Kerden, agissant en qualité de sous-traitant, est :<br>
                    Société HEROKU<br>
                    650 7th St - San Francisco,<br>
                    CA 94103 - États-Unis
                    </p>


                </div>
            </div>
        </div>
    </div>



    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{asset('js/jquery.ui.touch-punch.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js" crossorigin="anonymous"></script>
    <script src=" {{ asset('js/popr.min.js') }}"></script>
    <script type="text/javascript" src=" {{ asset('js/select2.min.js') }} "></script>
    <script type="text/javascript" src=" {{ asset('js/jquery.vticker.min.js') }} "></script>
    <script type="text/javascript" src=" {{ asset('js/socket.io.min.js') }} "></script>

    <script type="text/javascript">

        var base = "kerden_mess_";
        function storeMessageInSession(message){    
            var index = 0;
            while( sessionStorage.getItem(base+index) !=null ) index++;
            sessionStorage.setItem(base+index,message);
        }

        function checkNotificationPermission(){
            if(Notification.permission === 'denied') return false;

            Notification.requestPermission(function (permission) {
              if(!('permission' in Notification)) {
                Notification.permission = permission;
              }
            });
            return (Notification.permission === "granted");
        }

        function notifyNewMessage(pseudo,message){
            if(document.visibilityState === "visible") return;

            if(!('Notification' in window)){
                console.log('Notifications non supportées');
                return;
            }

            if(Notification.permission === "granted"){
                //NOTIFY
                var notif = new Notification('Nouveau Message de '+pseudo+' sur Kerden.fr', {
                    icon: 'http://kerden.dev/images/kerden-logo.png',
                    body: message,
                  });
                notif.onclick = function(){ window.focus(); this.close();}
            }
            else{
                if( checkNotificationPermission() ){
                    var notif = new Notification('Nouveau Message de '+pseudo+' sur Kerden.fr', {
                    icon: 'http://kerden.dev/images/kerden-logo.png',
                    body: message,
                  });
                    notif.onclick = function(){ window.focus(); this.close();}
                }
            }
        }

        (function($){
            @if (Request::path() != 'register')
                $('#connexionModal').has('.help-block').modal('show');
            @endif

            $('#switchModal').click(function(e){
                $('#connexionModal').modal('hide');
                $('#inscriptionModal').modal('show');
            });
            $(window).load(function(){
                $("#loader").fadeOut("1000");
                $(".unloaded").removeClass (function (index, css) {
                    return (css.match (/(^|\s)unloaded-\S+/g) || []).join(' ');
                });
                $('.unloaded').removeClass('unloaded');
            });
            $('.faqCollapse').on('show.bs.collapse',function(){
                $('.faqCollapse').not(this).collapse('hide');
            });

            var lastObj;
            $("a[data-faq-tab]").on('click',function(event){
                var obj = $('.tab-first-level').not('.active').find('a[data-faq-tab="'+event.target.dataset.faqTab+'"]');
                if(obj.is(lastObj)){
                    return null;
                }
                else{
                    lastObj = obj;
                    obj.click();
                }
            });

            $('#homepageRentDropdown').click(function(){
                $('#homepageRentSelect').slideToggle();
            });
            $('#homepageGuestRentDropdown').click(function(){
                $('#homepageGuestRentSelect').slideToggle();
            });
            /*Trick for font-weight on chrome under windows*/
            if(/Chrome/.test(navigator.userAgent) && /Windows/.test(navigator.userAgent)){
                console.log("part case");
                $("html").attr("style",'font-weight:600!important');
            }

            /*LIVE CHAT*/

            var socket = io( "{{ env('SOCKET_URL','https://kerdenlivechat.herokuapp.com') }}" );

            socket.on('connect_error',function(){
                $('#noServerWarning').show();
                $('#liveChatNewMessageForm').hide();
                $('#liveChatMessagesList').hide();
            });


            @if(Auth::user() && Auth::user()->role->role == 'admin')
                var myPseudo = '{{Auth::user()->firstName}}';
                socket.emit('admin connect',myPseudo);
                socket.on('newUser',function(pseudo,id,session){
                    var newChat = $('.modelChat').clone().addClass('adminChatWindow').removeClass('modelChat').addClass('live_'+id);
                    $(newChat).find('.title span').text('- Discussion avec '+$('<div/>').html(pseudo).text());
                    $(newChat).find('.title').click(function(){
                        $(newChat).find('.content').slideToggle();
                        $(newChat).find('.liveExpandIcon').toggleClass('fa-expand fa-window-minimize');
                    });
                    $(newChat).find('textarea').keydown(function(event){
                        if(event.keyCode==13){
                          $(newChat).find('.newMessageForm').submit();
                          return false;  
                        } 
                    } );
                    $(newChat).find('form').append('<input type="hidden" name="id" value="'+id+'">');
                    $(newChat).find('.newMessageForm').submit(function(){
                        socket.emit('adminMessage',id,myPseudo,$(this).find('textarea').val());
                        $(this).find('textarea').val('').focus();
                        return false;
                    });
                    $('.adminChat').append(newChat.show());
                    var index = 0;
                    while( session[base+index] != undefined){
                        var tab = /(.+)::(.+)/.exec(session[base+index]);
                        $(newChat).find('ul').append( '<li><div class="pseudo">'+tab[1].replace('Vous',pseudo)+'</div><div class="mess">'+tab[2]+'</div></li>' );
                        index++;
                    }
                    if(index>0){
                        window.newChat = newChat;
                        $(newChat).find('.content').slideDown();
                        $(newChat).find('ul').scrollTop(  $(newChat).find('ul')[1].scrollHeight );  
                    }
                });
                socket.on('new message',function(id,pseudo,message){
                    $('.live_'+id).find('.content').show();
                    var theUL = $('.live_'+id).find('ul');
                    window.theUL= theUL;
                    $(theUL).append( '<li><div class="pseudo">'+pseudo+'</div><div class="mess">'+message+'</div></li>' );
                    $(theUL).scrollTop( theUL[1].scrollHeight );
                    notifyNewMessage(pseudo,message);
                });
                socket.on('userOut',function(id){
                    $('.live_'+id).remove();
                });
            @else
                @if(Auth::guest())
                    var myPseudo = 'Invité';
                @else
                    var myPseudo = '{{Auth::user()->firstName}}';
                @endif

                socket.emit('user connect', myPseudo ,sessionStorage);
                $('#liveChatNewMessageForm').submit(function(){
                    $('#liveChatMessagesList').append( '<li><div class="pseudo">Vous</div><div class="mess">'+$('#liveChatNewMessageInput').val()+'</div></li>' );
                    socket.emit('new message',myPseudo ,$('#liveChatNewMessageInput').val());
                    storeMessageInSession("Vous::"+$('#liveChatNewMessageInput').val() );
                    $('#liveChatNewMessageInput').val('').focus();
                    $('#liveChatMessagesList').scrollTop(  $('#liveChatMessagesList')[0].scrollHeight );
                    return false;
                });
                socket.on('welcomeUser',function(){
                    $('#noServerWarning').hide();
                    $('#liveChatNewMessageForm').slideDown();
                    $('#liveChatMessagesList').slideDown();
                });
                socket.on('adminMessage',function(pseudo,message){
                    $('.liveChat .content').slideDown();
                    $('#liveChatExpand').hide();
                    $('#liveChatMinimize').show();
                    $('#liveChatMessagesList').append( '<li><div class="pseudo admin">'+pseudo+'</div><div class="mess">'+message+'</div></li>' );
                    storeMessageInSession(pseudo+'::'+message);
                    $('#liveChatMessagesList').scrollTop(  $('#liveChatMessagesList')[0].scrollHeight );
                    notifyNewMessage(pseudo,message);
                });
                $('.newChatMessageArea').keypress(function(event){
                    if (event.keyCode == 13){
                        $(this).parent().submit();
                        return false;
                    }
                });
                $('#offlineForm').find('textarea').keypress(function(event){
                    if(event.keyCode == 13){
                        $(this).parent().submit();
                        return false;
                    }
                });
                var firstSub = true;
                $('#offlineForm').submit(function(){
                    if(firstSub){
                        $('#offLineFormPartTwo').slideDown();
                        firstSub = false;
                        return false;
                    }
                });
            @endif

            
            socket.on('no admin',function(){
                $('#noServerWarning').show();
                $('#liveChatNewMessageForm').hide();
                $('#liveChatMessagesList').hide();
            });

            $('.liveChat .title').click(function(){
                $('.liveChat .content').slideToggle();
                $('.liveChat .liveExpandIcon').toggleClass('fa-expand fa-window-minimize');
            });

            //LOAD PREVIOUS CHAT MESSAGES
            if(sessionStorage.length >0){
                var index=0;
                var item;
                while( (item = sessionStorage.getItem( base+index ) )!=null ){
                    var tab = /(.+)::(.+)/.exec(item);
                    $('#liveChatMessagesList').append( '<li><div class="pseudo">'+tab[1]+'</div><div class="mess">'+tab[2]+'</div></li>' );
                    index++;
                }
                $('.liveChat .content').slideDown();
                $('#liveChatExpand').hide();
                $('#liveChatMinimize').show();
                $('#liveChatMessagesList').scrollTop(  $('#liveChatMessagesList')[0].scrollHeight );
                $('.liveChat .liveExpandIcon').toggleClass('fa-expand fa-window-minimize');
            }

        }) (jQuery);
    </script>
    
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @yield('baseHomeScript')
    @yield('scripts')
</body>
</html>
