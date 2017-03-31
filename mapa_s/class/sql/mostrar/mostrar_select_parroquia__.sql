SELECT cod_parroquia,parroquia
FROM vsw_sector b
where  cod_municipio= {fld:municipio}
group by cod_parroquia,parroquia
order by 2