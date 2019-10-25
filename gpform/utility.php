<?php
/**
 * Decode del json
 */
function gpJsonDecode($string) {
    $json = json_decode($string, true);
    $error = true;
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            $error = false;
           // echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
         //   echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
         //   echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
         //   echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
         //   echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
         //   echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
         //   echo ' - Unknown error';
        break;
    }
    return ($error) ? false : $json;
}