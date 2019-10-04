$(function () {
    gpSetDatePickerui('body');
});

function gpSetDatePickerui(div) {
    $(div).find(".jsgp-setdatepicker").each(function() {
        var dateFormat = $(this).data('dateformat');
        dateFormat = (dateFormat == "undefined") ? 'mm/dd/yy' : dateFormat;
        var gpDp = $(this).datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            dateFormat: dateFormat,
            showButtonPanel: true,
            showOn: "none"
        });
        var minDate = $(this).data('mindate');
        if (typeof minDate != "undefined") {
            tempD = Date.parse(minDate);
            if (isNaN(tempD)) {
                gpDp.datepicker("option", "minDate", minDate);
            } else {
                //console.log(new Date(tempD));
                gpDp.datepicker("option", "minDate", new Date(tempD) );
            }
            gpAddValidationArray(this, 'gpValDatePicherMinDate');
        }
        var maxDate = $(this).data('maxdate');
        if (typeof maxDate != "undefined") {
            tempD = Date.parse(maxDate);
            if (isNaN(tempD)) {
                gpDp.datepicker("option", "maxDate", maxDate);
            } else {
                gpDp.datepicker("option", "maxDate", new Date(tempD) );
            }
            gpAddValidationArray(this, 'gpValDatePicherMaxDate'); 
        }
        // setto il bottone per il calendario
        $(this).parent().find('label').data('gpdp', gpDp);
        $(this).parent().find('label').click(function () {
            $(this).data('gpdp').datepicker('show');
        });
    });
    
   // mindate e maxDate devono essere 
}

// verifica se minDate è rispettato
function gpValDatePicherMinDate(that) {
    //console.log("MINDATE CHECK");
    // non valida se è required...
    if ($(that).val() == "") {
        return true;
    }
    var minDate = $(that).datepicker("option", "minDate");
    var currentDate = $(that).datepicker("getDate");
    if (currentDate == null || typeof currentDate == "undefined" || isNaN(currentDate) ) {
        return false;
    }
    //console.log(currentDate);
    var date = Date.parse(minDate);
    if (isNaN(date)) {
        date = new Date();
        $a = $('<input>').datepicker();
        test = $a.datepicker("setDate", minDate);
        date = $a.datepicker('getDate');
        $a.datepicker("destroy");
    } else {
        date = new Date(date);
    }
    if (typeof date != "undefined" && currentDate != null) {
       // console.log(date);
        return (currentDate >= date);
    }
}

// verifica se maxDate è rispettato
function gpValDatePicherMaxDate(that) {
   // console.log("MAXDATE CHECK");
    // non valida se è required...
    if ($(that).val() == "") {
        return true;
    }
    var maxDate = $(that).datepicker("option", "maxDate");
    var currentDate = $(that).datepicker("getDate");
    if (currentDate == null || typeof currentDate == "undefined" || isNaN(currentDate)) {
        return false;
    }
    var date = Date.parse(maxDate);
    if (isNaN(date)) {
        //console.log("maxDate " + maxDate);
        date = new Date();
        $a = $('<input>').datepicker();
        test = $a.datepicker("setDate", maxDate);
        date =  $a.datepicker('getDate');
        $a.datepicker("destroy");
        //console.log("c "+date);
    } else {
        date = new Date(date);
    }
    if (typeof date != "undefined" && currentDate != null) {
        return (currentDate <= date);
    }
}

