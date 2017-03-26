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
                    <li class="dropdown">
                        <a href="#" class="blue-menu dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            @if(Auth::user()->unreadMessages > 0)
                                <i class="fa fa-envelope-o"></i><sup class="unreadNumber">{{ Auth::user()->unreadMessages }}</sup>
                            @endif    
                            <span class="badge">4</span>                                                    
                            Mon espace
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/home') }}"><i class='fa fa-btn fa-user'></i> Espace membre</a> </li>
                            <li><a href="#"><i class='fa fa-shield'></i> Espace Ker'house</a> </li>
                            <li><a href="{{ url('/logout') }}">Déconnexion</a></li>
                        </ul>
                    </li>
                    <li><a class="green-menu" href="{{ url('/logout') }}">Déconnexion</a></li>
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

    <div class="modal fade" id="cguModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>Conditions Générales d'Utilisation</h4>
                </div>
                <div class="modal-body">
                    @include('cgu')
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
