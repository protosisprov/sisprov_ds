function sendTablaNivel_1(id){
//        alert('../../reqs/menu_rol/menu_nivel_1_tabla.php?id_nivel_0='+id);
    	send_ajax('GET','../../reqs/menu_rol/menu_nivel_1_tabla.php?id_nivel_0='+id, 'responseTablaNivel_1', null);	
}

function responseTablaNivel_1( response ){
    //alert(response);
    (response)?llenarTabla(response.split('¬'),'|'):llenarTabla('','|'); 
    jQryTableRefresh('tablaRows');
}