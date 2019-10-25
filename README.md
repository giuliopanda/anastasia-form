GENERARE FORM IN AUTOMATICO
==========================

Questa serie di funzioni php servono per generare un form a partire da un array (o un json).

Il form viene renderizzato con i css di bootstrap, mentre il javascript si poggia su jquery e jquery ui.

Il progetto prevede l'implementazione di tutta una serie di dinamiche javascript per la gestione di un form quali i campi ripetuti, una gestione avanzata dei checkbox e dei select, le date con particolare attenzione al sistema di validazione che partendo da bootstrap ne implementa una versione più completa.

QUICK START
-----------

dopo aver scaricato i file, apri il quickstart.php per vedere come impostare un primo progetto di base
```
<?php 
$dataForm = json_decode('
{
    "form" :
    {
        "method" : "get",
        "fields" : 
        [
            {
                "type":"input",
                "name":"field",
                "label":"Field"
            }
        ]
    }
}', true);
gpHtml_echoForm($dataForm); 
```

I file del progetto sono dentro la cartella gpform. 