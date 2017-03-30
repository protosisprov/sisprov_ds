SELECT m.id, m.orden, m.titulo, m.ruta, s.descripcion as status 
FROM seguridad.menu_2 as m 
JOIN seguridad.status s ON m.id_status=s.id 
WHERE id_menu_1 = {fld:id_nivel_1} 
ORDER BY 2;
