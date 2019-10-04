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
        
            <h2>i parametri</h2>
            <p> </p>
            <h3>Parametri comuni dei campi</h3>
            <ul>
                <li><b>type</b>: checkbox</li>
                <li><b>name</b>: Il nome del campo. Se ci sono più opzioni vengono aggiunte le parentesi quadre </li>
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
                <li><b>col-label e col-field</b>: la dimensione (da 1 a 12) del label e del campo se il layout è horizontal_form</li>
                <li><b>style</b>: gli stili css</li>
                <li><b>class</b>: le classi dei css </li>
                <li><b>onchange, onclick etc..</b>: i javascript</li>
            </ul>

            <br><hr><br>
            <h3>Validazione</h3>
            <p>I sistemi di validazione in generale non verificano se è required oppure no, quindi in generale vengono attivati solo quando il campo è compilato</p> 
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/input01.json"); 
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

            <h3>validazioni personalizzate</h3>
            <p>E' possibile aggiungere una o più validazioni personalizzate attraverso l'attributo gp-validation. Questo accetta più stringhe separate da spazio ognuna delle quali si riferisce ad una funzione di validazione.<br>
            Per aggiungere dinamicamente una nuova validazione si può usare la funzione di servizio gpAddValidationArray che riceve il field e il nome della funzione di validazione da attivare.</p>
            <p>Le funzioni di validazione vengono eseguite di continuo da quando viene creato il form. I messaggi di errore vengono però mostrati solo dopo aver premuto submit perché si aggiunge la class "was-validated" al form. Per questo motivo come si può vedere nell'esempio "tutto maiuscolo", è possibile intervenire a livello di editing.</p>
            <p>Se una funzione di gpValidation dà errore, viene scritta sulla console e il form continua ad essere eseguito.</p>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/gpvalidation.json"); 
            $dataForm = gpJsonDecode($json);
            ?>
            <script>
            function gpOnlyChar(that) {
                return /^[a-zA-Z]+$/.test($(that).val());
            }

            function gp3CharUpperCase(that) {
                return /^[A-Z]{3}/.test($(that).val());
            }
            // questo non valida, trasforma i valori
            function transformUpperCase(that) {
                var curPos = doGetCaretPosition(that);
                console.log (doGetCaretPosition(that));
                $(that).val($(that).val().toUpperCase());
                setCaretToPos(that,curPos);
                return true;
            }

            // posizione del cursore nel campo
            function doGetCaretPosition (oField) {
                // Initialize
                var iCaretPos = 0;
                // IE Support
                if (document.selection) {
                    // Set focus on the element
                    oField.focus();
                    // To get cursor position, get empty selection range
                    var oSel = document.selection.createRange();
                    // Move selection start to 0 position
                    oSel.moveStart('character', -oField.value.length);
                    // The caret position is selection length
                    iCaretPos = oSel.text.length;
                }

                // Firefox support
                else if (oField.selectionStart || oField.selectionStart == '0')
                    iCaretPos = oField.selectionDirection=='backward' ? oField.selectionStart : oField.selectionEnd;
                // Return results
                return iCaretPos;
            }

            function setSelectionRange(input, selectionStart, selectionEnd) {
                if (input.setSelectionRange) {
                    input.focus();
                    input.setSelectionRange(selectionStart, selectionEnd);
                }
                else if (input.createTextRange) {
                    var range = input.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', selectionEnd);
                    range.moveStart('character', selectionStart);
                    range.select();
                }
            }

            function setCaretToPos (input, pos) {
                setSelectionRange(input, pos, pos);
            }

            </script>
            <div class="row">
                <div class="col-sm">
                    <pre style ="max-height:200px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                </div>
                <div class="col-sm">
                <?php gpHtml_echoForm($dataForm); ?>  
                </div>
            </div> 

            <h3>Date (jqueryui)</h3>
            <p> </p>
            <h3>Parametri</h3>
            <ul>
                <li><b>type</b>: datepickerui. La data gestita con jquery ui</li>
                <li><b>pattern</b>: Se non inserito cerca di crearlo in automatico dal formato della data</li>
                <li><b>date-min</b>: limitare il calendario vedi jquery ui datepicker minDate per maggiori info </li>
                <li><b>date-max</b>: limitare il calendario vedi jquery ui datepicker maxDate per maggiori info</li>
                <li><b>date-format</b>: Il formato della data</li>
            </ul>
            <?php
            $json = file_get_contents(dirname(__FILE__)."/json/date.json"); 
            $dataForm = gpJsonDecode($json);
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <pre style ="max-height:200px; background:#F2F2F2"> <?php echo $json; ?></pre> 
                </div>
                <div class="col-sm-6">
                <?php gpHtml_echoForm($dataForm); ?>  
                </div>
            </div> 
        </div>
    </body>
</html>
<?php
