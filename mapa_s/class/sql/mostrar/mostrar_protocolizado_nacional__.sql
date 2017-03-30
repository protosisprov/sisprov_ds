select count(*) from vsw_documento_entregado a, beneficiario_temporal b
where a.persona_id=b.persona_id
and b.estatus=80