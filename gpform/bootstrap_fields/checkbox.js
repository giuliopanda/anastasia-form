// Validazione dei checkbox 
function gpValidation_checkbox_required(that) {
    // that è l'input hidden
    var gpClass = $(that).data('checkboxgroupclass');
    if ($(that).val() == "") {
        $block = gpUtilityFindblockField(that);
        //console.log("BLOCK2 " + $block);
        $block.find("." + gpClass).each(function () {
            this.setCustomValidity("invalid");
        });
        return false;
    } else {
        $("." + gpClass).each(function () {
            this.setCustomValidity("");
        });
        return true;
    }

}
// Quando i checkbox cambiano di valore
/*
$(function () {
    $('[type=checkbox]').change(function () {
        setCheckboxValue(this);
    })
    $('[type=checkbox]').each(function () {
        setCheckboxValue(this);
    })
});
*/
/**
 * Se bisogna avviare una funzione alla creazione del form si mette nell'elemento da definire data-gphtmlinit con il nome della funzione da passare
 * @param {} el 
 */

function gphtmlInitCheckBox(el) {
    $(el).change(function () {
        setCheckboxValue(this);
    })
    setCheckboxValue(el);
}

// la funzione che compila i valori del campo hidden
function setCheckboxValue(that) {
    // that è il checkbox
    var rifInput = $(that).data('inputid');
    var rifClass = $(that).data('checkboxgroupclass');
    var scbValues = [];
    if (rifInput != 'undefined' && rifClass != 'undefined') {
        $block = gpUtilityFindblockField(that);
        //console.log ("BLOCK "+$block);
        if ($block.find('.' + rifClass).length > 1) {
            if (rifClass) {
                $('.' + rifClass).each(function () {
                    if ($(this).is(":checked")) {
                        scbValues.push($(this).val());
                    }
                });
            }
            if (scbValues.length > 0) {
                $(rifInput).val(JSON.stringify(scbValues));
            } else {
                $(rifInput).val('');
            }
        } else {
            $checkbox = $('.' + rifClass).first();
            if ($checkbox.is(":checked")) {
                $(rifInput).val($checkbox.val());
            } else {
                $(rifInput).val('');
            }
        }
        $(rifInput).change();
    }
}