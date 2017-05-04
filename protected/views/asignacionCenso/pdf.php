<?php

function nombre($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_NOMBRE'];
}

function apellido($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_APELLIDO'];
}

function nacionalidadCedula($selec, $select2, $iD) {
    $saime = ConsultaOracle::getNacionalidadCedulaPersonaByPk($selec, $select2, (int) $iD);
    return $saime['NACIONALIDAD'] . " - " . $saime['CEDULA'];
}


    if($consultaNuevaPersona->fecha_nacimiento == null){ $nac="No Posee"; }else{    $nac=Yii::app()->dateFormatter->format("d/MM/y", strtotime($consultaNuevaPersona->fecha_nacimiento)); } 
    if($consultaNuevaPersona->telf_habitacion == null){ $tlf_h = "No Posee"; }else{$tlf_h =$consultaNuevaPersona->telf_habitacion; }
    if($consultaNuevaPersona->telf_celular == null){ $tlf_c = "No Posee"; }else{$tlf_c=$consultaNuevaPersona->telf_celular; }
    if($consultaNuevaPersona->correo_electronico == null){ $correo = "No Posee"; }else{$correo =$consultaNuevaPersona->correo_electronico; };

?>
<?php

$pdf = Yii::createComponent('application.vendors.mpdf.mpdf');
$cabecera = '<img src="' . Yii::app()->request->baseUrl . '/images/cintillo.jpg"/>';




$html.="<table align='right' width='100%' border='0'>       
                            <tr>
                                        <td colspan='3' align='center'><b><font size='6' color='#B40404'>Reporte de Asignación de Censo:</font><font size='6'> ".nombre('PRIMER_NOMBRE',$model->persona_id)." ".apellido('PRIMER_APELLIDO',$model->persona_id)." /" . date('d-m-Y') ." </font></td>
                                <br/>
                                <br/>
                            </tr>
                                        <tr><td colspan='3'></td></tr><tr><td colspan='3'></td></tr>
                                        <tr><td colspan='3'></td></tr><tr><td colspan='3'></td></tr>
                                        <tr><td colspan='3'></td></tr><tr><td colspan='3'></td></tr>
                                        <tr><td colspan='3'></td></tr><tr><td colspan='3'></td></tr>
            
                             <tr>
                                        <td colspan='3' align='center'><b>LUGAR A CENSAR</b></td>
                             </tr>
			<tr>
				<td>
					<span class='subtitulo'><b>Estado:</b></span> " . $model->desarrollo->fkParroquia->clvmunicipio0->clvestado0->strdescripcion . "
					<br>
					<span class='subtitulo'><b>Municipio:</b></span> " . $model->desarrollo->fkParroquia->clvmunicipio0->strdescripcion . "
					<br>
					<span class='subtitulo'><b>Parroquia:</b></span> " . $model->desarrollo->fkParroquia->strdescripcion . "
					<br>
					<span class='subtitulo'><b>Nombre del Desarrollo Habitacional:</b></span> " . $model->desarrollo->nombre . "
					<br>
					<span class='subtitulo'><b>Nombre de la Oficina:</b></span> " . $model->oficina->nombre . "
					<br>
					<span class='subtitulo'><b>Censado:</b></span> " . (($model->censado) ? 'SI' : 'NO') . "
					<br>
					<span class='subtitulo'><b>Fecha de Asignación:</b></span> " . Yii::app()->dateFormatter->format("d/M/y - hh:mm a", strtotime($data->fecha_asignacion)) . "
				</td>
                                 
				</tr>
                                <br/>
                                <br/>
			<tr>
                                 <td colspan='3' align='center'><b>PERSONA ASIGNADA</b></td>
			</tr>
                        <br/>
                                <br/>
			<tr>
				<td>                                   
                                        <span class='subtitulo'>Nombres:</span> ".$consultaNuevaPersona->primer_nombre." ".$consultaNuevaPersona->segundo_nombre."<br>
                                        <span class='subtitulo'>Apellidos:</span> ".$consultaNuevaPersona->primer_apellido." ".$consultaNuevaPersona->segundo_apellido."<br>
                                        <span class='subtitulo'>Cédula de Identidad:</span> &nbsp;&nbsp;".$consultaNuevaPersona->cedula."<br>
                                        <span class='subtitulo'>Fecha de Nacimiento:</span> &nbsp;".$nac."<br>
                                        <span class='subtitulo'>Teléfono Habitación:</span> &nbsp;&nbsp;".$tlf_h."<br>  
                                        <span class='subtitulo'>Teléfono Celular:</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tlf_c."<br> 
                                        <span class='subtitulo'>Correo Electrónico:</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$correo ."<br>  
				</td>
				
				
			</tr>
		</table>
	</center>
";

$mpdf = new mPDF('c', 'LETTER');
$mpdf->SetTitle(' Asignación de Censo N° ' . $model->id_asignacion_censo . ' ' . date('h:i:A') . '');
$mpdf->SetMargins(5, 50, 30);
$mpdf->SetAuthor('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetCreator('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetHTMLHeader($cabecera);
$mpdf->SetFooter('Generado desde el Sistema de Protocolización el ' . date('d-m-Y') . ' a las ' . date('h:i:A') . '' . Yii::app()->user->name . ' |                        Página {PAGENO}/{nbpg}');
$mpdf->WriteHTML($html);
$mpdf->Output('Asignacion_Censo-' . $model->id_asignacion_censo . ' .pdf', 'D');
exit;
?>
