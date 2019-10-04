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
    console.log("ADD GPVAL " + gpValidation);
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