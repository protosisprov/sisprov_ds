SELECT m.id, m.titulo, m.ruta FROM seguridad.menu_0 as m 
JOIN seguridad.rol_0 r ON m.id=r.id_menu_0 WHERE r.id_rol={fld:id} AND id_status=1 ORDER BY orden; 