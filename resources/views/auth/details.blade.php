@extends('auth.menu')

@section('headers')
<link rel="stylesheet" href="{{ URL::asset('css/datepicker3.css') }}">
@endsection

@section('contentPane')
@if(!empty($error))
<div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
{{ $error }}
</div>
@endif
@if(!empty($message))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
{{ $message }}
</div>
@endif

<div class="panel panel-kerden-home">
    <div class="kerden-back-button">Retour</div>
    <div class="panel-heading">{{trans( 'userdetails.details' )}}</div>
    <div class="panel-body">
        @if($errors->has('fromProvider'))
            <div class="alert alert-danger fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        Impossible de modifier l'adresse E-mail pour les comptes OAuth (Facebook ou Google).
                </div>
        @endif
        {!! Form::model($details,['url'=>'/userdetails','autocomplete'=>'off','class'=>'form-horizontal details-form']) !!}
            {!! csrf_field() !!}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="'email" class="col-md-4 control-label">E-mail *</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="email" value="{{$user->email}}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group has-error" id='mailChangeWarning' style="display:none">
                <div class="col-md-6 col-md-offset-4">
                    <span class="help-block">
                        <i class="fa fa-exclamation-triangle"></i>&nbsp;Attention : si vous modifiez votre e-mail, il ne sera pas re-vérifié. Si votre nouvelle adresse n'existe pas, vous ne recevrez plus de messages!
                    </span>
                </div>
            </div>

            <div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                <label for="'firstName" class="col-md-4 control-label">Prénom *</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="firstName" value="{{$user->firstName}}">
                    @if ($errors->has('firstName'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstName') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                <label for="lastName" class="col-md-4  control-label">Nom *</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="lastName" value="{{$user->lastName}}">
                    @if ($errors->has('lastName'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastName') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                {!! Form::label(trans('validation.attributes.birthday').' *', null ,
                    ['class'=>'col-md-4 control-label']) !!}

                <div class="col-md-6">
                     {!! Form::text('birthday', null ,['id'=>'birthday',
                                                    'placeholder'=>'jj-mm-aaaa',
                                                    'class'=>'form-control'])  !!}

                    @if ($errors->has('birthday'))
                        <span class="help-block">
                            <strong>{{ $errors->first('birthday') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                {!! Form::label(trans('validation.attributes.nationality').' *',null,
                    ['class'=>'col-md-4 control-label']) !!}

                <div class="col-md-6">
                {!! Form::select('nationality',$paysCodes,null,['class'=>'form-control','id'=>'nationality']) !!}

                    @if ($errors->has('nationality'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nationality') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(trans('validation.attributes.countryOfResidence'),null,
                    ['class'=>'col-md-4 control-label']) !!}

                <div class="col-md-6">
                    <select class="form-control" name="countryOfResidence" id="countryOfResidence"
                     value="{{ old('countryOfResidence') }}" disabled >
                     <option value="FR" selected>France</option>
                    </select>
                </div>
            </div>

            <div class="form-group{{ $errors->has('addressLine1') ? ' has-error' : '' }}">
                {!! Form::label(trans('validation.attributes.address').' *',null,
                    ['class'=>'col-md-4 control-label']) !!}
                <div class="col-md-6">
                     {!! Form::text('addressLine1',null,['class'=>'form-control'])  !!}

                    @if ($errors->has('addressLine1'))
                        <span class="help-block">
                            <strong>{{ $errors->first('addressLine1') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(trans('validation.attributes.addressComp'),null,
                    ['class'=>'col-md-4 control-label']) !!}

                <div class="col-md-6">
                    {!! Form::text('addressLine2',null,['class'=>'form-control'])  !!}
                </div>
            </div>

            <div class="form-group{{ $errors->has('addressPostalCode') ? ' has-error' : '' }}">
                {!! Form::label(trans('validation.attributes.postalCode').' *',null,
                    ['class'=>'col-md-4 control-label']) !!}

                <div class="col-md-6">
                    {!! Form::text('addressPostalCode',null,['class'=>'form-control'])  !!}

                    @if ($errors->has('addressPostalCode'))
                        <span class="help-block">
                            <strong>{{ $errors->first('addressPostalCode') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('addressCity') ? ' has-error' : '' }}">
                {!! Form::label(trans('validation.attributes.city').' *',null,
                    ['class'=>'col-md-4 control-label']) !!}

                <div class="col-md-6">
                     {!! Form::text('addressCity',null,['class'=>'form-control'])  !!}

                    @if ($errors->has('addressCity'))
                        <span class="help-block">
                            <strong>{{ $errors->first('addressCity') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

        @if ($details->type == 'legal')
            <div class="form-group">
                {!! Form::label(trans('userdetails.iamlegal'),null,
                    ['class'=>'col-md-6 control-label']) !!}

                <div class="col-md-1">
                    {!! Form::checkbox('type', null,($details->type === 'legal'),
                      ['class'=>'form-control','id'=>'type','disabled'=>''] ) !!}
                </div>
                <input type="hidden" name="type" value="legal" />
            </div>




            <div class="panel panel-default" id="organizationaddressPanel">

                <div class="panel-heading">{{trans( 'userdetails.organizationdetails' )}}</div>
                <div class="panel-body">

                    <div class="form-group{{ $errors->has('organizationname') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">{{trans('validation.attributes.name').' *'}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="organizationname" id="organizationname"
                             value="{{ isset($orga->name)? $orga->name :old('organizationname') }}">

                            @if ($errors->has('organizationname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('organizationname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('orgaType') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">{{trans('validation.attributes.type')}}</label>

                        <div class="col-md-6">
                            <select class="form-control" name="orgaType" id="orgaType">
                                <option value="BUSINESS" @if ($orga->type=="BUSINESS") selected  @endif>Entreprise</option>
                                <option value="ORGANIZATION" @if ($orga->type=="ORGANIZATION") selected  @endif>Association</option>
                            </select>

                            @if ($errors->has('orgaType'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('orgaType') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                    

                    <div class="form-group{{ $errors->has('headQuartersAddressLine1') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">{{trans('validation.attributes.address').' *'}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="headQuartersAddressLine1" id="headQuartersAddressLine1"
                             value="{{ isset($orga->headQuartersAddressLine1) ? $orga->headQuartersAddressLine1 : old('headQuartersAddressLine1') }}">

                            @if ($errors->has('headQuartersAddressLine1'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('headQuartersAddressLine1') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('validation.attributes.addressComp')}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="headQuartersAddressLine2" id="headQuartersAddressLine2"
                             value="{{ isset($orga->headQuartersAddressLine2) ? $orga->headQuartersAddressLine2 : old('headQuartersAddressLine2') }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('headQuartersAddressPostalCode') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">{{trans('validation.attributes.postalCode').' *'}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="headQuartersAddressPostalCode" id="headQuartersAddressPostalCode"
                             value="{{ isset($orga->headQuartersAddressPostalCode) ? $orga->headQuartersAddressPostalCode : old('headQuartersAddressPostalCode') }}">

                            @if ($errors->has('headQuartersAddressPostalCode'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('headQuartersAddressPostalCode') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('headQuartersAddressCity') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">{{trans('validation.attributes.city').' *'}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="headQuartersAddressCity" id="headQuartersAddressCity"
                             value="{{ isset($orga->headQuartersAddressCity) ? $orga->headQuartersAddressCity : old('headQuartersAddressCity') }}">

                            @if ($errors->has('headQuartersAddressCity'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('headQuartersAddressCity') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            @endif

            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                @if( $user->phone && $user->phone->phone == 'noPhone')
                    <label for="Téléphone" class="col-md-4 control-label"><span>Téléphone <small>- désactivé</small></span> <i class="fa fa-question-circle-o question-phone-logo" data-toggle='modal' data-target="#phoneModal"></i></label>
                @else
                    <label for="Téléphone" class="col-md-4 control-label"><span>Téléphone</span> <i class="fa fa-question-circle-o question-phone-logo" data-toggle='modal' data-target="#phoneModal"></i></label>
                @endif

                <div class="col-md-6">
                    <input type="number" name="phone" title="phone" class="form-control"
                    @if( $user->phone || ($user->phone && $user->phone->phone != 'noPhone'))
                        value="{{$user->phone->phone}}"
                    @endif
                    @if( $user->phone && $user->phone->phone == 'noPhone')
                        disabled="disabled">
                        <input type="hidden" name='noPhone' value="1"
                    @endif
                    >

                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                    <span class='help-block' id='invalidPhone' style="display:none"><strong>Ceci n'est pas un numéro de téléphone valide.</strong></span>
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-2 col-md-offset-4 col-xs-6">
                    <a href="{{url('/home')}}" class="btn btn-kerden-cancel">{{trans('auth.cancel')}}</a>
                </div>
                <div class="col-md-2 col-xs-6">
                    <button type="submit" class="btn btn-kerden-confirm">{{trans('auth.validate')}}</button>
                </div>
            </div>

        {!! Form::close() !!}
    </div>
</div>

<div class="modal fade"  id="phoneModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="font-family:'Avenir Next'">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Téléphone</h4>
            </div>
            <div class="modal-body">
                <h3>Pourquoi un numéro de téléphone?</h3>
                    <p>Renseigner votre numéro de téléphone nous permet de vous mettre plus facilement en relation avec les autres utilisateurs de Kerden.fr (locataires et propriétaires).</p>
                    <p>À court terme, l'équipe prévoit de mettre en place un système d'alerte SMS pour vous simplifier la vie!</p>
                <h3>Comment utilisons-nous votre numéro?</h3>
                    <p>Nous n'utilisons pas directement votre numéro. Nous le transmettons à vos interlocuteurs (locataires ou propriétaires), uniquement dans le cadre d'une réservation approuvée et déjà payée.</p>
                    <p>Kerden.fr s'engage à ne pas divulger votre numéro en dehors du cadre sus-cité.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
@if(App::getLocale() == 'fr')
<script src="{{ URL::asset('js/bootstrap-datepicker.fr.js') }}"></script>
@endif
<script src="{{ URL::asset('js/jquery.inputmask.js') }}"></script>
<script>
(function($){
    $('input[name="email"]').focus(function(){
        console.log('la');
        $('#mailChangeWarning').slideDown();
    });

    $('#birthday').datepicker({
        format:'dd-mm-yyyy',
        startView:'decade',
        autoclose:true
    });

    $('[data-toggle="tooltip"]').tooltip(); 

    $('#nationality').select2();

    $('.HPMenuLink').removeClass('active');
    $('.userMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(1)').addClass('active');

    $('.details-form').submit(function(){
        var t = $('input[name="phone"]').val();

        if(/[0-9]{10}/.test(t) || $('input[name="noPhone"]').size()>0 ){
            $('#invalidPhone').hide();
            return true;
        }
        else{
            $('input[name="phone"]').parent().parent().addClass('has-error');
            $('#invalidPhone').show();
            return false;
        }
    });

    $('input[name="nophone"]').change(function(){
        if( $(this).is(":checked") ){
            $('input[name="phone"]').attr('disabled','disabled');
            $('label[for="Téléphone"] span').html( $('label[for="Téléphone"] span').text()+'<small> - désactivé</small>' );            
            $('<input>').attr({
                type: 'hidden',
                id: 'noPhone',
                name: 'noPhone',
                value: '1'
            }).appendTo('.details-form');
        }else{
            $('input[name="phone"]').removeAttr('disabled');
            $('label[for="Téléphone"] span small').remove();
            $('input[name="noPhone"]').remove();
        }
        $('#phoneModal').modal('hide');
    });
}) (jQuery);
</script>
@endsection