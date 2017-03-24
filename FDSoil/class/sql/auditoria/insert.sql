INSERT INTO auditoria.auditoria_usuario(
            id_usuario,
            fecha,
            hora, 
            ip, 
            accion)
    VALUES ({fld:id_usuario},
             '{fld:fecha}',
             '{fld:hora}',
             '{fld:remote_addr}',
             '{fld:accion}');