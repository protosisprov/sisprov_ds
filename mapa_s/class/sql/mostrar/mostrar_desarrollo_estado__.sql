SELECT count(*)
FROM desarrollo a, vsw_sector b
where a.parroquia_id=b.cod_parroquia
AND estado ilike '{fld:estado}'