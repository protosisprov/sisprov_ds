SELECT m.id, m.id_menu_1, m.titulo, m.ruta FROM seguridad.menu_2 as m 
JOIN seguridad.rol_2 r ON m.id=r.id_menu_2 WHERE r.id_rol={fld:id} AND id_status=1 ORDER BY id_menu_1,orden;