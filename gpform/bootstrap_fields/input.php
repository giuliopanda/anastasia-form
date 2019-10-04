<?php
function gpHtml_input($settings, $values) {
    $html = "";
    if (isset($values[$settings['name']])) {
        $settings['value'] = $values[$settings['name']];
    } else {
        $settings['value'] =  gpHtmlGetAttrValue(array('value', 'default'), $settings);
    }
    $settings = gpHtmlUtilityAttrSetting($settings, array('class'=>array('form-control')));
    $html = '<input'. gpHtmlGetAttrs(array('type','aria-describedby','value','placeholder', 'required', 'disabled','maxlength','max','min','pattern','step'), $settings) . '>';
    if (isset($settings['invalid']) && $settings['invalid'] != "") {
        $html .= '<div class="invalid-feedback">'.$settings['invalid'].'</div>';
    }
    return gpHtmlSetLayout($html, $settings);
}
/**
 * type password
 */
function gpHtml_password($settings, $values) {
    return gpHtml_input($settings, $values);
}

/**
 * type email
 */
function gpHtml_email($settings, $values) {
    return gpHtml_input($settings, $values);
}

/**
 * type url
 */
function gpHtml_url($settings, $values) {
    return gpHtml_input($settings, $values);
}

/**
 * type number
 */
function gpHtml_number($settings, $values) {
    return gpHtml_input($settings, $values);
}





