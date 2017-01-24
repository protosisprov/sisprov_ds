<?php

$persona = (object) ConsultaOracle::getPersonaBeneficiario($analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->nacionalidad, $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->cedula);
//Determinar nacionalidad
if (($analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->nacionalidad) == 97) {
    $nacionalidad = 'V';
} else {
    $nacionalidad = 'E';
}
?>
<?php

$pdf = Yii::createComponent('application.vendors.mpdf.mpdf');
$cabecera = '<img src="' . Yii::app()->request->baseUrl . '/images/cintillo.jpg"/>';



$html = "<table align='right'   width='100%' border='0'>     
                        <tr>
                        <td><font size='2'><i><b>Información General</b></i> </font><td>
                        <td align='left'><font size='2'><i><b>Fecha de Impresión: ".date('d-m-Y')." </b></i> </font><td>
                        </tr>
                        <tr>
                            <td colspan='4' align='center'><b><font size='5'>DATOS DEL BENEFICIARIO</br></br></font></td>
                        </tr>		
        </table> 
        
        <table   width='100%' border='0'>       
                        <tr style='background:#E5E2E2' >
                            <td colspan='4'><b>Nombres y Apellidos: </b>" . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->nombre_completo . "</td>
                        </tr>
                        <tr style='background:#E5E2E2' >
                            <td colspan='2'><b>Cédula: </b>" . $nacionalidad . " - " . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->cedula . "</td>
                            <td colspan='2' align='rigth'><b>Telefonos:</b> " . $persona->CODIGO_HAB . "-" . $persona->TELEFONOHAB . "/" . $persona->CODIGO_MOVIL . "-" . $persona->TELEFONOMOVIL . "</td>
                        </tr>
                        <tr style='background:#E5E2E2' >
                            <td colspan='4'><b>Desarrollo Habitacional:</b> " . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->desarrollo->nombre . "</td>
                        </tr>
                        <tr style='background:#E5E2E2' >
                             <td colspan='4'>
                            <b>Dirección:</b> 
                             Urbanización " . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->desarrollo->urban_barrio .
        "; Avenida/Calle/Esquina/Carretera " . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->desarrollo->av_call_esq_carr .
        ";<br/>Estado: " . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->desarrollo->fkParroquia->clvmunicipio0->clvestado0->strdescripcion .
        "; Municipio: " . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->desarrollo->fkParroquia->clvmunicipio0->strdescripcion .
        "; Parroquia: " . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->desarrollo->fkParroquia->strdescripcion .
        "</td>
                        </tr>

        </table> <br/> <br/>
";
//.($analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->fkNacionalidad->descripcion=='VENEZOLANO')?'V':'E';


$html.=$htmlprincipal;



$html.= $tablaAmortiz;





$mpdf = new mPDF('c', 'LETTER');
$mpdf->SetMargins(5, 50, 30);
$mpdf->SetAuthor('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetCreator('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetHTMLHeader($cabecera);
$mpdf->SetFooter('Generado desde el SISPROV el ' . date('d-m-Y') . ' a las ' . date('h:i:A') . ' ' . Yii::app()->user->name . ' |                        Página {PAGENO}/{nbpg}');
//$mpdf->SetTitle(' Desarrollo Habitacional N° '.$analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->desarrollo->id_desarrollo.' - '.$analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->desarrollo->nombre.' '.date('h:i:A') .'');
$mpdf->WriteHTML($html);
$mpdf->Output('Tabla_amortizacion_' . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->cedula . '.pdf', 'D');
exit;
?>