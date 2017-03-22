SELECT id, titulo
FROM seguridad.menu_2
WHERE id_menu_1 = {fld:id_nivel_1} 
ORDER BY orden;
