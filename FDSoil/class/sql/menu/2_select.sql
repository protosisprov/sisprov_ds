SELECT m.id, m.id_menu_1, m.titulo, m.ruta 
FROM menu_rol.menu_2 as m 
JOIN menu_rol.rol_2 r ON m.id=r.id_menu_2
WHERE r.id_rol=2
ORDER BY id_menu_1,orden;