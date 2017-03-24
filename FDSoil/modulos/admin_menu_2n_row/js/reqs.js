function send_guarda_nivel_2(){ 
//    alert('../../reqs/menu_rol/menu_nivel_2_nuevo.php');
   send_ajax('POST','../../reqs/menu_rol/menu_nivel_2_nuevo.php', 'response_nivel_2', construir_nivel_2());
}
function construir_nivel_2(){
    
    var id_n1  = document.getElementById('id_n1').value;
    var id_row = document.getElementById('id_row').value; 
    var opcion = document.getElementById('id_opcion').value;
    var ruta   = document.getElementById('id_ruta').value;
    var orden  = document.getElementById('id_orden').value;
    var status = document.getElementById('id_status').value;
    
     var data = "id_n1="+id_n1+"&id_row="+id_row+"&opcion="+opcion+"&ruta="+ruta+"&orden="+orden+"&status="+status;
    //     alert(data);
     return data;
    
}
function response_nivel_2(response){
//    alert(response);
    if (response === 'C')
     {
       alert('EL REGISTRO FUÉ GUARDADO CON ÉXITO');
       window.location.href=('../admin_menu_2n_list');
       
     }
    else if (response === 'A'){
        
         alert('EL REGISTRO SE ACTUALIZÓ CON ÉXITO');
         window.location.href=('../admin_menu_2n_list');
    } 
    else if (response === 'T')
    {
         alert('ERROR. EL REGISTRO ESTÁ REPETIDO');
         window.location.reload();
    }
    else
    {
        alert('ERROR GUARDANDO REGISTRO');
        window.location.reload();
    }
}
