select count(bene.id_beneficiario) as Familia
from vsw_sector sec
LEFT JOIN desarrollo des ON des.parroquia_id = sec.cod_parroquia
LEFT JOIN beneficiario_temporal btem ON btem.desarrollo_id = des.id_desarrollo
LEFT JOIN beneficiario bene ON bene.beneficiario_temporal_id = btem.id_beneficiario_temporal
LEFT JOIN unidad_familiar ufam ON ufam.beneficiario_id = bene.id_beneficiario
where  estado ilike '{fld:estado}'
group by estado
order by estado asc