select count(bene.id_beneficiario) as Familia
from vsw_sector sec
LEFT JOIN beneficiario bene ON bene.parroquia_id = sec.cod_parroquia
 left JOIN unidad_familiar ufam ON ufam.beneficiario_id = bene.id_beneficiario
where  estado ilike '{fld:estado}'
group by estado
order by estado asc
