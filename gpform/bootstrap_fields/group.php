<?php
/**
 * Un gruppo generalmente è una riga e definisce il layout così non lo devo scrivere mille volte! 
 */
function gpHtml_group($settings, $values) {
    $settingLayout = (isset($settings['layout'])  && $settings['layout'] != "") ? $settings['layout'] : '' ;
    if ($settingLayout == 'horizontal_form' ) {
        $formControlSettings = gpHtmlUtilityAttrSetting(array('class'=>array('form-group', "gphtml-horizontal-form")));
    } else {
        $formControlSettings = gpHtmlUtilityAttrSetting(array('class'=>array('form-group')));
    }
    $html = '';
    if (isset($settings['repeatable'])) {
        if (isset($settings['name']) &&  isset($values[$settings['name']])  && is_array($values[$settings['name']])) {
            $tempHtml = array();
            foreach ($values[$settings['name']] as $val) {
                $tempHtml[] = gpHtml_single_group ($settings, $val,  $formControlSettings);
                
            }
            $html = implode("", $tempHtml);
        }
    } else {
        if (isset($settings['name']) &&  isset($values[$settings['name']]) && is_array($values[$settings['name']])) {
            $values = $values[$settings['name']];
        }
        $html = gpHtml_single_group ($settings, $values,  $formControlSettings);
    }

   
    // qui creo l'html che contiene tutto. Anche questo in funzione del layout
    
    if (@$settings['layout'] == 'horizontal_form' ) {
        $wrapSettings = gpHtmlUtilityAttrSetting($settings, array('class'=>array("gphtml-layout-horizontal-form")));
    } else if (@$settings['layout'] == 'inline' ) {
         $wrapSettings = gpHtmlUtilityAttrSetting($settings, array('class'=>array("gphtml-layout-inline")));
    } else {
        $wrapSettings = gpHtmlUtilityAttrSetting($settings,  array('class'=>array("gphtml-default-layout")));
    }

    $htmlStart = "\n  <div". gpHtmlGetAttrs(array(), $wrapSettings) . ">";
  
    if (isset($settings['title']) && $settings['title'] != "") {
        $htmlStart .= "<h3 class=\"gphtml-title\">".$settings['title']."</h3>";
    }
    if (isset($settings['description']) && $settings['description'] != "") {
        $htmlStart .= "<div class=\"gphtml-desc\">".$settings['description']."</div>";
    }

    $htmlEnd = '';

    if (isset($settings['footer']) && $settings['footer'] != "") {
        $htmlEnd .=  "<div class=\"gphtml-footer\">".$settings['footer']."</div>\n  </div>";
    } else {
        $htmlEnd .= "\n  </div>";
    }
    
    return $htmlStart.$html.$htmlEnd;
}



function gpHtml_single_group ($settings, $values,  $formControlSettings) {

    $html = array();
   // $render = (isset($settings['render']) && trim($settings['render']) != "") ?$settings['render']."_" : '';
    $settingLayout = (isset($settings['layout'])  && $settings['layout'] != "") ? $settings['layout'] : '' ;
    $settingColLabel = (isset($settings['col-label']) && $settings['col-label'] != "") ? $settings['col-label'] : '' ;
    $settingColForm = (isset($settings['col-form']) && $settings['col-form'] != "") ? $settings['col-form'] : '' ;
    $divRowOpened = false;
    $countCols = 0;
    $currentCount = 0;

    if (isset($settings['repeatable'])) {
    }

    foreach ($settings['fields'] as $field) {
        $field['layout'] = $layout = (isset($field['layout']) && $field['layout'] != "") ? $field['layout']: $settingLayout;
        $field['col-label'] = (isset($field['col-label']) && $field['col-label'] != "") ? $field['col-label'] : $settingColLabel;
        $field['col-form'] = (isset($field['col-form']) && $field['col-form'] != "") ? $field['col-form'] : $settingColForm;
        // NON VA BENE!!! il layout deve essere a livello di elementi del form
        if (function_exists('gpHtml_'.$field['type'])) {
            $htmlField = call_user_func_array('gpHtml_'.$field['type'], array($field, $values));
            $field = gpHtmlUtilityAttrSetting($field, array('class'=>array('form-control')));
            if ($htmlField !== false) { 
                if ($settingLayout == 'inline' && isset($field['pull-right'])) {
                    $formControlSettings = gpHtmlUtilityAttrSetting($formControlSettings, array('class'=> 'ml-auto'));
                }
                $htmlField =  "\n  <div". gpHtmlGetAttrs(array(), $formControlSettings) . ">". $htmlField . "\n  </div>";
                if (isset($settings['cols'])) {
                    if (is_array($settings['cols'])) {
                        $settingsCol = (int)$settings['cols'][$currentCount%count($settings['cols'])];
                    } else {
                        $settingsCol = (int)$settings['cols'];
                    }
                    $htmlStart = "\n  <div class=\"col-md-". $settingsCol. "\">";
                    $htmlEnd = "\n  </div>";
                    $newRow = $htmlStart. $htmlField .$htmlEnd;
                    if ($countCols%12 == 0)  {
                        $divRowOpened = true;
                        $newRow = "\n  ".'<div class="form-row">'. $newRow;
                    } 
                    if (($countCols+$settingsCol)%12 == 0)  {
                        $divRowOpened = false;
                        $newRow =  $newRow."\n  </div>";
                    }
                    $countCols += $settingsCol;
                } else {
                     $newRow =  $htmlField;
                }
                $html[] = $newRow;
                $currentCount++;
            }     
           
        } else {
           // la funzione non esiste
           continue; 
        }
    }
    if (isset($divRowOpened) && $divRowOpened) {
        $html[] =  "\n  </div>\n";
    }

    $htmlStart =  $htmlEnd = '';
    if (@$settings['layout'] == 'inline')  {
        $classInline = "form-inline";
        if (isset($settings['layout-inline-class'])) {
            $classInline .= " ".$settings['layout-inline-class'];
        }
        $htmlStart = "\n  ".'<div class="'.$classInline.'">'."\n   ";
        
    }
   
    if (@$settings['layout'] == 'inline' ) {
        $htmlEnd = "\n  </div>";
    }
    return $htmlStart . implode("", $html) . $htmlEnd;
}