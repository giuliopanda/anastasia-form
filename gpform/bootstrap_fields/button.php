<?php
/*
https://getbootstrap.com/docs/4.3/components/spinners/
<button class="btn btn-primary" type="button" disabled>
  <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
  Loading...
</button>
*/
function gpHtml_button($settings, $values) {
    if (!isset($settings['class'])) {
        $settings['class'] = array('btn-light');
    }
    $settings = gpHtmlUtilityAttrSetting($settings, array('class'=>array('btn')));
    $settings['value'] =  gpHtmlGetAttrValue(array('value',  'text', 'default'), $settings);
    $html ='<button '. gpHtmlGetAttrs(array('type','disabled'), $settings) .'>'. $settings['value'] .'</button>';
    return gpHtmlSetLayout($html, $settings);
}  


function gpHtml_submit($settings, $values) {
    if (!isset($settings['class'])) {
        $settings['class'] = array('btn-primary');
    }
    $settings = gpHtmlUtilityAttrSetting($settings, array('class'=>array('btn')));
     
    $settings['value'] =  gpHtmlGetAttrValue(array('value', 'default', 'text'), $settings);
    $html ='<input type="submit"'. gpHtmlGetAttrs(array('value'), $settings) .'>';
    return gpHtmlSetLayout($html, $settings);
}  

