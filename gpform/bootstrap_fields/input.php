<?php
function gpHtml_input($settings, $values) {
    $html = "";
    $settings = gpHtmlUtilityAttrSetting($settings, array('class'=>array('form-control')));
    if (isset($values[$settings['nameForValue']])) {
        $settings['value'] = $values[$settings['nameForValue']];
    } else {
        $settings['value'] =  gpHtmlGetAttrValue(array('value', 'default'), $settings);
    }
    $html = '<input'. gpHtmlGetAttrs(array('name','type','aria-describedby','value','placeholder',  'required', 'readonly', 'disabled','maxlength','max','min','pattern','step'), $settings) . '>';
    if (isset($settings['invalid']) && $settings['invalid'] != "") {
        $html .= '<div class="invalid-feedback">'.$settings['invalid'].'</div>';
    }
    return gpHtmlSetLayout($html, $settings);
}
/**
 * type hidden
 */
function gpHtml_hidden($settings, $values) {
    return gpHtml_input($settings, $values);
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





