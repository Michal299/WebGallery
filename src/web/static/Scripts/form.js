$(function(){
    $("#name").tooltip({
        content: "Nie podszywaj się pod innych"
    });
    $("#surname").tooltip({
        content: "Ta opcja nie jest konieczna, ale zalecana"
    });
    $("#pswd").tooltip({
        content: "Pamiętaj, żeby używać bezpiecznego hasła"
    });
    $("#e_mail").tooltip({
        content: "Nie będziemy Ci spamować, spokojnie"
    });
    $("#male").tooltip({
        content: "Jest nas większość w tym środowisku"
    });
    $("#female").tooltip({
        content: "Milo że kobiety też lubią kostki Rubika"
    });
    $("#dicelist").tooltip({
        content: "Dzięki wybraniu tutaj rodzaju będziemy mogli Ci wysyłać " +
            "ciekawe promocje, informacje o nowych modelach danego rodzaju" +
            " kostek itp... Oczywiscie nie zaśmiecimy Ci skrzynki ;)"
    });
    $('#progressbar').progressbar({
        max: 4,
        value: 0
    }).width(50+'%').height(30);
});

$(document).ready(function(){
    var Progress=[0,0,0,0];
    var add;
    var substract;
    $("#name").on('blur', function(){
        var input=$(this);
        add=false;
        substract=false;
        if(check_validate(input,1)) {
            if(Progress[0]===0){
                add=true;
                Progress[0]=1;
            }
        }
        else {
            if(Progress[0]===1){
                substract=true;
                Progress[0]=0;
            }
        }
        if(add===true) {
            var val=$('#progressbar').progressbar("value");
            $('#progressbar').progressbar("value", val+1);
        }
        if(substract===true) {
            var val=$('#progressbar').progressbar("value");
            $('#progressbar').progressbar("value", val-1);
        }

    });
    $("#surname").on('blur', function(){
        var input=$(this);
        add=false;
        substract=false;
        if(check_validate(input,1)) {
            if (Progress[1] === 0) {
                Progress[1] = 1;
                add=true;
            }
        }
        else {
            if (Progress[1] === 1) {
                Progress[1] = 0;
                substract=true;
            }
        }
        if(add===true) {
            var val=$('#progressbar').progressbar("value");
            $('#progressbar').progressbar("value", val+1);
        }
        if(substract===true) {
            var val=$('#progressbar').progressbar("value");
            $('#progressbar').progressbar("value", val-1);
        }

    });
    $("#e_mail").on('blur', function () {
        var input=$(this);
        add=false;
        substract=false;
        if(check_validate(input,2)) {
            if (Progress[2] === 0) {
                Progress[2] = 1;
                add=true;
            }
        }
        else {
            if (Progress[2] === 1) {
                Progress[2] = 0;
                substract=true;
            }
        }
        if(add===true) {
            var val=$('#progressbar').progressbar("value");
            $('#progressbar').progressbar("value", val+1);
        }
        if(substract===true) {
            var val=$('#progressbar').progressbar("value");
            $('#progressbar').progressbar("value", val-1);
        }

    });
    $("#pswd").on('blur', function () {
        var input=$(this);
        add=false;
        substract=false;
        if(check_validate(input,3)) {
            if (Progress[3] === 0) {
                Progress[3] = 1;
                add=true;
            }
        }
        else {
            if (Progress[3] === 1) {
                Progress[3] = 0;
                substract=true;
            }
        }
        if(add===true) {
            var val=$('#progressbar').progressbar("value");
            $('#progressbar').progressbar("value", val+1);
        }
        if(substract===true) {
            var val=$('#progressbar').progressbar("value");
            $('#progressbar').progressbar("value", val-1);
        }

    });
    $("#reset").on('click', function(){
      $("#progressbar").progressbar("value",0);
      $("div").removeClass("BadParent").removeClass("GoodParent");
      for(var i=0; i<Progress.length; i++) {
          Progress[i] = 0;
      }
    })
});
function check_validate(element,mode) {
    var text=element.val();
    var length=text.length;
    var validate=false;
    var find;
    var i;
    switch (mode) {
        case 1: //imie i nazwisko i tego typu rzeczy
            var znakiLacDuze=[260,262,280,321,323,346,377,379];
            //                  Ą  Ć   Ę    Ł  Ń   Ś   Ź   Ż
            if(text.charAt(0)>='A'&&text<='Z')
            {
                validate=true;
            }
            else{
                for(i=0; i<znakiLacDuze.length; i++)
                {
                    if(text.charCodeAt(0)===znakiLacDuze[i]) {
                        validate = true;
                        break;
                    }
                }
            }
            if(validate===true)
            {
                for(i=1; i<length; i++)
                {
                    find=false;
                    if(text.charAt(i)>='a'&&text.charAt(i)<='z')
                    {
                        validate=true;
                    }
                    else{
                        for(var j=0; j<znakiLacDuze.length; j++)
                        {
                            if(text.charCodeAt(i)===(znakiLacDuze[j]+1))
                            {
                                find=true;
                                validate=true;
                                break;
                            }
                        }
                        if(find===false)
                        {
                            validate=false;
                            break;
                        }
                    }

                }
            }
            break;
        case 2: //email
            if(text.charAt(0)!=='_'||text.charAt(0)!=='_'||text.charAt(0)!=='.'||text.charAt(0)!=='-')
            {
                if(text.charAt(0)<='0'||text.charAt(0)>='9')
                {
                    for(i=1; i<length; i++)
                    {
                        if(text.charAt(i)==='@')
                        {
                            validate = (length - i - 1) >= 4;
                            break;
                        }
                    }
                }
                else
                {
                    validate=false;
                }
            }
            else{
                validate=false;
            }
            break;
        case 3: //haslo
            if(length>0) validate=true;
            else validate=false;
            break;
    }

    if(validate===true)
    {
        element.closest('div').removeClass("BadParent").addClass("GoodParent");
        return true;
    }
    else
    {
        element.closest('div').removeClass("GoodParent").addClass("BadParent");
        return false;
    }
}