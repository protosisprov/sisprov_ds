function sendComboNivel_1(id){
	send_ajax('GET','../../reqs/menu_rol/menu_nivel_1_combo.php?id_nivel_0='+id, 'responseComboNivel_1', null);	
}

function responseComboNivel_1( response ){
    llenarCombo(document.getElementById('id_nivel_1'),response.split('¬'),'|','null','Seleccione...');    
}

function sendTablaNivel_2(id){
	send_ajax('GET','../../reqs/menu_rol/menu_nivel_2_tabla.php?id_nivel_1='+id, 'responseTablaNivel_2', null);	
}

function responseTablaNivel_2( response ){
    (response)?llenarTabla(response.split('¬'),'|'):llenarTabla('','|'); 
    jQryTableRefresh('tablaRows');
}