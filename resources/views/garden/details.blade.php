@extends ('garden.menu')

@section('contentPane')
<div class="kerden-page-2-1">
    
    <div class="kerden-back-button">Retour</div>
    <h1>{{$garden->title}}</h1>
    <div class="panel-kerden-home" style='border:none'>
        <div class="panel-heading"><strong>Critères</strong></div>
    </div>
</div>
    <div class="row tabbable">
        <div class="left-home-sub-menu col-md-3 kerden-page-2-2">
            <ul class=" nav nav-pills-stacked details-tab">
                <li class="active">
                    <a href="#tabActi"data-toggle="tab" data-kerdenpage="3">Activités
                        @if($errors->has('activities'))
                            <i class="fa fa-exclamation-triangle" style='color:red'></i>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="#tabMusiq" data-toggle="tab" data-kerdenpage="3">Diffusion de musique
                    @if($errors->has('music'))
                        <i class="fa fa-exclamation-triangle" style='color:red'></i>
                    @endif</a>
                </li>
                <li>
                    <a href="#tabKitchen" data-toggle="tab" data-kerdenpage="3">Cuisine</a>
                </li>
                <li>
                    <a href="#tabToilets" data-toggle="tab" data-kerdenpage="3">Toilettes</a>
                </li>
                <li>
                    <a href="#tabWare" data-toggle="tab" data-kerdenpage="3">Équipement de jardin</a>
                </li>
                <li>
                    <a href="#tabAnimals" data-toggle="tab" data-kerdenpage="3">Animaux</a>
                </li>
                <li>
                    <a href="#tabGuidelines" data-toggle="tab" data-kerdenpage="3">Consignes</a>
                </li>
                <li>
                    <a href="#tabSave" data-toggle="tab" data-kerdenpage="3">Enregistrer</a>
                </li>
            </ul>
        </div>

{!! Form::open(['url'=>'/garden/details/'.$garden->id]) !!}

        <div class="tab-content col-md-9 kerden-page-3">
            <div class="kerden-back-button-p3">Retour</div>
            <div class="tab-first-level tab-pane fade active in" id="tabActi">
                    
                @include('garden.details.activities')
                <div class="row">
                    
                    <div class="col-xs-12 text-center"><div class="btn btn-kerden-confirm nextBtn">Suivant &gt;</div></div>
                </div>
            </div>
            <div class="tab-first-level tab-pane fade" id="tabMusiq">
                @include('garden.details.musicware')
                <div class="row">
                    <div class="col-xs-6 text-right"><div class="btn btn-kerden-cancel prevBtn">&lt; Précédent</div></div>
                    <div class="col-xs-6"><div class="btn btn-kerden-confirm nextBtn">Suivant &gt;</div></div>
                </div>
            </div>
            <div class="tab-first-level tab-pane fade" id="tabToilets">
                <div class='panel panel-kerden-home'>
                    <div class="panel-heading">{{ trans('garden.wc') }}</div>
                    <div class='panel-body'>
                        <div class='form-group'>
                            {!! Form::label('wc_in',trans('garden.wc_in'),['class'=>'control-label col-xs-7']) !!}
                            <div class='col-xs-5'>{!! Form::number('wc_in',$toilets->wc_in,['class'=>'form-control','min'=>'0']) !!}</div>
                        </div>
                        <div class='form-group'>
                            {!! Form::label('wc_in',trans('garden.wc_out'),['class'=>'control-label col-xs-7']) !!}
                            <div class='col-xs-5'>{!! Form::number('wc_out',$toilets->wc_out,['class'=>'form-control','min'=>'0']) !!}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 text-right"><div class="btn btn-kerden-cancel prevBtn">&lt; Précédent</div></div>
                    <div class="col-xs-6"><div class="btn btn-kerden-confirm nextBtn">Suivant &gt;</div></div>
                </div>
            </div>
            <div class="tab-first-level tab-pane fade" id="tabKitchen">
                @include('garden.details.kitchen')
                <div class="row">
                    <div class="col-xs-6 text-right"><div class="btn btn-kerden-cancel prevBtn">&lt; Précédent</div></div>
                    <div class="col-xs-6"><div class="btn btn-kerden-confirm nextBtn">Suivant &gt;</div></div>
                </div>
            </div>
            <div class="tab-first-level tab-pane fade" id="tabWare">
                @include('garden.details.gardenware')
                <div class="row">
                    <div class="col-xs-6 text-right"><div class="btn btn-kerden-cancel prevBtn">&lt; Précédent</div></div>
                    <div class="col-xs-6"><div class="btn btn-kerden-confirm nextBtn">Suivant &gt;</div></div>
                </div>
            </div>
            <div class="tab-first-level tab-pane fade" id="tabAnimals">
                @include('garden.details.animals')
                <div class="row">
                    <div class="col-xs-6 text-right"><div class="btn btn-kerden-cancel prevBtn">&lt; Précédent</div></div>
                    <div class="col-xs-6"><div class="btn btn-kerden-confirm nextBtn">Suivant &gt;</div></div>
                </div>
            </div>
            <div class="tab-first-level tab-pane fade" id="tabGuidelines">
                @include('garden.details.guidelines')
                <div class="row">
                    <div class="col-xs-6 text-right"><div class="btn btn-kerden-cancel prevBtn">&lt; Précédent</div></div>
                    <div class="col-xs-6"><div class="btn btn-kerden-confirm nextBtn">Suivant &gt;</div></div>
                </div>
            </div>            
            <div class="tab-first-level tab-pane fade" id="tabSave">
                <div class="form-group col-xs-12">
                    <div class="col-xs-6 text-right"><div class="btn btn-kerden-cancel prevBtn">&lt; Précédent</div></div>
                    <div class='col-xs-6'>
                        @if($garden->state == "new")
                            {!! Form::submit(trans('pagination.next'),['class'=>'btn btn-kerden-confirm']) !!}
                        @else
                            {!! Form::submit('Enregistrer',['class'=>'btn btn-kerden-confirm']) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>



                    {!! Form::close() !!}
        </div>
    </div>

<div class="modal fade"  id="piscineModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="font-family:'Avenir Next'">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Piscine</h4>
            </div>
            <div class="modal-body">
<div class="row" style='margin-left:10px;margin-right:10px'>Vous venez de déclarer posséder une piscine.<br>
    Pour que votre piscine soit aux normes de sécurité, elle doit être pourvu d’au moins un des quatre dispositifs de sécurité normalisé visant à prévenir le risque de noyade: abri, alarme, barrière ou couverture.  
    Si votre piscine n’est pas pourvu d’au moins un des quatre dispositifs de sécurité elle n’apparaîtra pas dans les équipements de votre jardin et les locataire n’auront pas le droit de l’utiliser.
    <br>
    Votre piscine est-elle pourvu d’au moins un des quatre dispositif de sécurité ?
</div>
<div class="row">
                <div class="col-xs-6 text-right">
                    <div class="btn btn-kerden-valid" onclick="piscineNormesOk();">Oui</div>
                </div>
                <div class="col-xs-6">
                    <div class="btn btn-kerden-confirm" onclick="piscineNormesKO();">Non</div>
                </div>
            </div>            
        </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

function eraseRow(e){
    $('#'+e).remove();
    return false;
}

function checkLevels(level){
    var levels = ['none','low','high','powerfull'];
    var disable = false;
    for(var i in levels){
        if(level == levels[i]){
            if(i==0){$('input[name="music_lower_level"]').val(['none']);}
            else{$('input[name="music_lower_level"]').val([levels[i-1]]);}
            disable = true;
        }
        if(disable){
            $('input[name="music_lower_level"][value="'+levels[i]+'"]').attr('disabled','disabled');
            $('input[name="music_lower_level"][value="'+levels[i]+'"]').parent().addClass('unactiveLabel');
        }else{
            $('input[name="music_lower_level"][value="'+levels[i]+'"]').removeAttr('disabled');
            $('input[name="music_lower_level"][value="'+levels[i]+'"]').parent().removeClass('unactiveLabel');
        }
    }
}

function piscineNormesOk(){
    var obj = $('#Piscine');
    if(obj.length ==0){
        $('input[name^="opt_"]').each(function(){
            if($(this).val().toLowerCase() == 'piscine'){
                obj= $(this).parent().parent();
                $(this).replaceWith('Piscine');
                return false;
            }
        });
    }
    var txt = obj.html().replace(/Piscine/g,'Piscine_normes_ok').replace(/opt_./g,'Piscine_normes_ok');
    obj.html(txt);
    obj.attr('id','Piscine_normes_ok');
    $('input[name="gardenware[Piscine_normes_ok]"]').val('1');
    $('#piscineModal').modal('hide');
}

function piscineNormesKO(){
    var obj = $('#Piscine');
    if(obj.length ==0){
        $('input[name^="opt_"]').each(function(){
            if($(this).val().toLowerCase() == 'piscine'){
                obj= $(this).parent().parent();
                $(this).replaceWith('Piscine');
                return false;
            }
        });
    }
    var txt = obj.html().replace(/Piscine/g,'Piscine_normes_ko').replace(/opt_./g,'Piscine_normes_ko');
    obj.html(txt);
    obj.attr('id','Piscine_normes_ko');
    $('input[name="gardenware[Piscine_normes_ko]"]').val('1');
    $('#piscineModal').modal('hide');
}

function alertPiscine(){
    $('#piscineModal').modal('show');
}

function removeLine(event){
    var line = $(event.target).data('line');
    $('i[data-line="'+line+'"]').parent().remove();
    $('#hiddenNewLinesList').append('<input type="hidden" name="removeGuideline[]" value="'+line+'" />');
}

(function($){
    var i=1;
    $('#wareselect').select2({placeholder: 'Ajouter un équipement',width:'100%'});
    $('#wareselect').select2('val',0);

    $('#wareselect').on("select2:select",function(e){
        var camelName = e.params.data.text.replace(' ','_');
        var label = e.params.data.text;
        if(e.params.data.element.id == 'otherOPT'){
            camelName = 'opt_'+i; i++;
            label = '<input type="text" name="'+camelName+'" />';
        }
        var input = '<input type="number" class="form-control" min="0" placeholder="Nombre" name="gardenware['+camelName+']" />';
        var closeBut = '<a style="cursor:pointer" onclick="eraseRow(\''+camelName+'\')" >x    </a>';
        label = closeBut+label;
        $('#tableWare').append('<tr id="'+camelName+'"><td class="col-xs-7">'+label+'</td><td>'+input+'</td></tr>');
        $('#wareselect').select2('val',0);
        $('input[name="'+camelName+'"]').blur(function(){
            if($(this).val().toLowerCase() == 'piscine'){
                alertPiscine();
            }
        });
        if(camelName=='Piscine'){
            alertPiscine();
        }
    });


    $('input[name="music_lowerlevel_asked"]').change(function(){
        $('#music_lower_level_div').toggle($(this).is(':checked'));
    });
    
    $('input[name="music"]').change(function(){
        checkLevels($(this).val());
    });
    checkLevels($('input[name="music"]:checked').val());

    $('#piscineModal').on('hide.bs.modal',function(){
        $('#Piscine').remove();
        $('input[name^="opt_"]').each(function(){
            if($(this).val().toLowerCase() == 'piscine'){
                $(this).parent().parent().remove();
            }
        });
    });

    $('.HPMenuLink').removeClass('active');
    $('.gardenMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(3)').addClass('active');

    $('.nextBtn').click(function(){
          $('.details-tab > .active').next('li').find('a').trigger('click');
    });
    $('.prevBtn').click(function(){
          $('.details-tab > .active').prev('li').find('a').trigger('click');
    });


    $('#newGuidelineBtn').click(function(){
        var line = $('textarea[name="newGuidelineTextArea"]').val();
        if(line.length > 0){
            $('#emptyListElmt').remove();
            $('#guidelinesList').append('<li>'+line+'</li>');
            $('#hiddenNewLinesList').append('<input type="hidden" name="newGuidelines[]" value="'+line+'"/>')
            $('textarea[name="newGuidelineTextArea"]').val("");
        }
    });


    showPage2();


}) (jQuery);
</script>

@endsection