@extends ('garden.menu')

@section('contentPane')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Critères</strong></div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'/garden/details/'.$garden->id]) !!}
                    <div class='col-md-6'>
                        @include('garden.details.activities')
                    </div>

                    <div class='col-md-6'>
                        @include('garden.details.musicware')
                    </div>

                    <div class='col-md-6'>
                        <div class='panel panel-default'>
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
                    </div>

                    <div class='col-md-6'>
                        @include('garden.details.kitchen')
                    </div>

                    <div class='col-md-6'>
                        @include('garden.details.gardenware')
                    </div>

                    <div class="col-md-6">
                        @include('garden.details.animals')
                    </div>

                    <div class="form-group">
                        <a href="/home"><div class='col-xs-4 col-xs-offset-4'>{!! Form::button(trans('auth.cancel'),['class'=>'btn btn-danger']) !!}</div></a>
                        <div class='col-xs-4'>
                            @if($garden->state == "new")
                                {!! Form::submit(trans('pagination.next'),['class'=>'btn btn-primary']) !!}
                            @else
                                {!! Form::submit('Enregistrer',['class'=>'btn btn-primary']) !!}
                            @endif
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
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
                    <div class="btn btn-warning" onclick="piscineNormesKO();">Non</div>
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
    $('#piscineModal').modal('hide');
}

function piscineNormesKO(){
    $('#piscineModal').modal('hide');

}

function alertPiscine(){
    $('#piscineModal').modal('show');
}

(function($){
    var i=1;
    $('#wareselect').select2({placeholder: 'Ajouter un équipement'});
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
    $('.left-menu-link:nth-child(2)').addClass('active');


}) (jQuery);
</script>

@endsection