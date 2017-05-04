<?php
	function nombre($selec,$iD){
	    $saime = ConsultaOracle::getPersonaByPk($selec,(int)$iD);
	    return $saime['PRIMER_NOMBRE'];
	}
	function apellido($selec,$iD){
	    $saime = ConsultaOracle::getPersonaByPk($selec,(int)$iD);
	    return $saime['PRIMER_APELLIDO'];
	}
        function nacionalidadCedula($selec,$select2,$iD){
	    $saime = ConsultaOracle::getNacionalidadCedulaPersonaByPk($selec,$select2,(int)$iD);
	    return $saime['NACIONALIDAD']." - ".$saime['CEDULA'];
	}

    $persona = Persona::model()->findByAttributes(array('nacionalidad' => $model->nacionalidad, 'cedula' => $model->cedula));
    if($persona->fecha_nacimiento == null){ $nac="No Posee"; }else{    $nac=Yii::app()->dateFormatter->format("d/MM/y", strtotime($persona->fecha_nacimiento)); } 
    if($persona->telf_habitacion == null){ $tlf_h = "No Posee"; }else{$persona->telf_habitacion; }
    if($persona->telf_celular == null){ $tlf_c = "No Posee"; }else{$persona->telf_celular; }
    if($persona->correo_electronico == null){ $correo = "No Posee"; }else{$persona->correo_electronico; };
    
    
    
?>

<?php

$pdf = Yii::createComponent('application.vendors.mpdf.mpdf');
$cabecera = '<img src="' . Yii::app()->request->baseUrl . '/images/cintillo.jpg"/>';


$html.="<table align='right' width='100%' border='0'>       
    <tr >
                
        <br/>
                <br/>
                </td>
            </tr>
            <tr><td colspan='3'></td></tr><tr><td colspan='3'></td></tr>
            <tr><td colspan='3'></td></tr><tr><td colspan='3'></td></tr>
            <tr><td colspan='3'></td></tr><tr><td colspan='3'></td></tr>
            <tr><td colspan='3'></td></tr><tr><td colspan='3'></td></tr>
            <tr>
            </tr>
             <tr>
                    <td colspan='3' align='center'><b>Datos Personales</b></td>
            </tr>
            <tr>
                    <td>
                            <span class='subtitulo'>Nombres y Apellidos:</span> ".$model->nombre_completo."<br>
                            <span class='subtitulo'>Cédula de Identidad:</span> &nbsp;&nbsp;".$persona->cedula."<br>
                            <span class='subtitulo'>Fecha de Nacimiento:</span> &nbsp;".$nac."<br>
                            <span class='subtitulo'>Teléfono Habitación:</span> &nbsp;&nbsp;".$persona->telf_habitacion."<br>  
                            <span class='subtitulo'>Teléfono Celular:</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$persona->telf_celular."<br> 
                            <span class='subtitulo'>Correo Electrónico:</span> &nbsp;&nbsp;&nbsp;&nbsp;".$persona->correo_electronico."<br>        
                    </td>
                    
            </tr>
             <tr>
                    <td colspan='3' align='center'><b>Desarrollo</b></td>
            </tr>
             <br/>
             <br/>
            <tr>
                    <td>
                            <span class='subtitulo'>Desarrollo:</span> ".$model->desarrollo->nombre."<br>
                            <span class='subtitulo'>Estado:</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$model->desarrollo->fkParroquia->clvmunicipio0->clvestado0->strdescripcion."<br>
                            <span class='subtitulo'>Municipio:</span> ".$model->desarrollo->fkParroquia->clvmunicipio0->strdescripcion."<br>
                            <span class='subtitulo'>Parroquia:</span> &nbsp;".$model->desarrollo->fkParroquia->strdescripcion."<br>
                            <span class='subtitulo'>Unidad Multifamiliar:</span> ".$model->unidadHabitacional->nombre."<br>
                            <span class='subtitulo'>Tipo de Inmueble:</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$model->unidadHabitacional->genTipoInmueble->descripcion."<br>
                            <span class='subtitulo'>Piso:</span> ".$model->vivienda->nro_piso."<br>
                            <span class='subtitulo'>Número de Vivienda:</span> ".$model->vivienda->nro_vivienda."<br>
                            <span class='subtitulo'>Fecha de Creación:</span> &nbsp;&nbsp;&nbsp;&nbsp;".date('d/m/Y', strtotime($model->fecha_creacion))."<br>
                            
                                
                    </td>
            </tr>
            
            
            </table>

";


$mpdf = new mPDF('c', 'LETTER');
$mpdf->SetTitle(' Beneficiario N° '.$model->id_beneficiario_temporal.' '.date('h:i:A') .'');
$mpdf->SetMargins(5, 50, 30);
$mpdf->SetAuthor('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetCreator('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetHTMLHeader($cabecera);

$mpdf->WriteHTML($html);
$mpdf->SetFooter('Generado desde el Sistema de Protocolización el ' . date('d-m-Y') . ' a las ' . date('h:i:A') . '' . Yii::app()->user->name . ' |                        Página {PAGENO}/{nbpg}');
$mpdf->Output('Beneficiario-'.$model->id_beneficiario_temporal.' .pdf','D');
exit;
?>
