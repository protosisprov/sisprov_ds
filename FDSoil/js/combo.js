function llenarCombo( obj, arreglo, separador, valor, texto){
    vaciarCombo( obj);
    if (valor!=null && texto!=null) 
        crearOpcion(obj, valor, texto);
    obj.innerHTML+=crearGrupoOpcion( arreglo, separador); 
}

function crearGrupoOpcion( arreglo, separador){
    var opciones = new Array();
    var rows = new Array();
    var optGroup = document.createElement('optgroup');
    for (i=0; i<(arreglo.length); i++){
        rows=arreglo[i].split(separador);
        opciones[i]=document.createElement("option");	
        opciones[i].value = rows[0].replace(/^\s*|\s*$/g,"");
        opciones[i].text = rows[1].replace(/^\s*|\s*$/g,"");
        if (rows[2]!=undefined){
            opciones[i].label = rows[2].replace(/^\s*|\s*$/g,"");
        }
        optGroup.appendChild(opciones[i]);
    }	
    return optGroup.innerHTML;

}

function crearOpcion(objeto, valor, texto){
    var opcion = document.createElement("option");
    opcion.value = valor;
    opcion.text = texto;
    objeto.options.add(opcion);
}

function vaciarCombo(combo){
    while(combo.options.length > 0){
        combo.options[combo.options.length-1] = null;
    }
}

function bubbleSort(inputArray, inputArray1, start, rest){
    for (var i = rest - 1; i >= start;  i--){
        for (var j = start; j <= i; j++){
            if (inputArray1[j+1] < inputArray1[j]){
                var tempValue = inputArray[j];
                var tempValue1 = inputArray1[j];
                inputArray[j] = inputArray[j+1];
                inputArray1[j] = inputArray1[j+1];
                inputArray[j+1] = tempValue;
                inputArray1[j+1] = tempValue1;
            }
        }
    }
    return inputArray;
}


function ClearList(OptionList, TitleName) 
{
    OptionList.length = 0;
}

function move(side, docFormObjLista, docFormObjSelected)
{   
    var temp1 = new Array();
    var temp2 = new Array();
    var tempa = new Array();
    var tempb = new Array();
    var current1 = 0;
    var current2 = 0;
    var y=0;
    var attribute;
    //assign what select attribute treat as attribute1 and attribute2
    if (side == "right")
    {  
        attribute1 = docFormObjLista; 
        attribute2 = docFormObjSelected;
    }
    else
    {  
        attribute1 = docFormObjSelected;
        attribute2 = docFormObjLista; 
    }
    //fill an array with old values seleccionados
    for (var i = 0; i < attribute2.length; i++)
    {  
        y=current1++
        temp1[y] = attribute2.options[i].value;
        tempa[y] = attribute2.options[i].text;
    //alert("valores viejos: "+tempa[y]);
    }
    //assign new values to arrays
    for (var i = 0; i < attribute1.length; i++)
    {   
        if ( attribute1.options[i].selected )
        {  
            //llena un vector con los valores todos seleccionados
            y=current1++
            temp1[y] = attribute1.options[i].value;
            tempa[y] = attribute1.options[i].text;
        //alert("valores seleccionados: "+tempa[y])
        }
        else
        {  
            //llena un vector con los valores no seleccionados
            y=current2++
            temp2[y] = attribute1.options[i].value; 
            tempb[y] = attribute1.options[i].text;
        //alert("valores NO seleccionados: "+tempb[y])
        }
    }
    //sort atribute2
    temp1=bubbleSort(temp1,tempa, 0, temp1.length - 1);
    //sort atribute1
    temp2=bubbleSort(temp2,tempb, 0, temp1.length - 1);
    //generating new options 
    ClearList(attribute2,attribute2);
    for (var i = 0; i < temp1.length; i++)
    {  
        attribute2.options[i] = new Option();
        attribute2.options[i].value = temp1[i];
        attribute2.options[i].text =  tempa[i];
    //alert("listbox2: "+attribute2.options[i].text);
    }
    //generating new options
    ClearList(attribute1,attribute1);
    if (temp2.length>0)
    {	
        for (var i = 0; i < temp2.length; i++)
        {   
            attribute1.options[i] = new Option();
            attribute1.options[i].value = temp2[i];
            attribute1.options[i].text =  tempb[i];
        //alert("listbox1: "+attribute1.options[i].text);
        }
    }
    return true;
}


function vacia_selected(docFormObjLista, docFormObjSelected){   
    var temp1 = new Array();
    var temp2 = new Array();
    var tempa = new Array();
    var tempb = new Array();
    var current1 = 0;
    var current2 = 0;
    var y=0;
    var attribute;
    //assign what select attribute treat as attribute1 and attribute2
    attribute1 = docFormObjSelected;
    attribute2 = docFormObjLista; 
    //fill an array with old values seleccionados
    for (var i = 0; i < attribute2.length; i++)
    {  
        y=current1++
        temp1[y] = attribute2.options[i].value;
        tempa[y] = attribute2.options[i].text;
    //alert("valores viejos: "+tempa[y]);
    }
    //assign new values to arrays
    for (var i = 0; i < attribute1.length; i++)
    {   
        //llena un vector con los valores de la lista
        y=current1++
        temp1[y] = attribute1.options[i].value;
        tempa[y] = attribute1.options[i].text;
    }
    //sort atribute2
    temp1=bubbleSort(temp1,tempa, 0, temp1.length - 1);
    //sort atribute1
    temp2=bubbleSort(temp2,tempb, 0, temp1.length - 1);
    //generating new options 
    ClearList(attribute2,attribute2);
    for (var i = 0; i < temp1.length; i++)
    {  
        attribute2.options[i] = new Option();
        attribute2.options[i].value = temp1[i];
        attribute2.options[i].text =  tempa[i];
    //alert("listbox2: "+attribute2.options[i].text);
    }
    //generating new options
    ClearList(attribute1,attribute1);
    if (temp2.length>0)
    {	
        for (var i = 0; i < temp2.length; i++)
        {   
            attribute1.options[i] = new Option();
            attribute1.options[i].value = temp2[i];
            attribute1.options[i].text =  tempb[i];
        //alert("listbox1: "+attribute1.options[i].text);
        }
    }
    return true;
}

function onOffHasta(objDesde, objHasta){
    if (objDesde.value!=0){
        objHasta.disabled=false;
        objHasta.length=1;
        var j=1;
        for (var i = 0; i < objDesde.length; i++){
            if (parseInt(objDesde.options[i].value) >= parseInt(objDesde.value)){
                objHasta.options[j] = new Option();
                objHasta.options[j].value = objDesde.options[i].value;
                objHasta.options[j].text = objDesde.options[i].text;
                j++;
            }
        }	
    }
    else{
        objHasta.disabled=true;
        objHasta.value = "0";
    }
}

function onOffDesdeHasta(objDesde, objHasta){
    objDesde.disabled=true;
    objDesde.value = "0";
    objHasta.disabled=true;
    objHasta.value = "0";
}

function checkIt(objCheck, objLista, objSelected ){
    if (objCheck.checked)	{
        objLista.disabled  = false;	
        objSelected.disabled  = false;
    }
    else{
        objLista.disabled = true;		
        objSelected.disabled = true;
        vacia_selected( objLista, objSelected);		
    }
    return false;
}

function mayorQ(desde, hasta, argumento) 
{
    if (desde == '' || hasta == '')
    {
        alert('Indique el rango del campo ' + argumento + ' .');
        return false;
    }
    else
    {
        if (hasta < desde)
        {
            alert("El campo 'Desde' debe ser menor que 'Hasta'" + argumento);
            return false;
        }
        else
        {
            alert("Ok, procesando informaci&oacute;n" + argumento);
            return true;
        }
    }	
}

function validar_combo(id_campo,id_mensaje,mensaje){
    obj=document.getElementById(id_campo);
    objmsj=document.getElementById(id_mensaje);
    if(obj.value == 0){
        objmsj.className="alert-danger";
        objmsj.innerHTML = ''+mensaje;
        return false;
    }
    else{
        objmsj.innerHTML = '';
        return true;
    }
}

function getValues(objForm, objStrArray){
	if (objForm.length!=0)
		for (i=0;i<objForm.length;i++)
			objStrArray.value=(i==0)?objForm.options[i].value:objStrArray.value+", "+objForm.options[i].value;   			
   	return objStrArray.value;
}
