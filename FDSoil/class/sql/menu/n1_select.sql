SELECT m.id, m.id_menu_0, m.titulo, m.ruta FROM seguridad.menu_1 as m 
JOIN seguridad.rol_1 r ON m.id=r.id_menu_1 WHERE r.id_rol={fld:id} AND id_status=1 ORDER BY id_menu_0,orden;