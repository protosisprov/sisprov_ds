function submitEdit(valor){
    relocate('../admin_usuario_row_admin/index.php', {'id':valor});    
}

function submitDelete(valor){
    if (confirm('¿Desea Eliminar Este Registro?'))    
        relocate('delete.php', {'id':valor});
}

function submitKeyReset(valor){
    if (confirm('¿Desea Resetear la Clave de Este Registro?'))    
        relocate('reset_key.php', {'id':valor});
}
