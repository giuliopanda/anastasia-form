<?php
define("ANASTASIA_FORM","1");
function gpHtml_loadFolderFields($dir, $relative = true) {
    if ($relative) {
        $directory = dirname(__FILE__).DIRECTORY_SEPARATOR.$dir;
    } else {
        $directory = $dir;
    } 
    $folder = scandir($directory);
    foreach ($folder as $key => $value) {
        if (!in_array($value,array(".",".."))) {
            if (is_file($directory . DIRECTORY_SEPARATOR . $value) && substr($value,-4) == ".php") {
                require_once($directory . DIRECTORY_SEPARATOR . $value);
            }
        }
    }
}

function gpHtml_echoForm($dataForm, $values = "") {
    if (!is_array($values)) {
        $values = array();
    }
    if ($dataForm !== false && isset($dataForm['form']) && isset($dataForm['form']['fields'])) {
        $dataForm['form'] = gpHtmlUtilityAttrSetting($dataForm['form'], array('class'=>array('needs-validation')));
        $html = gpHtml_form($dataForm['form'], $values);
        if ($html !== false) {
            echo "<form novalidate". gpHtmlGetAttrs(array('action','accept-charset', 'autocomplete', 'enctype', 'method', 'novalidate', 'target' ), $dataForm['form']).">\n  ". $html."\n</form>\n";
        }
    }
}

/**
 * La funzione da cui si parte per generare il form.
 * @param Array $formArray la struttura di come è costruito il form
 * @param Array $values i dati da caricare nel form
 * @return Array (html, script) l'html del form e i javascript per la gestione dei dati  
 */
function gpHtml_form($formArray, $values) {
    $html = array();
    $count = 0;
    $render = (isset($formArray['render']) && trim($formArray['render']) != "") ?$formArray['render']."_" : '';
    $settingLayout = (isset($formArray['layout'])) ? $formArray['layout'] : '' ;

    foreach ($formArray['fields'] as $field) {
        if (isset($formArray['id'])) {
            $field['pre-id'] = $formArray['id'];
        }

        if (isset($formArray['preview-name']) && !isset($field['preview-name'])) {
            $field['preview-name'] = $formArray['preview-name'];
        }

        // parametri che vengono passati dal form  ai campi o al gruppo. Nel caso il gruppo poi deve passare questi valori ai campi 
        $field['layout'] = (isset($field['layout']) && $field['layout'] != "") ? $field['layout'] : $settingLayout;
        $count++;
        if (isset($formArray['default-wrap']) && $field['type'] != "group") {
            // Default wrap crea il gruppo di defualt da associare per ogni riga
            $tempData = $formArray['default-wrap'];
            $tempData['fields'] = array($field);
            $field = $tempData;
        } 
        if (function_exists('gpHtml_'.$render.$field['type'])) {
            $htmlField = call_user_func_array('gpHtml_'.$render.$field['type'], array($field, $values));
        
        }  else if (function_exists('gpHtml_'.$field['type'])) {
            $htmlField= call_user_func_array('gpHtml_'.$field['type'], array($field, $values)); 
        } else  {
            // la funzione non esiste
            continue; 
        }
        $html[] = $htmlField;
    }
    $htmlString = trim(implode("",$html) != "") ? trim(implode("", $html)) : false;
    return $htmlString;
}

/**
 * Imposta l'html a seconda di come è stato definito il layout. Questo è uguale per tutti gli elementi.
 * @param String $html 
 * @param Array $setting
 * @return String
 */

function gpHtmlSetLayout($html, $setting) {
    $setting = gpHtmlUtilityAttrSetting($setting, array('class'=>array('form-control')));
    if ($html !== false) { 
        switch ($setting['layout']) {
             case 'inline':
                $tempHtml = "\n     ";
                if (isset($setting['labelname']) && trim($setting['labelname']) != "") {
                    $setting['label'] = gpHtmlUtilityAttrSetting($setting['label'], array('class'=>array('my-1 mr-2')));
                    $tempHtml .= '<label'. gpHtmlGetAttrs(array('for'), $setting['label']) . '>'. gpHtmlGetAttrValue('labelname', $setting) . '</label>'."\n    ";
                }
                $tempHtml .= '<div class="my-1 mr-sm-2">'.$html."</div>";
                $html = $tempHtml;
                break;
            case 'horizontal_form':
                $setting['label'] = gpHtmlUtilityAttrSetting($setting['label'], array('class'=>array('col-form-label')));
                $colLabel = (isset($setting['col-label']) && (int)$setting['col-label'] > 0 &&  (int)$setting['col-label'] <= 12) ? (int)$setting['col-label'] : 2;
                $colForm = (isset($setting['col-field']) && (int)$setting['col-field'] > 0 &&  (int)$setting['col-field'] + $colLabel  <= 12) ? (int)$setting['col-field'] : 12 - $colLabel;
                $html = "\n    <div class=\"row\">\n     ".'<div class="col-sm-'.$colLabel.'"><label'. gpHtmlGetAttrs(array('for'), $setting['label']) . '>'. gpHtmlGetAttrValue('labelname', $setting) . '</label></div>'."\n    ".'<div class="col-sm-'.$colForm.'">'.$html."</div>\n    </div>";
                break;
            default:
                if (isset($setting['labelname']) && trim($setting['labelname']) != "") {
                    $html = "\n    ".'<label'. gpHtmlGetAttrs(array('for'), $setting['label']) . '>'. $setting['labelname'] . '</label>'."\n    ".$html;
                } else {
                    $html = "\n    ".$html;
                }
                break;
        }
    }     
    return "\n<div class=\"jsgp-blockfield\">\n  ".$html."\n</div>";
}

/**
 * Riceve una serie di attributi di un elemento html e ne ritorna la stringa con i valori compilati  
 * @param Array $arrayAttribute un array di attributi es ['name', 'class']
 * @param Array $setting il campo convertito dal json
 * @param Boolean $addDefault Se true aggiunge una serie di attributi che tanto si trovano in tutti gli elementi html e da la possibilità di aggiungere gli attributi data-*
 * @return String
 */

 function gpHtmlGetAttrs($arrayAttribute, $settings, $addDefault = true) {
    $string = array();
     if ($addDefault) {
         $arrayAttribute = array_merge($arrayAttribute, array('class','style','id','title','alt','onclick','onblur','onchange','oncontextmenu','onfocus','oninput','oninvalid','onreset','onsearch','onselect','onsubmit'));
        $arrayAttribute = array_unique($arrayAttribute);
        foreach ($settings as $att=>$_val) {
            if (substr($att,0,5) == "data-" || substr($att,0,2) == "v-" || substr($att,0,3) == "gp-") {
                $string[] = trim(gpHtmlGetAttr($att, $settings));
            }
        }
        
     }
    foreach ($arrayAttribute as $att) {
         $string[] = trim(gpHtmlGetAttr($att, $settings));
    }
    $string = array_filter($string);
    $string = trim(implode(" ", $string));
    if ($string != "") {
        return " ".$string;
    } else {
        return "";
    }
 }
/**
 * Restituisce gli attributi da inserire
 */

 function gpHtmlGetAttr($attribute, $settings) {
    if (!isset($settings[$attribute])) return "";
    if ($settings[$attribute] === true) {
        return " ".$attribute.' ';
    }
    if (is_string($settings[$attribute]) || is_numeric($settings[$attribute])) {
        return " ".$attribute.'="'.str_replace('"','\"', $settings[$attribute]).'" ';
    } else if (is_array($settings[$attribute])) {
          $vals = array();
        $typeArray = '';
        foreach ($settings[$attribute] as $key=>$value) {
            if ((((int)$key > 0 && (string)(int)$key == $key)) || $key == '0') {
                if ($typeArray != "" && $typeArray != 'array') {
                    $typeArray = 'error';
                    break;
                } else { 
                    $typeArray = 'array';
                }
            } else {
                if ($typeArray != "" && $typeArray != 'object') {
                    $typeArray = 'error';
                    break;
                } else { 
                     $typeArray = 'object';
                }
               
            }
        }
        if ($typeArray == "object") {
            foreach ($settings[$attribute] as $key=>$value) {
                $vals[$key] = $key.":".$value;
            }
            $value = str_replace("  ", " ", implode(";", $vals));
            return " ".$attribute.'="'.str_replace('"','\"', $value).'" ';
        }
        if ($typeArray == "array") {
            $vals = str_replace("  ", " ", implode(" ", $settings[$attribute]));
            return " ".$attribute.'="'.str_replace('"','\"', $vals).'" ';
        }
    } else if (is_object($settings[$attribute])) {
        $vals = array();
        foreach ($settings[$attribute] as $key=>$value) {
            $vals[$key] = $key.":".$value;
        }
        $value = str_replace("  ", " ", implode(";", $vals));
        return " ".$attribute.'="'.str_replace('"','\"', $value).'" ';
    }

    return "";
 }

/**
 * Ritorna il valore dell'array. Se viene passato un array tra i valori ritorna il primo valore di cui esiste la chiave
 */
function gpHtmlGetAttrValue($mixed, $array) {
    if (is_array($mixed)) {
        foreach ($mixed as $key) {
            if (isset($array[$key])) {
                return $array[$key];
            }  
        }
    }
    if (is_string($mixed) && isset($array[$mixed])) {
        return $array[$mixed];
    }
    return "";
}

/** Aggiunge un valore agli attributi dei settings */
function gpHtmlAddAttrValue($attributeArray, $array) {
    foreach ($attributeArray as $at=>$val) {
        if (isset($array[$at])) {
            if (is_array($val) || is_array($array[$at])) {
                if (!is_array($val)) {
                    $val = array($val);
                }
                if (!is_array($array[$at])) {
                    $array[$at] = array($array[$at]);
                }
                $array[$at] = array_merge($array[$at], $val);
            } else {
                 $array[$at] .= $array[$at];
            }
        } else {
            $array[$at] = $val;
        }
    }
    return $array;
}
/**
 * Utility per il setting degli attributi degli elementi html. In particolare inserisce l'id se non esisteva e divide gli attributi per il label.
 */
function gpHtmlUtilityAttrSetting($settings, $add = false) {
   
    if (!isset($settings['id']) && isset($settings['name'])) {
        if(isset($settings['preview-name']) && $settings['preview-name'] !="") {
            $string  = str_replace(array(' ',"-"), '_', strtolower(trim($settings['preview-name'])))."_".str_replace(array(' ',"-"), '_', strtolower(trim($settings['name'])));
        } else {
            $string = str_replace(array(' ',"-"), '_', strtolower(trim($settings['name']))); 
        }
        $settings['_name-clean']  = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        if (isset ($settings['pre-id'])) {
            $settings['id'] = "gpi".$settings['pre-id'].$settings['_name-clean'];
        } else {
            $settings['id'] = "gpi".$settings['_name-clean'];
        }
    }
    if (!isset($settings['labelname'])) {
        if (isset($settings['name'])) {
            $settings['labelname'] = $settings['name'];
        } else {
            $settings['labelname'] = '';
        }
    }
    if (!isset($settings['layout'])) {
        $settings['layout'] = '';
    }
    if (isset($settings['required']) && $settings['required'] == "true") {
        $settings['required'] = true;
    }
    if (isset($settings['disabled']) && $settings['disabled'] == "true") {
        $settings['disabled'] = true;
    }
    if (!isset($settings['label'])) {
        $settings['label'] = array();
    }
    if ($settings['label'] !== false) {
        if (is_string($settings['label'])) {
            $settings['labelname'] = $settings['label'];
            $settings['label'] = array();
        } else if(is_array($settings['label']) && isset($settings['label']['text'])) {
            $settings['labelname'] = $settings['label']['text'];
        }
    } else {
        $settings['labelname'] = '';
    }
    if (!isset($settings['for']) && isset($settings['id'])) {
        $settings['label']['for'] = $settings['id'];
    }
    if (!isset($settings['label']['id']) && isset($settings['id'])) {
        $settings['label']['id'] = $settings['id']."_label";
    }
    if ($add !== false) {
        foreach ($add as $key=>$value) {
            if (!isset($settings[$key])) {
                $settings[$key] = $value;
            } else if (is_array($value) || is_array($settings[$key])) { 
               
                if (!is_array($settings[$key])) {
                        $settings[$key] = array($settings[$key]);
                }
                if (is_array($value) ) {
                    $settings[$key] = array_merge($settings[$key], $value);
                } else {
                    if ($key == "style") {
                        $newValue = array();
                        $value = array_filter(explode(";", $value));
                        foreach ($value as $vt) {
                            $vtt = explode(":", $vt);
                            $newValue[$vtt[0]] = $vtt[1];
                        }
                         $value =  $newValue;
                        $settings[$key] = array_merge($settings[$key], $value);
                    } else {
                        $settings[$key] = array_merge($settings[$key], array($value));
                    }
                   
                }
            } 
        }
    }
    if (isset($settings['name'])) {
       
        $settings['nameForValue'] = $settings['name'];
        if(isset($settings['preview-name']) && $settings['preview-name'] !="") {
            $settings['name'] = trim($settings['preview-name']).".".trim ($settings['name']);
        } else {
            $settings['name'] = trim ($settings['name']);
        }
        if (strpos($settings['name'], ".") > 0) {
            $tempName = explode(".", $settings['name']);
            $settings['nameForValue'] =$tempName[count($tempName) - 1];
            $settings['name'] = trim(array_shift($tempName));
            foreach ($tempName as $tp) {
                $settings['name'] .= "[".trim($tp)."]";
            }
        } elseif(isset($settings['preview-name']) && $settings['preview-name'] !="") {
            $settings['name'] = $settings['preview-name']."[". $settings['name']."]";
        }
    } 

    return $settings;
}


/**
 * Trova il valore di un array multiplo dato un percorso con il punto
 * esempio values : {"a":{"b":"ciao"}}  name = a.b 
 */
function gpHtmlUtilityFindValue($values, $name) {
    if (!is_array($values) || !is_string($name) ) {
        return false;
    }
    $names = explode(".", $name);
    $currValues = $values;
    if (count($names) > 0) {
        foreach ($names as $n) {
            if (isset($currValues[$n])) {
                $currValues = $currValues[$n];
            } else {
                return false;
            }
        }
        return $currValues;
    } else {
        if (isset($currValues[$name])) {
            $currValues = $currValues[$name];
        } else {
            return false;
        }
    }
    return false;
}
