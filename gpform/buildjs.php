<?php
$getFolder = str_replace(array("/", "\\"), "", $_GET['folder']);
$directory = dirname(__FILE__).DIRECTORY_SEPARATOR.$getFolder;

$folder = scandir($directory);
$js = array();

$js[] = file_get_contents( dirname(__FILE__).DIRECTORY_SEPARATOR."gpform.js");
foreach ($folder as $key => $value) {
    if (!in_array($value,array(".",".."))) {
        if (is_file($directory . DIRECTORY_SEPARATOR . $value) && substr($value,-3) == ".js") {
            $js[] = file_get_contents($directory . DIRECTORY_SEPARATOR . $value);
        }
    }
}
header('Content-Type: application/javascript');
echo implode("\n", $js);