UPDATE seguridad.usuario 
   SET correo='{fld:correo}', 
       celular='{fld:celular}', 
       telefono1='{fld:telefono1}', 
       telefono2='{fld:telefono2}', 
       pregunta_seguridad='{fld:pregunta_seguridad}', 
       respuesta_seguridad='{fld:respuesta_seguridad}'
 WHERE id={fld:id};