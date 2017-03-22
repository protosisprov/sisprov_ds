SELECT m.id, m.orden, m.titulo, m.ruta, s.descripcion as status 
FROM seguridad.menu_1 as m 
JOIN seguridad.status s ON m.id_status=s.id 
WHERE id_menu_0 = {fld:id_nivel_0} 
ORDER BY 2;
