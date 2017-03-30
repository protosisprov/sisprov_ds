function accordion(sArray,separate1,separate2){
	var oDivAcordeon=document.getElementById('id_acordeon');
	var array1=new Array();
	var array2=new Array();
	oDivAcordeon.innerHTML='';
	array1=sArray.split(separate1);
	var array2=array1[0].split(separate2);
	var idEmp=array2[0];
	var oTitle=creaTitle(array2[0],array2[1]);
	oDivAcordeon.appendChild(oTitle);
	var oTable=document.createElement('table');
	oTable.setAttribute('id','idTable'+array2[0]);
	oTable.setAttribute('class','tableAcordeon');
	oTable.style.display='none';
	oTable=addRowTable(oTable,array2[2],array2[3]);
	oDivAcordeon.appendChild(oTable);
	for (var i=1;i<(array1.length-1); i++){
		array2=array1[i].split(separate2);
		if (idEmp==array2[0]){
			oTable=addRowTable(oTable,array2[2],array2[3]);
			oDivAcordeon.appendChild(oTable);			
		}
		else{
			var idEmp=array2[0];
			var oTitle=creaTitle(array2[0],array2[1]);
			oDivAcordeon.appendChild(oTitle);
			oTable=document.createElement('table');
			oTable.setAttribute('id','idTable'+array2[0]);	
			oTable.setAttribute('class','tableAcordeon');
			oTable.style.display='none';
			oTable=addRowTable(oTable,array2[2],array2[3]);
			oDivAcordeon.appendChild(oTable);
		}
	}
}

function creaTitle(id,descripcion){
	var oDiv=document.createElement("div");
	oDiv.setAttribute('class','divAcordeonTitle');
	oDiv.setAttribute('id','idDiv'+id);
	var oSubDiv1=document.createElement("div");
	oSubDiv1.setAttribute('class','divAcordeonSubTitle1');
	var input_chk=document.createElement('input');
	input_chk.setAttribute('id','idChkMain'+id);
	input_chk.setAttribute('type','hidden');
	input_chk.setAttribute('onclick','chkAll("idTable'+id+'","idChkMain'+id+'")');
	input_chk.setAttribute('title','Seleccione el Producto...');
	oSubDiv1.appendChild(input_chk);
	oDiv.appendChild(oSubDiv1);
	var oSubDiv2=document.createElement("div");
	oSubDiv2.setAttribute('class','divAcordeonSubTitle2');
   	var oH3=document.createElement("h3");
	oH3.setAttribute('class','titleAcordeon');
   	var oH3TextNode=document.createTextNode(descripcion);
   	oH3.appendChild(oH3TextNode);
	oH3.setAttribute('onclick','onOff("idTable'+id+'","idChkMain'+id+'")');
	oH3.setAttribute('title','Seleccione la Empresa...');
	oSubDiv2.appendChild(oH3);
	oDiv.appendChild(oSubDiv2);
	return oDiv;
}

function addRowTable(oTable,id_row,des_td) {
	var td_chekar=document.createElement('td');
	td_chekar.setAttribute('style','width:10%;');
	var input_chk=document.createElement('input');
	input_chk.setAttribute('type','checkbox');
	input_chk.setAttribute('title','Seleccione el Producto...');
	td_chekar.appendChild(input_chk);
	var ta=document.createElement('td');	
	ta.setAttribute('class','tdAcordeon');
	var na=document.createTextNode(des_td);
	ta.appendChild(na);
	ta.setAttribute('align','center');
	var tr=document.createElement('tr');
	tr.setAttribute('id','idRow'+id_row);
	tr.appendChild(td_chekar);
	tr.appendChild(ta);
	oTable.appendChild(tr);
	paintTable(oTable);
	return oTable;
}

function paintTable(table){
  	if (table.rows.length==0)
		return false;
	for (var rowIndex=0;rowIndex<table.rows.length;rowIndex++) 
		table.rows[rowIndex].className=((rowIndex% 2)==0)?"lospare":"losnone";
} 

function onOff(idTable,idChkMain){
	var oTable=document.getElementById(idTable);	
	var oChkMain=document.getElementById(idChkMain);	
	if (oTable.style.display=='none'){
		oTable.style.display='';
		oChkMain.type='checkbox';
	}
	else{
		oTable.style.display='none';
		oChkMain.checked=false;
		oChkMain.type='hidden';
		for (var i=0;i<oTable.rows.length;i++)
			var objChk=oTable.rows[i].cells[0].firstChild.checked=false;			
	}
}

function chkAll(idObjTable,idChkMain){
	var oTable=document.getElementById(idObjTable);
	var oChkMain=document.getElementById(idChkMain); 
	for (var i=0;i<oTable.rows.length;i++){
		objChk=oTable.rows[i].cells[0].firstChild;
		objChk.checked=(oChkMain.checked)?true:false;		
	}
}

function toGoOverTables(separate1,separate2){
	var oArrayChk=document.getElementById('id_arrayChk');
	var aStablas=document.getElementsByTagName('table');
	oArrayChk.innerHTML='';
	for (var i=0; i<(aStablas.length); i++){
		var oTabla=aStablas[i];
		for (var j=0; j<(oTabla.rows.length); j++){
			var objChk=oTabla.rows[j].cells[0].firstChild;
			if (objChk.checked){
				oArrayChk.innerHTML+=oTabla.id.substring(7,oTabla.id.length)+separate2+oTabla.rows[j].id.substring(5,oTabla.rows[j].id.length)+separate1;
			}			
		}		
	}
	oArrayChk.innerHTML=oArrayChk.innerHTML.substring(0,oArrayChk.innerHTML.length-1);
}

