<?php


function gpHtml_select($settings, $values) {
    $html = "";
    $settings = gpHtmlUtilityAttrSetting($settings, array('class'=>array('custom-select')));
    $html = "\n      ".'<select'. gpHtmlGetAttrs(array('name', 'type','aria-describedby','placeholder', 'required'), $settings) . '>'."\n        ";
    $options = array();
    $val = gpHtmlUtilityFindValue($values, $settings['nameForValue']);
    if ($val == false && isset($settings['default'])) {
        $val  = $settings['default'];
    }

    if (isset($settings['options-function']) && function_exists($settings['options-function']))  {
        $settings['options'] =  call_user_func_array($settings['options-function'], array($settings, $val));
    }
    foreach ($settings['options'] as $opt)  {
      
        if (isset($opt['optgroup'])) {
              $options[] = '<optgroup '. gpHtmlGetAttrs(array('label'), $opt['optgroup']) .'>';
              foreach ($opt['optgroup']['options'] as $optg)  {
                    if (isset($optg['value']) && isset($val)) {
                        if (is_array($val)) {
                            if (in_array($optg['value'], $val)) {
                                $optg['selected'] = "selected";
                            }
                        } else if ($val == $optg['value']) {
                            $optg['selected'] = "selected";
                        }
                    }
                    $options[] = '<option '. gpHtmlGetAttrs(array('value','selected'), $optg) .'>'. gpHtmlGetAttrValue(array('label', 'value'), $optg) . '</option>';
              }
              $options[] =  '</optgroup>';
        } else {
            if (isset($opt['value']) && isset($val)) {
                if (is_array($val)) {
                    if (in_array($opt['value'], $val)) {
                        $opt['selected'] = "selected";
                    }
                } else if ($val == $opt['value']) {
                    $opt['selected'] = "selected";
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