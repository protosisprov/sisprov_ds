SELECT m.id, m.orden, m.titulo, m.ruta, s.descripcion as status
FROM seguridad.menu_0 as m 
--JOIN menu_rol.rol_0 r ON m.id=r.id_menu_0
JOIN seguridad.status s ON m.id_status=s.id
WHERE m.id={fld:id};
