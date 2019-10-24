
/**
 * Per i gruppi che si ripetono la funzione che clona il gruppo
* @param {} that
 */
function gpCloneGroup(that) {
    var idClone = $(that).data('clone');
    var box = $(that).data('box');
    var maxCount = 0;
    $(box).find('.gpjs-repeatable').each(function () {
        var d = $(this).data('repgroup').split(".");
        count = d.pop();
        maxCount = Math.max(maxCount, count);
    })
    maxCount++;
    dataRepGroup = $(that).data('name').split(".");
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
    
    $clone.find('*').each(function () {
        allData = $(this).data();
        for (dx in allData) {
           // console.log("DATA" + allData[dx]);
            if (allData[dx].substring(0, 1) == "#") {
                console.log("NEW DATA (" + dx + ")" + "#gp" + maxCount + allData[dx].substring(1))
                $(this).data(dx, "#gp" + maxCount + allData[dx].substring(1));
            }
        }

        if ($(this).prop('name')) {
            var oldName = $(this).attr('name');
            if (oldName.indexOf('[]') > -1) {
                oldName2 = oldName.replace("[]", "");
                $(this).prop('name', newDataRepGroup + "[" + oldName2 + "][]");
            } else {
                $(this).prop('name', newDataRepGroup + "[" + $(this).attr('name') + "]");
            }
        }
        if ($(this).prop('id')) {
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
    
    $(idClone).before($clone);
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
    gpHtmlInit($clone.get());

}
