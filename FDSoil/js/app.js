function id_sistema(strName, strEnte, strCarp){
    encabezado(strName + ' - MPPTAA');
    titulo(strName);
    firma();
}
function titulo(strTit){
    document.getElementById('titulo').innerHTML=strTit;
}
function encabezado(strEnc){
    document.getElementById('encabezado').innerHTML=strEnc;
}

function firma(){
   document.getElementById('id_firma').innerHTML='<span style="font-weight:bold;">Ministerio del Poder Popular para Transporte y Obras P\u00FAblicas.</span>.<br>RIF. G-20010010-9 -<a href="http://www.mtt.gob.ve//" title="Página web del MPPTOP" target="_blank">P\u00E1gina Web</a> Copyleft 2016 <font style="color:#d00000;">Herramienta Desarrollada en Revoluci\u00f3n bajo Software Libre por la Oficina de Tecnolog\u00EDa de Informaci\u00f3n y Comunicaci\u00f3n (OTIC)</font>';
}

function id_acceso(strEmail,strTelefon,strWebUserRow){
    acceso_email(strEmail);
    acceso_telefon(strTelefon);
    acceso_webUserRow(strWebUserRow);
}

function acceso_email(strEmail){
    document.getElementById('id_email').innerHTML=strEmail;
}

function acceso_telefon(strTelefon){
    document.getElementById('id_telefon').innerHTML=strTelefon;
}

function acceso_webUserRow(strWebUserRow){
    document.getElementById('div_webUserRow').style.display=strWebUserRow;
}

//AGREGADO 08-06-15
function toogle(a, b, c) {
    document.getElementById(b).style.display = a;
    document.getElementById(c).style.display = a;
}

function toogle_cerrar(a, b, c) {
    document.getElementById(b).style.display = a;
    document.getElementById(c).style.display = a;
}

function paginador(cantidad,total,contenedor,funcion) {
    var paginacion = trae(contenedor);
    paginacion.innerHTML = "";
    var i;
    var pagina = 0;
    var paginas = Math.ceil(parseInt(total)/parseInt(cantidad));
    
    var ul = document.createElement("ul");
    for(i=0;i< paginas;i++) {
        var li = document.createElement("li");
        var a = document.createElement("a");
        a.href="#";
        a.innerHTML = i+1;
        pagina = i * parseInt(cantidad);
        eval('a.onclick= function(){'+funcion+'('+pagina+')}');
        li.appendChild(a);
        ul.appendChild(li);
    }
    paginacion.appendChild(ul);
}

function add_filas(row, clase, funcion, falso, limite) {
    //EL FALSO ES EL CAMPO PARA CAMBIAR LA FILA DE COLOR, DEPENDIENDO DE TRUE O FALSE
    if (!funcion) {
        funcion = "";
    }
    if (!falso) {
        falso = "";
    }
    if (!limite) {
        limite = "";
    }
    var otro = "";
    var funciones = funcion.split("#");
    var tr = document.createElement('tr');
    tr.className = '';
    tr.style.align = 'center';
    var td = new Array();
    var node = new Array();
    var texto;
    
    if ((limite=='') || (limite==0)) {
        limite = row.length;
    }

    for (var i = 0; i < row.length; i++) {
        if (clase=='td') {
            otro = otro + row[i]+ "#";
        }
        
        td[i] = document.createElement(clase);
        td[i].style.align = 'center';

        if (falso!="") {
            if (row[parseInt(falso)]=='f') {
                td[i].style.backgroundColor = '#FFE1E1';
            } else {
                td[i].style.backgroundColor = '#FFF';
            } 
        }
        
        if (row[i]=='f') {
            texto = "Inactivo";
        } else if (row[i]=='t') {
            texto = "Activo";
        } else {
            texto = row[i];
        }
        
        if (i <= limite) {
            node[i] = document.createTextNode(texto);
            td[i].appendChild(node[i]);
            tr.appendChild(td[i]);
        }
    }
    
    if (funcion!="") {
        if (clase=='td')  {
            td = document.createElement(clase);
            td.align='center';
            td.style.cursor = "pointer";
            td.style.verticalAlign = "middle";
            for (i=0; i < funciones.length;i++) {
                var imagen = document.createElement('img');
                imagen.width = "24";
                imagen.style.padding = "3px";
                imagen.tittle = otro;
                switch(i) {
                    case 0:
                        imagen.src = "../../../FDSoil/images/32x32/edit.png";
                        eval("imagen.onclick = function(){"+funciones[i]+"(this.tittle);}");
                    break;
                    case 1:
                        imagen.src = "../../../FDSoil/images/32x32/Imprimir.png";
                        eval("imagen.onclick = function(){"+funciones[i]+"(this.tittle);}");
                    break;
                    case 2:
                        imagen.src = "../../../FDSoil/images/32x32/buscar.png";
                        eval("imagen.onclick = function(){"+funciones[i]+"(this.tittle);}");
                    break;
                    default:
                        imagen.src = "../../../FDSoil/images/32x32/delete.png";
                        eval("imagen.onclick = function(){"+funciones[i]+"(this.tittle);}");
                }
                
                td.appendChild(imagen);
            }
            tr.appendChild(td);
        }
    }    
    
    return tr;
}

function trae(idobjeto){
   var objeto = document.getElementById(idobjeto);
   return objeto;
}

function textCounter(origen, contador, maxlimit) {
    var field = document.getElementById(origen);
    var countfield = document.getElementById(contador);
    
    if (field.value.length > maxlimit) {// if too long...trim it!
        field.value = field.value.substring(0, maxlimit);
    // otherwise, update 'characters left' counter
    } else { 
        countfield.value = maxlimit - field.value.length;
    };
};

function activa_ayuda(valor) {
    var contenedor = document.getElementById('ayuda');
    
    if (contenedor.style.display=='none') {
        $(contenedor).load('ayuda.html');
        setTimeout("ver_nota_informativa('ayuda',"+valor+");", 50); 
    } else {
        ocultar_nota_informativa('ayuda',valor);
    }
}

function incrusta_pagina(contenedor,pagina,parametros) {
    var contenedor = document.getElementById(contenedor);
    
    contenedor.innerHTML = '<img src="../../../FDSoil/images/principal/loading.gif" />';
    if (parametros!=0) {
        $.post(pagina, parametros, function(data) {
          $(contenedor).html(data);
        });
    } else {
        $(contenedor).load(pagina);
    }    
}

function ver_nota_informativa(campo,opcion) {
    //LAS OPCIONES SON puff, bounce, blind, explode, clip, drop, fade, fold, highlight, pulsate, scale, shake, size, slide, transfer
    $(trae(campo)).show( estilo_ui(opcion), { times:1,  distance:100, direction:'down' }, 300 ) .delay(0);
}

function ocultar_nota_informativa(campo,opcion) {
    $(trae(campo)).hide( estilo_ui(opcion), { times:1,  distance:100, direction:'down' }, 300 ) .delay(0);
}

function estilo_ui(valor) {
    var cadena = "";
    switch (valor) {
        case 1:
            cadena = "puff";
            break;
        case 2:
            cadena = "bounce";
            break;
        case 3:
            cadena = "blind";
            break;
        case 4:
            cadena = "explode";
            break;
        case 5:
            cadena = "clip";
            break;
        case 6:
            cadena = "drop";
            break;
        case 7:
            cadena = "fade";
            break;
        case 8:
            cadena = "fold";
            break;
        case 9:
            cadena = "highlight";
            break;
        case 10:
            cadena = "pulsate";
            break;
        case 11:
            cadena = "scale";
            break;
        case 12:
            cadena = "shake";
            break;
        case 13:
            cadena = "size";
            break;
        case 14:
            cadena = "slide";
            break;
        default:
            cadena = "blind";
    }
    
    return cadena;
}
//$( "#handler-puff" ).click(function() { // PUFF
//    $( "#puff" ).show( "puff", 500 ) .delay(1000) .hide( "puff", 500 );
//    $( "#puff" ).show( "bounce", { times:3, distance:100,  direction:'down' }, 2000 ).delay(2000).hide( "bounce", { times:1,  distance:100, direction:'down' }, 1000 );
//     $( "#puff" ).show( "blind", { direction:'down' }, 1000 ) .delay(2000) .hide( "blind", { direction:'down' }, 1000 );
//    $( "#puff" ).show( "explode", 500 ) .delay(2000) .hide( "explode", 500 );
//});