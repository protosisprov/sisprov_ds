function inicio(strArrayMenu) {
    menu(strArrayMenu);
    var obj=new app();
    id_sistema(obj.name);
}

function valForm(){  
    
    var clave1=document.getElementById('id_clave1').value;
    var divErr1=document.getElementById('div_clave1');
    divErr1.innerHTML=(clave1=='')?'Debe Indicar la Clave Anterior...':'';
    
    var clave2=document.getElementById('id_clave2').value;
    var divErr2=document.getElementById('div_clave2');
    divErr2.innerHTML=(clave2=='')?'Debe Indicar la Nueva Clave...':'';
    
    var clave3=document.getElementById('id_clave3').value;
    var divErr3=document.getElementById('div_clave3'); 
    divErr3.innerHTML=(clave3=='')?'Debe Confirmar la Nuena Clave...':'';
    
    if (divErr1.innerHTML=='' && divErr2.innerHTML=='' && divErr3.innerHTML=='') 
        send_change_pass();
}

function val_clave(id_destino){     
    
    var clave1 = document.getElementById('id_clave2');
    var clave2 = document.getElementById('id_clave3');
    
    if (clave1.value != '' && clave2.value != '') {
        if (clave1.value != clave2.value) {
            document.getElementById(id_destino).innerHTML = 'Las claves no coinciden.';
        } else {
            document.getElementById(id_destino).innerHTML = '';
        }
    } else {
        document.getElementById(id_destino).innerHTML = '';
    }
}

function valNewClaveConfirme(){
    var clave2 = document.getElementById('id_clave2').value;
    var clave3 = document.getElementById('id_clave3').value;
    var divErr3 = document.getElementById('div_clave3');
    divErr3.innerHTML=(clave2!=clave3)?'Las claves no coinciden...':'';        
}