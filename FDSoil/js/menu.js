function menu(strMenu){
	var arrMenu=strMenu.split("$");
	var array0=arrMenu[0].split("%");
	var array1=arrMenu[1].split("%");
	var array2=arrMenu[2].split("%");
	var array3=arrMenu[3].split("%");
	var oUl0=doUl();
	for (a=0; a < array0.length; a++){
		var row0 = array0[a].split("|");
		var id0=row0[0];
		var hasRow1=false;
		hasRow1=hasDependent(id0,array1);
		if (hasRow1==false){
			oUl0.appendChild(doLiA(row0[1],row0[2]));
		}
		else{
			var oLi0=doLiASpan(row0[1],'#');
			var oUl1=doUl();
			for (p=0; p < array1.length; p++){
				var row1 = array1[p].split("|");
				if (id0==row1[1]){
					var id1=row1[0];
					var hasRow2=false;					
					hasRow2=hasDependent(id1,array2);
					if (hasRow2==false){
						oUl1.appendChild(doLiA(row1[2],row1[3]));
					}
					else{
						var oLi1=doLiASpan(row1[2],'#');
						var oUl2=doUl();
						for (h=0; h < array2.length; h++){
							var row2 = array2[h].split("|");
							if (id1==row2[1]){
								var id2=row2[0];
								var hasRow3=false;
								hasRow3=hasDependent(id2,array3);
								if (hasRow3==false){
									oUl2.appendChild(doLiA(row2[2],row2[3]));
								}
								else{
									var oLi2=doLiASpan(row2[2],'#');
									var oUl3=doUl();
									for (n=0; n < array3.length; n++){
										var row3 = array3[n].split("|");
										if (id2==row3[1]){
											oUl3.appendChild(doLiA(row3[2],row3[3]));
										}
									}									
									oLi2.appendChild(oUl3);
									oUl2.appendChild(oLi2);
								}
							}
						}
						oLi1.appendChild(oUl2);
						oUl1.appendChild(oLi1);
					}
				}
			}			
			oLi0.appendChild(oUl1);
			oUl0.appendChild(oLi0);			
		}
	}
	document.getElementById("menu").appendChild(oUl0);
}

function hasDependent(idRepresentante,arrDependiente){
	var response=false;
	for (var j=0; j < arrDependiente.length; j++){
			var dependienteRow = arrDependiente[j].split("|");
			if (idRepresentante==dependienteRow[1]){
				response=true;
				break;
			}
		}
	return 	response;
}

function doUl(){
	var oBj=document.createElement("ul");
	oBj.setAttribute('class','');
	return oBj;
}

function doLiA(tNodo, direccion){
	var oBj=doLi();
	oBj.appendChild(doAtNodo( tNodo, direccion));
	return oBj;
}

function doAtNodo( tNodo, direccion){
	var oBj=doA(direccion);
	oBj.appendChild(document.createTextNode(tNodo));
	return oBj;
}

function doA(direccion){
	var oBj=document.createElement("a");
	oBj.setAttribute('class','');
	oBj.setAttribute('href', direccion);
	return oBj;
}

function doLiASpan(tNodo, direccion){
	var oBj=doLi();
	oBj.appendChild(doASpantNodo( tNodo, direccion));
	return oBj;
}

function doASpantNodo( tNodo, direccion){
	var oBj=doA(direccion);
	oBj.appendChild(doSpand(tNodo));
	return oBj;
}

function doSpand(tNodo){
	var oBj=document.createElement("span");
	oBj.appendChild(document.createTextNode(tNodo));
	return oBj;
}

function doLi(){
	var oBj=document.createElement("li");
	oBj.setAttribute('class','has-sub');
return oBj;
}