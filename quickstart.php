<?php 
    // dove si trovano i singoli campi da caricare
    $fieldFolder = "bootstrap_fields";
    require (dirname(__FILE__)."/gpform/utility.php");
    require (dirname(__FILE__)."/gpform/gpform.php");
    gpHtml_loadFolderFields($fieldFolder);
?><html>
    <head>
        <?php require "head.php"; ?>
    </head>
    <body>
        <div class="container">
            <?php 
            $dataForm = json_decode('
            {
                "form" :
                {
                    "method" : "get",
                    "fields" : 
                    [
                        {
                            "type":"input",
                            "name":"field",
                            "label":"Field"
                        }
                    ]
                }
            }', true);
            gpHtml_echoForm($dataForm); 
            ?> 
        </div>
    </body>
</html>