SELECT a.id, a.cedula, a.nombre, a.apellido, a.usuario, a.correo, b.descripcion as perfil, c.descripcion as estatus
FROM seguridad.usuario a INNER JOIN seguridad.roles b ON a.id_rol=b.id INNER JOIN seguridad.status c ON a.id_status=c.id
ORDER BY 2;
