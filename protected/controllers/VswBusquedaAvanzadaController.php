<?php

class VswBusquedaAvanzadaController extends Controller {
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

        /*
          $estado = new Tblestado;
          $municipio = new Tblmunicipio;
          $parroquia = new Tblparroquia;
         */
        $model = new VswBusquedaAvanzada( );
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['VswBusquedaAvanzada'])) {
            $model->attributes = $_GET['VswBusquedaAvanzada'];
            $datos = $model->search();

            if ($datos) {
                $suma = $this->actionArmaHojaCalculo($datos, $model);
            } else {
                Yii::app()->user->setFlash('success', "La consulta no devolvio resultados. Intente otra combinacion en los filtros.");
            }
        }//fin if $_GET['VswBusquedaAvanzada']

        $this->render('index', array('model' => $model));
    }

    public function actionArmaHojaCalculo($datos, $model) {
        
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

        //$objPHPExcel->getActiveSheet()->setSharedStyle($estilo_etiquetas, "A$fila:CJ$fila");
        $objPHPExcel->getActiveSheet()->setSharedStyle($estilo_etiquetas, "A$fila:BK$fila");

        foreach ($datos as $key => $registro) {

            $fila++;
            $letra = "A";
            
            //Extraer los campos que no se requieren en el reporte
            $arreglo_nuevo = $registro->attributes;
            unset($arreglo_nuevo['id_beneficiario_temporal']);
            unset($arreglo_nuevo['id_nacionalidad']);
            unset($arreglo_nuevo['id_estatus_adjudicado']);
            unset($arreglo_nuevo['id_desarrollo']);
            unset($arreglo_nuevo['cod_estado']);
            unset($arreglo_nuevo['cod_municipio']);
            unset($arreglo_nuevo['cod_parroquia']);
            unset($arreglo_nuevo['id_parcela']);
            unset($arreglo_nuevo['id_unidad_habitacional']);
            unset($arreglo_nuevo['id_vivienda']);
            unset($arreglo_nuevo['tipo_vivienda_id']);
            unset($arreglo_nuevo['id_fuente_financiamiento']);
            unset($arreglo_nuevo['id_programa']);
            unset($arreglo_nuevo['id_ente_ejecutor']);
            unset($arreglo_nuevo['id_beneficiario']);
            unset($arreglo_nuevo['condicion_trabajo_id']);
            unset($arreglo_nuevo['condicion_laboral_id']);
            unset($arreglo_nuevo['fuente_ingreso_id']);
            unset($arreglo_nuevo['relacion_trabajo_id']);
            unset($arreglo_nuevo['sector_trabajo_id']);
            unset($arreglo_nuevo['gen_cargo_id']);
            unset($arreglo_nuevo['cod_estado_anterior']);
            unset($arreglo_nuevo['cod_municipio_anterior']);
            unset($arreglo_nuevo['cod_parroquia_anterior']);
            unset($arreglo_nuevo['condicion_unidad_familiar_id']);
            unset($arreglo_nuevo['id_tipo_inmueble']);

            //foreach (array_keys($registro->attributes) as $etiqueta) {
            foreach (array_keys($arreglo_nuevo) as $etiqueta) {
                //Coloco las etiquetas
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra . "5", $model->attributeLabels()[$etiqueta]);
                //Coloco los valores
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra++ . $fila, $registro[$etiqueta]);
            }//fin foreach que recorre el registro
        }//fin foreach que recorre los datos y arma los valores en el Excel
//Auto ajusto todos los campos
        foreach (range(0, 99) as $col) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        //Agregar Imagen
        /* $objDrawing = new PHPExcel_Worksheet_Drawing();
          $objDrawing->setName('PHPExcel logo');
          $objDrawing->setDescription('PHPExcel logo');
          $objDrawing->setPath('./images/cintillo.jpg');       // filesystem reference for the image file
          $objDrawing->setWidth(300);                 // sets the image height to 36px (overriding the actual image height);
          $objDrawing->setHeight(130);                 // sets the image height to 36px (overriding the actual image height);
          $objDrawing->setCoordinates('A1');    // pins the top-left corner of the image to cell D24
          $objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); */

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

    public function actionBuscarMunicipios() {
        /* var_dump($_POST["VswBusquedaAvanzada"]["cod_estado"]);die();
          $Id = (isset($_POST['Tblestado']['clvcodigo']) ? $_POST['Tblestado']['clvcodigo'] : $_GET['clvcodigo']);
         */
        $Selected = isset($_GET['municipio']) ? $_GET['municipio'] : '';

        if (!empty($_POST["VswBusquedaAvanzada"]["cod_estado"])) {
            $criteria = new CDbCriteria;
            $criteria->addCondition('t.clvestado = :clvestado');
            $criteria->params = array(':clvestado' => $_POST["VswBusquedaAvanzada"]["cod_estado"]);
            $criteria->order = 't.strdescripcion ASC';
            $criteria->select = 'clvcodigo, strdescripcion';

            $data = CHtml::listData(Tblmunicipio::model()->findAll($criteria), 'clvcodigo', 'strdescripcion');
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('SELECCIONE'), true);
            foreach ($data as $id => $value) {
                if ($Selected == $id) {
                    echo CHtml::tag('option', array('value' => $id, 'selected' => true), CHtml::encode($value), true);
                } else {
                    echo CHtml::tag('option', array('value' => $id), CHtml::encode($value), true);
                }
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('SELECCIONE'), true);
        }
    }

    public function actionBuscarParroquias() {
        //  $Id = (isset($_POST['Tblmunicipio']['clvcodigo']) ? $_POST['Tblmunicipio']['clvcodigo'] : $_GET['municipio']);
        $Selected = isset($_GET['parroquia']) ? $_GET['parroquia'] : '';
        if (!empty($_POST["VswBusquedaAvanzada"]["cod_estado"])) {
            $criteria = new CDbCriteria;
            $criteria->addCondition('t.clvmunicipio = :clvmunicipio');
            $criteria->params = array(':clvmunicipio' => $_POST["VswBusquedaAvanzada"]["cod_estado"]);
            //$criteria->order = 't.parroquia ASC';
            $criteria->select = 'clvcodigo, strdescripcion';
            $data = CHtml::listData(Tblparroquia::model()->findAll($criteria), 'clvcodigo', 'strdescripcion');
            //var_dump($data);die;

            echo CHtml::tag('option', array('value' => ''), CHtml::encode('SELECCIONE'), true);
            foreach ($data as $id => $value) {
                if ($Selected == $id) {
                    echo CHtml::tag('option', array('value' => $id, 'selected' => true), CHtml::encode($value), true);
                } else {
                    echo CHtml::tag('option', array('value' => $id), CHtml::encode($value), true);
                }
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('SELECCIONE'), true);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    /*
      public function loadModel($id)
      {
      $model=VswBusquedaAvanzada::model()->findByPk($id);
      if($model===null)
      throw new CHttpException(404,'The requested page does not exist.');
      return $model;
      }
     */
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    /*
      protected function performAjaxValidation($model)
      {
      if(isset($_POST['ajax']) && $_POST['ajax']==='vsw-busqueda-avanzada-form')
      {
      echo CActiveForm::validate($model);
      Yii::app()->end();
      }
      }
     */
}
