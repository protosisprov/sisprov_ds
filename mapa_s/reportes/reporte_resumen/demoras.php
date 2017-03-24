<?php
    session_start();
    header('Content-Type: text/html;charset=utf-8');
    include_once ('../../class/reporte_pdf_model.php');
    include_once ('../../class/mapa_model.php');

    //Variables utilizadas --------------------------------------
//    print_r($_GET);die;
    $_GET['estado'] = $_GET['estado'];
//    $_GET['order'] = $_POST['order'];
//    $_GET['sector'] = " and id_sector=".$_POST['sector_usuario'];
//    
    $obj = new mapa();
//    $obj->validar_session($_SESSION);
    //*********************************************************************************************************
    function cadena($cadena) {
        return strtoupper(utf8_decode($cadena));
    }
    
    function fecha_derecha($fecha) {
        $arr_fecha = explode("-",$fecha);
        $cadena = $arr_fecha[2]."/".$arr_fecha[1]."/".$arr_fecha[0];
        
        return $cadena;
    }
    
    function nulo($cadena) {
        if (($cadena=="") or ($cadena==NULL)) {
            $cadena=0;
        }
        return $cadena;
    }
    
    function Calcula($valor,$valor2) {
        $porcentaje = 0;
        if ($valor2==0) $valor2=1;
        if (($valor + $valor2) > 0) {
            $porcentaje = round((($valor * 100) / $valor2),2);
        }
        
        return $porcentaje;
    }
    
    function fornum2($valor) {
        $valor = number_format($valor,0, ',', '.');
        
        return $valor;
    }
    //*********************************************************************************************************
    
    $titulo = "Desarrollos Habitacionales por Estado";
    
    $cuadro =$obj->mostrar_desarrollo_parroquia($_GET);              
    $c1 = $obj->resultToArrayRegistro($cuadro);

    
//    $id['sector'] = $_POST['sector_usuario'];
//    $id['fecha1'] = $_POST['fecha_compa1'];
//    $id['fecha2'] = $_POST['fecha_compa2'];
    if ($c1[0]=="") {
        echo "<h3>NO EXISTEN DATOS</h3>";die;
    }

    $pdf = new reporte_pdf('L', 'pt', 'Letter');
    
    $pdf->SetTitle("Desarrollo_habitacional", true);
    $pdf->AddPage('l');
    $pdf->SetFont('Arial', '', 12);
    $Xaux = 35; //INICIO DE LA CELDA
    $Yaux = 5;
    $alto = 5;
    $posx = 25;
    $posy = 30;

//***************************************** PAGINA 1 *****************************************************************************
    $pdf->Image('../../img/desarrollo.png', 50, 50, 110, 40);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->setY(58);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Multicell(755, 15, utf8_decode($titulo), 0, 'C', false);
    $pdf->ln(10);   
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 116, 136);
    $pdf->SetFont('Arial', 'B', 14);
//    $pdf->Multicell(755, 15, ("Desarrollo Habitacionales "), 0, 'C', false);
    $pdf->ln(20);   

    $pdf->SetFillColor(0,152,192);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetAligns(array('C','C','C','C'));
    $pdf->SetX($Xaux);
    $pdf->SetWidths(array(350,200,150));
    $pdf->Row(array('Municipios','Parroquias','Desarrollos'), false, 'DF');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetAligns(array('L','C','C','C'));

    $cuadro =$obj->mostrar_desarrollo_parroquia($_GET);                     
    while ($c1 = $obj->extraer_arreglo($cuadro)){
        $c_nombre[] = $c1['municipio'];
        $c_cantidad[] = $c1['parroquia'];
//        $c_cantidad+= $c1['count'];
       
                
        $pdf->SetX($Xaux);
        $pdf->Row(array(utf8_decode($c1['municipio']),utf8_decode($c1['parroquia']),$c1['count']), false, 'DF');
        
    }
    
    $pdf->Output('Resumen por desarrollo.pdf', 'I'); 
?>
