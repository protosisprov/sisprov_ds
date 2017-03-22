SELECT m.id, m.id_menu_2, m.titulo, m.ruta 
FROM menu_rol.menu_3 as m 
JOIN menu_rol.rol_3 r ON m.id=r.id_menu_3
WHERE r.id_rol=2
ORDER BY id_menu_2,orden;