<?php

class ReporteAnalisisController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    /**
     * @return array action filters
     */
//    public function filters() {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//        );
//    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//    public function accessRules() {
//        return array(
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index', 'view'),
//                'users' => array('*'),
//            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create', 'update', 'BuscarMunicipios', 'BuscarParroquias'),
//                'users' => array('@'),
//            ),
//            array('allow', // allow admin user to perform 'admin' and 'delete' actions
//                'actions' => array('admin', 'delete'),
//                'users' => array('admin'),
//            ),
//            array('deny', // deny all users
//                'users' => array('*'),
//            ),
//        );
//    }

    public function filters() {
        return array(array('CrugeAccessControlFilter'));
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('*'),
                'users' => array('@'),
            ),
        );
    }

    public function actionIndex() {
$model = new Desarrollo('search');
//         $criteria = new CDbCriteria;
//         $model = Desarrollo::model()->findAll($criteria);
         $this->render('repoExcel', array('model' => $model));
    }

    public function actionRepoExcel() {

        
$connection = Yii::app()->db;
$sql = "select unidad_familiar_id, beneficiario_id, monto_inicial, monto_credito, sub_directo_habitacional, sub_vivienda_perdida, plazo_credito_ano,
nro_cuotas, monto_cuota_financiera, monto_cuota_f_total, monto_prima_inicial_fg, alicuota_fondo_garantia,
tasa_interes_id, tasa_fongar_id, fuente_financiamiento_id, monto_cuota_finan_requerida,  programa_id, maxima_capacidad_pago, diferencia_pago  
from analisis_credito ac
join unidad_familiar uf  ON uf.id_unidad_familiar = ac.unidad_familiar_id
join beneficiario be ON be.id_beneficiario = uf.beneficiario_id
where ac.estatus = 5 and ac.fuente_financiamiento_id = 3";
$command = $connection->createCommand($sql);
$dataReader = $command->query();
$rows = $dataReader->readAll();



        Yii::import('ext.phpexcel.XPHPExcel');
        $objPHPExcel = XPHPExcel::createPHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Banco Nacional de la Vivienda y Habitat - Banavih")
                ->setLastModifiedBy("Banco Nacional de la Vivienda y Habitat - Banavih")
                ->setTitle("Reporte generado desde sistema de protocolización")
                ->setSubject("Reporte generado desde sistema de protocolización")
                ->setDescription("Banco Nacional de la Vivienda y Habitat - Banavih");

        $estilo_etiquetas = new PHPExcel_Style();
        $estilo_etiquetas->applyFromArray(
                array('fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '1fb5ad')),
                    'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')),
                    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
                    'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),)));

        $objPHPExcel->getActiveSheet()->SetCellValue("A1", 'Sistema de Protolización y Regularización de la Vivienda');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->setSharedStyle($estilo_etiquetas, "A1:F1");
        $objPHPExcel->getActiveSheet()->SetCellValue("A2", 'Generado el día: ' . date('d-m-Y') . ' a las ' . date('h:i a') . ' por el usuario "' . Yii::app()->user->name . '"');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');

        $fila = 5;
//        $tamaño = $contador;
        $objPHPExcel->getActiveSheet()->setSharedStyle($estilo_etiquetas, "A$fila:S$fila");
        
        
//            $letra = "A";
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $fila, 'Nombre Completo');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $fila, 'Cédula');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $fila, 'Monto del Crédito');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $fila, 'Monto Inicial');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $fila, 'Sub. Directo Habitacional');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $fila, 'Sub.Vivienda Perdida');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $fila, 'Plazo del Crédito');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $fila, 'Diferencia de Pago');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $fila, 'Fongar');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $fila, 'Tasa Interés');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $fila, 'Tasa Fongar');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $fila, 'Fuente de Financiamiento');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $fila, 'Número de Cuotas');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $fila, 'Monto Cuota Financiera');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $fila, 'Monto Cuota Financiera Total');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $fila, 'Monto Prima Inicial Fongar');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $fila, 'Programa');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $fila, 'Máxima Capacidad de Pago');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $fila, 'Monto Cuota Financiera Requerida');
       // for ($i = 0; $i <= 3; $i++) {
        $i=0;$j=0;$k=0;$l=0;$m=0;$n=0;$o=0;$p=0;$q=0;$r=0;$s=0;$t=0;$u=0;$v=0;$w=0;$x=0;$y=0;$z=0;
        
         foreach ($rows as $key => $registro) {

            $model = Beneficiario::model()->findByPk($rows[$i++]['beneficiario_id']);
            $tasa = TasaInteres::model()->findByPk($rows[$q++]['tasa_interes_id']);
            $programa = Programa::model()->findByPk($rows[$x++]['programa_id']);
            $persona = (object) ConsultaOracle::getPersonaBeneficiario($model->beneficiarioTemporal->nacionalidad, $model->beneficiarioTemporal->cedula);
            
            $fila++;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A" . $fila, $model->beneficiarioTemporal->nombre_completo);
                if ($model->beneficiarioTemporal->nacionalidad == 97){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B" . $fila, 'V'.'-'.$model->beneficiarioTemporal->cedula);
                }else{
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B" . $fila, 'E'.'-'.$model->beneficiarioTemporal->cedula);
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C" . $fila, $rows[$j++]['monto_credito']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D" . $fila, $rows[$k++]['monto_inicial']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E" . $fila, $rows[$l++]['sub_directo_habitacional']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F" . $fila, $rows[$m++]['sub_vivienda_perdida']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G" . $fila, $rows[$n++]['plazo_credito_ano']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H" . $fila, $rows[$o++]['diferencia_pago']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I" . $fila, $rows[$p++]['alicuota_fondo_garantia']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J" . $fila, $tasa->tasa_interes);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K" . $fila, $rows[$r++]['tasa_fongar_id']);
                if ($rows[$s++]['fuente_financiamiento_id'] == 2){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L" . $fila, 'FAOV');
                }else{
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L" . $fila, 'FASP');
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M" . $fila, $rows[$t++]['nro_cuotas']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("N" . $fila, $rows[$u++]['monto_cuota_financiera']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("O" . $fila, $rows[$v++]['monto_cuota_f_total']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("P" . $fila, $rows[$w++]['monto_prima_inicial_fg']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Q" . $fila, $programa->nombre_programa);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("R" . $fila, $rows[$y++]['maxima_capacidad_pago']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("S" . $fila, $rows[$z++]['monto_cuota_finan_requerida']);
        }
//Auto ajusto todos los campos
        foreach (range(0, 99) as $col) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
             

        $nombrearchivo = "protocolizacion-" . date('Y-m-d-H_i_a') . ".xls";
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nombrearchivo . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;

    }
//fin accion armar excel

  
}
