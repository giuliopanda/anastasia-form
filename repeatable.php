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
                <li><b>repeatable</b>: Se impostato permette di ripetere il gruppo di opzioni. I valori passsati con il data hanno come key il name ipostato sul gruppo.
                    <ul>
                        <li><b>clone</b>: "true" se è possibile aggiungere nuovi gruppi</li>
                        <li><b>class, style, id etc...</b>: I parametri vengono aggiunti al div che contiene un singolo gruppo di ripetizione.</li>
                    </ul>
                </li>
               <li>TODO: delete</li>
               <li>TODO: clone</li>
               <li>TODO: ordina</li>
               <li>TODO: numero di gruppi vuoti quando si carica il form senza dati</li>
               <li>TODO: numero di gruppi vuoti quando si carica il form con dati già inseriti</li>
            </ul>
            <p>Per la parte della programmazione se bisogna avviare una funzione alla creazione del form si mette nell'elemento da definire data-gphtmlinit con il nome della funzione da passare. La funzione riceve solo l'elemento su cui esiste. Se bisogna passare altri parametri si mettono in data. Quando si clona un gruppo i nomi e gli Id vengono riscritti. Se serve di passare un id dentro una proprietà data bisogna mettere il cancelletto prima in questo modo viene riscritto anche il parametro data con il riferimento dell'id.
            </p>
            <br>
            <h3>Ripetizione</h3>
            <p>Test di funzionamento dei vari campi</p>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/repeatable01.json"); 
            $data = array();
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
                    <pre style ="max-height:800px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                     <pre style ="max-height:600px; background:#F2F2F2"> <?php echo str_replace(",",",\n", json_encode($data)); ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm, $data); ?>  
                </div>
            </div> 

            <h3>Test sui parametri di repeatable</h3>
            <p>Se è permesso il bottone clone</p>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/repeatable02.json"); 
            $data = array();
            $data['users']= array(array('name'=>"Giulio"), array('name'=>"Sofia"));
            $data['users2']= array(array('name'=>"Giulio"), array('name'=>"Sofia"));
            $data['checkboxes'][] = array('checkbox-cols'=>array(1,2));
            $data['radios'][] = array('rd'=>array());
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    <pre style ="max-height:800px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                     <pre style ="max-height:600px; background:#F2F2F2"> <?php echo str_replace(",",",\n", json_encode($data)); ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm, $data); ?>  
                </div>
            </div> 


        </div>
    </body>
</html>
<?php
