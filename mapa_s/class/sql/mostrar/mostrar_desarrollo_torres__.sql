SELECT  
id_desarrollo,estado, municipio, parroquia,a.nombre as desarrollo, 
b.nombre as torre, b.total_unidades as viviendas,
sum(b.total_unidad_censada) as unidad_censada, sum(total_unidad_disponible) as unidad_disponible
FROM desarrollo a, unidad_habitacional b, vsw_sector c
where a.id_desarrollo=b.desarrollo_id
and  a.parroquia_id = c.cod_parroquia
and estado ilike '%{fld:estado}%'
group by id_desarrollo,estado, municipio, parroquia,a.nombre,b.nombre, b.total_unidades
order by 4

