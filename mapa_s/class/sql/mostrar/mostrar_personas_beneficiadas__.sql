select count(ufam.id_unidad_familiar) as personas
from vsw_sector sec
LEFT JOIN beneficiario bene ON bene.parroquia_id = sec.cod_parroquia
 left JOIN unidad_familiar ufam ON ufam.beneficiario_id = bene.id_beneficiario
 left join grupo_familiar gf ON ufam.id_unidad_familiar = gf.unidad_familiar_id
 where  estado ilike '{fld:estado}'