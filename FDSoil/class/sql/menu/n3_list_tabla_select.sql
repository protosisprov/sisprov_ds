SELECT m.id, m.orden, m.titulo, m.ruta, s.descripcion as status 
FROM seguridad.menu_3 as m 
JOIN seguridad.status s ON m.id_status=s.id 
WHERE id_menu_2 = {fld:id_nivel_2} 
ORDER BY 2;
