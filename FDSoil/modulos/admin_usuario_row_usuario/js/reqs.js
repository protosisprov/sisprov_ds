function send_cedula( nac, num){
    send_ajax('GET', "../../reqs/saime/buscar_ci.php?nac="+nac+"&num="+num, 'response_cedula', null,null);
}
function response_cedula(response){   
   
    var arreglo = response.split(',');
    document.getElementById("id_nombres").value = arreglo[1].replace(/^\s*|\s*$/g,"");	
    document.getElementById("id_apellidos").value = arreglo[0].replace(/^\s*|\s*$/g,"");
}
function send_usuario(usu){
    send_ajax('GET', "../../reqs/usuario/disponibilidad.php?usuario="+usu, 'response_usuario', null,null);
}
function response_usuario(response){   
    if(response=='t') {
        document.getElementById("div_usuario").innerHTML ="";
    }else if(response=='f'){
        document.getElementById("div_usuario").innerHTML ="Este nombre ya esta siendo usado por otra persona ";   
        document.getElementById("id_usuario").focus();
    }    
}
