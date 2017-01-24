<?php

class ViviendaController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array('accessControl', array('CrugeAccessControlFilter'), // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('*'),
                'users' => array('@'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Vivienda;
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;
        $desarrollo = new Desarrollo;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        //$model->;

        if (isset($_POST['Vivienda'])) {

            $unidad = $_POST['Vivienda']['unidad_habitacional_id'];
            $piso = $_POST['Vivienda']['nro_piso'];
            $vivienda = trim(strtoupper($_POST['Vivienda']['nro_vivienda']));
            $tipo_vivienda = $_POST['Vivienda']['tipo_vivienda_id'];
            $consulta = Vivienda::model()->findByAttributes(array('unidad_habitacional_id' => $unidad, 'nro_piso' => $piso, 'nro_vivienda' => $vivienda, 'tipo_vivienda_id' => $tipo_vivienda));

            if (empty($consulta)) {
                $model->attributes = $_POST['Vivienda'];

                $model->unidad_habitacional_id = $unidad;
                //                $model->unidad_habitacional_id = $_POST['Vivienda']['unidad_habitacional_id'];
                $model->tipo_vivienda_id = $_POST['Vivienda']['tipo_vivienda_id'];
                $model->construccion_mt2 = $_POST['Vivienda']['construccion_mt2'];
                $model->nro_piso = $piso;
                $model->nro_vivienda = $vivienda;
                $model->sala = ($_POST['Vivienda']['sala'] == 'TRUE') ? true : false;
                $model->porcentaje_vivienda = empty($_POST['Vivienda']['porcentaje_vivienda']) ? 0.00 : $_POST['Vivienda']['porcentaje_vivienda'];
                $model->comedor = ($_POST['Vivienda']['comedor'] == 'TRUE') ? true : false;
                $model->cocina = ($_POST['Vivienda']['cocina'] == 'TRUE') ? true : false;
                $model->lavandero = ($_POST['Vivienda']['lavandero'] == 'TRUE') ? true : false;
                $model->lindero_norte = $_POST['Vivienda']['lindero_norte'];
                $model->lindero_sur = $_POST['Vivienda']['lindero_sur'];
                $model->lindero_este = $_POST['Vivienda']['lindero_este'];
                $model->lindero_oeste = $_POST['Vivienda']['lindero_oeste'];
                $model->coordenadas = $_POST['Vivienda']['coordenadas'];
                
                
                if (!empty($_POST['Vivienda']['precio_vivienda'])){
                   $precio = $_POST['Vivienda']['precio_vivienda'];
                   $precio_vivienda = str_replace(".", "", $precio);
                   $precio_vivienda1 = str_replace(",", ".", $precio_vivienda);
                   $model->precio_vivienda = $precio_vivienda1;
               }else{
                   $model->precio_vivienda =  0.00;
               }
                $model->nro_estacionamientos = $_POST['Vivienda']['nro_estacionamientos'];
                $model->descripcion_estac = $_POST['Vivienda']['descripcion_estac'];
                $model->nro_banos_auxiliar = $_POST['Vivienda']['nro_banos_auxiliar'];
                $model->fuente_datos_entrada_id = 90;
                $model->estatus_vivienda_id = 75;
                $model->asignada = '0';
                $model->fecha_creacion = 'now';
                $model->fecha_actualizacion = 'now';
                $model->usuario_id_creacion = Yii::app()->user->id;
//                echo '<pre>';var_dump($model);die;
                // $model->usuario_id_actualizacion = 5;

                if ($model->save()) {
                    if (isset($_POST['cargar_otro'])) {
                        $this->render('create', array(
                            'model' => new Vivienda, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia, 'desarrollo' => $desarrollo
                        ));
                        Yii::app()->end();
                    } else {
                        $this->redirect(array('vswUnifamiliar/admin'));
                        Yii::app()->end();
                    }
                }
            } else {
                $this->render('create', array(
                    'model' => $model, 'estado' => $estado,
                    'municipio' => $municipio, 'parroquia' => $parroquia,
                    'desarrollo' => $desarrollo,
                    'sms' => 1
                ));
                Yii::app()->end();
            }
        }
        $this->render('create', array(
            'model' => $model, 'estado' => $estado,
            'municipio' => $municipio, 'parroquia' => $parroquia,
            'desarrollo' => $desarrollo
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;
        $desarrollo = new Desarrollo;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Vivienda'])) {
//            $unidad = $_POST['Vivienda']['unidad_habitacional_id'];
            $piso = $_POST['Vivienda']['nro_piso'];
            $vivienda = trim(strtoupper($_POST['Vivienda']['nro_vivienda']));
//            $consulta = Vivienda::model()->findByAttributes(array('unidad_habitacional_id' => $unidad, 'nro_piso' => $piso, 'nro_vivienda' => $vivienda));
            if (empty($consulta)) {
                $model->attributes = $_POST['Vivienda'];
//                $model->tipo_vivienda_id = $_POST['Vivienda']['tipo_vivienda_id'];
                $model->construccion_mt2 = $_POST['Vivienda']['construccion_mt2'];
                $model->porcentaje_vivienda = empty($_POST['Vivienda']['porcentaje_vivienda']) ? 0.00 : $_POST['Vivienda']['porcentaje_vivienda'];
                $model->nro_piso = $piso;
                $model->nro_vivienda = $vivienda;
                $model->sala = ($_POST['Vivienda']['sala'] == 'TRUE') ? true : false;
                $model->comedor = ($_POST['Vivienda']['comedor'] == 'TRUE') ? true : false;
                $model->cocina = ($_POST['Vivienda']['cocina'] == 'TRUE') ? true : false;
                $model->lavandero = ($_POST['Vivienda']['lavandero'] == 'TRUE') ? true : false;
                $model->lindero_norte = $_POST['Vivienda']['lindero_norte'];
                $model->lindero_sur = $_POST['Vivienda']['lindero_sur'];
                $model->lindero_este = $_POST['Vivienda']['lindero_este'];
                $model->lindero_oeste = $_POST['Vivienda']['lindero_oeste'];
                $model->coordenadas = $_POST['Vivienda']['coordenadas'];
                
               if (!empty($_POST['Vivienda']['precio_vivienda'])){
                   $precio = $_POST['Vivienda']['precio_vivienda'];
                   $precio_vivienda = str_replace(".", "", $precio);
                   $precio_vivienda1 = str_replace(",", ".", $precio_vivienda);
                   $model->precio_vivienda = $precio_vivienda1;
               }else{
                   $model->precio_vivienda =  0.00;
               }
                $model->nro_estacionamientos = $_POST['Vivienda']['nro_estacionamientos'];
                $model->descripcion_estac = $_POST['Vivienda']['descripcion_estac'];
                $model->nro_banos_auxiliar = $_POST['Vivienda']['nro_banos_auxiliar'];
                $model->fuente_datos_entrada_id = 90;
                $model->estatus_vivienda_id = 75;
                $model->asignada = '0';
                $model->fecha_creacion = 'now';
                $model->fecha_actualizacion = 'now';
                $model->usuario_id_creacion = Yii::app()->user->id;

                if ($model->save())
                    $this->redirect(array('view', 'id' => $model->id_vivienda));
            }
        }

        $this->render('update', array('model' => $model, 'estado' => $estado,
            'municipio' => $municipio, 'parroquia' => $parroquia, 'desarrollo' => $desarrollo
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Vivienda');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Vivienda('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Vivienda']))
            $model->attributes = $_GET['Vivienda'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Vivienda::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vivienda-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPdf($id) {
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $this->render('pdf', array(
            'model' => $this->loadModel($id),
            'estado' => $estado,
            'municipio' => $municipio,
        ));
    }

    /*  ------------------------------------- */

    public function actiondocumento($id) {
        $model = new Documentacion;
        $modell = new Documentacion;

        if (Yii::app()->user->checkAccess('saren')) {
            $ente = 312; //SAREN 
        } else {
            $ente = 311; //BANAVIH
        }

        if ($ente == 312) { //SAREN
            $consultaDoc = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 292, 'ente_documento' => 312, 'es_multi' => 0));
            $consultaDoc2 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 292, 'ente_documento' => 311, 'es_multi' => 0));
            $consultaDoc1 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 292, 'ente_documento' => 312, 'es_multi' => 0, 'doc_primera_vez' => 1));

            if (isset($consultaDoc1)) {

                //MODEL MUESTRA DOCUMENTO GENERADO POR BANAVIH PARA SER CORREGIDO POR SAREN
                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 292, 'ente_documento' => 312, 'es_multi' => 0)); //esto
//                MODELL MUESTRA DOCUMENTO GENERADO POR BANVIH


                $modell = 1;
                $doc_banavih = 1;
            } else if (isset($consultaDoc)) {

                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 292, 'ente_documento' => 312, 'es_multi' => 0));
                $modell = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 292, 'ente_documento' => 311, 'es_multi' => 0));

                $sql_pg = ("SELECT documento FROM documentacion WHERE id_documentacion = (SELECT MIN (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . ")");
                $doc_banavih = Yii::app()->db->createCommand($sql_pg)->queryRow(); //PRIMER DOCUMENTO GENERADO POR BANAVIH
            } else if (isset($consultaDoc2)) {

                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 292, 'ente_documento' => 311, 'es_multi' => 0));
                $modell = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 292, 'ente_documento' => 311, 'es_multi' => 0));
                $doc_banavih = 1;
            }

//            var_dump($modell);die;

            if (isset($_POST['PlantillaDocumento']) || isset($_POST['Documentacion'])) {

                $documento = new Documentacion;

                $buscarDocUniPrimeraVez = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 292, 'es_activo' => 1, 'ente_documento' => 312, 'es_multi' => 0, 'doc_primera_vez' => 1));
                $buscarDocUniPrimeraVez2 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 292, 'es_activo' => 1, 'ente_documento' => 312, 'es_multi' => 0, 'doc_primera_vez' => 1));
                $buscarBeneficiario = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 292, 'es_activo' => 1, 'ente_documento' => 312, 'es_multi' => 0));
                $buscarBeneficiario2 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 292, 'es_activo' => 1, 'ente_documento' => 311, 'es_multi' => 0));

//                var_dump($buscarBeneficiario2);die;

                if (!empty($buscarBeneficiario)) {

                    if (!empty($buscarDocUniPrimeraVez2)) { //SI EL DOCUMENTO EXISTE POR PRIMERA VEZ
                        Documentacion::model()->updateByPk($buscarBeneficiario->id_documentacion, array(
                            'estatus' => 292, //ESTATUS INACTIVO
                            'es_activo' => false,
                            'fecha_actualizacion' => 'now()',
                            'usuario_id_actualizacion' => Yii::app()->user->id,
                                )
                        );


                        $beneficiario = BeneficiarioTe::model()->findByPk($id);

                        $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                        $documento->tipo_documento_id = $beneficiario->unidadFamiliars[0]->analisisCreditos[0]->tipo_documento_id;
                        $documento->estatus = 292; //ESTATUS ACTIVO
                        $documento->fecha_creacion = 'now()';
                        $documento->fecha_actualizacion = 'now()';
                        $documento->ente_documento = 312;
                        $documento->usuario_id_creacion = Yii::app()->user->id;
                        $documento->fk_beneficiario = $id;
                        $documento->es_multi = FALSE;
                        $documento->doc_primera_vez = true;

                        if ($documento->save()) {
                            $this->redirect(array('/documentacion/adminsarenBene'));
                        } else {
                            $this->redirect(array('/site/error'));
                        }
                    } else {

                        Documentacion::model()->updateByPk($buscarBeneficiario->id_documentacion, array(
                            'estatus' => 292, //ESTATUS INACTIVO
                            'es_activo' => false,
                            'fecha_actualizacion' => 'now()',
                            'usuario_id_actualizacion' => Yii::app()->user->id,
                                )
                        );


                        $beneficiario = Beneficiario::model()->findByPk($id);

                        $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                        $documento->tipo_documento_id = $beneficiario->unidadFamiliars[0]->analisisCreditos[0]->tipo_documento_id;
                        $documento->estatus = 292; //ESTATUS ACTIVO
                        $documento->fecha_creacion = 'now()';
                        $documento->fecha_actualizacion = 'now()';
                        $documento->ente_documento = 312;
                        $documento->usuario_id_creacion = Yii::app()->user->id;
                        $documento->fk_beneficiario = $id;
                        $documento->es_multi = FALSE;

                        if ($documento->save()) {
                            $this->redirect(array('/documentacion/adminsarenBene'));
                        } else {
                            $this->redirect(array('/site/error'));
                        }
                    }
                } else if (!empty($buscarBeneficiario2)) {

                    if (empty($buscarDocUniPrimeraVez)) {  //SI EL DOCUMENTO EXISTE POR PRIMERA VEZ
                        $beneficiario = Beneficiario::model()->findByPk($id);

                        $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                        $documento->tipo_documento_id = $beneficiario->unidadFamiliars[0]->analisisCreditos[0]->tipo_documento_id;
                        $documento->estatus = 292; //ESTATUS ACTIVO
                        $documento->fecha_creacion = 'now()';
                        $documento->fecha_actualizacion = 'now()';
                        $documento->ente_documento = 312;
                        $documento->usuario_id_creacion = Yii::app()->user->id;
                        $documento->fk_beneficiario = $id;
                        $documento->es_multi = FALSE;
                        $documento->doc_primera_vez = true;

                        if ($documento->save()) {
                            $this->redirect(array('/documentacion/adminsarenBene'));
                        } else {
                            $this->redirect(array('/site/error'));
                        }
                    } else {

                        $beneficiario = Beneficiario::model()->findByPk($id);

                        $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                        $documento->tipo_documento_id = $beneficiario->unidadFamiliars[0]->analisisCreditos[0]->tipo_documento_id;
                        $documento->estatus = 292; //ESTATUS ACTIVO
                        $documento->fecha_creacion = 'now()';
                        $documento->fecha_actualizacion = 'now()';
                        $documento->ente_documento = 312;
                        $documento->usuario_id_creacion = Yii::app()->user->id;
                        $documento->fk_beneficiario = $id;
                        $documento->es_multi = FALSE;

                        if ($documento->save()) {
                            $this->redirect(array('/documentacion/adminsarenBene'));
                        } else {
                            $this->redirect(array('/site/error'));
                        }
                    }
                }
            }





            $this->render('documento', array('model' => $model, 'modell' => $modell, 'doc_banavih' => $doc_banavih));
        } else { //BANAVIH
            $consultaDoc = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 294, 'ente_documento' => 311, 'es_multi' => 0));
            $consultaDoc2 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 53, 'es_activo' => 1, 'es_multi' => 0, 'ente_documento' => 311));

            if (isset($consultaDoc)) {

                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 294, 'ente_documento' => 311, 'es_multi' => 0));
                $modell = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 294, 'ente_documento' => 312, 'es_multi' => 0));
            } else if (isset($consultaDoc2)) {

                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'es_multi' => 0, 'ente_documento' => 311));
                $modell = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 294, 'es_multi' => 0, 'ente_documento' => 311));
            }



            if (isset($_POST['PlantillaDocumento']) || isset($_POST['Documentacion'])) {

                $documento = new Documentacion;

                $buscarBeneficiario = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 53, 'es_multi' => 0));
                $buscarDocumentoDevuelto = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 294, 'es_multi' => 0, 'ente_documento' => 311));



                if (!empty($buscarBeneficiario)) { // INSERT Y UPDATE CUANDO EL DOCUMENTO ESTA EN ESTATUS ACTIVO
                    Documentacion::model()->updateByPk($buscarBeneficiario->id_documentacion, array(
                        'estatus' => 54, //ESTATUS INACTIVO
                        'es_activo' => false,
                        'fecha_actualizacion' => 'now()',
                        'usuario_id_actualizacion' => Yii::app()->user->id,
                        'doc_primera_vez' => false,
                            )
                    );


                    $beneficiario = Beneficiario::model()->findByPk($id);

                    $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                    $documento->tipo_documento_id = $beneficiario->unidadFamiliars[0]->analisisCreditos[0]->tipo_documento_id;
                    $documento->estatus = 53; //ESTATUS ACTIVO
                    $documento->fecha_creacion = 'now()';
                    $documento->fecha_actualizacion = 'now()';
                    $documento->ente_documento = 311; // ENTE BANAVIH
                    $documento->usuario_id_creacion = Yii::app()->user->id;
                    $documento->fk_beneficiario = $id;
                    $documento->es_multi = FALSE;
                    $documento->doc_primera_vez = TRUE;

                    if ($documento->save()) {

                        $this->redirect(array('/documentacion/adminbeneficiario'));
                    } else {
                        $this->redirect(array('/site/error'));
                    }
                } else {// INSERT Y UPDATE CUANDO EL DOCUMENTO ESTA EN ESTATUS DEVUELTO POR SAREN
                    Documentacion::model()->updateByPk($buscarDocumentoDevuelto->id_documentacion, array(
                        'estatus' => 54, //ESTATUS INACTIVO
                        'es_activo' => false,
                        'fecha_actualizacion' => 'now()',
                        'usuario_id_actualizacion' => Yii::app()->user->id,
                            )
                    );


                    $beneficiario = Beneficiario::model()->findByPk($id);

                    $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                    $documento->tipo_documento_id = $beneficiario->unidadFamiliars[0]->analisisCreditos[0]->tipo_documento_id;
                    $documento->estatus = 294; //ESTATUS DEVUELTO
                    $documento->fecha_creacion = 'now()';
                    $documento->ente_documento = 311;
                    $documento->fecha_actualizacion = 'now()';
                    $documento->usuario_id_creacion = Yii::app()->user->id;
                    $documento->fk_beneficiario = $id;
                    $documento->es_multi = FALSE;

                    if ($documento->save()) {

                        $this->redirect(array('/documentacion/adminbeneficiario'));
                    } else {
                        $this->redirect(array('/site/error'));
                    }
                }
            }
            $this->render('documento', array('model' => $model, 'modell' => $modell));
        }
    }

    /*  ------------------------------------- */

    public function actionListarDocumento() {

        $agent_documentacion = $_POST['Documentacion']['agente_documentacion'];
        $apoderado = $_POST['Documentacion']['apoderado'];
        $error = array();
//        $id_beneficiario = 53;
        $id_beneficiario = $_POST['id_beneficiario'];
        if (empty($apoderado) || empty($agent_documentacion)) {
            echo json_encode(array('cont' => '', 'sms' => '1'));
        } else {
            $unidadFamiliar = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id_beneficiario));

            $criteria1 = new CDbCriteria;
            $criteria1->condition = 'unidad_familiar_id= :unidad_familiar';
            $criteria1->params = array(":unidad_familiar" => (int) $unidadFamiliar->id_unidad_familiar);
            $analisisCredito_1 = AnalisisCredito::model()->findAll($criteria1);

            if (empty($analisisCredito_1)) {
                array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> EL BENEFICIARIO NO PRESENTA UN ANÁLISIS DE CREDITO');
                echo json_encode(array('cont' => $error, 'sms' => '3'));
                Yii::app()->end();
            } else {
                if (count($analisisCredito_1) == 2) {
                    $analisisCredito = $analisisCredito_1[0];
                    $analisisCredito_extra = $analisisCredito_1[1];
                } else {
                    $analisisCredito = $analisisCredito_1[0];
                    $analisisCredito_extra = NULL;
                }
            }
            if (!empty($analisisCredito) && $analisisCredito->fuente_financiamiento_id == 2) {
                /*
                 * VALIDACION PROVICIONAL QUE PERMITE LA ITERAR 
                 */
                array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> NO EXISTES DOCUMENTOS PARA FAOV.');
                echo json_encode(array('cont' => $error, 'sms' => '3'));
                Yii::app()->end();
            }

            $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id_beneficiario));
            if (empty($model)) {
                $model = PlantillaDocumento::model()->findByAttributes(array('fk_tipo_documento' => $analisisCredito->tipo_documento_id));
            }

            // var_dump($analisisCredito,$unidadFamiliar->id_unidad_familiar);die;

            /* BUSQUEDA DE LOS DATOS DEL APODERADO */
            $data_apoderado = Abogados::model()->findByPk($apoderado);
//            echo '<pre>';var_dump(isset($analisisCredito->vivienda->unidadHabitacional));die;
            $info_apoderado = ConsultaOracle::setPersona("*", (int) $data_apoderado->persona_id);
//            /* BUSQUEDA DE LOS DATOS DEL AGENTE DE DOCUMENTACION */
            $data_agente = Abogados::model()->findByPk($agent_documentacion);
            $info_agente = ConsultaOracle::setPersona("*", (int) $data_agente->persona_id);

            $array = explode(" ", $model->documento);


//            var_dump($array);die;
            foreach ($array as &$value) {
                /* ------------------- DATOS DEL APODERADO ------------------- */

                if (stristr($value, '&NOMBRE_ABOGADO_APODERADO')) {
                    $value = $info_apoderado['PRIMER_NOMBRE'] . ' ' . $info_apoderado['PRIMER_APELLIDO'];
                }
                if (stristr($value, '&CEDULA_ABOGADO')) {
                    $value = ($info_apoderado['NACIONALIDAD'] == 1) ? "V-" . $info_apoderado['CEDULA'] : "E-" . '-' . $info_apoderado['CEDULA'];
                }
                if (stristr($value, '&RIF_ABOGADO')) {
                    if (isset($data_apoderado->rif_abogado)) {
                        $value = strtoupper($data_apoderado->rif_abogado);
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> RIF DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&FOLIO_ABOGADO')) {
                    if (isset($data_apoderado->folio)) {
                        $value = strtoupper($data_apoderado->folio);
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> FOLIO DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&TOMO_ABOGADO')) {
                    if (isset($data_apoderado->tomo)) {
                        $value = $data_apoderado->tomo;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> TOMO DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&ANO_ABOGADO')) {
                    if (isset($data_apoderado->anio)) {
                        $value = $data_apoderado->anio;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> AÑO DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&ABOGADO_NUMERO_PROTOCOLO')) {
                    if (isset($data_apoderado->nun_protocolo)) {
                        $value = $data_apoderado->nun_protocolo;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> NÚMERO DE PROTOCOLO DEL APODERADO');
                    }
                }
                //nombre de la oficina del  registro publico

                if (stristr($value, '&MUNICIPIO_REGISTROPUBLICO')) {
                    if (isset($data_apoderado->registroPublico->fkParroquia->clvmunicipio0->strdescripcion)) {
                        $value = $data_apoderado->registroPublico->fkParroquia->clvmunicipio0->strdescripcion;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> MUNICIPIO DEL REGISTRO PÚBLICO AL QUE PERTENECE EL APODERADO');
                    }
                }
                if (stristr($value, '&ESTADO_REGISTROPUBLICO')) {
                    if (isset($data_apoderado->registroPublico->fkParroquia->clvmunicipio0->clvestado0->strdescripcion)) {
                        $value = $data_apoderado->registroPublico->fkParroquia->clvmunicipio0->clvestado0->strdescripcion;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ESTADO DEL REGISTRO PÚBLICO AL QUE PERTENECE EL APODERADO');
                    }
                }
                if (stristr($value, '&IMPRE_ABOGADO')) {
                    $value = $data_apoderado->inpreabogado;
                }
//                /* ------------------- FIN DATOS DEL APODERADO ------------------- */

                /* ------------------- DATOS DEL AGENTE DE DOCUMENTACION------------------- */



                if (stristr($value, '&NOMBRE_ABOGADO')) {
                    $value = $info_agente['PRIMER_NOMBRE'] . ' ' . $info_agente['PRIMER_APELLIDO'];
//                   
                }


               




                $criteria = new CDbCriteria;
                $criteria->condition = 'id_beneficiario= :id_beneficiario';
                $criteria->params = array(":id_beneficiario" => $id_beneficiario);
                $consultar = Beneficiario::model()->findAll($criteria);


//                        $consultar->beneficiario_temporal_id->cedula;
                //var_dump($consultar[0]['beneficiario_temporal_id']);die;
                //var_dump($unidadFamiliar->beneficiario->beneficiarioTemporal->cedula);die;

                 $fecha1 = substr($analisisCredito->fecha_actualizacion,0,10);
                 $fecha= implode("", array_reverse(explode("-", $fecha1)));
                 $cadena_fecha=$fecha[0].$fecha[1].$fecha[2].$fecha[3].$fecha[6].$fecha[7];
                 
               

                if (stristr($value, '&CODIGO')) {
                    $value = $cadena_fecha.$data_apoderado->registroPublico->fkParroquia->clvmunicipio0->clvestado0->strid.str_pad($analisisCredito->id_analisis_credito, 4, "0", STR_PAD_LEFT).'-'.$unidadFamiliar->beneficiario->beneficiarioTemporal->cedula;
                }

//                if (stristr($value, '&IMPRE_ABOGADO')) {
//                    $value = $data_agente->inpreabogado;
//                }


                /* ------------------- FIN DATOS DEL AGENTE DE DOCUMENTACION------------------- */

                /* ------------------- estado civil solicitante ------------------- */

                if (stristr($value, '&')) {

                    if (stristr($value, '&ESTADO_CIVIL_SOLICITANTE')) {


                        $estado_civil_solicitante = ConsultaOracle::setPersona("GEN_EDO_CIVIL_ID", (int) $unidadFamiliar->beneficiario->beneficiarioTemporal->persona_id);


                        switch ($estado_civil_solicitante["GEN_EDO_CIVIL_ID"]) {
                            case 1:
                                $estado_civil_solicitante = 'Soltero';
                                break;
                            case 2:
                                $estado_civil_solicitante = 'Casado';
                                break;
                            case 3:
                                $estado_civil_solicitante = 'Divorciado';
                                break;
                            case 4:
                                $estado_civil_solicitante = 'Viudo';
                                break;
                            case NULL:
                                $estado_civil_solicitante = 'No Aplica';
                                break;
                        }
                        $edocivilsol = ' Estado Civil ' . $estado_civil_solicitante . ' ';

                        $value = $edocivilsol;
                    }
                }
                /* ------------------- FIN estado civil solicitante------------------- */


                if (stristr($value, '&')) {

                    /*                     * ** SEARCH COSOLICITANTE * ** */
                    if ($value == '&CEDULA_COSOLISITANTE') {
                        $criteria = new CDbCriteria;
                        $criteria->condition = 'unidad_familiar_id= :unidad_familiar_id AND tipo_persona_faov IS NOT NULL';
                        $criteria->params = array(":unidad_familiar_id" => $analisisCredito->unidad_familiar_id);
                        $GrupoFamiliar = GrupoFamiliar::model()->findAll($criteria);


                        if (!empty($GrupoFamiliar)) {
                            $cosol = ' y ,';
                            foreach ($GrupoFamiliar as $value) {
                                $nombre = ConsultaOracle::setPersona("PRIMER_NOMBRE", (int) $value->persona_id);
                                $apellido = ConsultaOracle::setPersona("PRIMER_APELLIDO", (int) $value->persona_id);
                                $cedula_cosolicitante = ConsultaOracle::setPersona("CEDULA", (int) $value->persona_id);
                                $nacionalidad_cosolicitante = ConsultaOracle::setPersona("NACIONALIDAD", (int) $value->persona_id);
                                $identificacion = ($nacionalidad_cosolicitante['NACIONALIDAD'] == '1') ? 'V' . '-' . $cedula_cosolicitante['CEDULA'] : 'E' . '-' . $cedula_cosolicitante['CEDULA'];
                                $estado_civil_cosolicitante = ConsultaOracle::setPersona("GEN_EDO_CIVIL_ID", (int) $value->persona_id);


                                switch ($estado_civil_cosolicitante["GEN_EDO_CIVIL_ID"]) {
                                    case 1:
                                        $estado_civil_cosolicitante = 'Soltero';
                                        break;
                                    case 2:
                                        $estado_civil_cosolicitante = 'Casado';
                                        break;
                                    case 3:
                                        $estado_civil_cosolicitante = 'Divorciado';
                                        break;
                                    case 4:
                                        $estado_civil_cosolicitante = 'Viudo';
                                        break;
                                    case NULL:
                                        $estado_civil_cosolicitante = 'No Aplica';
                                        break;
                                }

                                $cosol.='<b>' . $nombre['PRIMER_NOMBRE'] . ' ' . $apellido['PRIMER_APELLIDO'] . ' (' . $value->tipoPersonaFaov->descripcion . ')</b> Titular de la Cédula de Identidad Nº ' . '<b> Nº ' . $identificacion . '</b> ' . ' Estado Civil ' . '<b>' . $estado_civil_cosolicitante . '</b>' . ' ';
                            }
                            $value = $cosol;
                        } else {
                            $value = ' ';
                        }
                    }

                    $variable = VariablesDocumentos::model()->findByAttributes(array('variable' => $value));
                    if (!empty($variable)) {

                        if (stristr($variable->variable, '_EXT')) {
                            $result = $analisisCredito_extra;
                        } else {
                            $result = $analisisCredito;
                        }



                        $string = explode(',', $variable->relation);
                        switch (count($string)) {
                            case 1:
                                if (isset($result->$string[0])) {
                                    $valor = $result->$string[0];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 2:
                                if (isset($result->$string[0]->$string[1])) {
                                    $valor = $result->$string[0]->$string[1];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 3:
                                if (isset($result->$string[0]->$string[1]->$string[2])) {
                                    $valor = $result->$string[0]->$string[1]->$string[2];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 4:
                                if (isset($result->$string[0]->$string[1]->$string[2]->$string[3])) {
                                    $valor = $result->$string[0]->$string[1]->$string[2]->$string[3];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 5:
                                if (isset($result->$string[0]->$string[1]->$string[2]->$string[3]->$string[4])) {
                                    $valor = $result->$string[0]->$string[1]->$string[2]->$string[3]->$string[4];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 6:
                                if (isset($result->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5])) {
                                    $valor = $result->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 7:
                                if (isset($result->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5]->$string[6])) {
                                    $valor = $result->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5]->$string[6];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 8:
                                if (isset($result->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5]->$string[6]->$string[7])) {
                                    $valor = $result->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5]->$string[6]->$string[7];
                                } else {
                                    $valor = null;
                                }
                                break;
                        }

                        if (!empty($valor) || is_bool($valor)) {
                            if (is_bool($valor)) {
                                $value = ($valor == 'TRUE') ? 'SI' : 'NO';
                            } else if ($variable->numero_letras == 'TRUE') {
                                if ($variable->es_cifra_monetaria == 'TRUE') {
                                    $num = explode('.', $valor);
                                    $segundo = isset($num[1]) ? ' CON ' . str_replace('00', '', Generico::numtoletras($num[1])) . ' CÉNTIMOS' : '';
                                    $value = str_replace('00', '', Generico::numtoletras($num[0])) . ' BOLÍVARES ' . $segundo;
                                } else {
                                    $num = explode('.', $valor);
                                    $segundo = isset($num[1]) ? ' CON ' . str_replace('00', '', Generico::numtoletras($num[1])) : '';
                                    $value = str_replace('00', '', Generico::numtoletras($num[0])) . ' ' . $segundo;
                                }
                            } else if ($variable->es_fecha == 'TRUE') {
                                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                                $value = date('d', strtotime($valor)) . " de " . $meses[date('n', strtotime($valor)) - 1] . " de " . date('Y', strtotime($valor));
                            } else {
                                $value = $valor;
                            }
                        } else {
                            array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ' . $variable->label);
                        }
                    }
                }
            }
            if (empty($error)) {
                $cont = $model->documento = implode(' ', $array);
                echo json_encode(array('cont' => $cont, 'sms' => '2'));
            } else {
                $error = implode('<br /> ', $error);
                echo json_encode(array('cont' => $error, 'sms' => '3'));
            }
        }
    }

    /*
     * ACtion Ajax que actualiza solo el monto de la vivienda
     */

    public function actionUpdateMontoVivienda() {
        $montoVivienda = $_POST['costoVivienda'];
        $idVivienda = $_POST['idVivienda'];
        $update = Vivienda::model()->updateByPk($idVivienda, array('precio_vivienda' => $montoVivienda));
        echo json_encode($montoVivienda);
    }

}
