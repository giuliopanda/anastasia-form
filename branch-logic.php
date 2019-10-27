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
            <h2>Logiche</h2>
             <p></p>
            <h3>Parametri</h3>
            <ul>
                <li><b>branch-logic</b>: Definisce se mostrare o no alcuni campi o gruppi di campi</li>
            </ul>
            <br>
            <h3>Uso di base</h3>
            <p>
            Si possono usare i seguenti operatori:  ['&&', 'AND', 'and', '||', 'OR', 'or',  '==', '!=', "<>", ">=", "<=", ">", "<", "+", "-", "/", "*", "in", "IN"]
            <br>
            IN viene usato per gestire i dati all'interno di un json quale i checkbox oppure per cercare sottostringe all'interno di una stringa
            "ci" IN "coccio"
            <br>
            I campi vengono richiamati tramite il $
            TODO la funzione branch-logic (blFindField) AL MOMENTO NON FUNZIONA!
            
            </p>
            
            <?php
           $json = file_get_contents(dirname(__FILE__)."/json/branch-logic01.json"); 
          
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    <pre style ="max-height:800px; background:#F2F2F2"> <?php echo $json; ?></pre>  
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm); ?>  
                </div>

            </div> 
        </div>
        <script>
            function gpexecuteBl() {
                console.log ('gpexecuteBl');
                $('#res').val(gpExecuteBranchLogic($('#bl').val()));
            }
        </script>
    </body>
</html>
<?php
