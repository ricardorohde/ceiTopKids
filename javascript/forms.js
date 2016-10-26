function limpaCaracteresNaoNumericos(f) {
    var s = "";
    for (var i = 0; i < f.value.length; i++) {
        var c = f.value.charAt(i);
        if (c >= '0' && c <= '9')
            s = s + c;
    }
    f.value = s;
    return true;
}

function getName(o) {
    var s = o.name;
    if (o.caption)
        s = o.caption;
    return s;
}

function campoObrigatorio(f) {
    if (f.value == "") {
        alert("O campo \"" + getName(f) + "\" deve ser preenchido.");
        f.focus();
        return false;
    } else
        return true;
}

function campoEmail(c) {

    ok = verificaEmail(c);
    if (!ok) {
        alert("\"" + c.value + "\" n�o � um endere�o de e-mail v�lido. Exemplo de e-mail v�lido: \"usuario@dominio.com\"");
        c.focus();
        return false;
    }
    else
        return true;
}

function campoData(f) {
    ok = verificaData(f);
    if (!ok) {
        alert("O campo \"" + getName(f) + "\" deve estar no formato: dd/mm/aaaa. Ex.: 31/01/2000");
        f.focus();
    }
    return ok;
}

function campoHora(f) {
    ok = verificaHora(f);
    if (!ok)
    {
        alert("O campo \"" + getName(f) + "\" deve estar no formato: hh:mm. Ex.: 13:45");
        f.focus();
    }
    return ok;
}

function campoDataHora(f) {
    ok = true;
    tval = f.value;
    if (tval == "")
        return true;
    i = tval.indexOf(" ");
    if (i < 0)
        ok = false;
    if (ok) {
        t1 = tval.substring(0, i);
        t2 = tval.substring(i + 1);
        f.value = t1;
        ok = verificaData(f);
        t1b = f.value;
    }
    if (ok) {
        f.value = t2;
        ok = verificaHora(f);
        t2b = f.value;
    }
    if (ok)
        f.value = t1b + " " + t2b;
    else {
        f.value = tval;
        alert("O campo \"" + getName(f) + "\" deve estar no formato: dd/mm/aaaa hh:mm. Ex.: 31/01/2000 13:45");
        f.focus();
    }
    return ok;
}


function verificaEmail(c) {
    var indexDot;
    var indexAt

    if (c.value != "") {
        indexAt = c.value.indexOf("@");
        if ((indexAt <= 0) || (indexAt >= c.value.length - 1))
            return false;

        indexDot = c.value.indexOf(".");
        if ((indexDot <= 0) || (indexDot >= c.value.length - 1)) {
            return false;
        }
        return true;
    }
    else {
        return true;
    }
}

function verificaData(f) {
    if (f.value != "") {
        salva = f.value;
        t = f.value;
        if (t.charAt(1) == "/")
            t = '0' + t;
        if (t.charAt(4) == "/")
            t = t.substring(0, 3) + '0' + t.substring(3);
        f.value = t;
        limpaCaracteresNaoNumericos(f);
        ok = true;
        //parseFloat funciona melhor que parseInt
        if (f.value.length < 8)
            ok = false;
        else if (parseFloat(f.value.substring(0, 2)) > 31 || parseFloat(f.value.substring(0, 2)) <= 0)
            ok = false;
        else if (parseFloat(f.value.substring(2, 4)) > 12 || parseFloat(f.value.substring(2, 4)) <= 0)
            ok = false;
        else if (parseFloat(f.value.substring(4)) < 1850 || parseFloat(f.value.substring(4)) > 2100)
            ok = false;

        if (ok) {
            t = f.value;
            f.value = t.substring(0, 2) + "/" + t.substring(2, 4) + "/" + t.substring(4);
        } else {
            f.value = salva;
        }
        return ok
    } else
        return true;
}


function verificaHora(f) {
    if (f.value != "") {
        salva = f.value;
        t = f.value;
        if (t.charAt(1) == ":")
            t = '0' + t;
        if (t.charAt(2) == ":" && t.length == 4)
            t = t.substring(0, 3) + '0' + t.substring(3);
        f.value = t;
        limpaCaracteresNaoNumericos(f);
        ok = true;
        //parseFloat funciona melhor que parseInt
        if (f.value.length < 4)
            ok = false;
        else if (parseFloat(f.value.substring(0, 2)) > 24 || parseFloat(f.value.substring(0, 2)) < 0)
            ok = false;
        else if (parseFloat(f.value.substring(2, 4)) > 59 || parseFloat(f.value.substring(2, 4)) < 0)
            ok = false;

        if (ok) {
            t = f.value;
            f.value = t.substring(0, 2) + ":" + t.substring(2);
        } else {
            f.value = salva;
        }
        return ok
    } else
        return true;
}


function minLength(f) {
    if (f.value != "") {
        if (f.value.length < f.minlength) {
            alert("O campo \"" + getName(f) + "\" deve conter pelo menos "
                + f.minlength + " caracteres.");
            f.focus();
            return false;
        } else
            return true;
    } else
        return true;
}

function maxLength(f) {
    if (f.value != "") {
        if (f.value.length > f.maxlength) {
            alert("O campo \"" + getName(f) + "\" n�o deve conter mais de "
                + f.maxlength + " caracteres.");
            f.focus();
            return false;
        } else
            return true;
    } else
        return true;
}

function ectLength(f) {
    if (f.value != "") {
        if (f.value.length != f.ectlength) {
            alert("O campo \"" + getName(f) + "\" deve conter "
                + f.ectlength + " caracteres.");
            f.focus();
            return false;
        } else
            return true;
    } else
        return true;
}


var nomeCampo;
function campoSelecionado(v) {
    nomeCampo = v.srcElement.id;

//document.getElementById(nomeCampo).style.border = '2px solid #BDC3C7';
}

function colorBorder(v) {
    var tecla = window.event.keyCode;
    if (tecla != 9) {
        if (v != "") {
            document.getElementById(nomeCampo).style.border = '2px solid #BDC3C7';
        } else {
            document.getElementById(nomeCampo).style.border = '2px solid #FF0000';
        }
    }


}



function valida(f) {

    var ok = true;
    for (var i = 0; i < f.elements.length; i++) {

        var c = f.elements[i];

        if (c.type == "text" || c.type == "select-one" ||
            c.type == "select" || c.type == "password" ||
            c.type == "textarea" || c.type == "file" ||
            c.type == "radio") {

            document.getElementById(getName(c)).style.border = '2px solid #BDC3C7';
 

            if (c.value === "") {
                if(getName(c) == "arquivo"){
                    
                }else if(getName(c) == "email"){
                    
                }else if(getName(c) == "obs"){
                    
                }else if(getName(c) == "vaga_garagem"){
                    
                }else if(getName(c) == "fone_fixo"){
                    
				}else if(getName(c) == "fone_emergencia"){
                    
                }else if(getName(c) == "myfile"){
                    
                }else{
                    document.getElementById(getName(c)).style.border = '2px solid #FF0000';

                    ok = false;
                }
               
                    

            }

        }
    }
    
    var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

    if (ok == false) {
        alert("Preencha os campos obrigatorios");
    }
    
    

    if (document.getElementById("email").value != "") {
        if (!filter.test(document.getElementById("email").value)) {
            alert('Por favor, digite o email corretamente');
            document.getElementById("email").focus();
            document.getElementById("email").style.border = '2px solid #FF0000';
            ok = false;
        }
    }

    return ok;
}

function validaVisitante(f) {

    var ok = true;
    for (var i = 0; i < f.elements.length; i++) {

        var c = f.elements[i];

        if (c.type == "text" || c.type == "select-one" ||
            c.type == "select" || c.type == "password" ||
            c.type == "textarea" || c.type == "file" ||
            c.type == "radio") {

            document.getElementById(getName(c)).style.border = '2px solid #BDC3C7';
 

            if (c.value === "") {
                if(getName(c) == "arquivo"){
                    
                }else if(getName(c) == "obs"){
                       
                }else if(getName(c) == "myfile"){
                    
                }else if(getName(c) == "fone_contato"){
                    
                }else{
                    document.getElementById(getName(c)).style.border = '2px solid #FF0000';

                    ok = false;
                }
               
                    

            }

        }
    }
    
    var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

    if (ok == false) {
        alert("Preencha os campos obrigatorios");
    }
    
    

   

    return ok;
}

function Limpar(f) {
    for (var i = 0; i < f.elements.length; i++) {
        var c = f.elements[i];
        if (c.type == "text" || c.type == "select-one" ||
            c.type == "select" || c.type == "password" || c.type == "textarea") {
            if (c.type == "select-one" || c.type == "select" || c.type == "radio" || c.type == "checkbox")
                c.options[0].selected = true;
            else
                c.value = "";
        }
    }
}


/////////////////////////////////// campo s� para numeros  ///////////////////////////////////////////
function blockNumbers(e)
{
    var key;
    var keychar;
    var reg;

    if (window.event) {
        // for IE, e.keyCode or window.event.keyCode can be used
        key = e.keyCode;
    }
    else if (e.which) {
        // netscape
        key = e.which;
    }
    else {
        // no event, so pass through
        return true;
    }

    keychar = String.fromCharCode(key);
    reg = /\d/;
    // return !reg.test(keychar); ===> para tirar n�meros � necess�rio tirar o exclama��o (!)
    return reg.test(keychar);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////// MASCARA PARA CEP (s� aceita numeros)  /////////////////////////////
function MM_formtCep(e, src, mask) {
    if (window.event) {
        _TXT = e.keyCode;
    }
    else if (e.which) {
        _TXT = e.which;
    }
    if (_TXT > 47 && _TXT < 58) {
        var i = src.value.length;
        var saida = mask.substring(0, 1);
        var texto = mask.substring(i)
        if (texto.substring(0, 1) != saida) {
            src.value += texto.substring(0, 1);
        }
        return true;
    } else {
        if (_TXT != 8) {
            return false;
        }
        else {
            return true;
        }
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* Máscaras ER */
function mascaraFone(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}
function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}
function mtel(v) {
    v = v.replace(/\D/g, "");             //Remove tudo o que não é dígito
    v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v = v.replace(/(\d)(\d{3})$/, "$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}


function MM_formtCep(e, src, mask) {
    if (window.event) {
        _TXT = e.keyCode;
    }
    else if (e.which) {
        _TXT = e.which;
    }
    if (_TXT > 47 && _TXT < 58) {
        var i = src.value.length;
        var saida = mask.substring(0, 1);
        var texto = mask.substring(i)
        if (texto.substring(0, 1) != saida) {
            src.value += texto.substring(0, 1);
        }
        return true;
    } else {
        if (_TXT != 8) {
            return false;
        }
        else {
            return true;
        }
    }
}

////////////////////////////////////////  MASCARA TELEFONE  ////////////////////////////////////////////
function MascaraTelefone(objeto) {
    if (objeto.value.length == 0)
        objeto.value = '(' + objeto.value;
    if (objeto.value.length == 3)
        objeto.value = objeto.value + ')';
    if (objeto.value.length == 8)
        objeto.value = objeto.value + '-';
}

function mascara(o, f) {

    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}

function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}


function soLetras(v) {
    return v.replace(/\d/g, "") //Remove tudo o que n�o � Letra   
}

function soLetrasMA(v) {
    v = v.toUpperCase() //Mai�sculas   
    return v.replace(/\d/g, "") //Remove tudo o que n�o � Letra ->maiusculas   
}

function soLetrasMI(v) {
    v = v.toLowerCase() //Minusculas   
    return v.replace(/\d/g, "") //Remove tudo o que n�o � Letra ->minusculas   
}

function soNumeros(v) {
    return v.replace(/\D/g, "") //Remove tudo o que n�o � d�gito   
}
///////////////////////////////////////////////////////////////////////////////////////////////////////



