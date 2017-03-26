@extends ('garden.menu')

@section('contentPane')

    <div class="panel panel-kerden-home">
        <div class="panel-heading"><strong>Tarif</strong></div>
        <div class="panel-body">
            {{ trans('garden.pricesHelper2') }}<br/>
            {{ trans('garden.pricesHelper2.2') }}

            {!! Form::open() !!}

                <div style='margin-top:30px' class="form-group {{ $errors->has('prices.weekDay') ? ' has-error' : '' }}">
                    <label class="control-label col-xs-7 col-sm-5">Prix en semaine (lundi au jeudi): </label>
                    <div class="col-xs-5 col-sm-2 input-group">
                        {!! Form::number('prices[weekDay]',$garden->prices?$garden->prices->weekDay:null,
                        ['class'=>'form-control','min'=>'0','id'=>'weekDay']) !!}
                        <span class="input-group-addon">€/heure</span>
                    </div>

                    <div style='margin-top:30px' class="form-group {{ $errors->has('prices.weekEnd') ? ' has-error' : '' }}">
                        <label class="control-label col-xs-7 col-sm-5">Prix en Week-End (vendredi au dimanche): </label>
                        <div class="col-xs-5 col-sm-2 input-group">
                            {!! Form::number('prices[weekEnd]',$garden->prices?$garden->prices->weekEnd:null,
                            ['class'=>'form-control','min'=>'0','id'=>'weekEnd',
                            'data-toggle'=>'popover','title'=>'Tarif suggéré','data-placement'=>'top']) !!}
                            <span class="input-group-addon">€/heure</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr style='width:75%'/>
            <div class="panel-heading"><strong>Horaires</strong></div>
            <div class="panel-body">
                {{ trans('garden.pricesHelper3') }}<br/>
                {{ trans('garden.pricesHelper3.2') }}


            
            	@foreach( trans('base.weekDays') as $k=>$day)
                    <div class="row" style='margin-top:30px;padding-bottom:15px'>
            		  <div class="col-xs-3 text-right" style='white-space:nowrap'>{{$day}} :</div>
            		  <div class="col-xs-9">
                        <div class="admin-day-slider">
                			<div class="sliderDays" id="{{$day}}">

                                {!! Form::hidden('hours'.$k.'[begin_slot]',$garden->getHours($k)? $garden->getHours($k)->begin_slot :9)  !!}
                                {!! Form::hidden('hours'.$k.'[end_slot]',$garden->getHours($k)? $garden->getHours($k)->end_slot :18)  !!}
                            </div>
                        </div>
            		  </div>
                    </div>
            	@endforeach

            <div class="col-xs-12 text-center">
                {!! Form::submit(trans('base.save'),['class'=>'btn btn-kerden-confirm'])  !!}

            </div>
            {!! Form::close() !!}

        </div>
    </div>

@endsection

@section('scripts')
<script type="text/javascript">
function setweekEnd(price){
    $('#weekEnd').val(price);
    $('[data-toggle="popover"]').popover('hide');
}
(function($){
    var hoursArray = [9,14,18,22,23,24,25,26,27,28];
	$('.sliderDays').slider({
    	range:true,
    	min:9,
    	max:28,
    	values:[9,18],
        slide:function( event, ui ) {
            if( $.inArray( ui.value ,hoursArray) == -1 ) return false;
            $(ui.handle.parentElement).children('input').first().val( ui.values[0] );
            $(ui.handle.parentElement).children('input').last().val( ui.values[1] );
            if(ui.values[0] == ui.values[1]){
                $(ui.handle.parentElement).children('.ui-slider-handle').first().attr('data-hour','indisponible');
                $(ui.handle.parentElement).children('.ui-slider-handle').last().attr('data-hour','indisponible');
            }
            else{
                $(ui.handle.parentElement).children('.ui-slider-handle').first().attr('data-hour',ui.values[0]%24+' h');
                $(ui.handle.parentElement).children('.ui-slider-handle').last().attr('data-hour',ui.values[1]%24+' h');
            }
        }
    });

    $.each($('.sliderDays'),function(){
        var val = $(this).children('input').first().val(),
            val2 = $(this).children('input').last().val();
        $(this).slider({
            values:[val , val2]
        })
        if(val == val2){
            $(this).children('.ui-slider-handle').first().attr('data-hour','indisponible');
            $(this).children('.ui-slider-handle').last().attr('data-hour','indisponible');
        }else{
            $(this).children('.ui-slider-handle').first().attr('data-hour',val%24+' h');
            $(this).children('.ui-slider-handle').last().attr('data-hour',val2%24+' h');
        }   
    });

    $('#weekDay').change(function(event){
        var price = event.target.value;
        price = Math.ceil((Number(price)+ Math.ceil(price/5))/5)*5;
        var html = "&nbsp;&nbsp;<a style='cursor:pointer' onclick='setweekEnd("+price+")'>OK</a>";
        $('#weekEnd').attr('data-content',price+html);
        $('[data-toggle="popover"]').popover('show');
    });
    $('[data-toggle="popover"]').popover({
        trigger:'manual',
        html:true
    });


    $('.HPMenuLink').removeClass('active');
    $('.gardenMenu').addClass('active');
    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(4)').addClass('active');
    showPage2();

}) (jQuery);
</script>
@endsection