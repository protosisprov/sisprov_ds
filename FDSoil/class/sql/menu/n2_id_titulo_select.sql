SELECT m0.titulo as titulo0, m1.titulo as titulo1, m2.id, m2.titulo as titulo2  FROM seguridad.menu_2 m2
JOIN seguridad.menu_1 m1 ON m2.id_menu_1 = m1.id
JOIN seguridad.menu_0 m0 ON m1.id_menu_0 = m0.id 
WHERE m2.id = {fld:id};