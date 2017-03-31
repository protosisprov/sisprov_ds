select
b.nombre as nombre_desarrollo, a.nombre as unidad_familiar, 
urban_barrio || ' ' || av_call_esq_carr || ' ' || zona as direccion, e.descripcion, cedula, nombre_completo
from unidad_habitacional a, desarrollo b, beneficiario_temporal c,
 vsw_sector d, maestro e
where a.desarrollo_id=b.id_desarrollo
and c.desarrollo_id=b.id_desarrollo
and  b.parroquia_id=d.cod_parroquia
and c.nacionalidad=e.id_maestro
and  estado ilike '%{fld:estado}%'