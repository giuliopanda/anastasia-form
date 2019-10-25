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
        /** Rendo visibili i campi nascosti dei radio per far vedere come funzionano */
            #gpirequiredradioexample01 {display:block !important;}
            #gpirequiredradioexample02 {display:block !important;}
            #gpicxradioexample01 {display:block !important;}
            #gpicxradioexample02 {display:block !important;}
            #gpirequiredradiodisabilitato {display:block !important;}
            #gpirequiredradioonlyes {display:block !important;}
        </style>
    </head>
    <body>
        <div class="container">
        <h2> Gestione dei radio</h2>
        <p>I radio sono molto simili ai radio. Per mantenere la compatibilità con i messaggi invalid di bootstrap mantengono un campo nascosto in cui salvano il valore con il suffisso -mergeradio. </p>

        <h3>Parametri speciali</h3>
        <ul>
            <li><b>type</b>: radio</li>
            <li><b>name</b>: Il nome del campo. Se ci sono più opzioni vengono aggiunte le parentesi quadre </li>
            <li><b>elements-layout</b>: Può essere inline, oppure a colonne grid-[1-12]. Esempio grid-6 saranno due colonne </li>
            <li><b>options</b>: I radio sono identificati qui da un array contentente coppie di valori label, value, [required, disabled ...]</li>
            <li><b>default</b>: Il valore di default.</li>
            <li><b>required</b>: Il radio  deve essere spuntato. Non è possibile  mettere obbligatorio uno specifico valore.</li>
        </ul>
         <br><hr><br>
         <h3>Esempi</h3>
        <?php
        $json = file_get_contents(dirname(__FILE__)."/json/radio01.json"); 
        $dataForm = gpJsonDecode($json);
        $data = array('radio-example02'=>2);
        ?>
         <div class="row">
            <div class="col-sm">
                <pre style ="max-height:300px; background:#F2F2F2"> <?php echo $json; ?></pre> 
            </div>
            <div class="col-sm">
            <?php gpHtml_echoForm($dataForm, $data); ?>  
            </div>
        </div> 
       
        <h4> Campi obbligatori </h4>
        <p>Almeno un radio deve essere spuntato</p>
        <?php
        $json = file_get_contents(dirname(__FILE__)."/json/radio02.json"); 
        $dataForm = gpJsonDecode($json);
        ?>
         <div class="row">
            <div class="col-sm">
                <pre style ="max-height:300px; background:#F2F2F2"> <?php echo $json; ?></pre> 

                <p>Impostando una validazione attraverso una funzione personalizzata si può usare la funzione <b>gpValidation_radio_utility</b> per colorare correttamente i campi</p>
                <pre style="max-height:300px; background:#F2F2F2">&lt;script&gt;
    function onlyyes(that) {
        var ris =  ($(that).val() == &apos;1&apos;);
        return gpValidation_radio_utility(that, ris);
    }
&lt;/script&gt;</pre>
            </div>
            <div class="col-sm">
            <?php gpHtml_echoForm($dataForm); ?>  
            </div>
        </div> 
        <h4> Allineamento orizzontale </h4>
        <p> E' possibile scegliere di allineare i radio in orizzontale oppure in colonne. In quest'ultimo caso l'attributo grid-x definisce quanto spazio deve occupare ogni radio secondo la solita griglia a 12. Per cui grid-6 genererà due colonne, grid-4 tre colonne, grid-3 quattro colonne e grid-2 sei colonne. </p>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/radio03.json"); 
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
        <script>
        function onlyyes(that) {
            var ris =  ($(that).val() == '1');
            return gpValidation_radio_utility(that, ris);
        }
        </script>
    </body>
</html>
<?php
