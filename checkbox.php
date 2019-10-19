<?php 
    // dove si trovano i singoli campi da caricare
    $fieldFolder = "bootstrap_fields";
    require (dirname(__FILE__)."/gpform/utility.php");
    require (dirname(__FILE__)."/gpform/gpform.php");
    gpHtml_loadFolderFields($fieldFolder);
?><html>
    <head>
         <?php require "head.php"; ?>
        <style>
        /** Rendo visibili i campi nascosti dei checkbox per far vedere come funzionano */
            #gpirequiredcheckboxexample01 {display:block !important; margin-top: 0.7rem;}
            #gpirequiredcheckboxexample02 {display:block !important; margin-top: 0.7rem;}
            #gpicxcheckboxexample01 {display:block !important; margin-top: 0.7rem;}
            #gpicxcheckboxexample02 {display:block !important; margin-top: 0.7rem;}
            #gpirequiredcheckboxdisabilitato {display:block !important; margin-top: 0.7rem;}
        </style>
    </head>
    <body>
        <div class="container">
        <h2> Gestione dei checkbox</h2>
        <p>I checkbox possono essere singoli o multipli. Per una più semplice gestione dei dati i valori vengono salvati in un campo nascosto che si chiama come il nome dei checkbox con il suffisso -mergecheckbox. I dati al suo interno possono assumere un valore secco se c'è un solo checkbox, oppure un json di valori. In questi esempio il campo di input generalmente nascosto è visibile per comprendere meglio il funzionamento</p>

        <h3>Parametri speciali</h3>
        <ul>
            <li><b>type</b>: checkbox</li>
            <li><b>name</b>: Il nome del campo. Se ci sono più opzioni vengono aggiunte le parentesi quadre </li>
            <li><b>elements-layout</b>: Può essere inline, oppure a colonne grid-[1-12]. Esempio grid-6 saranno due colonne </li>
            <li><b>options</b>: I checkbox sono identificati qui da un array contentente coppie di valori label, value, [required, disabled ...]</li>
            <li><b>default</b>: Il valore di default. Può essere anche un array [1,2] nel caso il valore di default comprendesse più checkbox</li>
            <li><b>required</b>: Se obbligatorio almeno un checkbox deve essere spuntato. E' possibile altrimenti mettere obbligatorio una singola opzione.</li>
        </ul>
         <br><hr><br>
         <h3>Esempi</h3>
        <?php
        $json = file_get_contents(dirname(__FILE__)."/json/checkbox01.json"); 
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
       
        <h4> Campi obbligatori </h4>
        <p>Almeno un checkbox deve essere spuntato</p>
        <?php
        $json = file_get_contents(dirname(__FILE__)."/json/checkbox02.json"); 
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
        <h4> Allineamento orizzontale </h4>
        <p> E' possibile scegliere di allineare i checkbox in orizzontale oppure in colonne. In quest'ultimo caso l'attributo grid-x definisce quanto spazio deve occupare ogni checkbox secondo la solita griglia a 12. Per cui grid-6 genererà due colonne, grid-4 tre colonne, grid-3 quattro colonne e grid-2 sei colonne. </p>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/checkbox03.json"); 
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

        </div>
    </body>
</html>
<?php
