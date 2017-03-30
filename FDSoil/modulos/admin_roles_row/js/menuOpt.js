function optHasDependent(idRepresentante,arrDependiente){
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

function row0Add(id,opt,flag){
    
    var tr  = document.createElement('tr');

    var td = document.createElement('td');	
    var node = document.createTextNode(id);
    td.setAttribute('style','color:#FFFFFF');
    td.appendChild(node);
    tr.appendChild(td);

    td = document.createElement('td');
    node = document.createTextNode(opt);
    colspan = (flag=='o')?'4':'5';	
    td.setAttribute('colspan',colspan);
    if (flag=='t') 
	td.setAttribute('style','font-weight:bold');
    td.appendChild(node);
    tr.appendChild(td);    
  
    if (flag=='o'){
        td=document.createElement('td');
        td.setAttribute('style','width:10%;');
        var input_chk=document.createElement('input');
        input_chk.setAttribute('type','checkbox');
        input_chk.setAttribute('title','Seleccione el Producto...');
        td.appendChild(input_chk);
        tr.appendChild(td);
    }   

    td = document.createElement('td');	
    td.setAttribute('style','color:#FFFFFF');
    node = document.createTextNode(flag);        
    td.appendChild(node);
    tr.appendChild(td);   
    
    document.getElementById('tbl').appendChild(tr);
    
}

function row1Add(id0,id,opt,flag){

    var tr  = document.createElement('tr');
    
    var td = document.createElement('td');	
    var node = document.createTextNode(id0);
    td.setAttribute('style','color:#FFFFFF');
    td.appendChild(node);
    tr.appendChild(td);

    td = document.createElement('td');
    node = document.createTextNode(id);
    td.setAttribute('style','color:#FFFFFF');	
    td.appendChild(node);
    tr.appendChild(td);  
    
    td = document.createElement('td');	
    node = document.createTextNode(opt);
    colspan = (flag=='o')?'3':'4';
    td.setAttribute('colspan',colspan);
    if (flag=='t') 
	td.setAttribute('style','font-weight:bold');
    td.appendChild(node);
    tr.appendChild(td); 

    if (flag=='o'){  
	td=document.createElement('td');
    	td.setAttribute('style','width:10%;');
    	var input_chk=document.createElement('input');
    	input_chk.setAttribute('type','checkbox');
    	input_chk.setAttribute('title','Seleccione el Producto...');
    	td.appendChild(input_chk);
    	tr.appendChild(td);  
    }

    var td = document.createElement('td');
    td.setAttribute('style','color:#FFFFFF');
    var node = document.createTextNode(flag);
    td.appendChild(node);
    tr.appendChild(td);  
    
    document.getElementById('tbl').appendChild(tr);
    
}

function row2Add(id0,id1,id,opt,flag){

    var tr  = document.createElement('tr');
    
    var td = document.createElement('td');	
    var node = document.createTextNode(id0);
    td.setAttribute('style','color:#FFFFFF');
    td.appendChild(node);
    tr.appendChild(td);

    td = document.createElement('td');	
    node = document.createTextNode(id1);
    td.setAttribute('style','color:#FFFFFF');
    td.appendChild(node);
    tr.appendChild(td);
    
    td = document.createElement('td');	
    node = document.createTextNode(id);
    td.setAttribute('style','color:#FFFFFF');
    td.appendChild(node);
    tr.appendChild(td); 
    
    td = document.createElement('td');	
    node = document.createTextNode(opt);
    colspan = (flag=='o')?'2':'3';
    td.setAttribute('colspan',colspan);
    if (flag=='t') 
    	td.setAttribute('style','font-weight:bold');
    td.appendChild(node);
    tr.appendChild(td);    

    if (flag=='o'){      
	td=document.createElement('td');
    	td.setAttribute('style','width:10%;');
    	var input_chk=document.createElement('input');
    	input_chk.setAttribute('type','checkbox');
    	input_chk.setAttribute('title','Seleccione el Producto...');
    	td.appendChild(input_chk);
    	tr.appendChild(td); 
    }
  
    td = document.createElement('td');
    td.setAttribute('style','color:#FFFFFF');
    node = document.createTextNode(flag);
    td.appendChild(node);
    tr.appendChild(td); 
    
    document.getElementById('tbl').appendChild(tr);
    
}

function row3Add(id0,id1,id2,id,opt,flag){

    var tr  = document.createElement('tr');

    var td = document.createElement('td');	
    var node = document.createTextNode(id0);
    td.setAttribute('style','color:#FFFFFF');
    td.appendChild(node);
    tr.appendChild(td);
    
    td = document.createElement('td');	
    node = document.createTextNode(id1);
    td.setAttribute('style','color:#FFFFFF');
    td.appendChild(node);
    tr.appendChild(td);
    
    td = document.createElement('td');	
    node = document.createTextNode(id2);
    td.setAttribute('style','color:#FFFFFF');
    td.appendChild(node);
    tr.appendChild(td);
    
    td = document.createElement('td');	
    node = document.createTextNode(id);
    td.setAttribute('style','color:#FFFFFF');
    td.appendChild(node);
    tr.appendChild(td);    
    
    td = document.createElement('td');	
    node = document.createTextNode(opt);
    td.appendChild(node);
    tr.appendChild(td);    
    
    td=document.createElement('td');
    td.setAttribute('style','width:10%;');
    input_chk=document.createElement('input');
    input_chk.setAttribute('type','checkbox');
    input_chk.setAttribute('title','Seleccione el Producto...');
    td.appendChild(input_chk);
    tr.appendChild(td);

    td = document.createElement('td');
    td.setAttribute('style','color:#FFFFFF');
    node = document.createTextNode(flag);
    td.appendChild(node);
    tr.appendChild(td);    
    
    document.getElementById('tbl').appendChild(tr);
    
}


function optMenuHave(strMenu){
    var arrMenu=strMenu.split("$");
    var array0=arrMenu[0].split("%");
    var array1=arrMenu[1].split("%");
    var array2=arrMenu[2].split("%");
    var array3=arrMenu[3].split("%");
    for (var a=0; a < array0.length; a++){
	var row0 = array0[a].split("|");
	var id0=row0[0];
	var hasRow1=false;
	hasRow1=optHasDependent(id0,array1);
	if (hasRow1==false)
		row0Add(row0[0],row0[1],'o');
	else{
            row0Add(row0[0],row0[1],'t');
            for (var p=0; p < array1.length; p++){
                var row1 = array1[p].split("|");
		if (id0==row1[1]){
                    var id1=row1[0];
                    var hasRow2=false;					
                    hasRow2=optHasDependent(id1,array2);
                    if (hasRow2==false)
			row1Add(row1[1],row1[0],row1[2],'o');                    
                    else{
                        row1Add(row1[1],row1[0],row1[2],'t');
        		for (var h=0; h < array2.length; h++){
                            var row2 = array2[h].split("|");
                            if (id1==row2[1]){
				var id2=row2[0];
                        	var hasRow3=false;
				hasRow3=optHasDependent(id2,array3);
				if (hasRow3==false)
					row2Add(row1[1],row2[1],row2[0],row2[2],'o');				
				else{
                                    row2Add(row1[1],row2[1],row2[0],row2[2],'t');
                                    for (var n=0; n < array3.length; n++){
					var row3 = array3[n].split("|");
					if (id2==row3[1])
						row3Add(row1[1],row2[1],row3[1],row3[0],row3[2],'o');                                        
                                    }
				}									
                            }
			}
                    }
                }
            }
        }
    }						
}

function sweepTable(){
   var oTbl=document.getElementById('tbl');
   var oTrs=oTbl.getElementsByTagName('tr');
   var arreglo0=new Array();
   var arreglo1=new Array();
   var arreglo2=new Array();
   var arreglo3=new Array();
   var a=0;
   var b=0;
   var c=0;
   var d=0;
   for(var i=1;i<oTrs.length;i++){
      var oTds=oTrs[i].getElementsByTagName('td');
      var id0='';
      var id1='';
      var id2=''; 
      var id3='';               
      if (oTds.length==4 && oTds[3].innerHTML=='o' && oTds[2].firstChild.checked){
	 id0=oTds[0].innerHTML;
         if (!isThereThisValueInTheArray(arreglo0,id0))
            arreglo0[a++]=id0;
      }
      else if (oTds.length==5 && oTds[4].innerHTML=='o' && oTds[3].firstChild.checked){
	 id0=oTds[0].innerHTML;
         if (!isThereThisValueInTheArray(arreglo0,id0))
	    arreglo0[a++]=id0;
	 id1=oTds[1].innerHTML;
         if (!isThereThisValueInTheArray(arreglo1,id0+'|'+id1))
            arreglo1[b++]=id0+'|'+id1;
      }
      else if (oTds.length==6 && oTds[5].innerHTML=='o' && oTds[4].firstChild.checked){
	 id0=oTds[0].innerHTML;
         if (!isThereThisValueInTheArray(arreglo0,id0))
	    arreglo0[a++]=id0;
         id1=oTds[1].innerHTML;
         if (!isThereThisValueInTheArray(arreglo1,id0+'|'+id1))
            arreglo1[b++]=id0+'|'+id1;
	 id2=oTds[2].innerHTML; 
         if (!isThereThisValueInTheArray(arreglo2,id1+'|'+id2))
            arreglo2[c++]=id1+'|'+id2;
      }
      else if (oTds.length==7 && oTds[6].innerHTML=='o' && oTds[5].firstChild.checked){
         id0=oTds[0].innerHTML;
         if (!isThereThisValueInTheArray(arreglo0,id0))
            arreglo0[a++]=id0;
	 id1=oTds[1].innerHTML;
         if (!isThereThisValueInTheArray(arreglo1,id0+'|'+id1))
            arreglo1[b++]=id0+'|'+id1;
	 id2=oTds[2].innerHTML; 
         if (!isThereThisValueInTheArray(arreglo2,id1+'|'+id2))
            arreglo2[c++]=id1+'|'+id2;
         id3=oTds[3].innerHTML;
         if (!isThereThisValueInTheArray(arreglo3,id2+'|'+id3))
	    arreglo3[d++]=id2+'|'+id3;
      }	
   }
   document.getElementById('id_str_array_n0').value=arreglo0.join('¬');
   document.getElementById('id_str_array_n1').value=arreglo1.join('¬');
   document.getElementById('id_str_array_n2').value=arreglo2.join('¬');
   document.getElementById('id_str_array_n3').value=arreglo3.join('¬');
   document.forms[0].submit();
}

function putOptRol(strArray){ 
        var arrRolOpt=strArray.split("$");
	var array0=arrRolOpt[0].split("%");
	var array1=arrRolOpt[1].split("%");
	var array2=arrRolOpt[2].split("%");
	var array3=arrRolOpt[3].split("%");
	for(var i in array0)
		putOptRolAuxNivel0(array0[i]);
	for(var i in array1)
		putOptRolAuxNivel1(array1[i]);
	for(var i in array2)
		putOptRolAuxNivel2(array2[i]);
	for(var i in array3)
		putOptRolAuxNivel3(array3[i]);
}

function putOptRolAuxNivel0(value){
	var oTbl=document.getElementById('tbl');
	var oTrs=oTbl.getElementsByTagName('tr');
	for(var i=1;i<oTrs.length;i++){
		var oTds=oTrs[i].getElementsByTagName('td');
		if (oTds.length==4 && oTds[3].innerHTML=='o' && value==oTds[0].innerHTML)
			oTds[2].firstChild.checked=true;
	}
}

function putOptRolAuxNivel1(strArray){
	var arreglo=strArray.split("|");
	var oTbl=document.getElementById('tbl');
	var oTrs=oTbl.getElementsByTagName('tr');
	for(var i=1;i<oTrs.length;i++){
		var oTds=oTrs[i].getElementsByTagName('td');
		if (oTds.length==5 && oTds[4].innerHTML=='o' && arreglo[0]==oTds[0].innerHTML && arreglo[1]==oTds[1].innerHTML )
			oTds[3].firstChild.checked=true;
	}
}

function putOptRolAuxNivel2(strArray){
	var arreglo=strArray.split("|");
	var oTbl=document.getElementById('tbl');
	var oTrs=oTbl.getElementsByTagName('tr');
	for(var i=1;i<oTrs.length;i++){
		var oTds=oTrs[i].getElementsByTagName('td');
		if (oTds.length==6 && oTds[5].innerHTML=='o' && arreglo[0]==oTds[0].innerHTML && arreglo[1]==oTds[1].innerHTML && arreglo[2]==oTds[2].innerHTML)
			oTds[4].firstChild.checked=true;
	}
}

function putOptRolAuxNivel3(strArray){
	var arreglo=strArray.split("|");
	var oTbl=document.getElementById('tbl');
	var oTrs=oTbl.getElementsByTagName('tr');
	for(var i=1;i<oTrs.length;i++){
		var oTds=oTrs[i].getElementsByTagName('td');
		if (oTds.length==7 && oTds[6].innerHTML=='o' && arreglo[0]==oTds[0].innerHTML && arreglo[1]==oTds[1].innerHTML && arreglo[2]==oTds[2].innerHTML && arreglo[3]==oTds[3].innerHTML)
			oTds[5].firstChild.checked=true;
	}
}

function isThereThisValueInTheArray(arreglo, valor) {
   var resp = false;
   for(var i in arreglo)
      if (arreglo[i] == valor) 
         resp = true
   return resp;
}
