function inicio(strArrayMenu) {
    var obj=new app();
    id_sistema(obj.name);
    menu(strArrayMenu);
    
    send_buscar_usuario_busqueda();
    if (document.getElementById('ex_usuariod').value===''){
       document.getElementById('muestra_usu_d').style.display='none';
       document.getElementById('mensaje_desactivados').innerHTML='No existen usuarios Desactivados';
       document.getElementById('table_desactivados').innerHTML='';
    }
}

function mostra_div(cadena,cadena1){
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
function reiniciar_formulario(cadena){
    var arreglo = cadena.split('#');
        var i;
        for (i = 0; i < arreglo.length; i++) {
           var campos = arreglo[i].split('#');
           document.getElementById(campos).value='';
       }
}

function nameusuario(){
    var nombre  = document.getElementById('nombre').value;
    var apelli  = document.getElementById('apellido').value;

    var porname = nombre.substring(0, 1); // porcion = "a"
    var porapel = apelli.substring(0, 9); // porcion = "a"
    
    var ver_usuario = porname + porapel;
    
    document.getElementById('usuario_asig').value = ver_usuario;
    
}

function cambio_vista($valor){
    if ($valor=='1'){
        document.getElementById('cac').className="active";
        document.getElementById('cic').className="disabled";
        document.getElementById('muestra_usu_d').style.display="block";
        document.getElementById('muestra_usu_act').style.display="none";
    }else{
        document.getElementById('cic').className="active";
        document.getElementById('cac').className="disabled";
        document.getElementById('muestra_usu_act').style.display="block";
        document.getElementById('muestra_usu_d').style.display="none";
    }
}

function cargar_ente(a,b,c,d){
    document.getElementById(a).style.display='none';
    document.getElementById(b).style.display='block';
    //imagenes
    document.getElementById(c).style.display='none';
    document.getElementById(d).style.display='block';
    
}

function accion_usuario_ente($accion,$id){
   var enviar = true;
   var mensaje;
    switch ($accion){
        case 1:
            mensaje="\u00BFSeguro(a) que desea desactivar el usuario seleccionado?";
            break;
        case 2:
            mensaje="\u00BFSeguro(a) que desea resetear la contraseña del usuario seleccionado?";
            break;
        case 3:
            mensaje="\u00BFSeguro(a) que desea reactivar el usuario seleccionado?";
            break;
    }
   
    if(enviar===true){
        enviar=confirm(mensaje);
    }
    if(enviar===true){
        send_acciones_usuario($accion,$id);
    }
}


//LISTAR LOS USUARIOS ACTIVOS
function title_usuarios_act(id_tabla) {
    var arreglo = new Array();
        arreglo[0] = 'Nro';
        arreglo[1] = 'Nombre y Apellido';
        arreglo[2] = 'Nro.Cédula';
        arreglo[3] = 'Usuario';
        arreglo[4] = 'Correo';
        arreglo[5] = 'Num. de télefono';
        arreglo[6] = 'Ente u Organismo';
        arreglo[7] = 'Acción';
        
    var tabla = document.getElementById(id_tabla);
//    tabla.appendChild(addRowDatos(arreglo, 'th'));
        tabla.innerHTML = "";
        tabla.appendChild(addRowDatos(arreglo, 'th',''));
}

function llenar_usuarios_act(tabla, response) {  
    var tabla = document.getElementById(tabla);
    var arreglo = response.split('¬');
    var i;
    var campos;
//    document.getElementById('cantidad_empleados').innerHTML='Cantidad de personal: '+arreglo.length;
    for (i = 0; i < arreglo.length; i++) {
        campos= arreglo[i].split('#');
        campos.unshift(i+1); 
        tabla.appendChild(addRowDatos(campos, 'td',campos[5]));
    }
    return;
}

function addRowDatos(row, clase) {
    var tr = document.createElement('tr');
    tr.className = '';
    tr.style.align = 'center';
    var td = new Array();
    var node = new Array();
    var y;
    if (clase=="th") {
        y = row.length;
    } else {
        y = row.length-2;
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
            switch (i){
                case 0:
                    td[i].align ='center';
                break;
                case 3:
                    td[i].align ='center';
                break;
                case 5:
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
      if (clase=='td')  {
                td = document.createElement(clase);
                var imagen = document.createElement('img');
                imagen.src = "../../../FDSoil/images/16x16/edit.png";
                imagen.tittle = "Continuar con registro de cuestionario";
                td.id = row[7];
                td.title = row[7];
                td.align ='center';
                td.style.cursor = "pointer";
                td.style.verticalAlign = "middle";
//                eval("td.onclick = function(){imprimir_planilla_consulta(this.id);}");
                eval("td.onclick = function(){mostra_div('modificar_usu_d#atras_u','muestra_usu_act#menu_corto#nuevo_u#buscar_u#muestra_usuario');send_buscar_usuario(this.id);}");
        //        .onClick = "alert('1')";
                td.appendChild(imagen);
                tr.appendChild(td);
                
                td = document.createElement(clase);
                var imagen = document.createElement('img');
                imagen.src = "../../../FDSoil/images/16x16/delete_2.png";
                imagen.tittle = "Desactivar usuario";
                td.id = row[7];
                td.title = row[7];
                td.align ='center';
                td.style.cursor = "pointer";
                td.style.verticalAlign = "middle";
                eval("td.onclick = function(){accion_usuario_ente(1, this.id)}");
                td.appendChild(imagen);
                tr.appendChild(td);
                
                td = document.createElement(clase);
                var imagen = document.createElement('img');
                imagen.src = "../../../FDSoil/images/24x24/open.png";
                imagen.tittle = "Resetear contraseña";
                td.id = row[7];
                td.title = row[7];
                td.align ='center';
                td.style.cursor = "pointer";
                td.style.verticalAlign = "middle";
                eval("td.onclick = function(){accion_usuario_ente(2, this.id)}");
                td.appendChild(imagen);
                tr.appendChild(td);
                
                td = document.createElement(clase);
                var imagen = document.createElement('img');
                imagen.src = "../../../FDSoil/images/24x24/open.png";
                imagen.tittle = "Resetear contraseña";
                td.id = row[7];
                td.title = row[7];
                td.align ='center';
                td.style.cursor = "pointer";
                td.style.verticalAlign = "middle";
                eval("td.onclick = function(){accion_usuario_ente(2, this.id)}");
                td.appendChild(imagen);
                tr.appendChild(td);
            }    
    return tr;
}