function submitInsert(valor){
    relocate('../admin_menu_3n_row/index.php', {'id_n2':valor});    
}

function submitEdit(valor1,valor2){
    relocate('../admin_menu_3n_row/index.php', {'id':valor1,'id_n2':valor2});    
}

function submitDelete(valor){    
    if (confirm('¿Desea Eliminar Este Registro?'))    
        relocate('delete.php', {'id':valor});    
}
