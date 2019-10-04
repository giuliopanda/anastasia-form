<?php 
    // dove si trovano i singoli campi da caricare
    $fieldFolder = "bootstrap_fields";
    require (dirname(__FILE__)."/gpform/gpform.php");
    gpHtml_loadFolderFields($fieldFolder);
?><html>
    <head>
         <?php require "head.php"; ?>
    </head>
    <body>
        <div class="container">
        <h2> Gestione dei form</h2>
        <p>questa serie di funzioni permette di generare dei form a partire da un array o un json.</p>
        <h3>gpHtml_form</h3>
        <p> Questa è la funzione principale a cui viene passato l'array con la struttura del form e i dati da compilare. La funzione cicla i dati dell'array e richiama le funzioni associate per generare i singoli campi. Le funzioni vengono richiamate a seconda del parametro type. Ad esempio un campo con type "input" chiamerà la funzione gpHtml_input. Se si desidera creare un nuovo gruppo di funzioni per il rendering dei form si può aggiungere l'attributo <b>"render"</b> => "mycustom". In questo modo le funzioni richiamate saranno del tipo gpHtml_mycustom_input. Se non viene trovata la funzione eseguirà la rispettiava funzione senza il suffisso del render.</p>
        <?php
        /** 
         Questa serie di funzioni gestisce la creazione di un form a partire da un json.
        
        I parametri sono:
        FORM: Apre un form. I parametri sono gli attributi del form tranne render e fields che sono due parametri speciali.
        FIELDS: contiene i campi da disegnare. Ogni campo equivale ad una funzione
        RENDER: modifica il nome della funzione da chiamare per i campi che sono sottostanti. Quindi se FORM ha un render = "pippo" le chiamate saranno gpHtml_pippo_[type] . Lefunzioni vengono richiamate dal parametri type. 
        Il render è solo nella parte del form, poi all'interno se serve fare un'override di una funzione lo si fa attraverso il layour
        E' possibile passare qualsiasi attributo valido da scrivere classi o stili semplicemente aggiungendo il parametro. Possono essere aggiunte tramite array esempio:  "class": ["class1","my_class","form_class"], oppure tramite un oggetto Esempio: "style" : { "color":"#258", "font-size":"16px"},


        I label possono essere modificati scrivendo labelname: "..." oppure label:"..." oppure label {text:"..."}
        * 
        * QUESTO SISTEMA PER GENERARE I FORM NON GESTISCE I VALORI... GENERA SOLO UN TEMPLATE!
        */
        //$json = file_get_contents(dirname(__FILE__)."/form.json");
      

        /**
         * cicla il json e crea l'html secondo il tipo e la renderizzazione 
         */
        $json = file_get_contents(dirname(__FILE__)."/json/example01.json"); 
        $dataForm = gpJsonDecode($json);
        ?>
         <div class="row">
            <div class="col-sm">
                <pre style ="max-height:500px; background:#F2F2F2"> <?php echo $json; ?></pre> 
            </div>
            <div class="col-sm">
            <?php gpHtml_echoForm($dataForm); ?>  
            </div>
        </div> 
        <h2>Aggiungere Javascript</h2>
        <p>E' possibile aggiungere un javascript ad esempio aggiungendo l'attributo onclick</p>
        <?php
        $json = file_get_contents(dirname(__FILE__)."/json/example02.json"); 
        $dataForm = gpJsonDecode($json);
        ?>
        <div class="row">
            <div class="col-sm">
                <pre style ="max-height:300px; background:#F2F2F2"> <?php echo $json; ?></pre> 
            </div>
            <div class="col-sm">
            <?php gpHtml_echoForm($dataForm, array('primo_numero' => 2, 'secondo_numero'=>4)); ?>  
            </div>
        </div> 

        <h2>Required</h2>
        <p></p>
        <?php
        $json = file_get_contents(dirname(__FILE__)."/json/example03.json"); 
        $dataForm = gpJsonDecode($json);
        ?>
        <div class="row">
            <div class="col-sm">
                <pre style ="max-height:300px; background:#F2F2F2"> <?php echo $json; ?></pre> 
            </div>
            <div class="col-sm">
            <?php gpHtml_echoForm($dataForm, array('primo_numero' => 2, 'secondo_numero'=>4)); ?>  
            </div>
        </div> 
        <script>
       

        function form2Calcola(that) {
           $('#f2a3').val( parseFloat($('#f2a1').val())+ parseFloat($('#f2a2').val()) );
        }
       
        </script>
        </div>
    </body>
</html>
<?php
