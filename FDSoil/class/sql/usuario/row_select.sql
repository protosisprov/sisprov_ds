SELECT  id, usuario, 
        correo, 
        cedula, 
        nombre, 
        apellido, 
        substring(cedula,1,1) as nacionalidad, 
        substring(cedula,2,length(cedula)) as ced, 
        celular, 
        telefono1, 
        telefono2, 
        id_rol, 
        id_status, 
        pregunta_seguridad, 
        respuesta_seguridad,
        dependencia
FROM seguridad.usuario
WHERE id={fld:id};