SELECT m.id, m.id_menu_2, m.titulo, m.ruta FROM seguridad.menu_3 as m 
JOIN seguridad.rol_3 r ON m.id=r.id_menu_3 WHERE r.id_rol={fld:id} AND id_status=1 ORDER BY id_menu_2,orden;