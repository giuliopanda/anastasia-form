<?php
/**
 * GESTIONE DEI RADIO
*/

function gpHtml_radio($settings, $values) {
    $html = "";
    $options = array();
    $settings = gpHtmlUtilityAttrSetting($settings);
    
    
    $tempUniqid =  uniqid();
    if (!isset($settings['_name-clean'])) {
        $settings['clean-name'] = $tempUniqid;
    }
    if (!isset($settings['id'])) {
         $settings['id'] = "gpi".$tempUniqid;
    }
     if (!isset($settings['name'])) {
         $settings['name'] = "temporaly_name_".$tempUniqid;
    }
     if (isset ($settings['pre-id'])) {
        $class= "jsradio-".$settings['pre-id'].$settings['_name-clean'];
    } else {
        $class= "jsradio-".$settings['_name-clean'];
    }
    
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
    $val = gpHtmlUtilityFindValue($values, $settings['nameForValue']);
    if (is_array($val)) {
        $val = array_shift($val);
    }
    if ($val == false && isset($settings['default'])) {
        $val  = $settings['default'];
    }
    foreach ($settings['options'] as $optKey => $opt)  {
        if (isset($opt['value']) && $val != false && $val == $opt['value']) {
             $opt['checked'] = true;
        }
        $opt['name'] = $settings['name'];
        if (isset($settings["gp-validation"])) {
            $opt["gp-validation"] = $settings["gp-validation"];
        }
        $opt['id'] = "temp_".uniqid();
        $opt = gpHtmlUtilityAttrSetting($opt, array('class'=>array('custom-control-input', $class),'data-radiogroupclass'=>$class,'type'=>"radio"));
        
        $opt['data-inputid'] = "#".$settings['id'];
        
        $opt['label']['class'] = 'custom-control-label';
            // Se bisogna avviare una funzione alla creazione del form si mette nell'elemento da definire data-gphtmlinit con il nome della funzione da passare
        $opt['data-gphtmlinit'] = "gphtmlInitRadio";
        $tmp    = "\n          ".'<input '. gpHtmlGetAttrs(array('name', 'type','value', 'checked', 'required', 'disabled'), $opt) . '>';
        $tmp   .= "\n          ".'<label '. gpHtmlGetAttrs(array('for'), $opt['label']) . ' >'. gpHtmlGetAttrValue('labelname', $opt) . '</label>'."\n      ";
       if (isset($opt['invalid']) && $opt['invalid'] != "") {
            $tmp .= '<div class="invalid-feedback">'.$opt['invalid'].'</div>';
        }
        $addClassElLayout =  (isset($settings["elements-layout"]) && $settings["elements-layout"] == "inline") ? ' custom-control-inline ' : '';
        $optionNewRow =  "\n      ".'<div class="custom-control custom-radio'.$addClassElLayout.'">'.$tmp.'</div>';
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
        $options[] = $optionNewRow;
    }
  
        
    if (isset($divRowOpened) && $divRowOpened) {
        $options[$optKey] =  $options[$optKey]."</div>";
    }
    
    // <div class="row">
  //  <div class="col-sm">
    $html .= implode("", $options)."\n    ";
    
    $gpVal = array();
    if (isset($settings['required']) && $settings['required'] == "true") {
        $gpVal[] = 'gpValidation_radio_required';
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
        $mergeCheckName = substr($settings['name'],0,-1).'-mergeradio]';
    } else {
        $mergeCheckName = $settings['name'].'-mergeradio';
    }
    $html .= '  <input type="text" id="'.$settings['id'].'" name="'.$mergeCheckName.'" value="'.htmlentities($val).'" class="form-control"'.$required.'data-radiogroupclass="'.$class.'" style="display:none">'."\n    ";
    if (isset($settings['invalid']) && $settings['invalid'] != "") {
        $html .= '<div class="invalid-feedback">'.$settings['invalid'].'</div>';
    }
    return gpHtmlSetLayout($html, $settings);
}