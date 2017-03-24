function enviar_valor_individual(id){ //alert(id);
    var arreglo = id.split('id_');
    var vacio = "Este campo se encuentra vacio";
    var enviar = true;

        if(!validar_campo('sector', 'msnj_sector', vacio)) enviar=false;
        if(!validar_campo('variable', 'msnj_variable', vacio)) enviar=false;
        if(!validar_campo('subcategoria', 'msnj_variable', vacio)) enviar=false;
        
        if (document.getElementById('valor_'+arreglo[1]).value==''){
            alert("Error! Al menos debe existir un valor en campo cantidad");
            enviar=false;
        }
        
    if(enviar===true){
        enviar=confirm('\u00BFSeguro(a) que desea guardar el valor indicado?');
    }
    if(enviar===true){
       send_actualizar_valor(arreglo[1]);
    }
}

function enviar_valores_lote(){ //alert(id);
    var estados=document.getElementById('estados').value;
    var arreglo = estados.split('¬');
    var vacio = "Este campo se encuentra vacio";
    var enviar = true;

        if(!validar_campo('sector', 'msnj_sector', vacio)) enviar=false;
        if(!validar_campo('variable', 'msnj_variable', vacio)) enviar=false;
        if(!validar_campo('subcategoria', 'msnj_variable', vacio)) enviar=false;

        for (var i = 0; i < arreglo.length; i++) {
            var arreglo2 = arreglo[i].split('#');
            if (document.getElementById('valor_'+arreglo2[1]).value==''){
            alert("Error! Al menos debe existir un valor en campo cantidad");
            enviar=false;
                if (enviar==false){
                    document.getElementById('valor_'+arreglo2[1]).focus();
                    break;
                }
            }
        }
        
        
    if(enviar===true){
        enviar=confirm('\u00BFSeguro(a) que desea guardar el valor indicado?');
    }
    if(enviar===true){
       send_actualizar_valor_lote();
    }
}