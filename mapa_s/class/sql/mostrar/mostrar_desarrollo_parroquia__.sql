SELECT  municipio, parroquia, count(id_desarrollo)
FROM desarrollo a
RIGHT OUTER JOIN  vsw_sector b
ON a.parroquia_id=b.cod_parroquia
where estado ilike '{fld:estado}'
{fld:cadena}
group by estado,municipio, parroquia
order by 1