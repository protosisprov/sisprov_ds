select 
count(id_unidad_habitacional) , sum(a.total_unidades), sum(a.total_unidad_censada), sum(total_unidad_disponible)
from unidad_habitacional a, desarrollo b,
 vsw_sector c
where a.desarrollo_id=b.id_desarrollo
and  b.parroquia_id=c.cod_parroquia
and estado ilike '{fld:estado}'