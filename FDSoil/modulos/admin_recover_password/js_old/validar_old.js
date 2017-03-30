function inicio(){
    var obj=new app();
    id_sistema(obj.name);
}


function validar_formulario_old(){
        
    var respuesta = document.getElementById('id_respuesta').value
    
    if(respuesta != ""){
        document.getElementById('form1').submit();
    }else{
        alert("error debe completar el campo de respuesta");
    }
    
}
