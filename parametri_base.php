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
            <h2>i parametri</h2>
            <p> </p>
            <h4>Parametri del form</h4>
            <ul>
                <li><b>id</b>: oltre a settare l'id del form viene usato per generare tutti gli id interni al form in modo univoco. Consigliato</li>
                <li><b>method</b>: get o post. Obbligatorio</li> 
                <li><b>fields</b>: L'array dei campi da disegnare. Obbligatorio</li> 
                <li><b>render</b>: Fa l'override di tutte le funzioni dei campi. Opzionale</li>
                <li><b>default-wrap</b>: L'html di default che racchiude i campi, comprensivo della gestione dei label. E' un oggetto con i seguenti parametri
                    <ul>
                        <li><b>type</b>: Quale funzione chiamare. Consigliato: group</li>
                        <li><b>layout</b>: Quale layout viene disegnato. Questo parametro viene passato ai singoli campi che lo passano a gpHtmlSetLayout dove viene impagniato il label con il field.</li>
                        <li><b>col-label e col-form</b>: la dimensione (da 1 a 12) del label e del campo se il layout è horizontal_form</li>
                    </ul>
                </li>
                <li><b>style</b>: gli stili css</li>
                <li><b>class</b>: le classi dei css </li>
                <li><b>onchange, onclick etc..</b>: i javascript</li>
                <li><b>preview-name</b>: Un nome di partenza. Ad esempio "preview-name":"user" farà sì che tutti i nomi dei campi inclusi si chiameranno user[name]</li>
            </ul>

            <h3>Parametri comuni dei campi</h3>
            <ul>
                <li><b>type</b>: checkbox</li>
                <li><b>name</b>: Il nome del campo. Se ci sono più opzioni vengono aggiunte le parentesi quadre (checkbox). Se il nome è concatenato dal punto esempio name.first apparirà name[first]. Se è presente un preview-name apparirà previewname[name][first] </li>
                <li><b>label</b>: Il nome del label oppure un oggetto con le opzioni dei label. 
                    <ul>
                        <li><b>text</b>: il testo del label </li>
                        <li><b>style</b>: gli stili css</li>
                        <li><b>class</b>: le classi dei css </li>
                        <li><b>onchange, onclick etc..</b>: i javascript</li>
                    </ul>
                </li>
                <li><b>labelname</b>: Il nome del label. E' un alias di label usato come stringa<li>
                <li><b>options</b>: I checkbox sono identificati qui da un array contentente coppie di valori label, value</li>
                <li><b>default</b>: Il valore di default</li>
                <li><b>required</b>: "true"</li>
                <li><b>disabled</b>: "true"</li>
                <li><b>col-label e col-form</b>: la dimensione (da 1 a 12) del label e del campo se il layout è horizontal_form</li>
                <li><b>style</b>: gli stili css</li>
                <li><b>class</b>: le classi dei css </li>
                <li><b>onchange, onclick etc..</b>: i javascript</li>
                <li><b>invalid</b>: Il testo quando il campo non soddisfa i criteri di verifica</li>
                <li><b>gp-validation</b>: richiama una funzione javascript in cui viene passato il campo da validare. Ritorna true false se il campo è validato oppure no.</li>
                <li><b>preview-name</b>: Un nome di partenza. Se già impostato si può mettere vuoto per rimuoverlo</li>
            </ul>

            <br><hr><br>
            <h3>Esempi</h3>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/params01.json"); 
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
       
            <h4> Altre opzioni </h4>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/params02.json"); 
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

            <h4> Layout e gruppi </h4>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/params03.json"); 
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
