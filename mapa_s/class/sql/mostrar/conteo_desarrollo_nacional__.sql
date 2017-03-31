SELECT estado, count(id_desarrollo), round(count(id_desarrollo)::numeric*100/{fld:id}::numeric,2) || '%' as procentaje, cod_estado
FROM desarrollo a
RIGHT OUTER JOIN  vsw_sector b
ON a.parroquia_id=b.cod_parroquia
group by estado,cod_estado
order by 1