function submitInsert(valor){
//    alert(valor);
    relocate('../admin_menu_1n_row/', {'id_n0':valor});
}

function submitEdit(valor1,valor2){
    relocate('../admin_menu_1n_row/', {'id':valor1,'id_n0':valor2});    
}

function submitDelete(valor){    
    if (confirm('¿Desea Eliminar Este Registro?'))    
        relocate('delete.php', {'id':valor});    
}
