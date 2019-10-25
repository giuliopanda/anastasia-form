// Validazione dei radio 
function gpValidation_radio_required(that) {
    // that è l'input hidden
    var ris = ($(that).val() != "");
    return gpValidation_radio_utility(that, ris);
   
}

function gpValidation_radio_utility(that, result) {
    var gpClass = $(that).data('radiogroupclass');
    $block = gpUtilityFindblockField(that);
    if (result) {
        $block.find("." + gpClass).each(function () {
            this.setCustomValidity("");
        });
        return true;
    } else {
        $block.find("." + gpClass).each(function () {
            this.setCustomValidity("invalid");
        });
        return false;
      
    }
}

/**
 * Se bisogna avviare una funzione alla creazione del form si mette nell'elemento da definire data-gphtmlinit con il nome della funzione da passare
 * @param {} el
 */
function gphtmlInitRadio(el) {
    $(el).change(function () {
        setRadioValue(this);
    });
    setRadioValue(el);
}



// la funzione che compila i valori del campo hidden
function setRadioValue(that) {
    // that è il campo input
    var rifInput = $(that).data('inputid');
    var name = $(that).prop('name');
    $(rifInput).val($('input[name="' + name + '"]:checked').val());
    $(rifInput).change();
}