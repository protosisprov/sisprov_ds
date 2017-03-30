//------- ----- REGISTRO DE VARIABLES -------- ---------

//GUARDAR LOS VALORES POR ESTADO
function enviar_archivo(id){
   //alert('../../reqs/guarda/guardar_valores_subcategoria.php');
   send_ajax('POST','prueba.php', 'response_guardar_valores', '');
}


function response_guardar_valores(response){
//    alert(response);
    document.getElementById('mensaje').style.display='block';
    var mensaje='';
    if (response=== 'C'){
        mensaje='Variable registrada exitosamente!';
    }else{
        mensaje='Existe un problema no fue registrado los valores.';
    }
    alert(mensaje);
    
    //window.location.reload();
}
