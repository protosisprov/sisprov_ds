function sendComboNivel_1(id){
	send_ajax('GET','../../reqs/menu_rol/menu_nivel_1_combo.php?id_nivel_0='+id, 'responseComboNivel_1', null);	
}

function responseComboNivel_1( response ){
    llenarCombo(document.getElementById('id_nivel_1'),response.split('¬'),'|','null','Seleccione...');    
}

function sendComboNivel_2(id){
	send_ajax('GET','../../reqs/menu_rol/menu_nivel_2_combo.php?id_nivel_1='+id, 'responseComboNivel_2', null);	
}

function responseComboNivel_2( response ){
    llenarCombo(document.getElementById('id_nivel_2'),response.split('¬'),'|','null','Seleccione...');    
}

function sendTablaNivel_3(id){
    send_ajax('GET','../../reqs/menu_rol/menu_nivel_3_tabla.php?id_nivel_2='+id, 'responseTablaNivel_3', null);	
}

function responseTablaNivel_3( response ){
    (response)?llenarTabla(response.split('¬'),'|'):llenarTabla('','|'); 
    jQryTableRefresh('tablaRows');
}