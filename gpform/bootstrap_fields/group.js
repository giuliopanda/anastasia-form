
/**
 * Per i gruppi che si ripetono la funzione che clona il gruppo
* @param {} that
 */
function gpCloneGroup(that) {
    var idClone = $(that).data('clone');
    //console.log("BOX: " + $(that).data('box'));
    var box = $(that).data('box');
    var nameReplace = "{" + $(that).data('idrip') + "}";
  //  console.log("TODO: NAMEREPLACE: " + nameReplace);
    var maxCount = 0;
    $(box).find('.gpjs-repeatable').each(function () {
        var d = $(this).data('repgroup').split(".");
        count = d.pop();
        maxCount = Math.max(maxCount, count);
    })
    maxCount++;
    dataRepGroup = $(that).data('name').split(".");
    //console.log("dataRepGroup: " + $(that).data('name'));
    dataRepGroup.push(maxCount);
    joinDataRepGroup = dataRepGroup.join(".");
  
    newDataRepGroup = dataRepGroup.shift();
    if (dataRepGroup.length > 0) {
        for (drg in dataRepGroup) {
            newDataRepGroup += "[" + dataRepGroup[drg] + "]"
        }
    }
  
    // console.log("dataRepGroup: " + newDataRepGroup + " " + joinDataRepGroup);
    // console.log(idClone);
    $clone = $(idClone).clone();
    /*
    if (!$(that).is(":invalid")) {
    if (!tempRis) {
        that.setCustomValidity('invalid');
    } else {
        that.setCustomValidity("");
    }
}
    */
    
    // Sostituisco i  {id} con i nome
    $clone.find('*').each(function () {
        if (typeof $(this).data('name') != "undefined") {
            if ($(this).data('name').indexOf(nameReplace) > -1) {
                //console.log("TODO namereplace > " + nameReplace + " => " + newDataRepGroup);
                newName = $(this).data('name').replace(nameReplace, newDataRepGroup);
                $(this).removeAttr('data-name');
                $(this).attr('data-name', newName);
                $(this).data('name', newName);
            }
        }
    });



    $clone.find('*').each(function () {
        allData = $(this).data();
        for (dx in allData) {
           // console.log("DATA" + allData[dx]);
            if (allData[dx].substring(0, 1) == "#") {
                console.log("NEW DATA (" + dx + ")" + "#gp" + maxCount + allData[dx].substring(1));
                $(this).removeAttr('data-' + dx);
                $(this).attr('data-' + dx, "#gp" + maxCount + allData[dx].substring(1));
                $(this).data(dx, "#gp" + maxCount + allData[dx].substring(1));
            }
        }

      
        if ($(this).prop('name')) {
            var oldName = $(this).attr('name');
            //console.log("OLD NAME: " + $(this).attr('name') + " nameReplace: " + nameReplace);
            if ($(this).attr('name').indexOf(nameReplace) > -1) {
                //console.log("TODO namereplace > " + nameReplace+" => "+ newDataRepGroup);
                oldName = oldName.replace(nameReplace, newDataRepGroup);
                $(this).prop('name', oldName );
            } 
        }

        if ($(this).prop('id')) {
          //  console.log("NEW ID " + "#gp" + maxCount + $(this).prop('id'));
            $(this).prop('id', "gp" + maxCount + $(this).prop('id'));
        }
        if ($(this).prop('for')) {
            $(this).prop('for', "gp" + maxCount + $(this).prop('for'));
        }
    })
  

    // fix ion-icon error
    $clone.find('ion-icon').each(function() {
        $(this).removeClass('md').removeClass('hydrated');
        $(this).after($("<ion-icon name=" + $(this).attr('name') + " class=" + $(this).attr('class') +"></ion-icon>"));
        $(this).remove();
    });
    $clone.css('display', 'none');
    $(idClone).before($clone);
    $clone.slideDown('fast') 
    $clone.css('display', 'block');
    $clone.removeAttr('id');
    $clone.addClass('gpjs-repeatable');
    $clone.removeClass('gpjs-formignore');
    $clone.data('repgroup', joinDataRepGroup);

    $(idClone).find('input').each(function() {
        if ($(this).is(":invalid")) {
            $clone.find('input').each(function () {
               this.setCustomValidity('');
               this.setCustomValidity('invalid');
            });
            return false;
        }
    })

    $(idClone).find('select').each(function () {
        if ($(this).is(":invalid")) {
            $clone.find('select').each(function () {
                this.setCustomValidity('');
                this.setCustomValidity('invalid');
            });
            return false;
        }
    })
    $(idClone).find('textarea').each(function () {
        if ($(this).is(":invalid")) {
            $clone.find('textarea').each(function () {
                this.setCustomValidity('');
                this.setCustomValidity('invalid');
            });
            return false;
        }
    })
    // sortable
    var gpK = 0;
    $(box).find('.gpjs-sortable-input').each(function () {
        $(this).val(gpK);
        gpK++;
    })

    gpHtmlInit($clone.get());

}

function gphtmlInitSortable(element) {
    $(element).sortable({
        handle: ".gpjs-handle",
        stop: function (event, ui) { 
            var sortableBox = ui.item.parent();
            var gpK = 0;
            $(sortableBox).find('.gpjs-sortable-input').each(function() {
                $(this).val(gpK);
                gpK++;
            })
        }
    });
    $(element).disableSelection();
}



function trashGroup(that) {
    $that = $(that);
    var countWhile = 0;
    while (!$that.hasClass('gpjs-repeatable') && countWhile < 5) {
        //console.log ($that);
        $that = $that.parent();
        countWhile++;
    }
    if ($that.hasClass('gpjs-repeatable')) {
        $that.slideUp('fast', function() {
            $(this).remove();
        }) 
    }
}