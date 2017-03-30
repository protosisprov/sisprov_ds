SELECT m0.titulo as titulo0, m1.id, m1.titulo as titulo1  FROM seguridad.menu_1 m1
JOIN seguridad.menu_0 m0 ON m1.id_menu_0=m0.id 
WHERE m1.id = {fld:id};