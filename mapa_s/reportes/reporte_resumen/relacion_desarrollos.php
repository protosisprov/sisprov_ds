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
    
    $titulo = "Relación de Desarrollos Habitacionales";
    
    $cuadro =$obj->mostrar_desarrollo_torres($_GET);              
    $c1 = $obj->resultToArrayRegistro($cuadro);

    
//    $id['sector'] = $_POST['sector_usuario'];
//    $id['fecha1'] = $_POST['fecha_compa1'];
//    $id['fecha2'] = $_POST['fecha_compa2'];
    if ($c1[0]=="") {
//        echo "<>NO EXISTEN DATOS</h3>";die;
        
         echo "<p style='color: #3c763d;
                background-color: #dff0d8; padding: 15px;
                margin-bottom: 20px;
                border: 1px solid transparent;
                border-radius: 4px;
                border-color: #d6e9c6;'><strong>NO EXISTEN DATOS A RELACIONAR EN EL PDF</strong>
                <button type='button' onclick='window.close()'>Cerrar</button>
                </p>";die;
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
    $pdf->Multicell(755, 15, ("En el Estado: ".utf8_decode($_GET['estado'])), 0, 'C', false);
    $pdf->ln(20);   

    $pdf->SetFillColor(0,152,192);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetAligns(array('C','C','C','C','C','C','C'));
    $pdf->SetX($Xaux);
    $pdf->SetWidths(array(100,100,150,150,60,60,100));
    $pdf->Row(array('Municipio','Parroquia','Desarrollo Habitacional', 'Unidad Familiar', 'Viviendas','Censadas', 'Disponible por Adjudicar'), false, 'DF');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetAligns(array('L','L','L','L','C','C','C'));
    //Difinicion de las variables de acumulacion
    $c_viviendas=0;
    $c_censadas=0;
    $c_disponible=0;
    
    $cuadro =$obj->mostrar_desarrollo_torres($_GET);                     
    while ($c1 = $obj->extraer_arreglo($cuadro)){
        $c_viviendas += $c1['viviendas'];
        $c_censadas += $c1['unidad_censada'];
        $c_disponible+= $c1['unidad_disponible'];
   
        $pdf->SetX($Xaux);
        $pdf->Row(array(utf8_decode($c1['municipio']),utf8_decode($c1['parroquia']),utf8_decode($c1['desarrollo']),$c1['torre'],$c1['viviendas'],$c1['unidad_censada'],$c1['unidad_disponible']), false, 'DF');
        
    }
        $pdf->SetFillColor(0,152,192);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetAligns(array('C','C','C','C','C','C'));
    $pdf->SetX($Xaux);
    $pdf->SetWidths(array(500,60,60,100));
    $pdf->Row(array('Total', $c_viviendas,$c_censadas,$c_disponible), false, 'DF');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetAligns(array('L','L','L','L','C','C','C'));
 
    
    $pdf->Output('Resumen por desarrollo.pdf', 'I'); 
?>