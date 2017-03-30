select usuario,correo,cedula,nombre,apellido,pregunta_seguridad,respuesta_seguridad,id 
from seguridad.usuario 
where cedula='{fld:cedula}' and correo='{fld:correo}';