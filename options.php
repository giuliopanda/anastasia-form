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
            <h2> Gestione dei campi con opzioni</h2>
            <p>I campi con opzione possono essere gestiti staticamente, oppure attraverso classi php personalizzate.</p>
            <ul>
                <li><b>options</b>: sono le opzioni statiche di select, checkbox e radio.
                    <ul>
                        <li><b>label</b>: il testo</li>
                        <li><b>value</b>: il valore</li>
                    </ul>
                </li>
                <li><b>options-function</b>: Qui è possibile chiamare una funzione php che popolerà le opzioni. La funzione riceve l'array con i settings e i valori della form. Ritorna un array di opzioni.</li>
                <li><b>options > optgroup</b> Dentro le opzioni è possibile raggruppare gli elementi attraverso l'attributo optgroup 
                    <ul>
                        <li><b>label</b>: il testo</li>
                        <li><b>options</b>: le opzioni label-value</li>
                    </ul>
                </li>
            </ul>
            <?php
    
            $json = file_get_contents(dirname(__FILE__)."/json/options01.json"); 
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    il json
                    <pre style ="max-height:250px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                    la funzone php 
                    <pre style ="max-height:250px; background:#F2F2F2"> 
    function get_options_func($settings, $value) {
        $ris = array();
        $ris[] = array("label"=>"Queste opzioni sono", "value"=>"0");
        $ris[] = array("label"=>"generate da una funzione ", "value"=>"1");
        $ris[] = array("label"=>"personalizzata ", "value"=>"2");
        return $ris;
    }
                    </pre>
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm); ?>  
                </div>
            </div> 

            <h3> Option group </h3>
            <?php
             $json = file_get_contents(dirname(__FILE__)."/json/options02.json"); 
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
            <h3> Option group per checkbox</h3>
            <?php
             $json = file_get_contents(dirname(__FILE__)."/json/options03.json"); 
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    <pre style ="background:#F2F2F2"> <?php echo $json; ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm); ?>  
                </div>
            </div> 
        </div>
    </body>
</html>
<?php
function get_options_func($settings, $value) {
    $ris = array();
    $ris[] = array("label"=>"Queste opzioni sono", "value"=>"0");
    $ris[] = array("label"=>"generate da una funzione ", "value"=>"1");
    $ris[] = array("label"=>"personalizzata ", "value"=>"2");
    return $ris;
}

function get_optgroup_example_func($settings, $value) {
    $json = json_decode('[{"optgroup":{"label":"Lazio","id":"lazio","options":[{"value":"roma","label":"roma"},{"value":"frosinone","label":"frosinone"},{"value":"latina","label":"latina"},{"value":"rieti","label":"Rieti"},{"value":"Viterbo","label":"Viterbo"}]}},{"optgroup":{"label":"lombardia","id":"lombardina","options":[{"value":"MILANO","label":"MILANO"},{"value":"Mantova","label":"Mantova"},{"value":"Lodi","label":"Lodi"},{"value":"Lecco","label":"Lecco"},{"value":"Cremona","label":"Cremona"},{"value":"Como","label":"Como"},{"value":"Brescia","label":"Brescia"},{"value":"Bergamo","label":"Bergamo"},{"value":"Monza e della Brianza","label":"Monza e della Brianza"},{"value":"Pavia","label":"Pavia"},{"value":"Sondrio","label":"Sondrio"},{"value":"Varese","label":"Varese"}]}}]', true);
    return $json;
}