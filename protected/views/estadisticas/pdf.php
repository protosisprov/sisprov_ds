<?php

$pdf = Yii::createComponent('application.vendors.mpdf.mpdf');
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

$html.= $documento;

$mpdf = new mPDF('c', 'LEGAL', '', '', 40, 30, 30,30);
$mpdf->SetTitle(' Documento N° ' . $id . ' - ' . date('h:i:A') . '');
$mpdf->SetAuthor('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetCreator('BANAVIH - Banco Nacional de Vivienda y Habitat');
$mpdf->SetHTMLHeader($cabecera);
$mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 8pt; ">  {PAGENO}/{nbpg} </div>');
$mpdf->WriteHTML($html);
$mpdf->Output('Documento-' . $id . ' .pdf', 'I');
exit;
?>