<?php

class PdfEstadisticas
{
    
    private $pdf;
    private $cintillo;
    private $footer;
    public  $orientacion;
    public  $nombreArchivo;
    public  $subTitulo;
    
    
    public function __construct() {
        $this->pdf = Yii::createComponent('application.vendors.mpdf.mpdf');
        $this->cintillo = '<img src="' . Yii::app()->request->baseUrl . '/images/cintillo.jpg"/>';
        $this->footer = 'Generado desde el Sistema de Protocolización el ' . date('d-m-Y') . ' a las ' . date('h:i:A') . ' / ' . Yii::app()->user->name . ', Página - ' .'{PAGENO}/{nbpg}';
        $this->orientacion = 'vertical';
        $this->nombreArchivo = 'ReporteEstadistico';
        
    }
    
    public function imprimirPdf($titulo, $contenido)
    {
        if($this->orientacion == 'horizontal')
            $mpdf = new mPDF('c', 'LETTER-L');
        else
            $mpdf = new mPDF('c', 'LETTER');
            
        $mpdf->SetTitle($titulo);
        $mpdf->SetMargins(5, 50, 30);
        $mpdf->SetAuthor('BANAVIH - Banco Nacional de Vivienda y Habitat');
        $mpdf->SetCreator('BANAVIH - Banco Nacional de Vivienda y Habitat');
        $mpdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$this->cintillo.'</div>','O', true);
        $mpdf->SetFooter($this->footer);
        if(empty($this->subTitulo))
            $html= '<table align="center"><tr><td><h1>'.$titulo.'</h1></td></tr></table>';
        else
            $html= '<table align="center"><tr><td><h1>'.$titulo.'</h1></td></tr><tr><td align="center"><h4>'.$this->subTitulo.'</h4></td></tr></table>';
        $html.=$contenido;
        $mpdf->WriteHTML($html);
        
        //Se eliminan las imagenes de los graficos que se crearon temporalmente para imprimir el pdf
        $mask = "*.png";
        array_map("unlink", glob("images/estadisticas_temp/".$mask));
        
        //Imprime el archivo pdf
        $mpdf->Output($this->nombreArchivo.'.pdf','D');
        exit;
    }
    
}

