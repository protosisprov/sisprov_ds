SELECT su.id AS id_usuario, su.usuario, su.clave, su.nombre, su.apellido, su.id_rol, 
su.id_status, su.cedula,su.dependencia
FROM seguridad.usuario su  
WHERE {fld:campo}='{fld:usuario}' AND clave='{fld:clave}'
GROUP BY su.id, su.usuario, su.clave, su.nombre, su.apellido, su.id_rol, 
su.id_status, su.cedula;