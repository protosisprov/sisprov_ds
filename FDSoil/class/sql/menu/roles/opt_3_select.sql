SELECT r1.id_menu_0,r2.id_menu_1, r3.id_menu_2, r3.id_menu_3 FROM seguridad.rol_3 r3
INNER  JOIN  seguridad.rol_2 r2  ON r3.id_menu_2=r2.id_menu_2
INNER  JOIN  seguridad.rol_1 r1  ON r2.id_menu_1=r1.id_menu_1
WHERE r3.id_rol={fld:id};

