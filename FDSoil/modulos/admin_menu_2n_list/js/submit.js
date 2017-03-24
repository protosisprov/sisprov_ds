function submitInsert(valor){
    relocate('../admin_menu_2n_row/index.php', {'id_n1':valor});    
}

function submitEdit(valor1,valor2){
    relocate('../admin_menu_2n_row/index.php', {'id':valor1,'id_n1':valor2});    
}

function submitDelete(valor){    
    if (confirm('¿Desea Eliminar Este Registro?'))    
        relocate('delete.php', {'id':valor});    
}
