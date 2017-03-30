
function acceptNum(e) {
	
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if(tecla == 8) {
        return true;
    }
    var patron;
    //patron = /[abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUV WXYZ0123456789]/
    //patron = /\d/; //solo acepta numeros, mejor dicho, no acepta digitos (letras)
    patron = /[0-9.]/; //solo acepta numeros, puntos y comas
    var te;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function porcentaje(e,valor) {
    if(flotante(e)){
        tecla = (document.all) ? e.keyCode : e.which;
        if(tecla == 8 || e.which == 0){
            return true;
        }else{
            num = String.fromCharCode(tecla);
            if(valor + num <=100){
                return true;
            }else{
                return false
            }
        }
    }else{
        return false;
    }
}

function flotante(e,value) {
    var tecla = (document.all) ? e.keyCode : e.which;
      
    if(tecla == 46 || e.which == 0)
    {
        var patron;
        patron = /[.]/;
        
        if(patron.test(value)){
            return false;
        }else{
            return true;
        }      
    }else{
        return entero(e);
    }
}

function entero(e) {
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if(tecla == 8 || e.which == 0)
    {
        return true;
    }
    var patron;
    //patron = /[abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUV WXYZ0123456789]/
    //patron = /\d/; //solo acepta numeros, mejor dicho, no acepta digitos (letras)
    patron = /[0-9]/; //solo acepta numeros
    var te;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function acceptNumTelefono(e) {
        
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if(tecla == 8 || e.which == 0)
    {
        return true;
    }
    var patron;
    //patron = /[abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUV WXYZ0123456789]/
    //patron = /\d/; //solo acepta numeros, mejor dicho, no acepta digitos (letras)
    patron = /[0-9()-]/; //solo acepta numeros, puntos y comas
    var te;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function acceptTexto(e) {
        
    var tecla;
    tecla = (document.all) ? e.keyCode : e.which;
    if(tecla == 8 || e.which == 0)
    {
        return true;
    }
    var patron;
    patron = /[abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ]/
    //patron = /\d/; //solo acepta numeros, mejor dicho, no acepta digitos (letras)
//    patron = /[0-9()-]/; //solo acepta numeros, puntos y comas
    var te;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function formato_float(fld, milSep, decSep, e){

	//onKeyPress="return formato_float(this,'','.',event)"
	//onKeyPress="return formato_float(this,'.',',',event)"
      	var tipo=e.keyCode;
      	if (tipo == 8){  
        	return true; // 3 8,37,39,46
        }
        var sep = 0;
        var key = '';
        var i = j = 0;
        var len = len2 = 0;
        var strCheck = '0123456789';
        var aux = aux2 = '';
        var whichCode = (window.Event) ? e.which : e.keyCode;
        //if (whichCode == 13) return true; // Enter
        key = String.fromCharCode(whichCode); // Get key value from key code
        if (strCheck.indexOf(key) == -1) return false; // Not a valid key
        len = fld.value.length;
        for(i = 0; i < len; i++)
        if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break;
        aux = '';
        for(; i < len; i++)
        if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i);
        aux += key;
        len = aux.length;
        if (len == 0) fld.value = '';
        if (len == 1) fld.value = '0'+ decSep + '0' + aux;
        if (len == 2) fld.value = '0'+ decSep + aux;
        if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
        if (j == 3) {
        aux2 += milSep;
        j = 0;
        }
        aux2 += aux.charAt(i);
        j++;
        }
        fld.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        fld.value += aux2.charAt(i);
        fld.value += decSep + aux.substr(len - 2, len);
        }
        return false;
}

function formato_numeric(fld, milSep, decSep, e){
      	var tipo=e.keyCode;
      	if (tipo == 8)  
            return true; // 3 8,37,39,46
        var key = '';
        var i = j = 0;
        var len = len2 = 0;
        var strCheck = '0123456789';
        var aux = aux2 = '';
        var whichCode = (window.Event) ? e.which : e.keyCode;
        //if (whichCode == 13) return true; // Enter
        key = String.fromCharCode(whichCode); // Get key value from key code
        if (strCheck.indexOf(key) == -1) 
            return false; // Not a valid key
        len = fld.value.length;
        for(i = 0; i < len; i++)
            if ((fld.value.charAt(i) != '0')) 
                break;
        aux = '';
        for(; i < len; i++)
            if (strCheck.indexOf(fld.value.charAt(i))!=-1) 
                aux += fld.value.charAt(i);
        aux += key;
        len = aux.length;
        aux2 = '';
        for (j = 0, i = len - 1; i >= 0; i--) {
            if (j == 3) {
                aux2 += milSep;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        fld.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
            fld.value += aux2.charAt(i);
        fld.value += aux.substr(len - 0, len);
        return false;
}

function IsNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function isInt(x){
        var y = parseInt(x);
        if (isNaN(y))
                return false;
        return x == y && x.toString() == y.toString();
}

function putFormat(nStr)
{
	nStr += '';
	x = nStr.split(',');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}

function delFormat(val1){
	var val2='';
	for (i=0; i<(val1.length); i++){
		if (val1.charAt(i)!='.'){
			val2=val2+val1.charAt(i);
		}
	}
	return val2.replace(',', '.');
}


function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

function putFloatFormat(numVal, sepMil,sepDec,cantDec){
        var numStr=numVal.toFixed(cantDec).toString()
        var regExp=/\./;
        var array=new Array();        
        if (regExp.test(numStr))
            array=numStr.split('.');
        else{
            array[0]=numStr;
            array[1]='0';
        }
        regExp=/(\d+)(\d{3})/;
	while (regExp.test(array[0]))           
		array[0] = array[0].replace(regExp, '$1' + sepMil + '$2');
	return array[0]+((cantDec!=0)?sepDec+array[1]:'');
}

function porcentage(lessNum,greatNum){
    var div=lessNum/greatNum;
    var x100to=(div*100).toString();
    if ((x100to.search(/[.]/))==-1)
	return x100to;	
    else
        return parseFloat(x100to).toFixed(2);    
}

function format(input)
{
var num = input.value.replace(/\./g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
num = num.split('').reverse().join('').replace(/^[\.]/,'');
input.value = num;
}
 
else{ alert('Solo se permiten numeros');
input.value = input.value.replace(/[^\d\.]*/g,'');
}
}