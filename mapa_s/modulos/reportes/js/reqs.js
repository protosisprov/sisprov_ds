/******NUEVAS FUNCIONES******/
function send_unidad(){
  send_ajax('POST','../../reqs/guarda/guarda_unidad.php', 'responde_guarda_unidad', construirdateunidad());
}

function construirdateunidad(){
   var nombre= document.getElementById('nombre_unidad').value;
   var data = 'nombre='+nombre;
   //alert(data);
   return data;   
}

function responde_guarda_unidad(response){
    //alert(response);
    if (response == 'C'){
       alert('LA UNIDAD FU\u00c9  AGREGADO CON \u00c9XITO');
        window.location.reload();
    }
    else if (response == 'T'){
        alert('ERROR. EL REGISTRO EST\u00c1 REPETIDO');
        window.location.reload();
    }
    else 
    {
        alert('Error Guardando Registro');
        window.location.reload();
    }
}
