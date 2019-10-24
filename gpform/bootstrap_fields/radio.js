// Validazione dei checkbox 
function gpValidation_radio_required(that) {
    // that è l'input hidden
    var gpClass = $(that).data('radiogroupclass');
    $block = gpUtilityFindblockField(that);
    if ($(that).val() == "") {
        $block.find("." + gpClass).each(function () {
            this.setCustomValidity("invalid");
        });
        return false;
    } else {
        $block.find("." + gpClass).each(function () {
            this.setCustomValidity("");
        });
        return true;
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