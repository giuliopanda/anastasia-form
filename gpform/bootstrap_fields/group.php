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

  
    if (@$settings['layout'] == 'horizontal_form' ) {
        $wrapSettings = gpHtmlUtilityAttrSetting($settings, array('class'=>array("gphtml-layout-horizontal-form")));
    } else if (@$settings['layout'] == 'inline' ) {
         $wrapSettings = gpHtmlUtilityAttrSetting($settings, array('class'=>array("gphtml-layout-inline")));
    } else {
        $wrapSettings = gpHtmlUtilityAttrSetting($settings,  array('class'=>array("gphtml-default-layout")));
    }

    $html = '';
    if (isset($settings['repeatable'])) {
        if (isset($settings['name'])) {
            $tempHtml = array();
            $k = 0;
            if (isset($values[$settings['name']])  && is_array($values[$settings['name']])) {
                foreach ($values[$settings['name']] as $val) {
                    $customSettings = $settings;
                    $customSettings['name'] = $customSettings['name'].".".($k++);
                    if (!is_array($settings['repeatable'])) {
                        $settings['repeatable'] = array($settings['repeatable']);
                    }
                    $repeatableSettings = gpHtmlUtilityAttrSetting($settings['repeatable'], array('class'=>array("gphtml-repeatable gpjs-repeatable"), 'data-repgroup'=>$customSettings['name']));
                    $tempHtml[] = "<div ".gpHtmlGetAttrs(array(), $repeatableSettings).">";
                    $tempHtml[] = gpHtml_single_group ($customSettings, $val,  $formControlSettings);
                    $tempHtml[] = "</div>";
                }
            }
            if (!is_array($settings['repeatable'])) {
                $settings['repeatable'] = array($settings['repeatable']);
            }
            // clone
            $idRip = "ripeatebletemplate".uniqid();
            $repeatableSettings = gpHtmlUtilityAttrSetting($settings['repeatable'], array('class'=>array("gphtml-repeatable gp-repeatablecloned gpjs-formignore"),'id'=>$idRip, 'style'=>"display:none;"));
            $tempHtml[] = "<div ".gpHtmlGetAttrs(array(), $repeatableSettings).">";
            $customSettingClone = $settings;
            $addData = array();
            if(isset($customSettingClone['preview-name'])) {
                $addData[] = "data-previewname=\"". $customSettingClone['preview-name']."\"";
                unset($customSettingClone['preview-name']);
            }
            if(isset($customSettingClone['name'])) {
                $addData[] = "data-name=\"".$customSettingClone['name']."\"";
                unset($customSettingClone['name']);
            }
            $tempHtml[] = gpHtml_single_group ($customSettingClone, array(),  $formControlSettings);
            $tempHtml[] = "</div>";
            $tempHtml[] = "<div class=\"btn btn-info float-right\" data-clone=\"#".$idRip."\" data-box=\"#". $wrapSettings['id']."\" ".implode(" ", $addData)." onclick=\"gpCloneGroup(this)\">  <ion-icon name=\"add-circle\" class=\"ionicon-left\"></ion-icon> ADD NEW</div><div class=\"clearfix\"></div>";
            $html = implode("", $tempHtml);
        } else {
            //TODO ERRORE se non è impostato un nome in un gruppo ripetibile.
            
        }
    } else {
        if (isset($settings['name']) ) {
            if (isset($values[$settings['name']]) && is_array($values[$settings['name']])) {
                $values = $values[$settings['name']];
            }   else {
                $values = array();
            }
        }
        $html = gpHtml_single_group ($settings, $values,  $formControlSettings);
    }

   
    // qui creo l'html che contiene tutto. Anche questo in funzione del layout
    if (isset($wrapSettings['title'])) {
        unset($wrapSettings['title']);
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
        if (isset($settings['name'])) {
            if (isset($settings['preview-name'])) {
                $field['preview-name'] = $settings['preview-name'].".".$settings['name'];
            } else {
                $field['preview-name'] = $settings['name'];
            }
        }
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