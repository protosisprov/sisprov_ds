function deleteAllRowsTable(idTable,limit){
    for(var i = document.getElementById(idTable).rows.length; i > limit;i--){
    document.getElementById(idTable).deleteRow(i -1);
    }
}

function tableToMatrix(idTabla,isThereId){    
    var objTable= document.getElementById(idTabla);
    var matrix=new Array();
    for (rowIndex=0; rowIndex<objTable.rows.length;rowIndex++){
        matrix[rowIndex]=new Array();
        var row=objTable.rows[rowIndex];
        var cells=row.cells;
        for (cellIndex=0;cellIndex<cells.length;cellIndex++){ 
            var startColNum=0; 
            if (isThereId){
                 matrix[rowIndex][0]=row.id;
                var startColNum=1;
            }
            matrix[rowIndex][cellIndex+startColNum]=cells[cellIndex].innerHTML;            
        }        
   }    
   return matrix;
}

function delRow(idTable,idRow){
	document.getElementById(idTable).deleteRow(idRow.parentNode.parentNode.rowIndex);
}

function srtArrayToTable(idTabla,strArray,separate1,separate2){    
    var rowArray=strArray.split(separate2);
    var objTable=document.createElement('table');
    objTable.setAttribute('id',idTabla);
    objTable.appendChild(srtArrayToTableAux(rowArray[0].split(separate1),'th'));
    for (i=1; i < rowArray.length; i++)
        objTable.appendChild(srtArrayToTableAux(rowArray[i].split(separate1),'td'));    
    return objTable;
}

function srtArrayToTableAux(cellArray,cellType){
    var tr=document.createElement('tr');
    var cell=new Array();
    var node=new Array();
    for (var i=0;i<cellArray.length;i++){
        cell[i]=document.createElement(cellType);
        node[i]=document.createTextNode(cellArray[i]);
        cell[i].appendChild(node[i]);
        tr.appendChild(cell[i]);
    }
    return tr;
}

function paintTRsClearDark(idTable) {
        var objTable= document.getElementById(idTable);
  	if (objTable.rows.length == 1)
            return false;
	for (rowIndex = 1; rowIndex < objTable.rows.length; rowIndex++) 
            objTable.rows[rowIndex].className=((rowIndex% 2) == 0)?'losnone':'lospare';              
}

function setAttributeTR(idTable,trIndex,attribute,value){
    var objTable=document.getElementById(idTable);  
    for (rowIndex=1;rowIndex<objTable.rows.length;rowIndex++) 
        if (rowIndex==trIndex)
            objTable.rows[rowIndex].setAttribute(attribute,value);                     
}


function setAttributeTD(idTable,attribute,value, fromTD, toTD, fromTR, toTR){
    var objTable=document.getElementById(idTable);
    for (rowIndex=0; rowIndex<objTable.rows.length;rowIndex++){
        var row=objTable.getElementsByTagName('tr')[rowIndex];
        var cells=row.getElementsByTagName('td');
        for (cellIndex=0;cellIndex<cells.length;cellIndex++) 
            if (cellIndex>=fromTD && cellIndex<=toTD && rowIndex>=fromTR && rowIndex<=toTR ) 
                cells[cellIndex].setAttribute(attribute,value);
    }
}

function putFormatTD(idTable, fromTD, toTD, fromTR, toTR){
    var objTable=document.getElementById(idTable);
    for (rowIndex = 0; rowIndex < objTable.rows.length; rowIndex++){
        var row = objTable.getElementsByTagName('tr')[rowIndex];
        var cells = row.getElementsByTagName('td');
        for (cellIndex = 0; cellIndex < cells.length; cellIndex++) 
            if (cellIndex>=fromTD && cellIndex<=toTD && rowIndex>=fromTR && rowIndex<=toTR ) 
                cells[cellIndex].innerHTML=putFormat(parseInt(cells[cellIndex].innerHTML));                                          
    }
}

function tableDelRowJQry(idRow, objTable){
	objTable.deleteRow(idRow.parentNode.parentNode.rowIndex);
}

function jQryTableRefresh(idTabla){    
    if (document.getElementById(idTabla+'_length')){   
        var obj1 = document.getElementById(idTabla+'_length');
        var padre1 = obj1.parentNode;
        padre1.removeChild(obj1);
    }        
    if (document.getElementById(idTabla+'_filter')){   
        var obj2 = document.getElementById(idTabla+'_filter');
        var padre2 = obj2.parentNode;
        padre2.removeChild(obj2);
    }      
    if (document.getElementById(idTabla+'_info')){
        var obj3 = document.getElementById(idTabla+'_info');
        var padre3 = obj3.parentNode;
        padre3.removeChild(obj3);
    }      
    if (document.getElementById(idTabla+'_paginate')){
        var obj4 = document.getElementById(idTabla+'_paginate');
        var padre4 = obj4.parentNode;
        padre4.removeChild(obj4);
    }    
    
    $(document).ready(function(){$('#'+idTabla).dataTable();});  
}

function validateTable(id_campo,id_mensaje,mensaje, minRow){
    obj=document.getElementById(id_campo);
    objmsj=document.getElementById(id_mensaje);
    var arreglo=obj.value.split(',');
    if(arreglo.length < minRow){
        objmsj.innerHTML = ''+mensaje;
        return false;
    }
    else{
        objmsj.innerHTML = '';
        return true;
    }
}


function matrixToTable(idTabla,matrix,isThereId){ 
    var objTable=document.createElement('table');
    objTable.id=idTabla;
    objTable.appendChild(matrixToTableAux(matrix[0],'th',isThereId));
    for (i=1; i < matrix.length; i++)
        objTable.appendChild(matrixToTableAux(matrix[i],'td',isThereId));    
    return objTable;
}

function matrixToTableAux(cellArray,cellType,isThereId){
    var tr=document.createElement('tr');
    var cell=new Array();
    var node=new Array();
    for (var i=0;i<cellArray.length;i++){
        if (isThereId && i==0) {
            tr.id=cellArray[i++];
        }
        cell[i]=document.createElement(cellType);
        node[i]=document.createTextNode(cellArray[i]);
        cell[i].appendChild(node[i]);
        tr.appendChild(cell[i]);       
    }
    return tr;
}

function addRowToTable(idTabla,row,isThereId){ 
    document.getElementById(idTabla).appendChild(addRowToTableAux(row,isThereId));    
}

function addRowToTableAux(row,isThereId){
    var tr=document.createElement('tr');
    var cell=new Array();
    var node=new Array();
    for (var i=0;i<row.length;i++){
        if (isThereId && i==0) 
            tr.id=row[i++];        
        cell[i]=document.createElement('td');
        node[i]=document.createTextNode(row[i]);
        cell[i].appendChild(node[i]);
        tr.appendChild(cell[i]);       
    }
    return tr;
}


/*
function matrixToExitTable(idTabla,matrix,isThereId){ 
    var objTable=document.getElementBy('table');
    objTable.id=idTabla;
    objTable.appendChild(matrixToTableAux(matrix[0],'th',isThereId));
    for (i=1; i < matrix.length; i++)
        objTable.appendChild(matrixToTableAux(matrix[i],'td',isThereId));    
    return objTable;
}

function matrixToExitTableAux(cellArray,cellType,isThereId){
    var tr=document.createElement('tr');
    var cell=new Array();
    var node=new Array();
    for (var i=0;i<cellArray.length;i++){
        if (isThereId && i==0) {
            tr.id=cellArray[i++];
        }
        cell[i]=document.createElement(cellType);
        node[i]=document.createTextNode(cellArray[i]);
        cell[i].appendChild(node[i]);
        tr.appendChild(cell[i]);       
    }
    return tr;
}*/

function strMatrixToExistTable(idTabla,strMatrix,separate1,separate2,thereIsTh){
    var rowArray=strMatrix.split(separate2);
    var objTable=document.getElementById(idTabla);
    var num=0;
    if (thereIsTh)
        objTable.appendChild(strMatrixToExistTableAux(rowArray[num++].split(separate1),'th'));
    
    for (i=num; i < rowArray.length; i++)
        objTable.appendChild(strMatrixToExistTableAux(rowArray[i].split(separate1),'td'));    
    return objTable;
}

function strMatrixToExistTableAux(cellArray,cellType){
    var tr=document.createElement('tr');
    var cell=new Array();
    var node=new Array();
    for (var i=0;i<cellArray.length;i++){
        cell[i]=document.createElement(cellType);
        node[i]=document.createTextNode(cellArray[i]);
        cell[i].appendChild(node[i]);
        tr.appendChild(cell[i]);
    }
    return tr;
}