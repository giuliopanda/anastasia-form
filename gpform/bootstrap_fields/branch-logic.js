// branch-logic

/**
 * Trova un campo partendo dal name. 
 * @param String name 
 * @param {*} typeOfReturn Dice se deve tornare  campo (element) oppure il valore (value) (default);
 */
var gpBLop = ['&&', 'AND', 'and', '||', 'OR', 'or',  '==', '!=', "<>", ">=", "<=", ">", "<", "+", "-", "/", "*", "in", "IN"];

// QUESTA FUNZIONE NON E' PIU' CORRETTA. ORA I CAMPI VENGONO DEFINITI DAl $ AD INIZIO
function blFindField(name, typeOfReturn) {
    if (!typeOfReturn) {
        typeOfReturn = "value";
    }
    var $field = $('[name="' + name + '"]');
    if ($field.get().length == 1) {
        var nodeName = $field.prop('nodeName').toLowerCase();
        var type = $field.prop('type').toLowerCase();
        console.log("[BRANCH-LOGIC]: '" + name + " nodeName " + nodeName + " type " + type);
        if (typeOfReturn == "element") { 
            return $field;
        }
        if (typeOfReturn == "value") {
            console.log("[BRANCH-LOGIC]: " + type);
            if (nodeName == "input" && (type == "input" || type == "hidden" || type == "text")) {
                return $field.val();
            }
            if (nodeName == "input" && (type == "checkbox")) {

            }
        }
    } else {
        var $field = $('[name="' + name + '-mergecheckbox"]'); 
        if ($field.get().length == 1) {
            if (typeOfReturn == "element") {
                return 'checkbox';
            } 
            return $field.val();
        }
        console.log("[BRANCH-LOGIC] ERROR: '"+name+"' return multiple elements");
        return false;
    }
    return false;
}

function blFindTargets(str) {
    console.log("blFindTargets");
    var tmpStr = str;
    for (i in gpBLop) {
        tmpStr = tmpStr.replace(gpBLop[i], "[||]", tmpStr);
    }
    var tmpStrArray = tmpStr.split("[||]");
    var result = [];
    for (i in tmpStrArray) {
        var tmpR = tmpStrArray[i].trim();
        
        if (tmpR.substr(0, 1) != "'" && tmpR.substr(0, 1) != '"') {
            var field = blFindField(tmpR, "element");
            if (field != false) {
                result.push(field);
            }
        }
    }
    console.log(result);
    return result;
}

// quando cambia un campo che fa parte di un branchlogic allora viene eseguita questa funzione
function gpCheckBranchLogic(that) {
    // l'elemento in cui è scritto il branchlogic al cui interno c'è il riferimento al campo che si sta modificando
    var target = $(that).data('gpblogictarget');
    var str = $(target).attr('gp-branchlogic');
    $block = gpUtilityFindblockField($(target));
    if (gpExecuteBranchLogic(str)) {
        $block.show();
        // mostra il campo
    } else {
        $block.hide();
        // nasconde il campo
    }

}

/**
 * Esegue il branchlogic  
 * Per ora prevedo una sola operazione per volta
 */
function gpExecuteBranchLogic(str) {
    console.log ("*** "+str);
    /* https://www.metaltoad.com/blog/regex-quoted-string-escapable-quotes
    virgolette 
    regex = /((?<![\\])['"])((?:(.|\n|\r)(?!(?<![\\])\1))*.?)\1/gm;
    while ((m = regex.exec(str)) !== null) {
        // This is necessary to avoid infinite loops with zero-width matches
        if (m.index === regex.lastIndex) {
            regex.lastIndex++;
        }

        // The result can be accessed through the `m`-variable.
        m.forEach((match, groupIndex) => {
            console.log(`Found match, group ${groupIndex}: ${match}`);
        });
    }
    */

    // parentesi

    var regexParentesi = /\(([^\(\)]+)\)/gm;
    findPar = true;
    while (findPar) {
        findPar = false;
        while ((m = regexParentesi.exec(str)) !== null) {
            // This is necessary to avoid infinite loops with zero-width matches
            if (m.index === regexParentesi.lastIndex) {
                regexParentesi.lastIndex++;
            }
            // The result can be accessed through the `m`-variable.
            m.forEach((match, groupIndex) => {
                if (match.indexOf("(") == -1) {
                   // console.log(`Found match, group ${groupIndex}: ${match}`);
                   // console.log(match);
                    str = str.replace("("+match+")", gpExecuteBranchLogic(match.replace("(", "").replace(")", "")));
                    findPar = true;
                }
            });
        }
    }

    var tmpStr = str;
    var findOpCharStart = -1;
    var firstOp = "";
    // trovo il primo operatore
   // console.log (str);
    for (i in gpBLop) {
        var curIndx = tmpStr.indexOf(gpBLop[i]);
        if (curIndx > -1 ) {
            firstOp = gpBLop[i];
            findOpCharStart = curIndx;
            break;
        }
    }
    if (findOpCharStart == -1) {
        if (str.substr(0, 1) == "'" || str.substr(0, 1) == '"') {
            return str.substr(1, str.length - 2);
        }
        if (!isNaN(str.trim())) {
            return Number(str.trim());
        }
        // altrimenti assumo che sia una variabile da cercare
        if (str.substr(0, 1) == "$") {
            return blFindField(str.substr(1, str.length - 1));
        }
        return str;
    }
    console.log( str);
    // divido la stringa con il primo operatore
    var firstPart = tmpStr.slice(0, findOpCharStart).trim();
    var opPart = tmpStr.slice(findOpCharStart, findOpCharStart + firstOp.length).trim();
    var secondPart = tmpStr.slice(findOpCharStart + firstOp.length).trim();
  //  console.log(" (" + firstPart + ") ("+ opPart + ") (" + secondPart + ")");
    var a = gpExecuteBranchLogic(firstPart);
    var b = gpExecuteBranchLogic(secondPart);
    console.log(" (" + a + ") ("+ opPart + ") (" + b + ")");
    a = String(a).trim();
    b = String(b).trim();
    switch (opPart) {
        case "==":
            return (a == b);
        case ">=":
            return (Number(a) >= Number(b));
        case "<=":
            return (Number(a) <= Number(b));
        case ">":
            return (Number(a) > Number(b));
        case "<":
            return (Number(a) < Number(b));
        case "!=":
            return (a != b);
        case "<>":
            return (a != b);
        case "+":
            return (Number(a) + Number(b));    
        case "-":
            return (Number(a) - Number(b));    
        case "/":
            return (Number(a) / Number(b));    
        case "*":
            return (Number(a) * Number(b));    
        case "AND":
            return ((a.toLowerCase() == 'true' || a == true || a == 1) && (b.toLowerCase() == 'true' || b == true || b == 1));
        case "&&":
            return ((a.toLowerCase() == 'true' || a == true || a == 1) && (b.toLowerCase() == 'true' || b == true || b == 1));
        case "OR":
            return ((a.toLowerCase() == 'true' || a == true || a == 1) || (b.toLowerCase() == 'true' || b == true || b == 1));
        case "||":
            return ((a.toLowerCase() == 'true' || a == true || a == 1) || (b.toLowerCase() == 'true' || b == true || b == 1));
        case "IN":
            try {
                c = JSON.parse(b);
                return (c.indexOf(a) > -1);
            } catch (e) {
                return (b.indexOf(a) > -1);
            }
        case "in":
            return (b.indexOf(a) > -1);
    }
    return 0;
}


/**
 * Imposta quali campi devono essere monitorati per valutare il branch logic.
 * @param {} element 
 */
function gpBranchLogicInit(element) {
    $(element).each(function () {
        $(this).find("*").each(function () {
            if ($(this).attr('gp-branchlogic')) {
                var fieldsToObserve = blFindTargets($(this).attr('gp-branchlogic'));
                for (fto in fieldsToObserve) {
                    $(fieldsToObserve[fto]).data('gpblogictarget', $(this));
                    $(fieldsToObserve[fto]).change(function () {
                        gpCheckBranchLogic(this);
                    });
                    gpCheckBranchLogic(fieldsToObserve[fto]);
                }
               
            }
        });
    });
}


$(function () {
    gpBranchLogicInit('.needs-validation');
});

