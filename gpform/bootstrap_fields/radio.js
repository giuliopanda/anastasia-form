// Validazione dei checkbox 
function gpValidation_radio_required(that) {
    // that è l'input hidden
    var gpClass = $(that).data('radiogroupclass');
    if ($(that).val() == "") {
        $("." + gpClass).each(function () {
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
$(function () {
    $('[type=radio]').click(function () {
        setRadioValue(this);
    })
    $('[type=radio]').each(function () {
        setRadioValue(this);
    })
});
// la funzione che compila i valori del campo hidden
function setRadioValue(that) {
    // that è il campo input
    var rifInput = $(that).data('inputid');
    var name = $(that).prop('name');
    $(rifInput).val($('input[name=' + name + ']:checked').val());
    $(rifInput).change();
}