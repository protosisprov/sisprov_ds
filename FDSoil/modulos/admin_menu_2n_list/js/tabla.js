function llenarTabla( arreglo, separador){
    var tbody = document.getElementById('tablaRows').tBodies[0];
    tbody.innerHTML='';
    var subarreglo = new Array();     
    var arregloTr = new Array();        
    for (i=0; i<(arreglo.length); i++){
	subarreglo=arreglo[i].split(separador);
        arregloTr[i]=addRowTable(subarreglo[0],subarreglo[1],subarreglo[2],subarreglo[3],subarreglo[4]);
        tbody.appendChild(arregloTr[i]);
    }	
}

function addRowTable(v0,v1,v2,v3,v4){        
    
    var tr  = document.createElement('tr');
    
    var td1 = document.createElement('td');	
    var node = document.createTextNode(v1);
    td1.appendChild(node);
    tr.appendChild(td1);
    
    var td2 = document.createElement('td');	
    var node = document.createTextNode(v2);
    td2.appendChild(node);
    tr.appendChild(td2);
    
    var td3 = document.createElement('td');	
    var node = document.createTextNode(v3);
    td3.appendChild(node);
    tr.appendChild(td3);

    var td4 = document.createElement('td');	
    var node = document.createTextNode(v4);
    td4.appendChild(node);
    tr.appendChild(td4);
    
    var td5=document.createElement('td');
   
    var objA=document.createElement('a');
    objA.setAttribute('onclick','submitEdit('+v0+','+document.getElementById('id_nivel_1').value+')');  
    var objImg=document.createElement('img');
    objImg.setAttribute('src','../../images/24x24/edit.png');  
    objImg.setAttribute('title','Edit...');  
    objImg.setAttribute('style','cursor:pointer;');  
    objA.appendChild(objImg); 
    td5.appendChild(objA);  
    
    objA=document.createElement('a');
    objA.setAttribute('onclick','submitDelete('+v0+')');   
    objImg=document.createElement('img');
    objImg.setAttribute('src','../../images/24x24/delete.png');  
    objImg.setAttribute('title','Delete...');  
    objImg.setAttribute('style','cursor:pointer;');  
    objA.appendChild(objImg); 
    td5.appendChild(objA);  
    
    tr.appendChild(td5);
  
    return tr;
}