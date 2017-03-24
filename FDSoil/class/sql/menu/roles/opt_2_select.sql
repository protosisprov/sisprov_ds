SELECT r1.id_menu_0, r2.id_menu_1, r2.id_menu_2 FROM seguridad.rol_2 r2
INNER JOIN seguridad.rol_1 r1 ON r2.id_menu_1=r1.id_menu_1 WHERE r2.id_rol={fld:id};
