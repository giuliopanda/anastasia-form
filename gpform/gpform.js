// Validazione generale

// TODO GP-VALIDATION E' UN ARRAY DI FUNZIONI!!!
(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                // TODO Rimuovo i gruppi nascosti che servono per la duplicazione
                var ris = form.checkValidity();
                $(form).find("*").each(function () {
                    if ($(this).attr('gp-validation')) {
                        gpCheckValidation(this);
                    }
                });
                if (!ris) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                    // TODO riattivo i gruppi nascosti per la duplicazione
                } 
            }, false);
        });
    }, false);
})();

function gpGetValidationArray(that) {
    var gpValidation =  ($(that).attr('gp-validation'));
    if (gpValidation) {
        arrayVal = gpValidation.split(" ");
        return arrayVal;
    } else{
        return false;
    }
}
function gpAddValidationArray(that, addFn) {
    var gpValidation = $(that).attr('gp-validation');
    if (gpValidation) {
        gpValidation = gpValidation + " " + addFn;
    } else {
        gpValidation = addFn;
    }
    $(that).attr('gp-validation', gpValidation);
    //console.log("ADD GPVAL " + gpValidation);
    if (that.gpAddCheckValidation != "t") {
        if ($(that).is("input") || $(that).is("textarea")) {
            $(that).keyup(function () {
                that.setCustomValidity("");
                gpCheckValidation(that);
            });
        }
        $(that).change(function () {
            that.setCustomValidity("");
            gpCheckValidation(that);
        });
        that.gpAddCheckValidation = 't';
    }
    
}


$(function () {
    $('.needs-validation').each(function () {
        $(this).find("*").each(function () {
            if ($(this).attr('gp-validation')) {
                if ($(this).is("input") || $(this).is("textarea")) {
                    $(this).keyup(function () {
                        this.setCustomValidity("");
                        gpCheckValidation(this);
                    });
                }
                $(this).change(function () {
                    this.setCustomValidity("");
                    gpCheckValidation(this);
                });
                this.gpAddCheckValidation = 't';
            }
        });

    });
})
// aggiunta di validazioni javascript custom
function gpCheckValidation(that) {
    var customFns = gpGetValidationArray(that);
    if (customFns) {
        for (cfn in customFns) {
            var customFn = customFns[cfn];
            //console.log(typeof window[customFn]);
           // console.log(customFn);
            if (typeof window[customFn] === typeof (Function)) {
                var tempRis = true;
                try {
                    tempRis = window[customFn](that);
                } catch (err) {
                    console.log("gpCheckValidation() ERROR ("+customFn + ") " + err.message);
                }
                if (!$(that).is(":invalid")) {
                    if (!tempRis) {
                        that.setCustomValidity('invalid');
                    } else {
                        that.setCustomValidity("");
                    }
                }
            } else {
                console.log("gpCheckValidation() ERROR (" + customFn + ") NOT FOUND! ");
            }
        }
    }
}

/** trova il div che contiene tutto l'html di un campo. 
 *  Questo ha come class jsgp-blockfield
 */

function gpUtilityFindblockField(that) {
    $that = $(that);
    var countWhile = 0;
    while (!$that.hasClass('jsgp-blockfield') && countWhile < 20) {
        //console.log ($that);
        $that = $that.parent();
        countWhile++;
    }
    return $that;
}

/**
 * INIT
 */

function gpHtmlInit(element) {
    $(element).find('[data-gphtmlinit]').each(function() {
        console.log("INIT: "+this);
        fn = $(this).data('gphtmlinit');
        if (typeof window[fn] === "function") {
            window[fn](this);
        }
    })
}
$(function () {
    gpHtmlInit(document.body);
});

/**
 * Per i gruppi che si ripetono la funzione che clona il gruppo
* @param {} that
 */
function gpCloneGroup(that) {
    var idClone = $(that).data('clone');
    var box = $(that).data('box');
    var maxCount = 0;
    $(box).find('.gpjs-repeatable').each(function() {
        var d = $(this).data('repgroup').split(".");
        count = d.pop();
        maxCount = Math.max(maxCount, count);
        dataRepGroup = d;
    })
    maxCount++;
    dataRepGroup.push(maxCount);
    joinDataRepGroup = dataRepGroup.join(".");
    newDataRepGroup = dataRepGroup.shift();
    if (dataRepGroup.length > 0) {
        for (drg in dataRepGroup) {
            newDataRepGroup += "[" + dataRepGroup[drg] + "]"
        }
    }

   // console.log("dataRepGroup: " + newDataRepGroup + " " + joinDataRepGroup);
   // console.log(idClone);
    $clone = $(idClone).clone();
    $clone.find('*').each(function() {
        console.log ("ALLDATA:");
        console.log($(this).data());
        console.log ("END DATA");
        allData = $(this).data();
       
        for (dx in allData) {
            console.log("DATA" + allData[dx]);
            if (allData[dx].substring(0,1) == "#") {
                console.log("NEW DATA (" + dx + ")" + "#gp" + maxCount + allData[dx].substring(1))
                $(this).data(dx, "#gp" + maxCount +allData[dx].substring(1));
            }
        }
        
        if ($(this).prop('name')) {
            var oldName = $(this).attr('name');
            if (oldName.indexOf('[]') > -1) {
                oldName2 = oldName.replace("[]","");
                $(this).prop('name', newDataRepGroup + "[" + oldName2 + "][]");
            } else {
                $(this).prop('name', newDataRepGroup + "[" + $(this).attr('name') + "]");
            }
        }
        if ($(this).prop('id')) {
            $(this).prop('id', "gp" + maxCount + $(this).prop('id'));
        }
        if ($(this).prop('for')) {
            $(this).prop('for', "gp" + maxCount + $(this).prop('for'));
        }

    })
    $(idClone).after($clone);
    $clone.css('display','block');
    $clone.prop('id',null);
    $clone.addClass('gpjs-repeatable');
    $clone.data('repgroup', joinDataRepGroup);
    gpHtmlInit($clone.get());

}

