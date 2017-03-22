<?php

class seniat
{

public function rif($rif)
{
    header('Content-type: text/html; charset=utf-8');
	$cadena_busqueda="";
	if( substr_count($rif, 'J')>0 || substr_count($rif, 'j')>0   || substr_count($rif, 'G')>0 || substr_count($rif, 'g')>0   || substr_count($rif, 'E')>0 || substr_count($rif, 'e')>0  || substr_count($rif, 'P')>0 || substr_count($rif, 'p')>0  || substr_count($rif, 'V')>0) 
            $cadena_busqueda="p_rif=$rif&p_cedula=";
	else
		$cadena_busqueda="p_rif=&p_cedula=$rif";
	$ch = curl_init('http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif='.$_GET['rif']); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');//esto si usa metodo GET
	//curl_setopt ($ch, CURLOPT_POST, 1);//esto si usa metodo POST
	//curl_setopt ($ch, CURLOPT_POSTFIELDS, $cadena_busqueda );
	/* Comentar estas dos lineas si no usa proxy */
        curl_setopt ($ch, CURLOPT_PROXY, "http://192.168.0.5");
        curl_setopt ($ch, CURLOPT_PROXYPORT, 8080);
	/* ----------------------------------------- */
	$codigo = curl_exec ($ch);
        //$arreglo = explode("Nombre", $codigo);
        $codigo = str_replace('"','' , $codigo );
        $arreglo = explode("Nombre", $codigo);
        $pru=substr($arreglo[1],1);
        echo $pru=  utf8_decode(substr($pru,0,strlen($pru)-6));
}

public function formato_rif($rif, $rif_form="")
{	$frif1="";$frif2="";
	if( substr_count($rif, '(')>0 && substr_count($rif, ')')>0 )
	{
		$frif1 = explode(" (", $rif);
		//$frif1 = str_replace(")","",$frif1[1]);
		$frif1 = $frif1[0];
		$frif1 = preg_replace("/(^J)(\d){9}[[:space:]]/","", $frif1);
		$frif1 = str_replace("\"","",  $frif1);
		$frif1 = preg_replace("/(^G)(\d){9}[[:space:]]/","", $frif1);
		
		

	}else
		$frif1 = $rif;
	
	$frif1 = preg_replace("/(^V)(\d){9}[[:space:]]/","", $frif1);

	$frif2 = $frif1 ;
	
	return $frif2;
}

}
?>
