<?php
function gpHtml_textarea($settings, $values) {
    $html = "";
    $settings = gpHtmlUtilityAttrSetting($settings, array('class'=>array('form-control')));
    $val = gpHtmlUtilityFindValue($values, $settings['nameForValue']);
    if ( $val == false) {
        if (isset( $settings['default'])) {
             $val =  $settings['default'];
        } else {
            $val = "";
        }
    }
    $html = '<textarea'. gpHtmlGetAttrs(array('name', 'type','aria-describedby', 'placeholder', 'required', 'readonly', 'disabled', 'rows','cols','wrap', 'maxlength' ), $settings) . '>'.htmlentities($val).'</textarea>';
    if (isset($settings['invalid']) && $settings['invalid'] != "") {
        $html .= '<div class="invalid-feedback">'.$settings['invalid'].'</div>';
    }
    return gpHtmlSetLayout($html, $settings);
}