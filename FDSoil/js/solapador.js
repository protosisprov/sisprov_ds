function segirTab(tTab){
	for (var i=0;i<tTab-1;i++){	
		if (document.all('div'+i).style.display!="none"){
			Tab(i+1,tTab);
			return;
		}
		
	}
}
function regresarTab(tTab){
	for (var i=1;i<=tTab-1;i++){
		if (document.all('div'+i).style.display!="none"){
			Tab(i-1,tTab);
			return;	
		}
		
	}
}
function Tab(nTab,tTab){
	for (var i=0;i<tTab;i++){
		if (nTab==i){
			document.all('div'+i).style.display="";
			document.getElementById('chk'+i).style.visibility = 'visible';	
			document.getElementById('Tab'+i).style.color="#000000";
		}
		else{
			document.all('div'+i).style.display="none";
			document.getElementById('chk'+i).style.visibility = 'hidden';
			document.getElementById('Tab'+i).style.color="#6E6E6E";	
		}
	}		
	
	if (nTab==0){
		document.getElementById('id_regresar').className='desHabilitarBoton';
		document.getElementById('id_seguir').className='HabilitarBoton';
	}
	else if(nTab==tTab-1){
		document.getElementById('id_regresar').className = 'HabilitarBoton';
		document.getElementById('id_seguir').className = 'desHabilitarBoton';
	}
	else{
		document.getElementById('id_regresar').className = 'HabilitarBoton';
		document.getElementById('id_seguir').className = 'HabilitarBoton';
	}



}

function ocultar_mostrar_objeto(id_nombre){//coloca los check a las pestañas
        var objeto = document.getElementById(id_nombre);
	if (objeto.style.visibility == 'visible'){
		objeto.style.visibility = 'hidden';
	}
	else{
		objeto.style.visibility = 'visible';
	}
}



