<?php
/**
 * GESTIONE DEI CHECKBOX
 * I dati vengono salvati dentro un input nascosto che si chiama [nome-campo]-mergecheckbox e può essere un json nel caso in cui sono più checkbox oppure un valore secco
 */
function gpHtml_checkbox($settings, $values) {
    $html = "";
    $options = array();
    $settings = gpHtmlUtilityAttrSetting($settings);
    if (!isset($values[$settings['name']]) && isset($settings['default'])) {
        $values[$settings['name']] = $settings['default'];
    }
    $tempUniqid =  uniqid();
    if (!isset($settings['_name-clean'])) {
        $settings['_name-clean'] = $tempUniqid;
    }
    if (!isset($settings['id'])) {
         $settings['id'] = "gpi".$tempUniqid;
    }
     if (!isset($settings['name'])) {
         $settings['name'] = "temporaly_name_".$tempUniqid;
    }
     if (isset ($settings['pre-id'])) {
        $class= "jscheckbox-".$settings['pre-id'].$settings['_name-clean'];
    } else {
        $class= "jscheckbox-".$settings['_name-clean'];
    }
    $colGrid = $colCount = $divRowOpened = 0;
    if  (isset($settings["elements-layout"]) && substr($settings["elements-layout"],0,5) == "grid-") {
        $colGrid =  (int)substr($settings["elements-layout"],5);
        if (in_array($colGrid, array(1,2,3,4,6))) {
            $colCount =round( 12 / $colGrid);
        }
        $divRowOpened = false;
    }
    if (isset($settings['options-function']) && function_exists($settings['options-function']))  {
        $settings['options'] =  call_user_func_array($settings['options-function'], array($settings, $values));
    }
    foreach ($settings['options'] as $optKey => $opt)  {
        if (isset($opt['optgroup'])) {
            if ($optKey == 0) { 
                $opt['optgroup'] = gpHtmlAddAttrValue(array('class'=>'gphtml-first-optgroup'), $opt['optgroup']);
            }
            $options[] = '<div '. gpHtmlGetAttrs(array(), $opt['optgroup']) .'>';
            if (isset($opt['optgroup']['label'])) {
                $options[] = '<h5 class="gphtml-optgroup-title">'.$opt['optgroup']['label'].'</h5>';
            }
            foreach ($opt['optgroup']['options'] as $optgKey => $optg)  {
                list($options[], $divRowOpened) = gpHtml_checkbox_option($optgKey, $optg, $values, $settings, $class,  $colGrid, $colCount, $divRowOpened); 
            }
            if (isset($divRowOpened) && $divRowOpened) {
                $options[] = "</div>";
                $divRowOpened = false;
            }   
        
            $options[] =  '</div>';

        } else {
          list($options[], $divRowOpened) = gpHtml_checkbox_option($optKey, $opt, $values, $settings, $class,  $colGrid, $colCount, $divRowOpened);
        }
    }
  
    if (isset($divRowOpened) && $divRowOpened) {
        $options[$optKey] =  $options[$optKey]."</div>";
    }   
  
    
    // <div class="row">
  //  <div class="col-sm">
    $html .= implode("", $options)."\n    ";
    if (isset($values[$settings['name']])) {
        if (is_array($values[$settings['name']])) {
            $value = json_encode($values[$settings['name']]);
        } else {
            $value =  $values[$settings['name']];
        }
    } else {
        $value = "";
    }
    $gpVal = array();
    if (isset($settings['required']) && $settings['required'] == "true") {
        $gpVal[] = 'gpValidation_checkbox_required';
    } 
    if (isset($settings['gp-validation'])) {
        if (is_array($settings['gp-validation'])) {
             $gpVal = array_merge($settings['gp-validation'],  $gpVal);
        } else {
             $gpVal[] = $settings['gp-validation'];
        }
    } 
    if (count ($gpVal) > 0) {
        $required =  ' gp-validation="'.implode(" ", $gpVal).'" ';
    } else {
        $required = "";
    }
    if (substr($settings['name'],-1) == "]" ) {
        $mergeCheckName = substr($settings['name'],0,-1).'-mergecheckbox]';
    } else {
        $mergeCheckName = $settings['name'].'-mergecheckbox';
    }
    $html .= '  <input type="text" id="'.$settings['id'].'" name="'.$mergeCheckName .'" value="'.htmlentities($value).'" class="form-control"'.$required.'data-checkboxgroupclass="'.$class.'" style="display:none">'."\n    ";
    if (isset($settings['invalid']) && $settings['invalid'] != "") {
        $html .= '<div class="invalid-feedback">'.$settings['invalid'].'</div>';
    }
    return gpHtmlSetLayout($html, $settings);
}


function gpHtml_checkbox_option($optKey, $opt, $values, $settings, $class, $colGrid, $colCount, $divRowOpened) {
    if (!isset($values[$settings['nameForValue']])) {
        $values[$settings['nameForValue']] =   gpHtmlGetAttrValue(array('value', 'default'), $settings);
    }
    if (isset($opt['value']) && isset($values[$settings['nameForValue']])) {
        if (is_array($values[$settings['nameForValue']])) {
            if (in_array($opt['value'], $values[$settings['nameForValue']])) {
                $opt['checked'] = true;
            }
        } else if ($values[$settings['nameForValue']] == $opt['value']) {
            $opt['checked'] = true;
        }
    }
    $opt['name'] = $settings['name'];
    
    if (isset($settings["gp-validation"])) {
        $opt["gp-validation"] = $settings["gp-validation"];
    }
    $opt['id'] = "temp_".uniqid();
    $opt = gpHtmlUtilityAttrSetting($opt, array('class'=>array('custom-control-input', $class),'data-checkboxgroupclass'=>$class,'type'=>"checkbox"));
    
    if (count ($settings['options']) > 1) {
        $opt['name'] .= "[]";
    }
    $opt['data-inputid'] = "#".$settings['id'];
    
    $opt['label']['class'] = 'custom-control-label';
    
    $tmp    = "\n          ".'<input '. gpHtmlGetAttrs(array('name', 'type', 'value', 'checked', 'required', 'disabled'), $opt) . '>';
    $tmp   .= "\n          ".'<label '. gpHtmlGetAttrs(array('for'), $opt['label']) . ' >'. gpHtmlGetAttrValue('labelname', $opt) . '</label>'."\n      ";
    if (isset($opt['invalid']) && $opt['invalid'] != "") {
        $tmp .= '<div class="invalid-feedback">'.$opt['invalid'].'</div>';
    }
    $addClassElLayout =  (isset($settings["elements-layout"]) && $settings["elements-layout"] == "inline") ? ' custom-control-inline ' : '';
    $optionNewRow =  "\n      ".'<div class="custom-control custom-checkbox'.$addClassElLayout.'">'.$tmp.'</div>';
    if  (isset($settings["elements-layout"]) && substr($settings["elements-layout"],0,5) == "grid-") {
        $optionNewRow = '<div class="col-sm-'.$colGrid.'">'.$optionNewRow.'</div>';
        if ($optKey%$colCount == 0)  {
            $divRowOpened = true;
            $optionNewRow = '<div class="row">'. $optionNewRow;
        } 
        if ($optKey%$colCount == $colCount-1)  {
            $divRowOpened = false;
            $optionNewRow =  $optionNewRow."</div>";
        }
    }
    return array($optionNewRow, $divRowOpened);
}