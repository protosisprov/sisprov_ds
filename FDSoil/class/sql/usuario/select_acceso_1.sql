SELECT su.id AS id_usuario, su.usuario, su.clave, su.nombre, su.apellido, su.id_rol, 
su.id_status, su.cedula, su.dependencia, MAX(id_auditoriausuario), to_char(fecha,'dd-mm-yyyy') || '-' || hora as ultima ,
accion FROM seguridad.usuario su
left join auditoria.auditoria_usuario a on a.id_usuario=su.id
WHERE {fld:campo}='{fld:usuario}' AND clave='{fld:clave}'
GROUP BY su.id, su.usuario, su.clave, su.nombre, su.apellido, su.id_rol, su.id_status, su.cedula, fecha, hora,accion,id_auditoriausuario
order by fecha desc
LIMIT 1
