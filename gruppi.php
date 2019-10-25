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
            <h2>Gruppi</h2>
            <p></p>
            <h3>Parametri</h3>
             <ul>
                <li><b>cols</b>: La divisione in celle di un gruppo su base 12. Può essere un numero che divide in colonne il gruppo di field oppure un array con più valori es ["6","6"]. In quest'ultimo caso si possono definire anche più righe es ["6","6","4","4","4"] (due righe una con due colonne e una con tre.</li>
                <li><b>title</b>: Il titolo del gruppo</li>
                <li><b>decription</b>: la descrizione del gruppo</li>
                <li><b>footer</b>: il testo in fondo al gruppo</li>
            </ul>

            <br>
            <h3>Griglie</h3>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/group01.json"); 
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    <pre style ="max-height:200px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm); ?>  
                </div>
            </div> 
       
            <h4> Titoli e testi </h4>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/group02.json"); 
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    <pre style ="max-height:300px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm); ?>  
                </div>
            </div> 

            <h4> stili e attributi e gruppi annidati </h4>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/group03.json"); 
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    <pre style ="max-height:400px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm); ?>  
                </div>
            </div> 
            <h4> group layout INLINE </h4>
            <p>Parametri dei gruppi</p>
            <ul>
                <li><b>layout</b>: "inline"</b>
                <li><b>layout-inline-class</b>: Imposta una classe sull'inline che è display flex. Quindi valgono tutte le impaginazioni flex tipo "justify-content-between"</li>
            </ul>
            <p>Parametri dei campi</p>
            <ul>
                <li><b> pull-right</b>: "true" Manda a destra il campo impostato e i successivi</b>
            </ul>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/group04.json"); 
            $dataForm = gpJsonDecode($json);
            ?>
            <pre style ="max-height:300px; background:#F2F2F2"> <?php echo $json; ?></pre> 
            <?php gpHtml_echoForm($dataForm); ?>  

            <h4> Hide/Show gruppo (e default) </h4>
        </div>
    </body>
</html>
<?php
