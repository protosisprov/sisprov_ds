SELECT m.id, m.orden, m.titulo as titulo1, m.ruta, s.descripcion as status
FROM seguridad.menu_3 as m 
JOIN seguridad.status s ON m.id_status=s.id
WHERE m.id={fld:id};