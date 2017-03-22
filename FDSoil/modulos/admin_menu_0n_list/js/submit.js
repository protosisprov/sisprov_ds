function submitEdit(valor){
    relocate('../admin_menu_0n_row/index.php', {'id':valor});    
}

function submitDelete(valor){
    if (confirm('¿Desea Eliminar Este Registro?'))    
        relocate('delete.php', {'id':valor});
}
