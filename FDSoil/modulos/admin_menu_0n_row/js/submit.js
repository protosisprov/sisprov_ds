//------------------------VALIDA DATOS OBRA AL GUARDAR------------------------/
function valida_nivel_0(){/*DATOS EMPRESAS*/
    var vacioI = "Debe selecionar una opcion";
    var vacio  = "Debe llenar el campo vacio";
    var enviar = true;
    
    if(!validar_campo('id_opcion','msjErroresOP',vacio)) enviar=false;
    if(!validar_campo('id_ruta',  'msjErroresRT',vacio)) enviar=false;
    if(!validar_campo('id_orden', 'msjErroresOR',vacio)) enviar=false;
    if(!validar_combo('id_status','msjErroresES',vacioI)) enviar=false;
    if (enviar === true)
    {   
     send_guarda_nivel_0();
    }
    
}