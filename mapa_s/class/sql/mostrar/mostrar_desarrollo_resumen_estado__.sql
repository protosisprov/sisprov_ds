SELECT nombre, descripcion, urban_barrio || ', '|| 
av_call_esq_carr || ',' || zona as direccion
FROM desarrollo a, vsw_sector b
where a.parroquia_id=b.cod_parroquia
AND estado ilike '{fld:estado}'