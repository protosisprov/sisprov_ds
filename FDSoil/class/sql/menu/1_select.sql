SELECT m.id, m.id_menu_0, m.titulo, m.ruta 
FROM menu_rol.menu_1 as m 
JOIN menu_rol.rol_1 r ON m.id=r.id_menu_1
WHERE r.id_rol=2
ORDER BY id_menu_0,orden;
