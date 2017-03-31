var estados_data = {
    'path2' : 'Amazonas',
    'path1' : 'Anzoátegui',
    'path3' : 'Apure',
    'path4' : 'Aragua',
    'path5' : 'Barinas',
    'path16' : 'Bolívar',
    'path17' : 'Carabobo',
    'path18' : 'Cojedes',
    'path19' : 'Delta Amacuro',
    'path6' : 'Distrito Capital',
    'path7' : 'Falcón',
    'path8' : 'Guárico',
    'path9' : 'Lara',
    'path10' : 'Mérida',
    'path11' : 'Miranda',
    'path20' : 'Monagas',
    'path21' : 'Nueva Esparta',
    'path12' : 'Portuguesa',
    'path22' : 'Sucre',
    'path13' : 'Táchira',
    'path14' : 'Trujillo',
    'path15' : 'Vargas',
    'path23' : 'Yaracuy',
    'path24' : 'Zulia',
    'path26' : 'Dependencias Federales'
};

function inicio(strArrayMenu) {
    var obj=new app();
    id_sistema(obj.name);
}

$(function() {
    var default_attributes = {
//         fill: '#f2ded7',
        fill: '#d5cdcd',
//         fill: '#f3cbcb',
         stroke: '#000000',
         'stroke-width': 1,
     };  
   var $munictxt = $('#div_estado');
   var $id_estado = $('#id_estado_path');
   var $nombre_estado = $('#nombre_estado');
//   send_mostar_variables_inicio(3);                           
   $.ajax({
     url: '../../img/mapa_venezuela.svg',
        type: 'GET',
        dataType: 'xml',
        success: function(xml) {
          var rjs = Raphael('lienzo', 700, 700);
          var corr="";
          $(xml).find('svg > g > g > path').each(function() {
            var path = $(this).attr('d');
            var pid = $(this).attr('id');
            var munic = rjs.path(path);

            munic.attr(default_attributes);

            munic.hover(function() {
              if (document.getElementById('nombre_estado').value!=''){
                var pathGatoGNU = rjs.path('m 234.02458,396.16011 c ...-3.20489 z');
pathGatoGNU.attr({fill: '#000000',stroke: '#3C0600','stroke-width': 1});
                var text = "Estado: ";
                if (typeof(estados_data[pid])!=='undefined'){
                  this.animate({ fill: '#cc4343' }); 
                  text+= "<b>"+estados_data[pid]+"<br />";
                }else{
                    text+="Zona en Reclamación";
                }
              }
//                       text+="("+$(this).attr('id')+")";
              $munictxt.html(text);
              $id_estado.val(pid);
              $nombre_estado.val(estados_data[pid]);
            }, function() {
              this.animate({ fill: default_attributes.fill });
              $munictxt.html("Seleccione un Estado");
            }). click(function() {
                    //alert("Click sobre un Estado. ID = "+pid);
//                    send_mostar_aeropuertos();
//                    send_mostar_puertos();
//                    var variable=document.getElementById('variables_3').value;
//                    title_table_dinamicas('table_variables_3',variable);
                    mostra_div('mostrar_info','mostrar_mapa');
                    mostrar_nombre_estado();
                    vistas('d3','d2','datos_d3','datos_d2');
                    send_mostar_desarrollo();                   
            });
            });
                  }
    });
});

function cargar_sector(sector){
//    alert("Dentro del cargar"+sector);
    var variable=document.getElementById('variables_'+sector).value;
    title_table_dinamicas('table_variables_'+sector,variable);
}

function mostrar_nombre_estado() {
    var i2 = document.getElementById('detalle_est');
    var estado = document.getElementById('nombre_estado').value;
    i2.innerHTML = "<i>Estado: </i> <b>"+(estado)+"</b>";
}


function inicio_v(sector){ //alert(sector);
//    send_mostar_variables(sector);
var activo=document.getElementById('activo_'+sector).value;
if (activo=="false"){
var variable = document.getElementById('variables_'+sector).value;
var campos= variable.split('¬');

    for (var i = 0; i < campos.length; i++) {
        document.getElementById('sector_table').value=campos[i]; 
//        alert(campos[i]);
        if (campos[i]=='PROVEEDURIAS (INVENTARIO)'){
            buscar_inventario_proveeduria(sector,campos[i]);
        }else{
            buscar_datos(sector,campos[i]);
        }
       
    }
//    ultima_actualizacion(sector); 
}

}

function ultima_actualizacion(){
    var estado = document.getElementById('nombre_estado').value;
    var sector = document.getElementById('id_sector').value;
    $.get('block/busqueda.php?estado='+estado+'&consulta=5'+'&sector='+sector, function(data) {
        document.getElementById('fecha_a').innerHTML="<i>Última Actualización:</i> "+data;
    });
}


function armar_datos(sector){
    var variable=document.getElementById('variables_'+sector).value;
    title_table_dinamicas('table_variables_'+sector,variable);
}

function buscar_datos(sector,valor){ //alert("Dentro: "+sector+"----"+valor+"---");
    if (document.getElementById('nombre_estado').value!=''){
        var estado = document.getElementById('nombre_estado').value;
        document.getElementById('sector_table').value=valor;
        window.setTimeout(send_mostar_datos(estado,sector,valor),500);
    }
}


function title_table_dinamicas(id_div, titulo) { //***** Verificada *****
    var i;
    var id_div = document.getElementById(id_div);
    id_div.innerHTML = "";
    var campos = titulo.split('¬');
    for (i=0;i<campos.length;i++) {// alert(campos[i]);
        var div = document.createElement('div');
        var node = document.createTextNode(campos[i]);
        var table = document.createElement('table');
        table.className='table table-bordered';
        table.style='width:95%';
        div.align ='center';
        div.style.fontSize = '12px';
        div.style.background = '#ffff';
        div.style.fontWeight = 'bold';
        div.style.width = "33%";
        div.style.float = "left";
        div.appendChild(node);

        table.id=campos[i];
        table.name=campos[i];
        div.appendChild(table);
        
        if (campos[i]=='PROVEEDURIAS (INVENTARIO)'){
            var btn = document.createElement('button');
            btn.id = "bnt_"+campos[i];
            btn.className = "btn btn-info";
            eval("btn.onclick = function(){mostrar_inventario();}");
            var t = document.createTextNode("Visualizar detalle de Inventario");
            btn.appendChild(t);
            document.body.appendChild(btn);
            div.appendChild(btn);
        }
        id_div.appendChild(div);
    }
}

function title_table_dinamicas_inventario(titulo){
    //table_variables_3-----COBERTURA NACIONAL¬FINANCIAMIENTO¬OBRAS¬PENSIONADOS¬PROVEEDURIAS (INVENTARIO)¬REGISTRO NACIONAL
    var i;
    var id_div = document.getElementById("table_variables_4");
    id_div.innerHTML = "";
    var campos = titulo.split('¬');
    for (i=0;i<campos.length;i++) {// alert(campos[i]);
          var campos2 = campos[i].split('#');
        var div = document.createElement('div');
        var node = document.createTextNode(campos2[1]);
        var table = document.createElement('table');
        table.className='table table-bordered';
        table.style='width:95%';
        div.align ='center';
        div.style.fontSize = '12px';
        div.style.background = '#ffff';
        div.style.fontWeight = 'bold';
        div.style.width = "33%";
        div.style.float = "left";
        div.appendChild(node);
        table.id=campos2[1];
        table.name=campos2[1];
        div.appendChild(table);
        id_div.appendChild(div);
    }
}

function mostra_div(cadena,cadena1){//alert(cadena);
//    Mostrar
    if (cadena!==""){
        var arreglo = cadena.split('#');
        var i;
        for (i = 0; i < arreglo.length; i++) {
           var campos = arreglo[i].split('#');
           document.getElementById(campos).style.display='block';
        }
    }
//    Ocultar
    if (cadena1!==""){
        var arreglo = cadena1.split('#');
        var i;
        for (i = 0; i < arreglo.length; i++) {
           var campos = arreglo[i].split('#');
           document.getElementById(campos).style.display='none';
        }
    }
}

function vistas(activo,desactivo,mostar,ocultar){ //alert(desactivo); 
    document.getElementById(activo).className="active";
    //    DISABLED
    if (desactivo!==""){
        var arreglo = desactivo.split('#');
        var i;
        for (i = 0; i < arreglo.length; i++) {
           var campos = arreglo[i].split('#');
           document.getElementById(campos).className='disabled';
        }
    }
    document.getElementById(mostar).style.display='block';
//    Ocultar
    if (ocultar!==""){
        var arreglo = ocultar.split('#');
        var i;
        for (i = 0; i < arreglo.length; i++) {
           var campos = arreglo[i].split('#');
           document.getElementById(campos).style.display='none';
        }
    }
}


//******************************************************************************

//LISTAR DATOS BASICOS DE LAS TABLAS
function title_table(id_tabla, titulo) { //***** Verificada *****
    var tabla = document.getElementById(id_tabla);
    tabla.innerHTML = "";
//    alert(titulo);
    var campos = titulo.split('#');
    tabla.appendChild(add_filas(campos, 'th','','',''));
}

function llenar_variable(tabla, response) {   //***** Verificada *****
    //alert(tabla);
    var tabla = document.getElementById(tabla);
    var arreglo = response.split('¬');
    var i;
    var campos;
//    document.getElementById('cantidad_empleados').innerHTML='Cantidad de personal: '+arreglo.length;
    for (i = 0; i < arreglo.length; i++) {
        campos= arreglo[i].split('#');
        campos.unshift(i+1); 
        tabla.appendChild(addRowDatos(campos, 'td',tabla));
    }
    return;
}

function llenar_variable_sin_conteo(tabla, response) {   //***** Verificada *****
    //alert(tabla);
    var tabla = document.getElementById(tabla);
    var arreglo = response.split('¬');
    var i;
    var campos;
//    document.getElementById('cantidad_empleados').innerHTML='Cantidad de personal: '+arreglo.length;
    for (i = 0; i < arreglo.length; i++) {
        campos= arreglo[i].split('#');
        tabla.appendChild(addRowDatos(campos, 'td',tabla));
    }
    return;
}


function addRowDatos(row, clase,tabla) {
    var tabla = document.getElementById(tabla);
    var tr = document.createElement('tr');
    tr.className = '';
    tr.style.align = 'center';
    var td = new Array();
    var node = new Array();
    var y;
    if (clase=="th") {
        y = row.length;
    } else {
        y = row.length;
    }    
    
    for (var i = 0; i < y; i++) {
        td[i] = document.createElement(clase);
        if (clase=='th') {
            td[i].align ='center';
            td[i].style.fontSize = '14px';
            td[i].style.background = 'lightgray';
            if (i==7){ 
                td[i].colSpan = '3';
            }
            node[i] = document.createTextNode(row[i]);
            td[i].appendChild(node[i]);
            tr.appendChild(td[i]);
        } else {
            switch (tabla){
                case 'desarrollo_p':
                    td[i].align ='center';
                break;
                default :
                    td[i].align ='left';
                    break;
            }

            td[i].style.fontSize = '13px';
            
            node[i] = document.createTextNode(row[i]);
            td[i].appendChild(node[i]);
            tr.appendChild(td[i]);
        };
    }   
    return tr;
}

function llenar_variable_basico(tabla, response) {   //***** Verificada *****
     var tabla = document.getElementById(tabla);
    var arreglo = response.split('¬');
    var i;
    for (i = 0; i < arreglo.length; i++) {
       var campos = arreglo[i].split('#'); 
       tabla.appendChild(addRowDatos_basicos(campos, 'td'));
       //tabla.appendChild(add_filas(campos, 'td','','1','2'));
    }
    return;
}

function llenar_variable_proveeduria(tabla, response) {   //***** Verificada *****
     var tabla = document.getElementById(tabla);
    var arreglo = response.split('¬');
    var i;
    for (i = 0; i < arreglo.length; i++) {
       var campos = arreglo[i].split('#'); 
       tabla.appendChild(addRowDatos_proveeduria(campos, 'td'));
       //tabla.appendChild(add_filas(campos, 'td','','1','2'));
    }
    return;
}

function addRowDatos_basicos(row, clase) {//***** Verificada *****
    var tr = document.createElement('tr');
    tr.className = '';
    tr.style.align = 'center';
    var td = new Array();
    var node = new Array();
    var y;
    if (clase=="th") {
        y = row.length;
    } else {
        y = row.length;
    }    
    
    for (var i = 1; i < y; i++) {
        td[i] = document.createElement(clase);
        if (clase=='th') {
            td[i].align ='center';
            td[i].style.fontSize = '14px';
            td[i].style.background = 'lightgray';
           
            node[i] = document.createTextNode(row[i]);
            td[i].appendChild(node[i]);
            tr.appendChild(td[i]);
        } else {
            td[i].style.fontSize = '13px';
             if (i==2){ 
                td[i].align ='right';
            }
            node[i] = document.createTextNode(row[i]);
            td[i].appendChild(node[i]);
            tr.appendChild(td[i]);
        };
    }   
    return tr;
}

function addRowDatos_proveeduria(row, clase) {//***** Verificada *****
    var tr = document.createElement('tr');
    tr.className = '';
    tr.style.align = 'center';
    var td = new Array();
    var node = new Array();
    var y;
    if (clase=="th") {
        y = row.length;
    } else {
        y = row.length;
    }    
    
    for (var i = 0; i < y; i++) {
        td[i] = document.createElement(clase);
        if (clase=='th') {
            td[i].align ='center';
            td[i].style.fontSize = '14px';
            td[i].style.background = 'lightgray';
           
            node[i] = document.createTextNode(row[i]);
            td[i].appendChild(node[i]);
            tr.appendChild(td[i]);
        } else {
            td[i].style.fontSize = '13px';
             if (i==1){ 
                td[i].align ='right';
            }
            node[i] = document.createTextNode(row[i]);
            td[i].appendChild(node[i]);
            tr.appendChild(td[i]);
        };
    }   
    return tr;
}

function abrir_archivo(){

   var nombre_estado=document.getElementById('id_estado_path').value;
   var direccion='../../modulos/archivos/subidas/'+sector+"-"+nombre_estado+'.pdf';
   var url=existeUrl(direccion);
   
}

function existeUrl(url) {
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
}