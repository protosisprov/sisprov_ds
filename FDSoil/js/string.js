function firstUpperOtherLower(cadena){
   var resp='';
   var arreglo=cadena.split(' ');
   for(var i in arreglo){
       resp+=firstUpperOtherLowerAux(arreglo[i])+' ';
   }
   
   return resp.substring(0,resp.length-1);
}

function firstUpperOtherLowerAux(cadena){
    var firstUpper=cadena.substring(0,1).toUpperCase();
    var otherLower=cadena.substring(1,cadena.length).toLowerCase();
    return firstUpper+otherLower;
}

