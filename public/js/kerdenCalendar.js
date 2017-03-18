var beginDate = null;
var endDate = null;
function beginSelection(date){
    beginDate = date;
    var dataToFind = date.format('YYYY-MM-DD');
    $(".fc-day[data-date='"+dataToFind+"']:not(.fc-other-month)").addClass('selecting');
    $('.selecting').tooltip({container:'body', title: 'Choisissez une date de fin.', trigger:'manual'});
    $('.selecting').tooltip("show");
};
function endSelection(date){
    if( date.isBefore(beginDate) ){
        $('#selectionErrors').show();
        $('#selectionErrors').html("Cette date est antérieure à la date de début!");
        setTimeout(function(){$('#selectionErrors').fadeOut()},2000);
        return;
    }
    $('.selecting').tooltip("destroy");
    //set date to the end of the selected day
    date.add(23,'hours');
    date.add(59,'minutes');
    endDate = date;
    var dataToFind = date.format('YYYY-MM-DD');
    $(".fc-day[data-date='"+dataToFind+"']:not(.fc-other-month)").addClass('selecting');
    $("#typeModal").modal();
};

function resetSelection(){
    beginDate=null;
    endDate = null;
    $('.selecting').removeClass('selecting');
};

function addDispo(dispo){
    $('#fromDate').val(beginDate);
    $('#toDate').val(endDate);
    $('#typeDispo').val(dispo);
    $('#addDispoForm').submit();
}

function invalidDispo(){
    $('#fromDate').val(beginDate);
    $('#toDate').val(endDate);
    $('#typeDispo').val('erase');
    $('#addDispoForm').submit();
}

var options = {
    lang: 'fr',
    header:{left:'',center:'title',right:''},
    events: evts,
    eventColor: 'green',
    aspectRatio:1.5,
    eventRender: function (event, element,view) {
        if(event.isResa){
            if(event.start.month() !== view.intervalStart.month()) { return false; }
            return $('<div class="reservation resa'+event.resaState+'">' + event.title + '</div>');
        }
        else{
            var apliableClass = event.acceptable? event.dispo+'Dispo' : 'greyCase';
            var dataToFind = moment(event.start).format('YYYY-MM-DD');
            $(".fc-day[data-date='"+dataToFind+"']:not('.fc-other-month')").addClass(apliableClass);
            return false;
        }
    },
    eventClick:function(event,element,view){
        document.location = event.link;
    },
    dayClick:function(date, jsEvent, view){
        var cn = jsEvent.toElement.className;
        if(!/fc-day/.test(cn)){return;}
        if(/other-month/.test(cn) || cn===''){
            console.log("other-month");
        }
        else{
            if(/fc-past/.test(cn)){
                $('#selectionErrors').show();
                $('#selectionErrors').html("Cette date est passée!");
                setTimeout(function(){$('#selectionErrors').fadeOut()},2000);
                return;
            }
            if(beginDate==null){
                beginSelection(date);
            }else{
                endSelection(date);
            }
        }
    },
};

