@extends ('garden.menu')

@section('headers')
<link rel="stylesheet" type="text/css" href=" {{ asset('css/fullcalendar.min.css') }} ">
@endsection

@section('contentPane')

        <div class="col-md-12">
            <div class="panel panel-kerden-home">

                <div class="panel-heading"><strong>Calendrier</strong></div>
                <div class="panel-body">
                	<div class="col-md-4">
                            {{trans('calendar.proposal')}}
                            <ul class="calendarModes" style='list-style:none'>
                                <li><div class="rond vert"></div>{!! trans('calendar.autoDispoHelper') !!}</li>
                                <li><div class="rond orange"></div>{{trans('calendar.manualDispoHelper')}}</li>
                                <li><div class="rond rouge"></div>{{trans('calendar.defaultDispoHelper')}}</li>
                            </ul>
                            <a href="#" data-toggle="modal" data-target="#helperModal">{{trans('calendar.calendarHelper')}}</a>
                            <hr/>
                            Affichage automatique par le site :
                            <ul class="calendarModes" >
                                <li><div class="rond blanc"></div>non rensigné, considéré comme indisponible</li>
                                <li><div class="rond gris"></div>jour non soumis à la location par vous même</li>
                                <li><div class="rond bleuClair"></div>Réservation en attente de confirmation</li>
                                <li><div class="rond bleuFonce"></div>Réservation confirmée</li>
                                <li><div class="rond jaune"></div>Réservation effectuée</li>
                            </ul>
                            <p style='margin-bottom:50px'>{{trans('calendar.resaClick')}}</p>
                	</div>
                	<div class="col-md-8">
                        <div class="row calendarsRowBtns" style='position:absolute; width:100%'>
                            <div class="btn btn-calendar" style='float:left' id='prevBtn'>&larr;Précédent</div>
                            <div class="btn btn-calendar" style='float:right' id='nextBtn'>Suivant&rarr;</div>
                        </div>
                        <div class='row' style="min-height:90px"><div class="cals" id='calendar'></div></div>
                        <div class='row' style="min-height:90px"><div class="cals" id="calendarPlusOne"></div></div>
                        <div class='row' style="min-height:90px"><div class="cals" id="calendarPlusTwo"></div></div>
                    </div>
                    <div class="col-md-12 text-center"><a href="{{url('/garden/dispo/'.$garden->id.'/ok')}}"><div class='btn btn-kerden-confirm'>Enregistrer</div></a></div>
                </div>
            </div>
        </div>
</div>
<div id="selectionErrors">Err</div>

{!! Form::open(['url'=>'garden/dispo/'.$garden->id, 'id'=>'addDispoForm']) !!}
{!! Form::hidden('fromDate',null,['id'=>'fromDate']) !!}
{!! Form::hidden('toDate',null,['id'=>'toDate']) !!}
{!! Form::hidden('typeDispo',null,['id'=>'typeDispo']) !!}
{!! Form::close() !!}


@endsection


@section('scripts')
<script type="text/javascript" src="{{ asset('js/fullcalendar.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.7.1/lang/fr.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.inputmask.js') }}"></script>
<script type="text/javascript">
var evts= [
@foreach($garden->dispos as $dispo)
{
    start:'{{Carbon\Carbon::createFromTimestamp($dispo->date)->toDateString() }}',
    end:'{{Carbon\Carbon::createFromTimestamp($dispo->date)->toDateString() }}',
    fullday:true,
    isResa:false,
    dispo:'{{$dispo->dispo}}',
    acceptable:'{{$garden->acceptWeekDay( Carbon\Carbon::createFromTimestamp($dispo->date)->dayOfWeek )}}'
},
@endforeach
@foreach($garden->reservations as $resa)
@if($resa->status == 'confirmed' || $resa->status == 'done' || $resa->status == 'waiting_confirm')
{
    title:'Réservation',
    start:'{{$resa->date_begin}}',
    end:'{{$resa->date_end}}',
    fullday:true,
    isResa:true,
    resaState:'{{$resa->status}}',
    link:'{{ url("/reservation/ownerView/".$resa->id) }}'
},
@endif
@endforeach
@if(session()->has('redDispo'))
    @foreach( session()->get('redDispo') as $red)
    {
        start:'{{Carbon\Carbon::createFromTimestamp($red)->toDateString() }}',
        end:'{{Carbon\Carbon::createFromTimestamp($red)->toDateString() }}',
        fullday:true,
        isResa:false,
        dispo:'none',
        acceptable:true,
    },
    @endforeach
@endif
];
</script>
<script type="text/javascript" src="{{ URL::asset('js/kerdenCalendar.js') }}"></script>
<script>
function initCals(){
    console.log("la");
    moment.locale(document.documentElement.lang);
    $('.cals').fullCalendar(options);
    $('#calendarPlusOne').fullCalendar('next');
    $('#calendarPlusTwo').fullCalendar('next');
    $('#calendarPlusTwo').fullCalendar('next');
    $('#typeModal').on('hidden.bs.modal', function (e) {
      resetSelection();
    });
    $('#typeModal').on('show.bs.modal',function(e){
        $('#beginDate').html(beginDate.format('DD MMMM'));
        $('#endDate').html(endDate.format('DD MMMM'));
    });

    $('#prevBtn').click(function(e){
        $('.cals').fullCalendar('prev');
    });
    $('#nextBtn').click(function(e){
        $('.cals').fullCalendar('next');
    });
}


(function($){
    $('.HPMenuLink').removeClass('active');
    $('.gardenMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(5)').addClass('active');

    showPage2();
    initCals();
}) (jQuery);
</script>


<div class="modal fade" tabindex="-1" role="dialog" id="typeModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{!! trans('calendar.dispoType') !!}</h4>
      </div>
      <div class="modal-body">
        <div class='row'>
            <div class='col-xs-3'><button type="button" class="btn btn-success" data-dismiss="modal" onclick="addDispo('auto')">Automatique</button></div>
            <div class='col-xs-9'>{{trans('calendar.autoDispo')}}</div>
        </div>
        <hr/>
        <div class='row'>
            <div class='col-xs-3'><button type="button" class="btn btn-warning" data-dismiss="modal" onclick="addDispo('manual')">Manuelle</button></div>
            <div class='col-xs-9'>{{trans('calendar.manualDispo')}}</div>
        </div>
        <hr/>
        <div class='row'>
            <div class='col-xs-3'><button type="button" class="btn btn-danger" data-dismiss="modal" onclick="invalidDispo()">Non Disponible</button></div>
            <div class='col-xs-9'>{{trans('calendar.unDispo')}}</div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="helperModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{!! trans('calendar.calendarHelper') !!}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('calendar.helperStep1')}}</p>
                <p>{{trans('calendar.helperStep2')}}</p>
                <p>{{trans('calendar.helperStep3')}}</p>
                <p>{{trans('calendar.helperStep4')}}</p>
            </div>
        </div>
    </div> 


@endsection