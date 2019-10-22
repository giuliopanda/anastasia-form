<?php
function gpHtml_textarea($settings, $values) {
    $html = "";
    if (isset($values[$settings['name']])) {
        $settings['value'] = $values[$settings['name']];
    } else {
        $settings['value'] =  gpHtmlGetAttrValue(array('value', 'default'), $settings);
    }
    $value =  gpHtmlGetAttrValue(array('value', 'default'), $settings);
    
    $settings = gpHtmlUtilityAttrSetting($settings, array('class'=>array('form-control')));
    $html = '<textarea'. gpHtmlGetAttrs(array('name', 'type','aria-describedby', 'placeholder', 'required', 'readonly', 'disabled', 'rows','cols','wrap', 'maxlength' ), $settings) . '>'.htmlentities($value).'</textarea>';
    if (isset($settings['invalid']) && $settings['invalid'] != "") {
        $html .= '<div class="invalid-feedback">'.$settings['invalid'].'</div>';
    }
    return gpHtmlSetLayout($html, $settings);
}