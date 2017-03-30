var pickControl = null;
var idControl = null;
var tot = null;

/*function pickOpen2(num,id, idCtl, url, ancho, altura){	
	if (pickControl!=null)
		pickClose();			
	pickControl = id;
	idControl = idCtl;
	tot = num;	
	showBox(pickControl, ancho, altura, url);
}*/
			
function pickOpen(id, idCtl, url, ancho, altura, cleft, ctop){
	if (pickControl!=null)
		pickClose();
	pickControl = id;
	idControl = idCtl;
	showBox(pickControl, ancho, altura, url, cleft, ctop);
}

/*
* Crear un DIV que contenga un IFRAME y posicionar el DIV con su contenido
* abajo y alineado a la izquierda del elemento cuyo ID es el valor del parametro objID
*/		
function showBox(objID, width, height, url, cleft, ctop){//Original author: JTricks.com :: http://www.jtricks.com/ 
	var obj = document.getElementById(objID);
	var newID = objID + "_popup";
	var borderStyle = "lightgrey 4px solid"
	var boxdiv = document.getElementById(newID);                

        show('id_fondo_opaco', 100);//document.getElementById('id_fondo_opaco').style.display='block';
        
	if (boxdiv != null){
		if (boxdiv.style.display=='none'){
                    
	    		if (url!=null)
				showBoxAux(objID,url);
			moveBox(obj, boxdiv, cleft, ctop);
			show(newID, 100);//boxdiv.style.display='block';                       
		} 
		else
			hide(newID, 100);//boxdiv.style.display='none';
		return false;
	}

	boxdiv = document.createElement('div');
        boxdiv.setAttribute('class', 'ventana_modal_catalogo');
	boxdiv.setAttribute('id', newID);
        boxdiv.style.display = 'none';        
	boxdiv.style.position = 'absolute';
	boxdiv.style.width = width + 'px';
	boxdiv.style.height = height + 'px';
	boxdiv.style.border = borderStyle;
	boxdiv.style.backgroundColor = '#F7F7F7';
	boxdiv.style.padding = "0px";

	var contents = document.createElement('iframe');
	contents.scrolling = 'yes';
	contents.frameBorder = '0';
	contents.style.width = width + 'px';
	contents.style.height = height + 'px';
	contents.marginHeight = 30;
	contents.marginWidth = 30;
	contents.setAttribute('id', objID + "_iframe");
	contents.setAttribute('name', objID + "_iframe");	  
	boxdiv.appendChild(contents);
	document.body.appendChild(boxdiv);
        
	if (url!=null)
		showBoxAux(objID,url);
            
	moveBox(obj, boxdiv, cleft, ctop);
	show(newID, 100);//boxdiv.style.display = 'block';
 	return false; 
}	

function showBoxAux(objID,url){
	var f = window.frames[objID + "_iframe"];
	f.document.open();
	f.document.write("<center>");
	f.document.write("<br><br>");
	f.document.write("<img src='../../../appOrg/images/progress.gif'>");
	f.document.write("<span style='padding-left:10px;font-family:Arial;font-size:9pt;font-weight:bold'>Loading...</span>");
	f.document.write("</center>");
	f.document.close();
	f.location = url;
}

function closePickList(){
	parent.pickClose();
}

function pickClose(){
	closeBox(pickControl);
	idControl = null;
	pickControl = null;       
        hide('id_fondo_opaco', 100);// document.getElementById('id_fondo_opaco').style.display='none';
}

function closeBox(objID){//Esconde un DIV + IFRAME abierto con la funcion showBox();
	var obj = document.getElementById(objID);
	if (!obj.readonly)
		obj.focus();		
        hide(objID + "_popup", 100);//document.getElementById(objID + "_popup").style.display = "none";
}

function selectItemSimple(id,objInput){
	var descripcion = document.getElementById(id);
	parent.pickSelect(id, descripcion.innerHTML, chkThis(id));
	closePickList();	
}

function chkThis(aidi){
	document.getElementById("abc").value=aidi;
	return document.getElementById("abc").value;
}

function selectItemMultiple(id,objInput){
	var descripcion = document.getElementById(id);
	parent.pickSelect(id, descripcion.innerHTML, chkThese(objInput, id));
}

function chkThese(obj, aidi){
	if (obj.checked==true)
		document.getElementById("abc").value+=aidi+';';
	else if(obj.checked==false)
		document.getElementById("abc").value=document.getElementById("abc").value.replace(aidi+';',"");
	return document.getElementById("abc").value;
}

var currStyle="";
function rowOn(obj) {
	currStyle = obj.className;
	obj.className="hilite";
}
function rowOff(obj) {
	obj.className=currStyle
}

// Posicionar un DIV justo debajo de un control de formulario, alineado a la izquierda.
// element: objeto que representa al control
// box: objeto que representa al DIV

function moveBox(element, box, cleft, ctop){//NOTE:	Original author: JTricks.com :: http://www.jtricks.com/

	var offset = 3;
	if (isIE())
		offset = -13;


	var obj = element;

        if (cleft==null && ctop==null){
            while (obj.offsetParent) {
                cleft += obj.offsetLeft;
	    	ctop += obj.offsetTop;
	    	obj = obj.offsetParent;
            }
        }

	box.style.left = cleft + 'px';
	ctop += element.offsetHeight + offset;
	
	if (document.body.currentStyle && document.body.currentStyle['marginTop']){
		ctop += parseInt(
	      	document.body.currentStyle['marginTop']);
	}

	box.style.top = ctop + 'px';

}

function isIE(){// Retorna TRUE si el navegador es Internet Explorer 
	return (navigator.appName.indexOf("Explorer")>0)?true:false;
}

function pickSelect(id, description){
	document.getElementById(idControl).value = id;
	document.getElementById(pickControl).value = description;
}

//    * firstChild: primer hijo
//    * lastChild: último hijo
//    * childNodes: array de los hijos del nodo
//    * parentNode: nodo padre
//    * nextSibling: siguiente hijo
//    * prevSibling: hijo anterior

