function enviar_datos(){
    var vacio = "Debe completar el campo vacio";
    var enviar = true;
    if(!validar_campo('nombre_unidad', 'msnj_unidad', vacio)) enviar=false;
    
    if (enviar === true)
    { 
        send_unidad();
    }
}

