<?php

$pdf = Yii::createComponent('application.vendors.mpdf.mpdf');

//Elimino los archivos creados en el directorio previamente para generar nuevos.

shell_exec('find . -name "*.zip" -type f -delete');
shell_exec('find . -name "*.pdf" -type f -delete');

$nombre_zip = rand(5, 15).'.zip';

$zip = new ZipArchive;

$zip->open("/var/www/sisprov_ds/pdf/".$nombre_zip,ZipArchive::CREATE);

foreach ($documentos as $documento ):

$cabecera = '<br> <img src="' . Yii::app()->request->baseUrl . '/images/cintillo.jpg"/> <br>';
$html= '<style type="text/css">
            .text-center{
                text-align: center;
            }
            
            
                #prueba
                
                {
                    font-family: Arial, Helvetica, sans-serif; 
                    font-size: 8px;
                    line-height: 10px;
                    
                    }
            p {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 16px;
                line-height: 32px;

            }
                
        
        </style>';

$html.= $documento['documento'];

$mpdf = new mPDF('c', 'LEGAL', '', '', 40, 30, 30,30);
$mpdf->SetTitle(' Documento N° ' . $documento['fk_beneficiario'] . ' - ' . date('h:i:A') . '');
$mpdf->SetAuthor('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetCreator('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetHTMLHeader($cabecera);
$mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 8pt; ">  {PAGENO}/{nbpg} </div>');
$mpdf->WriteHTML($html);
$mpdf->Output( '/var/www/sisprov_ds/pdf/Documento'.$documento['fk_beneficiario'].'.pdf', 'F'); 

$zip->addFile('/var/www/sisprov_ds/pdf/Documento'.$documento['fk_beneficiario'].'.pdf');

endforeach;

$zip->close();





?>

<?php
////exit;
//function descarga(){
//        $file = "/var/www/sisprov_ds/pdf/Zip5.zip";
//        $filename = "Zip3.zip";
//        header("Content-type: application/octet-stream");
//        header("Content-Type: application/force-download");
//        header("Content-Disposition: attachment; filename=\"$filename\"\n");
//}        
echo json_encode($nombre_zip);
?>
