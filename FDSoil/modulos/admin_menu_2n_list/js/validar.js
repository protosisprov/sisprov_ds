function inicio(strArrayMenu) {
    menu(strArrayMenu);
    var obj=new app();
    id_sistema(obj.name);
    valInsert(document.getElementById('id_nivel_0').value)
}

function valInsert(valor){
     if (valor!='null'){
        document.getElementById('id_img_add').disabled=false;
        document.getElementById('id_img_add').src="../../../FDSoil/images/32x32/nuevo.jpg";   
    }
    else{
        document.getElementById('id_img_add').disabled=true;
        document.getElementById('id_img_add').src="../../../FDSoil/images/32x32/nuevo-off.jpg";
    }  
}
