//------------------------VALIDA DATOS OBRA AL GUARDAR------------------------/
function valida_nivel_1(){
    var vacioI = "Debe selecionar una opcion";
    var vacio  = "Debe llenar el campo vacio";
    var enviar = true;
    
    if(!validar_campo('id_opcion','msjerrror_opci',vacio)) enviar=false;
    if(!validar_campo('id_ruta',  'msjerrror_rut', vacio)) enviar=false;
    if(!validar_campo('id_orden', 'msjerrror_orde',vacio)) enviar=false;
    if(!validar_combo('id_status','msjerrror_esta',vacioI)) enviar=false;
    
    if (enviar === true)
    {   
     send_guarda_nivel_1();
    }
    
}