<?php


function gpHtml_select($settings, $values) {
    $html = "";
    $settings = gpHtmlUtilityAttrSetting($settings, array('class'=>array('custom-select')));
    $html = "\n      ".'<select'. gpHtmlGetAttrs(array('name', 'type','aria-describedby','placeholder', 'required'), $settings) . '>'."\n        ";
    $options = array();
    $value =  gpHtmlGetAttrValue(array('value', 'default'), $settings);
    if (isset($settings['options-function']) && function_exists($settings['options-function']))  {
        $settings['options'] =  call_user_func_array($settings['options-function'], array($settings, $values));
    }
    if (!isset($values[$settings['name']]) && isset($settings['default'])) {
        $values[$settings['name']] = $settings['default'];
    }
    
    foreach ($settings['options'] as $opt)  {
        if (isset($opt['optgroup'])) {
              $options[] = '<optgroup '. gpHtmlGetAttrs(array('label'), $opt['optgroup']) .'>';
              foreach ($opt['optgroup']['options'] as $optg)  {
                    if (is_array($values[$settings['nameForValue']])) {
                        if (in_array($optg['value'], $values[$settings['nameForValue']])) {
                            $optg['selected'] = "selected";
                        }
                    } else if ($values[$settings['nameForValue']] == $optg['value']) {
                        $optg['selected'] = true;
                    }
                    $options[] = '<option '. gpHtmlGetAttrs(array('value','selected'), $optg) .'>'. gpHtmlGetAttrValue(array('label', 'value'), $optg) . '</option>';
              }
              $options[] =  '</optgroup>';
        } else {
            if (isset($opt['value']) && isset($values[$settings['nameForValue']])) {
                if (is_array($values[$settings['nameForValue']])) {
                    if (in_array($opt['value'], $values[$settings['nameForValue']])) {
                        $opt['selected'] = "selected";
                    }
                } else if ($values[$settings['nameForValue']] == $opt['value']) {
                    $opt['selected'] = true;
                }
            }
            $options[] = '<option '. gpHtmlGetAttrs(array('value','selected'), $opt) .'>'. gpHtmlGetAttrValue(array('label', 'value'), $opt) . '</option>';
        }
    }
    $html .= implode("\n        ", $options);
    $html .= "\n      </select>\n  ";
    if (isset($settings['invalid']) && $settings['invalid'] != "") {
        $html .= '<div class="invalid-feedback">'.$settings['invalid'].'</div>';
    }
     return gpHtmlSetLayout($html, $settings);
}