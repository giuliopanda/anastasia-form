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
            <h2>Ripetizione dei campi</h2>
            <p></p>
            <h3>Parametri IN LAVORAZIONE</h3>
            <ul>
                <li><b>name</b>: Se impostato tutti i campi del gruppo hanno il name come prefisso. Serve anche per estrarre i dati da un sottoinsieme</li>
                <li><b>repeatable</b>: Se impostato permette di ripetere il gruppo di opzioni con i valori che hanno come key il name ipostato sul gruppo.</li>
            </ul>

            <p>Per la parte della programmazione se bisogna avviare una funzione alla creazione del form si mette nell'elemento da definire data-gphtmlinit con il nome della funzione da passare. La funzione riceve solo l'elemento su cui esiste. Se bisogna passare altri parametri si mettono in data. Quando si clona un gruppo i nomi e gli Id vengono riscritti. Se serve di passare un id dentro una proprietà data bisogna mettere il cancelletto prima in questo modo viene riscritto anche il parametro data con il riferimento dell'id.
            </p>


            <br>
            <h3>Ripetizione</h3>
            <p>I campi vengono ripetuti a seconda del numero di dati importati 
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/repeatable01.json"); 
            $data = array('title' => "un campo singolo", 'users' => array(), 'checkboxes' => array());
            $data['users'][] = array('name'=>"Giulio","email"=>"giulio@gmail.com");
            $data['users'][] = array('name'=>"Marco","email"=>"marco@gmail.com");
            $data['users'][] = array('name'=>"Sofia","email"=>"sofia@gmail.com");
            $data['checkboxes'][] = array('checkbox-cols'=>array(1,2));
            $data['checkboxes'][] = array('checkbox-cols'=>array());
            $data['radios'][] = array('rd'=>array());
            $data['radios'][] = array('rd'=>array("1"));
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    <pre style ="max-height:200px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                     <pre style ="max-height:200px; background:#F2F2F2"> <?php echo str_replace(",",",\n", json_encode($data)); ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm, $data); ?>  
                </div>
            </div> 
        </div>
    </body>
</html>
<?php
