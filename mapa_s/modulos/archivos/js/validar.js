function inicio(strArrayMenu) {
    var obj=new app();
    id_sistema(obj.name);
    menu(strArrayMenu);
//    send_mostrar_variable_sector(1);
//    send_cargar_estado();
}

 $(function(){
      document.getElementById('mensaje').style.display='block';
        $("#formuploadajax").on("submit", function(e){
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("formuploadajax"));
            formData.append("dato", "valor");
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            
            var opciones = document.getElementsByName("accion");
 
            var seleccionado = false;
            for(var i=0; i<opciones.length; i++) {    
              if(opciones[i].checked) {
                seleccionado = true;
                var dato=opciones[i].value;
                break;
              }
            }
            var dato_url;
            var mensaje;
            if (dato=="cargar"){
                dato_url="archivo.php";
                mensaje="Ha cargada con éxito el archivo";
                document.getElementById('carga_file').style.display="none";
                document.getElementById('c_a').style.display="none";
            }else{
                dato_url="eliminar.php";
                mensaje="Ha eliminado con éxito el archivo";
                document.getElementById('e_a').style.display="none";
            }
            $.ajax({
                url: dato_url,
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                    if (res==' Error: 4<br>'){
                        $("#mensaje").css("background-color","#f2dede");
                        $("#mensaje").css("border-left","5px solid #d9534f");
                         $("#mensaje").css("color","#d9534f");
                        mensaje="Error en la carga del archivo";
                        res='';
                    }else{
    //                    $("#mensaje").class("alert alert-success");
                        $("#mensaje").css("background-color","#ECF4ED");
                        $("#mensaje").css("border-left","5px solid #90C693");
                         $("#mensaje").css("color","#577759");
                    }
                        $("#mensaje").css("padding","10px");
                        $("#mensaje").css("width","50%");
                        $("#mensaje").css("margin-left","24%");
                        $('#formuploadajax').each (function(){
                            this.reset();
                        });
                        $("#mensaje").html(mensaje + res);
                });
            
        });
    });
    

function cargar_form_estado(){ //alert("aqui");
    var estado=document.getElementById('estados').value;
    title_table('form_estados', 'Estado(s)#Cantidad#Actualizar');
    llenar_variable('form_estados',estado);
    
}

function verificar(){
    var mensaje=document.getElementById('mensaje').innerHTML;
    if (mensaje!=''){
        document.getElementById('mensaje').innerHTML='';
        document.getElementById('mensaje').style='';
    }
}


//***********************************************************************************************************


function habilitar(option){
    if(option==1){
           document.getElementById('carga_file').style.display='block';
           document.getElementById('c_a').style.display='block';
           document.getElementById('e_a').style.display='none';
       }else{
           document.getElementById('carga_file').style.display='none';
           document.getElementById('c_a').style.display='none';
           document.getElementById('e_a').style.display='block';
       }
}

