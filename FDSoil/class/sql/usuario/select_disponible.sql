select CASE WHEN count(id)=0 THEN true ELSE false END from seguridad.usuario where usuario='{fld:usuario}'
