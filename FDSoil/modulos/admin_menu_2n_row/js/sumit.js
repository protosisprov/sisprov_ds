//------------------------VALIDA DATOS OBRA AL GUARDAR------------------------/
function valida_nivel_2(){
    var vacioI = "Debe selecionar una opcion";
    var vacio  = "Debe llenar el campo vacio";
    var enviar = true;
    
    if(!validar_campo('id_opcion','msjerrror_opci_2',vacio)) enviar=false;
    if(!validar_campo('id_ruta',  'msjerrror_rut_2', vacio)) enviar=false;
    if(!validar_campo('id_orden', 'msjerrror_orde_2',vacio)) enviar=false;
    if(!validar_combo('id_status','msjerrror_esta_2',vacioI)) enviar=false;
    
    if (enviar === true)
    {   
     send_guarda_nivel_2();
    }
    
}