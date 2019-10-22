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
        
            <h2>Nomi dei campi e valori</h2>
            <p> </p>
            <h3>Parametri</h3>
            <ul>
                <li><b>name</b>: Il nome del campo. Se ci sono più opzioni vengono aggiunte le parentesi quadre (tipo checkbox)</li>
                <li><b>preview-name</b>: Nel form è il nome che raggruppa tutto il form.
                <li><b>default</b>: Il valore di default</li>
                <li><b>value</b>: il valore del campo</li>
            </ul>

            <br><hr><br>
            <h3>Nomi e valori</h3>
            <p>Una volta creato un form si può passare un'array con i valori del form da inserire</p> 
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/namevalue01.json"); 
            $data = array("name"=>"Giulio", "gender"=>"male", 'age'=>"40", 'note'=>"<b>Ecco un testo con html</b><br>Come viene gestito?<textarea>asdad</textarea> \ngjgjhg");
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    <pre style ="max-height:200px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                    <pre style ="max-height:200px; background:#F2F2F2"> <?php var_dump ($data); ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm, $data); ?>  
                </div>
            </div> 

            <h3>array di valori</h3>
            <p>preview-name permette di associare un valore di default a tutti i valori dei form senza però cambiare il valore degli array di associazionw</p> 
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/namevalue02.json"); 
            $data = array("name"=>"Giulio");
            $data['user'] =array("name"=>"Sofia");
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    <pre style ="max-height:200px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                    <pre style ="max-height:200px; background:#F2F2F2"> <?php var_dump ($data); ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm, $data); ?>  
                </div>
            </div> 

            <h3>L'attributo name nel gruppo.</h3>
            <p>Name nei gruppi. permette di associare un valore di default a tutti i valori dei form senza però cambiare il valore degli array di associazionw</p> 
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/namevalue03.json"); 
            $data = array("name"=>"Giulio");
            $data['user'] =array("name"=>"Sofia");
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm">
                    <pre style ="max-height:200px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                    <pre style ="max-height:200px; background:#F2F2F2"> <?php var_dump ($data); ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm, $data); ?>  
                </div>
            </div> 

        </div>
    </body>
</html>
<?php
