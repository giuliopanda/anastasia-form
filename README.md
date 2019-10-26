PHP BUILD BOOTSTRAP FORM
==========================

**Attualmente il lavoro è in sviluppo, non è ad una versione stabile.**


Questa serie di funzioni php permettono di generare un form a partire da un array (o un json).

Il form usa stili e sintassi di bootstrap 4, mentre per il javascript jquery e jquery ui.

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
