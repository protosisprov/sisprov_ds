function sendProducto(num_dig){
    //productoCargandoOnOff();
    send_ajax('GET', "../../reqs/reqs/producto.php?num_dig="+num_dig, 'responseProducto', null);
	
}

function responseProducto(response){   
	llenarCombo(document.getElementById('producto_lista'),response.split('|'),'#',null,null);
	llenarCombo(document.getElementById('producto_desde'),response.split('|'),'#',"0",'Seleccione...');
	llenarCombo(document.getElementById('producto_hasta'),response.split('|'),'#',"0",'Seleccione...');
    	//productoCargandoOnOff();
}

/*
function sendRunQuery_h(arreglo1,arreglo2){
   send_ajax('POST', "../../reqs/runQuery/projection.php", 'responseRunQuery', "arreglo1="+arreglo1+"&arreglo2="+arreglo2);
}

function sendRunQuery_h_a(arreglo1,arreglo2){
   send_ajax('POST', "../../reqs/runQuery/projection_anual.php", 'responseRunQuery', "arreglo1="+arreglo1+"&arreglo2="+arreglo2);
}

function responseRunQuery(response){  
        document.getElementById('resultado_cifras').innerHTML=response;
        onOfDivUnoYDos();
        cssTablaAlmacenDatosExIm();
}

*/