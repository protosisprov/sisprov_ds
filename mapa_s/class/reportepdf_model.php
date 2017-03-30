<?php

header('Content-Type: text/html;charset=utf-8');
define('FPDF_FONTPATH', '../../../FDSoil/packs/fpdf/font/');
require('../../../FDSoil/packs/fpdf/fpdf.php');
require('../../../FDSoil/packs/jpgraph/src/jpgraph.php');
require('../../../FDSoil/packs/jpgraph/src/jpgraph_pie.php');
require('../../../FDSoil/packs/jpgraph/src/jpgraph_pie3d.php');
include_once('../../../FDSoil/class/menu.model.php');

class reporte_pdf extends FPDF {
    public function __construct($orientation='P', $unit='mm', $format='A4')  {
       parent::__construct($orientation, $unit, $format);
     } 
    public function gaficoPDF($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL) { 
        //construccion de los arrays de los ejes x e y
        if(!is_array($datos) || !is_array($ubicacionTamamo)){
         echo "los datos del grafico y la ubicacion deben de ser arreglos";
        }
        elseif($nombreGrafico == NULL){
         echo "debe indicar el nombre del grafico a crear";
        }
        else{ 
         #obtenemos los datos del grafico  
         foreach ($datos as $key => $value){
          $data[] = $value[0];
          $nombres[] = $key; 
          $color[] = $value[1];
         } 
         $x = $ubicacionTamamo[0];
         $y = $ubicacionTamamo[1]; 
         $ancho = $ubicacionTamamo[2];  
         $altura = $ubicacionTamamo[3];  
         #Creamos un grafico vacio
         $graph = new PieGraph(600,400);
         #indicamos titulo del grafico si lo indicamos como parametro
         if(!empty($titulo)){
          $graph->title->Set($titulo);
         }   
         //Creamos el plot de tipo tarta
         $p1 = new PiePlot3D($data);
         $p1->SetSliceColors($color);
         #indicamos la leyenda para cada porcion de la tarta
         $p1->SetLegends($nombres);
         //Añadirmos el plot al grafico
         $graph->Add($p1);
         //mostramos el grafico en pantalla
         $p1->ShowBorder();
         $p1->ExplodeSlice(1);
         $graph->Stroke("$nombreGrafico.png"); 
         $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);  
        } 
    } 
    
    function Header() {
        
        // Select Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Framed title
        $this->Cell(30, 10, 'Title', 1, 0, 'C');
        // Line break
        $this->Ln(70);
        if($this->orientacion=='p'){
            $this->Image('../../../FDSoil/images/header.jpg', 10, 10, 580, 50);
        }else if($this->orientacion=='l'){
            $this->Image('../../../FDSoil/images/header.jpg', 55, 10, 680, 50);
        }
        $this->SetX(50);
        
    }

    function Footer() {
        // Go to 1.5 cm from bottom
        // Select Arial italic 8
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'I', 8);
        $this->SetY(-40);
        if($this->orientacion=='p'){
            $this->Write(5, '___________________________________________________________________________________________________________________');
        }else if($this->orientacion=='l'){
            $this->Write(5, '____________________________________________________________________________________________________________________________________________________');
        }
        $this->SetY(-30);
        $this->Write(5, utf8_decode('Ministerio del Poder Popular para Transporte Acuático y Aéreo. RIF.G-20010006-0'));
        // Print centered page number
        $this->AliasNbPages();
        $this->Cell(250, 10, 'Pagina ' . $this->PageNo().'/{nb}', 0, 0, 'R');
    }
    
    function titulo($text,$pdf,$Xaux) {
        $pdf->SetAltura_celda(14);
        if($this->orientacion=='p'){
            $pdf->SetWidths(array(520));
        }else if($this->orientacion=='l'){
            $pdf->SetWidths(array(710));
        }
        $pdf->SetFillColor(186, 49, 49);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetAligns(array('C'));
        $pdf->SetX($Xaux);
        $pdf->Row(array(utf8_decode($text)), false, 'DF');
    }
    
    function cabecera($pdf, $posx, $posY, $titulo, $longitud, $posicion){
        $Xaux = $posx;
        $Yaux = $posY;
        $pdf->SetY($Yaux);
        
        $Yaux=$pdf->GetY();
        $pdf->SetX($Xaux);
        $pdf->SetFont('Arial', '', 12);      
        $pdf->SetFillColor(195, 200, 200);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetWidths($longitud);
        $pdf->SetAligns($posicion);
        $pdf->Row($titulo,false,'DF');
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
 
        }

    function BasicTable($data) {
        $cantcelda = 0;
        foreach ($data as $row) {
            foreach ($row as $col)
                $cantcelda++;
            $this->Cell(100, 7, ($this->Cell(7, 7, '', 1, 0, 'L')) . $col, 0, 0, 'L');
            if ($cantcelda == 5) {
                $cantcelda = 0;
                $this->Ln();
            }
        }
    }
     
    function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle = 0) {
        $font_angle+=90 + $txt_angle;
        $txt_angle*=M_PI / 180;
        $font_angle*=M_PI / 180;
        $txt_dx = cos($txt_angle);
        $txt_dy = sin($txt_angle);
        $font_dx = cos($font_angle);
        $font_dy = sin($font_angle);
        $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', $txt_dx, $txt_dy, $font_dx, $font_dy, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        if ($this->ColorFlag)
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        $this->_out($s);
    }
    
    function printArreglo($result, $posx, $posy, $espaciadox, $long_cell) {
        $Xaux = 0;
        $Yaux = 0;
        $longitud = $espaciadox + $long_cell;
        $obj = new menu();
        $this->SetY($posy);
        $Ytem = 0;
        while ($row = $obj->extraer_registro($result)) {
            $Xaux = $posx;
            $Yaux = $this->GetY();
            for ($i = 0; $i < count($row); $i++) {
                $this->SetY($Yaux);
                $this->SetX($Xaux);
                $this->SetFont('Arial', '', 10);
                $this->Multicell($long_cell, 12, utf8_decode($row[$i]), 1,1, 'J', true);
                if ($Ytem < $this->GetY())
                    $Ytem = $this->GetY();
                $Xaux+=$longitud;
            }
            $this->SetY($Ytem);
            //$this->ln();        
        }
    }

    //-----------------------
     var $widths;
     var $aligns;
     var $altura_celda =0;

    function SetWidths($w) {

//Set the array of column widths

        $this->widths = $w;
    }
    function SetAltura_celda($h) {

//Set the array of column widths

        $this->altura_celda = $h;
    }

    function SetAligns($a) {

//Set the array of column alignments

        $this->aligns = $a;
    }

    function fill($f) {

//juego de arreglos de relleno

        $this->fill = $f;
    }

    function Row($data, $fill, $style) {

//Calculate the height of the row

        $nb = 0;

        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));

       // $nb++;
        if($this->altura_celda==0){
                $this->altura_celda=$this->FontSize+2;
            }
        $h = $this->altura_celda * $nb;

//Issue a page break first if needed

        //$this->CheckPageBreak($h);

//Draw the cells of the row

        for ($i = 0; $i < count($data); $i++) {

            $w = $this->widths[$i];

            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

//Save the current position

            $x = $this->GetX();

            $y = $this->GetY();

//Draw the border

            $this->Rect($x, $y, $w, $h, $style);

//Print the text
            
            $this->MultiCell($w, $this->altura_celda, $data[$i], 'LTR' ,$a ,$fill);

//Put the position to the right of the cell

            $this->SetXY($x + $w, $y);
        }

//Go to the next line

        $this->Ln($h);
    }

    function CheckPageBreak($h) {

//If the height h would cause an overflow, add a new page immediately

        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($long_x, $txt) {

//Computes the number of lines a MultiCell of width w will take

        $cw = &$this->CurrentFont['cw'];

        if ($long_x == 0)
            $long_x = $this->w - $this->rMargin - $this->x;

        $wmax = ($long_x - 2 * $this->cMargin) * 1000 / $this->FontSize;

        $cadena = str_replace("\r",'',$txt);

        $nb = strlen($cadena);

        if ($nb > 0 and $cadena[$nb - 1] == "\n")
            $nb--;

        $sep = -1;

        $i = 0;

        $j = 0;

        $l = 0;

        $nl = 1;

        while ($i < $nb) {

            $c = $cadena[$i];

            if ($c == "\n") {

                $i++;

                $sep = -1;

                $j = $i;

                $l = 0;

                $nl++;

                continue;
            }

            if($c==' ')

            $sep = $i;

            $l+=$cw[$c];

            if ($l > $wmax) {

                if ($sep == -1) {

                    if ($i == $j)
                        $i++;
                }

                else
                    $i = $sep + 1;

                $sep = -1;

                $j = $i;

                $l = 0;

                $nl++;
            }

            else
                $i++;
        }

        return $nl;
 }

function leerArANDdir($ruta)
{
    // comprobamos si lo que nos pasan es un direcotrio
    if (is_dir($ruta))
    {
        
        // Abrimos el directorio y comprobamos que
        if ($aux = opendir($ruta))
        {
            while (($archivo = readdir($aux)) !== false)
            {
                // Si quisieramos mostrar todo el contenido del directorio pondríamos lo siguiente:
                // echo '<br />' . $file . '<br />';
                // Pero como lo que queremos es mostrar todos los archivos excepto "." y ".."
                if ($archivo!="." && $archivo!="..")
                {
                    $ruta_completa = $ruta . '/' . $archivo;
 
                    if (is_dir($ruta_completa))
                    {
                       // echo "<br /><strong>Directorio:</strong> " . $ruta_completa;
                        leerArANDdir($ruta_completa . "/");
                    }
                    else
                    {
                        
                        return  $archivo;//."<br>";
                    }
                }
            }
 
            closedir($aux);
 
            // Tiene que ser ruta y no ruta_completa por la recursividad
           // echo "<strong>Fin Directorio:</strong>" . $ruta . "<br /><br />";
        }
    }
    else
    {
        echo "<br />No es ruta valida";
    }
}

function Code39($xpos, $ypos, $code, $baseline=7, $height=40){

$wide = $baseline;

$narrow = $baseline / 3 ;
$gap = $narrow;

$barChar['0'] = 'nnnwwnwnn';
$barChar['1'] = 'wnnwnnnnw';
$barChar['2'] = 'nnwwnnnnw';
$barChar['3'] = 'wnwwnnnnn';
$barChar['4'] = 'nnnwwnnnw';
$barChar['5'] = 'wnnwwnnnn';
$barChar['6'] = 'nnwwwnnnn';
$barChar['7'] = 'nnnwnnwnw';
$barChar['8'] = 'wnnwnnwnn';
$barChar['9'] = 'nnwwnnwnn';
$barChar['A'] = 'wnnnnwnnw';
$barChar['B'] = 'nnwnnwnnw';
$barChar['C'] = 'wnwnnwnnn';
$barChar['D'] = 'nnnnwwnnw';
$barChar['E'] = 'wnnnwwnnn';
$barChar['F'] = 'nnwnwwnnn';
$barChar['G'] = 'nnnnnwwnw';
$barChar['H'] = 'wnnnnwwnn';
$barChar['I'] = 'nnwnnwwnn';
$barChar['J'] = 'nnnnwwwnn';
$barChar['K'] = 'wnnnnnnww';
$barChar['L'] = 'nnwnnnnww';
$barChar['M'] = 'wnwnnnnwn';
$barChar['N'] = 'nnnnwnnww';
$barChar['O'] = 'wnnnwnnwn';
$barChar['P'] = 'nnwnwnnwn';
$barChar['Q'] = 'nnnnnnwww';
$barChar['R'] = 'wnnnnnwwn';
$barChar['S'] = 'nnwnnnwwn';
$barChar['T'] = 'nnnnwnwwn';
$barChar['U'] = 'wwnnnnnnw';
$barChar['V'] = 'nwwnnnnnw';
$barChar['W'] = 'wwwnnnnnn';
$barChar['X'] = 'nwnnwnnnw';
$barChar['Y'] = 'wwnnwnnnn';
$barChar['Z'] = 'nwwnwnnnn';
$barChar['-'] = 'nwnnnnwnw';
$barChar['.'] = 'wwnnnnwnn';
$barChar[' '] = 'nwwnnnwnn';
$barChar['*'] = 'nwnnwnwnn';
$barChar['$'] = 'nwnwnwnnn';
$barChar['/'] = 'nwnwnnnwn';
$barChar['+'] = 'nwnnnwnwn';
$barChar['%'] = 'nnnwnwnwn';

$this->SetFont('Arial','',10);
$this->Text($xpos, $ypos + $height + 2, $code);
$this->SetFillColor(0);

$code = '*'.strtoupper($code).'*';
for($i=0; $i<strlen($code); $i++){
$char = $code[$i];
if(!isset($barChar[$char])){
$this->Error('Invalid character in barcode: '.$char);
}
$seq = $barChar[$char];
for($bar=0; $bar<9; $bar++){
if($seq[$bar] == 'n'){
$lineWidth = $narrow;
}else{
$lineWidth = $wide;
}
if($bar % 2 == 0){
$this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
}
$xpos += $lineWidth;
}
$xpos += $gap;
}
} 
    
}
?>