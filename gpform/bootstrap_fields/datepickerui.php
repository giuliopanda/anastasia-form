<?php
/**
 * type number
 */
function gpHtml_datepickerui($settings, $values) {
    $settings['type'] = "input";
    $html = "";
    if (isset($values[$settings['name']])) {
        $settings['value'] = $values[$settings['name']];
    } else {
        $settings['value'] =  gpHtmlGetAttrValue(array('value', 'default'), $settings);
    }
    if (isset($settings['date-format'])) {
        $settings['data-dateformat'] = $settings['date-format'];
        $settings['date-format'] = str_replace("\\","\\\\", $settings['date-format']);
        $settings['date-format'] = str_replace(array("/","+","!","?"),array("\\/","\\+","\\!","\\?"), $settings['date-format']);
        $pattern = str_replace(array('yy', 'mm', 'dd', 'd','m','y'), array('[12][0-9]{3}', '(0[1-9]|1[0-2])', '(0[1-9]|[12][0-9]|3[01])','[0-9]','[0-9]','[0-9]{2}'), $settings['date-format']);
        if ($pattern != $settings['date-format'] && !isset($settings['pattern'])) {
            $settings['pattern'] = $pattern;
        }
        unset($settings['date-format']);
    } 
     if (isset($settings['date-min'])) {
        $settings['data-mindate'] = $settings['date-min'];
         unset($settings['date-min']);
    }
     if (isset($settings['date-max'])) {
        $settings['data-maxdate'] = $settings['date-max'];
         unset($settings['date-max']);
    }
    $settings['data-gphtmlinit'] = "gphtmlInitDatePickerui";
    $settings = gpHtmlUtilityAttrSetting($settings, array('class'=>array('form-control jsgp-setdatepicker')));
    $html = "\n  ".'<div class="input-group mb-3">'."\n    ".'<input'. gpHtmlGetAttrs(array('type','aria-describedby','value','placeholder', 'required', 'disabled','maxlength','max','min','pattern','step'), $settings) . '>'."\n    ".'<div class="input-group-append">'."\n    ".'<label class="input-group-text" for="inputGroupSelect02"><ion-icon name="calendar" class="ionicon-button"></ion-icon></label>'."\n    ".'</div>'."\n  ";

    if (isset($settings['invalid']) && $settings['invalid'] != "") {
        $html .= "\n  ".'<div class="invalid-feedback">'.$settings['invalid'].'</div>';
    } 
    $html .= '</div>';
    
    return gpHtmlSetLayout($html, $settings);
}
