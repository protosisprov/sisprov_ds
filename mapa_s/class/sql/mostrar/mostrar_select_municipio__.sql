SELECT cod_municipio,municipio
FROM vsw_sector b
where estado ilike '{fld:estado}'
group by cod_municipio,municipio
order by 2
