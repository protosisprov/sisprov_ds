<?php
class DocumentacionController extends Controller {
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
        $model = new Documentacion;
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        if (isset($_POST['Documentacion'])) {
            $model->attributes = $_POST['Documentacion'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_documentacion));
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        if (isset($_POST['Documentacion'])) {
            $model->attributes = $_POST['Documentacion'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_documentacion));
        }
        $this->render('update', array(
            'model' => $model,
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
        $dataProvider = new CActiveDataProvider('Documentacion');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }
    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Documentacion('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Documentacion']))
            $model->attributes = $_GET['Documentacion'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }
    /**
     * Manages all models.
     */
    public function actionAdminbeneficiario() {
        $asignaciones = new Asignaciones;
//          $SLQ = 'select b.id_beneficiario from beneficiario_temporal tmp
//                    join beneficiario b ON b.beneficiario_temporal_id = tmp.id_beneficiario_temporal
//                    join vsw_asignaciones_documentos doc ON doc.fk_caso_asignado = tmp.unidad_habitacional_id
//                    where doc.fk_usuario_asignado = 3';
//          $result = Yii::app()->db->createCommand($SLQ)->queryAll();
        //    var_dump($result);Die;
        $model = new Beneficiario('search');
        $model->unsetAttributes();  // clear any default values
// $llaves = implode('["id_beneficiario"]=>', $ids);
//    var_dump($ids);
//die;
        if (isset($_GET['Beneficiario']))
            $model->attributes = $_GET['Beneficiario'];
        $this->render('adminbeneficiario', array(
            'model' => $model, 'asignaciones' => $asignaciones,
        ));
    }
    /*
     * FUNCION QUE CONSULTA SI EL DOCUMENTO EXISTE (MULTIFAMILIAR)
     */
    public function actionDocumentoExiste() {
        $id = $_POST['id'];
        $id = (int) $id;
        $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id));
        if (empty($model)) {
            //INDICA QUE EL DOCUMENTO NO HA SIDO CREADO
            echo CJSON::encode(array('sms' => 1, 'documento' => 'vacio'));
        } else {
            //INDICA QUE EL DOCUMENTO HA SIDO CREADO
            echo CJSON::encode(array('sms' => 2, 'documento' => $model->documento));
        }
    }
    /**
     * Manages all models.
     */
    public function actionAdminmultifamiliar() {
//        $model = new VswMultifamiliar('search');
//        $model->unsetAttributes();  // clear any default values
//        if (isset($_GET['VswMultifamiliar']))
//            $model->attributes = $_GET['VswMultifamiliar'];
        $asignaciones = new Asignaciones;
        $this->render('adminmultifamiliar', array('asignaciones' => $asignaciones,
//            'model' => $model,
        ));
    }
    
        /**
     * Manages all models.
     */
    public function actionAdminactivacion() {
        $model = VswDocumentoEntregado::model()->findAll();
        //echo '<pre>';$model;die;
        $model = new VswDocumentoEntregado('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['VswDocumentoEntregado']))
            $model->attributes = $_GET['VswDocumentoEntregado'];
        //echo '<pre>';var_dump($model);die;
        $this->render('adminactivacion', array(
            'model' => $model,
        ));
    }
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Documentacion::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'documentacion-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    /*
     * 
     */
    public function actionGenerar2($id) {
        $model = new Documentacion;
//            var_dump($id);die;
        if (isset($_POST['PlantillaDocumento']) || isset($_POST['Documentacion'])) {
            $documento = new Documentacion;
            $buscarDocMulti = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 53));
            if (!empty($buscarDocMulti)) {
                Documentacion::model()->updateByPk($buscarDocMulti->id_documentacion, array(
                    'estatus' => 54, //ESTATUS INACTIVO
                    'fecha_actualizacion' => 'now()',
                    'usuario_id_actualizacion' => Yii::app()->user->id,
                        )
                );
            }
            $unidadHabitacional = UnidadHabitacional::model()->findByPk($id);
            $fuente_financiamiento = $unidadHabitacional->desarrollo->fuenteFinanciamiento->id_fuente_financiamiento;
            if ($fuente_financiamiento = 3) { //fasp
                $tipo_documento = 298;
            } else {
                $tipo_documento = 297; //faov
            }
            $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
            $documento->tipo_documento_id = $tipo_documento;
            $documento->estatus = 53; //ESTATUS ACTIVO
            $documento->fecha_creacion = 'now()';
            $documento->fecha_actualizacion = 'now()';
            $documento->usuario_id_creacion = Yii::app()->user->id;
            $documento->fk_beneficiario = $id;
            $documento->es_multi = true;
            $documento->ente_documento = 311;
            $documento->doc_primera_vez = TRUE;
            if ($documento->save()) {
                /*  ACTUALIZACION DE TABLA UNIDAD_FAMILIAR PARA LA IDENTICACION DE DOCUMENTO MULTI  */
                $ids_unidad_familiar = explode(',', $_POST['ids_unidad_familiar']);
                foreach ($ids_unidad_familiar as $idBenef) {
                    UnidadFamiliar::model()->updateByPk($idBenef, array(
                        'fk_tipo_documento_multi' => $tipo_documento, //DOC MULTI
                        'fecha_actualizacion' => 'now()',
                        'usuario_id_actualizacion' => Yii::app()->user->id,
                        'documentacion_id' => $documento->id_documentacion,
                            )
                    );
                }
                $this->redirect(array('/documentacion/adminmultifamiliar'));
            }
        }
        $this->render('generarDocMulti', array('model' => $model));
    }
    public function actionMultifamiliar($id) {
        
        $id = (int) $id;
        $model = new Documentacion;
        $modell = new Documentacion;
        if (Yii::app()->user->checkAccess('saren')) {
            $ente = 312;
        } else {
            $ente = 311;
        }
//        var_dump($ente);die;
        if ($ente == 312) { //SAREN
//            CONSULTA PARA DOCUMENTO YA CREADO POR SAREN
            $consultaDoc = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 285, 'ente_documento' => 312, 'es_multi' => 1));
            $consultaDoc1 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 285, 'ente_documento' => 312, 'es_multi' => 1, 'doc_primera_vez' => 1));
//            CONSULTA PARA DOCUMENTO POR PRIMERA VEZ GENERADO POR SAREN
            $consultaDoc2 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 285, 'ente_documento' => 311, 'es_multi' => 1));
            if (isset($consultaDoc1)) {
                //MODEL MUESTRA DOCUMENTO GENERADO POR BANAVIH PARA SER CORREGIDO POR SAREN
                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 285, 'ente_documento' => 312, 'es_multi' => 1)); //esto
//                MODELL MUESTRA DOCUMENTO GENERADO POR BANVIH
                $modell = 1;
                $doc_banavih = 1;
            } else if (isset($consultaDoc)) {
//                MODEL MUESTRA DOCUMENTO GENERADO POR BANAVIH PARA SER CORREGIDO POR SAREN
                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 285, 'ente_documento' => 312, 'es_multi' => 1)); //esto
//                MODELL MUESTRA DOCUMENTO GENERADO POR BANVIH
                $modell = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 285, 'ente_documento' => 311, 'es_multi' => 1));
                $sql_pg = ("SELECT documento FROM documentacion WHERE id_documentacion = (SELECT MIN (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . ")");
                $doc_banavih = Yii::app()->db->createCommand($sql_pg)->queryRow(); //PRIMER DOCUMENTO GENERADO POR BANAVIH
            } else if (isset($consultaDoc2)) {
                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 285, 'ente_documento' => 311, 'es_multi' => 1));
                $modell = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 285, 'ente_documento' => 311, 'es_multi' => 1));
                $doc_banavih = 1;
            }
            if (isset($_POST['PlantillaDocumento']) || isset($_POST['Documentacion'])) {
                $documento = new Documentacion;
                $buscarDocMultiPrimeraVez = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 285, 'es_activo' => 1, 'ente_documento' => 312, 'es_multi' => 1, 'doc_primera_vez' => 1));
                $buscarDocMultiPrimeraVez2 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 285, 'es_activo' => 1, 'ente_documento' => 312, 'es_multi' => 1, 'doc_primera_vez' => 1));
                $buscarDocMulti = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 285, 'es_activo' => 1, 'ente_documento' => 312, 'es_multi' => 1));
                $buscarDocMulti2 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 285, 'es_activo' => 1, 'ente_documento' => 311, 'es_multi' => 1));
                if (!empty($buscarDocMulti)) { //DOCUMENTO CORREGIDO POR SAREN MAS DE UNA VEZ
                    if (!empty($buscarDocMultiPrimeraVez2)) { //SI EL DOCUMENTO EXISTE POR PRIMERA VEZ
                        Documentacion::model()->updateByPk($buscarDocMulti->id_documentacion, array(
                            'estatus' => 285, //ESTATUS INACTIVO
                            /*  ACTUALIZACION DE TABLA UNIDAD_FAMILIAR PARA LA IDENTICACION DE DOCUMENTO MULTI  */
                            'fecha_actualizacion' => 'now()',
                            'es_activo' => false,
                            'usuario_id_actualizacion' => Yii::app()->user->id,
                                )
                        );
                        $unidadHabitacional = UnidadHabitacional::model()->findByPk($id);
                        $fuente_financiamiento = $unidadHabitacional->desarrollo->fuenteFinanciamiento->id_fuente_financiamiento;
                        if ($fuente_financiamiento = 3) { //fasp
                            $tipo_documento = 298;
                        } else {
                            $tipo_documento = 297; //faov
                        }
                        $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                        $documento->tipo_documento_id = $tipo_documento;
                        $documento->estatus = 285; //ESTATUS ACTIVO
                        $documento->fecha_creacion = 'now()';
                        $documento->fecha_actualizacion = 'now()';
                        $documento->usuario_id_creacion = Yii::app()->user->id;
                        $documento->fk_beneficiario = $id;
                        $documento->es_multi = true;
                        $documento->ente_documento = 312;
                        $documento->doc_primera_vez = true;
                        if ($documento->save()) {
                            /*  ACTUALIZACION DE TABLA UNIDAD_FAMILIAR PARA LA IDENTICACION DE DOCUMENTO MULTI  */
                            $ids_unidad_familiar = explode(',', $_POST['ids_unidad_familiar']);
                            foreach ($ids_unidad_familiar as $idBenef) {
                                UnidadFamiliar::model()->updateByPk($idBenef, array(
                                    'fk_tipo_documento_multi' => $tipo_documento, //DOC MULTI
                                    'fecha_actualizacion' => 'now()',
                                    'usuario_id_actualizacion' => Yii::app()->user->id,
                                    'documentacion_id' => $documento->id_documentacion,
                                        )
                                );
                            }
                            $this->redirect(array('/documentacion/adminsarenMulti'));
                        }
                    } else {
                        Documentacion::model()->updateByPk($buscarDocMulti->id_documentacion, array(
                            'estatus' => 285, //ESTATUS INACTIVO
                            /*  ACTUALIZACION DE TABLA UNIDAD_FAMILIAR PARA LA IDENTICACION DE DOCUMENTO MULTI  */
                            'fecha_actualizacion' => 'now()',
                            'es_activo' => false,
                            'usuario_id_actualizacion' => Yii::app()->user->id,
                                )
                        );
                        $unidadHabitacional = UnidadHabitacional::model()->findByPk($id);
                        $fuente_financiamiento = $unidadHabitacional->desarrollo->fuenteFinanciamiento->id_fuente_financiamiento;
                        if ($fuente_financiamiento = 3) { //fasp
                            $tipo_documento = 298;
                        } else {
                            $tipo_documento = 297; //faov
                        }
                        $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                        $documento->tipo_documento_id = $tipo_documento;
                        $documento->estatus = 285; //ESTATUS ACTIVO
                        $documento->fecha_creacion = 'now()';
                        $documento->fecha_actualizacion = 'now()';
                        $documento->usuario_id_creacion = Yii::app()->user->id;
                        $documento->fk_beneficiario = $id;
                        $documento->es_multi = true;
                        $documento->ente_documento = 312;
                        if ($documento->save()) {
                            /*  ACTUALIZACION DE TABLA UNIDAD_FAMILIAR PARA LA IDENTICACION DE DOCUMENTO MULTI  */
                            $ids_unidad_familiar = explode(',', $_POST['ids_unidad_familiar']);
                            foreach ($ids_unidad_familiar as $idBenef) {
                                UnidadFamiliar::model()->updateByPk($idBenef, array(
                                    'fk_tipo_documento_multi' => $tipo_documento, //DOC MULTI
                                    'fecha_actualizacion' => 'now()',
                                    'usuario_id_actualizacion' => Yii::app()->user->id,
                                    'documentacion_id' => $documento->id_documentacion,
                                        )
                                );
                            }
                            $this->redirect(array('/documentacion/adminsarenMulti'));
                        }
                    }
                } else if (!empty($buscarDocMulti2)) { //DOCUMENTO CORREGIDO POR SAREN POR PRIMERA VEZ
                    if (empty($buscarDocMultiPrimeraVez)) { //SI EL DOCUMENTO EXISTE POR PRIMERA VEZ
                        $unidadHabitacional = UnidadHabitacional::model()->findByPk($id);
                        $fuente_financiamiento = $unidadHabitacional->desarrollo->fuenteFinanciamiento->id_fuente_financiamiento;
                        if ($fuente_financiamiento = 3) { //fasp
                            $tipo_documento = 298;
                        } else {
                            $tipo_documento = 297; //faov
                        }
//                        var_dump($tipo_documento);die;
                        $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                        $documento->tipo_documento_id = $tipo_documento;
                        $documento->estatus = 285; //ESTATUS ACTIVO
                        $documento->fecha_creacion = 'now()';
                        $documento->fecha_actualizacion = 'now()';
                        $documento->usuario_id_creacion = Yii::app()->user->id;
                        $documento->fk_beneficiario = $id;
                        $documento->es_multi = true;
                        $documento->ente_documento = 312;
                        $documento->doc_primera_vez = true;
                        if ($documento->save()) {
                            /*  ACTUALIZACION DE TABLA UNIDAD_FAMILIAR PARA LA IDENTICACION DE DOCUMENTO MULTI  */
                            $ids_unidad_familiar = explode(',', $_POST['ids_unidad_familiar']);
                            foreach ($ids_unidad_familiar as $idBenef) {
                                UnidadFamiliar::model()->updateByPk($idBenef, array(
                                    'fk_tipo_documento_multi' => $tipo_documento, //DOC MULTI
                                    'fecha_actualizacion' => 'now()',
                                    'usuario_id_actualizacion' => Yii::app()->user->id,
                                    'documentacion_id' => $documento->id_documentacion,
                                        )
                                );
                            }
                            $this->redirect(array('/documentacion/adminsarenMulti'));
                        }
                    } else {
                        $unidadHabitacional = UnidadHabitacional::model()->findByPk($id);
                        $fuente_financiamiento = $unidadHabitacional->desarrollo->fuenteFinanciamiento->id_fuente_financiamiento;
                        if ($fuente_financiamiento = 3) { //fasp
                            $tipo_documento = 298;
                        } else {
                            $tipo_documento = 297; //faov
                        }
                        $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                        $documento->tipo_documento_id = $tipo_documento;
                        $documento->estatus = 285; //ESTATUS ACTIVO
                        $documento->fecha_creacion = 'now()';
                        $documento->fecha_actualizacion = 'now()';
                        $documento->usuario_id_creacion = Yii::app()->user->id;
                        $documento->fk_beneficiario = $id;
                        $documento->es_multi = true;
                        $documento->ente_documento = 312;
                        if ($documento->save()) {
                            /*  ACTUALIZACION DE TABLA UNIDAD_FAMILIAR PARA LA IDENTICACION DE DOCUMENTO MULTI  */
                            $ids_unidad_familiar = explode(',', $_POST['ids_unidad_familiar']);
                            foreach ($ids_unidad_familiar as $idBenef) {
                                UnidadFamiliar::model()->updateByPk($idBenef, array(
                                    'fk_tipo_documento_multi' => $tipo_documento, //DOC MULTI
                                    'fecha_actualizacion' => 'now()',
                                    'usuario_id_actualizacion' => Yii::app()->user->id,
                                    'documentacion_id' => $documento->id_documentacion,
                                        )
                                );
                            }
                            $this->redirect(array('/documentacion/adminsarenMulti'));
                        }
                    }
                }
            }
            $this->render('multifamiliar', array('model' => $model, 'modell' => $modell, 'doc_banavih' => $doc_banavih));
        } else { //BANAVIH
            $consultaDoc = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 295, 'ente_documento' => 311, 'es_multi' => 1));
            $consultaDoc2 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 53, 'es_activo' => 1, 'es_multi' => 1, 'ente_documento' => 311));
            if (isset($consultaDoc)) {
                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 295, 'ente_documento' => 311, 'es_multi' => 1));
                $modell = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 295, 'ente_documento' => 312, 'es_multi' => 1));
            } else if (isset($consultaDoc2)) {
//                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 294, 'ente_documento' => 1));
//                $modell = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 294, 'ente_documento' => 1));
                $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'es_multi' => 1, 'ente_documento' => 311));
                $modell = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 295, 'es_multi' => 1, 'ente_documento' => 311));
            }
//            var_dump($model);die;
            if (isset($_POST['PlantillaDocumento']) || isset($_POST['Documentacion'])) {
                $documento = new Documentacion;
                $buscarDocMulti1 = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 53, 'es_multi' => 1));
                $buscarDocumentoDevuelto = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1, 'estatus' => 295, 'es_multi' => 1, 'ente_documento' => 311));
//                var_dump($buscarDocum$buscarDocumentoDevueltoentoDevuelto);die;
                if (!empty($buscarDocMulti1)) { //INSERT CUANDO EL DOCUMENTO ES GENERADO POR PRIMERA VEZ , (doc_primera_vez es TRUE)
                    Documentacion::model()->updateByPk($buscarDocMulti1->id_documentacion, array(
                        'estatus' => 54, //ESTATUS INACTIVO
                        'fecha_actualizacion' => 'now()',
                        'usuario_id_actualizacion' => Yii::app()->user->id,
                        'es_activo' => false,
                        'doc_primera_vez' => false,
                            )
                    );
                    $unidadHabitacional = UnidadHabitacional::model()->findByPk($id);
                    $fuente_financiamiento = $unidadHabitacional->desarrollo->fuenteFinanciamiento->id_fuente_financiamiento;
                    if ($fuente_financiamiento = 3) { //fasp
                        $tipo_documento = 298;
                    } else {
                        $tipo_documento = 297; //faov
                    }
                    $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                    $documento->tipo_documento_id = $tipo_documento;
                    $documento->estatus = 53; //ESTATUS ACTIVO
                    $documento->fecha_creacion = 'now()';
                    $documento->fecha_actualizacion = 'now()';
                    $documento->usuario_id_creacion = Yii::app()->user->id;
                    $documento->fk_beneficiario = $id;
                    $documento->es_multi = true;
                    $documento->ente_documento = 311;
                    $documento->doc_primera_vez = TRUE;
                    if ($documento->save()) {
                        $buscarCaso = Asignaciones::model()->findByAttributes(array('fk_caso_asignado' => $unidadHabitacional->id_unidad_habitacional, 'fk_estatus' => 304, 'es_activo' => TRUE));
                        //var_dump($buscarCaso);die;
                        if (!empty($buscarCaso)) {
                            $buscarCaso->es_activo = FALSE;
                            $buscarCaso->fecha_actualizacion = 'now()';
                            $buscarCaso->usuario_id_actualizacion = Yii::app()->user->id;
                            if ($buscarCaso->save()) {
                                $modelAsignaciones = new Asignaciones;
                                $modelAsignaciones->fk_estatus = 304; //ANALIZADO
                                $modelAsignaciones->fk_entidad = $buscarCaso->fk_entidad;
                                $modelAsignaciones->fk_usuario_asignado = $buscarCaso->fk_usuario_asignado;
                                $modelAsignaciones->fk_usuario_q_asigna = $buscarCaso->fk_usuario_q_asigna;
                                $modelAsignaciones->fk_caso_asignado = $buscarCaso->fk_caso_asignado;
                                $modelAsignaciones->fecha_creacion = 'now()';
                                $modelAsignaciones->usuario_id_creacion = Yii::app()->user->id;
                                $modelAsignaciones->es_activo = TRUE;
                                $modelAsignaciones->save();
                                /*  ACTUALIZACION DE TABLA UNIDAD_FAMILIAR PARA LA IDENTICACION DE DOCUMENTO MULTI  */
                                $ids_unidad_familiar = explode(',', $_POST['ids_unidad_familiar']);
                                foreach ($ids_unidad_familiar as $idBenef) {
                                    UnidadFamiliar::model()->updateByPk($idBenef, array(
                                        'fk_tipo_documento_multi' => $tipo_documento, //DOC MULTI
                                        'fecha_actualizacion' => 'now()',
                                        'usuario_id_actualizacion' => Yii::app()->user->id,
                                        'documentacion_id' => $documento->id_documentacion,
                                            )
                                    );
                                }
                            }
                        }
                            $this->redirect(array('/documentacion/adminmultifamiliar'));
                    }
                } else { //(doc_primera_vez NO INSERTA NADA)
                    Documentacion::model()->updateByPk($buscarDocumentoDevuelto->id_documentacion, array(
                        'estatus' => 54, //ESTATUS INACTIVO
                        'fecha_actualizacion' => 'now()',
                        'usuario_id_actualizacion' => Yii::app()->user->id,
                        'es_activo' => false,
                            )
                    );
                    $unidadHabitacional = UnidadHabitacional::model()->findByPk($id);
//                    var_dump($unidadHabitacional);die;
                    $fuente_financiamiento = $unidadHabitacional->desarrollo->fuenteFinanciamiento->id_fuente_financiamiento;
                    if ($fuente_financiamiento = 3) { //fasp
                        $tipo_documento = 298;
                    } else {
                        $tipo_documento = 297; //faov
                    }
                    $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
                    $documento->tipo_documento_id = $tipo_documento;
                    $documento->estatus = 295;
                    $documento->fecha_creacion = 'now()';
                    $documento->fecha_actualizacion = 'now()';
                    $documento->usuario_id_creacion = Yii::app()->user->id;
                    $documento->fk_beneficiario = $id;
                    $documento->es_multi = true;
                    $documento->ente_documento = 311;
                    if ($documento->save()) {
                        /*  ACTUALIZACION DE TABLA UNIDAD_FAMILIAR PARA LA IDENTICACION DE DOCUMENTO MULTI  */
                        $ids_unidad_familiar = explode(',', $_POST['ids_unidad_familiar']);
                        foreach ($ids_unidad_familiar as $idBenef) {
                            UnidadFamiliar::model()->updateByPk($idBenef, array(
                                'fk_tipo_documento_multi' => $tipo_documento, //DOC MULTI
                                'fecha_actualizacion' => 'now()',
                                'usuario_id_actualizacion' => Yii::app()->user->id,
                                'documentacion_id' => $documento->id_documentacion,
                                    )
                            );
                        }
                        $this->redirect(array('/documentacion/adminmultifamiliar'));
                    }
                }
            }
            $this->render('multifamiliar', array('model' => $model, 'modell' => $modell));
        }
    }
    /*
     * FUNCION QUE LISTA LA INFORMACION DE LA UNIDAD MULTIFAMULIAR // DESARROLLO
     */
    public function actionListarDocumento() {
        $agent_documentacion = $_POST['Documentacion']['agente_documentacion'];
        $apoderado = $_POST['Documentacion']['apoderado'];
        $error = array();
        $ids_unidad_familiar = array();
        $idUnidadHabitacional = $_POST['id_unidad_habitacional'];
        if (empty($apoderado) || empty($agent_documentacion)) {
            echo json_encode(array('cont' => '', 'sms' => '1'));
        } else {
            $unidadHabitacional = UnidadHabitacional::model()->findByPk($idUnidadHabitacional);
//            $unidadHabitacional = UnidadHabitacional::model()->findByAttributes(array('desarrollo_id' => $idUnidadHabitacional));
            $fuente_financiamiento = $unidadHabitacional->desarrollo->fuenteFinanciamiento->id_fuente_financiamiento;
            if ($fuente_financiamiento = 3) { //DOCUMENTO FASP
                $tipo_documento = 298;
            } else {
                $tipo_documento = 297; //DOCUMENTO FAOV
            }
//            if (empty($unidadHabitacional)) {
//                array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> EL BENEFICIARIO NO PRESENTA UN ANÁLISIS DE CREDITO');
//                echo json_encode(array('cont' => $error, 'sms' => '3'));
//                Yii::app()->end();
//            }
            $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $idUnidadHabitacional, 'es_activo' => 1, 'es_multi' => 1));
            if (empty($model)) {
                $model = PlantillaDocumento::model()->findByAttributes(array('fk_tipo_documento' => $tipo_documento));
            }
//            var_dump($idUnidadHabitacional);die;
            /* BUSQUEDA DE LOS DATOS DEL APODERADO */
            $data_apoderado = Abogados::model()->findByPk($apoderado);
            $info_apoderado = ConsultaOracle::setPersona("*", (int) $data_apoderado->persona_id);
//            /* BUSQUEDA DE LOS DATOS DEL AGENTE DE DOCUMENTACION */
            $data_agente = Abogados::model()->findByPk($agent_documentacion);
            $info_agente = ConsultaOracle::setPersona("*", (int) $data_agente->persona_id);
            $array = explode(" ", $model->documento);
            foreach ($array as &$value) {
                /* ------------------- DATOS DEL APODERADO ------------------- */
                if (stristr($value, '&MULTI_NOMBRE_APODERADO')) {
                    $value = $info_apoderado['PRIMER_NOMBRE'] . ' ' . $info_apoderado['PRIMER_APELLIDO'];
                }
                if (stristr($value, '&MULTI_CEDULA_APODERADO')) {
                    $value = ($info_apoderado['NACIONALIDAD'] == 1) ? "V-" . $info_apoderado['CEDULA'] : "E-" . '-' . $info_apoderado['CEDULA'];
                }
                if (stristr($value, '&MULTI_RIF_APODERADO')) {
                    if (isset($data_apoderado->rif_abogado)) {
                        $value = strtoupper($data_apoderado->rif_abogado);
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> RIF DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&MULTI_APODERADO_FOLIO')) {
                    if (isset($data_apoderado->folio)) {
                        $value = strtoupper($data_apoderado->folio);
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> FOLIO DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&MULTI_APODERADO_TOMO')) {
                    if (isset($data_apoderado->tomo)) {
                        $value = $data_apoderado->tomo;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> TOMO DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&MULTI_APODERADO_AÑO')) {
                    if (isset($data_apoderado->anio)) {
                        $value = $data_apoderado->anio;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> AÑO DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&MULTI_REGISTRO_PUBLICO_ESTADO_APODERADO')) {
                    if (isset($data_apoderado->registroPublico->fkParroquia->clvmunicipio0->clvestado0->strdescripcion)) {
                        $value = $data_apoderado->registroPublico->fkParroquia->clvmunicipio0->clvestado0->strdescripcion;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ESTADO DEL REGISTRO PÚBLICO AL QUE PERTENECE EL APODERADO');
                    }
                }
                if (stristr($value, '&MULTI_REGISTRO_PUBLICO_MUNICIPIO_APODERADO')) {
                    if (isset($data_apoderado->registroPublico->fkParroquia->clvmunicipio0->strdescripcion)) {
                        $value = $data_apoderado->registroPublico->fkParroquia->clvmunicipio0->strdescripcion;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> MUNICIPIO DEL REGISTRO PÚBLICO AL QUE PERTENECE EL APODERADO');
                    }
                }
                //nombre de la oficina del  registro publico
//                if (stristr($value, '&IMPRE_ABOGADO')) {
//                    $value = $data_apoderado->inpreabogado;
//                }
//                /* ------------------- FIN DATOS DEL APODERADO ------------------- */
                /* ------------------- DATOS DEL AGENTE DE DOCUMENTACION------------------- */
                if (stristr($value, '&NOMBRE_ABOGADO')) {
                    $value = $info_agente['PRIMER_NOMBRE'] . ' ' . $info_agente['PRIMER_APELLIDO'];
                }
                if (stristr($value, '&IMPRE_ABOGADO')) {
                    $value = $data_agente->inpreabogado;
                }
                /* ------------------- FIN DATOS DEL AGENTE DE DOCUMENTACION------------------- */
//            var_dump($model);die();
                if (stristr($value, '&')) {
//                    
                    /*                     * ** CONSULTA DE LAS UNIDADES FAMILIARES (BENEFICIARIOS) ASOCIADOS A UNA UNIDAD HABITACIONAL (UNIDAD MULTIFAMILIAR)   * ** */
                    if ($value == '&MULTI_UNIFAMILIAR_ALL') {
                        $consulta = Yii::app()->db->createCommand("SELECT be.id_beneficiario, unif.fk_tipo_documento_multi, unif.id_unidad_familiar AS id, unif.nombre, CASE WHEN tmp.nacionalidad = 97 THEN 'V' ELSE 'E' END || '-'||tmp.cedula AS cedula, tmp.nombre_completo 
                                        FROM unidad_familiar unif
                                        JOIN beneficiario be ON unif.beneficiario_id = be.id_beneficiario 
                                        JOIN beneficiario_temporal tmp ON be.beneficiario_temporal_id = tmp.id_beneficiario_temporal AND tmp.estatus = 272
                                        JOIN maestro ma ON tmp.nacionalidad = ma.id_maestro
                                        WHERE unif.fk_tipo_documento_multi IS NULL AND  tmp.unidad_habitacional_id =  " . $unidadHabitacional->id_unidad_habitacional . " 
                                        ORDER BY unif.nombre ASC")->queryAll();
                        $cont = '';
                        foreach ($consulta as $valor) {
                            array_push($ids_unidad_familiar, $valor['id']);
                            $cont.='<b>' . $valor['nombre'] . ':</b> representada en este acto por la ciudadana <b> ' . $valor['nombre_completo'] . '</b> , titular de la Cédula de Identidad <b> Nº ' . $valor['cedula'] . '</b>, ';
                        }
                        $value = $cont;
                    }
                    if ($value == '&MULTI_CANT_UNIFA_LETRA') {
                        $count_unif = count($consulta);
                        $value = str_replace('00', '', Generico::numtoletras($count_unif));
                    }
                    if ($value == '&MULTI_CANT_UNIFAMILIAR_NUM') {
                        $count_unif = count($consulta);
                        $value = $count_unif;
                    }
                    /* CONSULTA QUE TRAE LAS VIVIENDAS QUE ESTAN ASOCIADAS A LA UNIDAD HABITACIONAL(UNIDAD MULTIFAMILIAR) */
                    if ($value == '&MULTI_VIVIENDA_ALL') {
                        $consul = Yii::app()->db->createCommand("SELECT vi.id_vivienda as id, uh.nombre, uh.gen_tipo_inmueble_id, m.descripcion, 
                                                                vi.tipo_vivienda_id, ms.descripcion as vivienda , vi.construccion_mt2, vi.nro_piso, vi.nro_vivienda, vi.sala, vi.cocina,
                                                                vi.comedor, vi.lavandero, vi.nro_estacionamientos, vi.descripcion_estac, vi.nro_habitaciones, vi.nro_banos, vi.nro_banos_auxiliar, 
                                                                vi.lindero_norte, vi.lindero_sur, vi.lindero_este , vi.lindero_oeste, vi.porcentaje_vivienda
                                                                FROM vivienda vi
                                                                JOIN unidad_habitacional uh ON uh.id_unidad_habitacional= vi.unidad_habitacional_id 
                                                                JOIN maestro ms ON ms.id_maestro = vi.tipo_vivienda_id 
                                                                JOIN maestro m ON m.id_maestro = uh.gen_tipo_inmueble_id
                                                                WHERE  uh.id_unidad_habitacional = " . $unidadHabitacional->id_unidad_habitacional . " 
                                                                AND NOT vi.estatus_vivienda_id = 211 ORDER BY nro_vivienda ASC")->queryAll();
                        $cont = '';
                        foreach ($consul as $valores) {
                            $porcentavivienda = $valores['porcentaje_vivienda'] / 100;
                            $cont.= (($valores['nro_piso'] != '') ? '<b> PISO ' . $valores['nro_piso'] . ' :</b>' : '') . '<b> ' . $valores['vivienda'] . ' ' . $valores['nro_vivienda'] . ' :</b> Tiene una superficie de'
                                    . ' ' . str_replace('00', '', Generico::numtoletras($valores['construccion_mt2'])) . 'metros cuadrados (' . $valores['construccion_mt2'] . ' mts2), sus linderos son; '
                                    . ' <b>NORTE:</b> ' . $valores['lindero_norte'] . ' , <b>SUR:</b> ' . $valores['lindero_sur'] . ' , <b>ESTE:</b> ' . $valores['lindero_este'] . ' y <b>OESTE: </b>' . $valores['lindero_oeste'] . ''
                                    . '. Consta de los siguientes ambientes (' . (($valores['sala'] = 'TRUE' && $valores['cocina'] = 'TRUE' && $valores['comedor'] = 'TRUE' && $valores['lavandero'] = 'TRUE') ? 'Sala , Cocina , Comedor , Lavandero' : ' Sala: No , Cocina: No, Comedor: No , Lavandero: No') . ''
                                    . ', ' . $valores['nro_banos'] . ' Baños, ' . $valores['nro_habitaciones'] . ' Habitaciones). '
                                    . 'Le Corresponde un porcentaje de cargas sobre cosas de uso y disfrute común (' . (($porcentavivienda != '') ? '' . str_replace('00', '', Generico::numtoletras($valores['porcentaje_vivienda'])) . ' Porciento, ' . $valores['porcentaje_vivienda'] . ' %' : ' 0 %' ) . ').'
                                    . '' . (($valores['descripcion_estac'] != '') ? ' Asimismo, le corresponde el uso exclusivo de ' . $valores['descripcion_estac'] . ' Puesto de estacionamiento del área común de estacionamientos.' : '') . '';
                            //$cont.='<b>' . $valores['vivienda'] .'</b>  ';
                        }
                        $value = $cont;
                    }
                    //CANTIDAD DE VIVIENDAS 
                    if ($value == '&MULTI_TOTAL_VIVIENDAS') {
                        $consul_vivienda = Yii::app()->db->createCommand("SELECT  tipo_vivienda_id, ms.descripcion AS tipo,  COUNT(tipo_vivienda_id) AS cantidad FROM vivienda vi
                                                                        JOIN maestro ms ON ms.id_maestro = vi.tipo_vivienda_id 
                                                                        JOIN unidad_habitacional uh ON uh.id_unidad_habitacional= vi.unidad_habitacional_id
                                                                        WHERE  uh.id_unidad_habitacional= " . $unidadHabitacional->id_unidad_habitacional . " 
                                                                        GROUP BY tipo_vivienda_id, ms.descripcion")->queryAll();
                        $cont = '';
                        foreach ($consul_vivienda as $valor) {
                            $cont.=' ' . $valor['cantidad'] . ' ' . $valor['tipo'] . ' ';
                        }
                        $value = $cont;
                    }
//                    if ($value == '&MULTI_TOTAL_EDIFICIOS') { //cantidad de apartamentos 
//                        $count_total_unif = UnidadHabitacional::model()->count('id_unidad_habitacional=:id_unidad_habitacional', array('id_unidad_habitacional' => $unidadHabitacional->id_unidad_habitacional));
//                        $value = $count_total_unif;
//                    }
                    $variable = VariablesDocumentos::model()->findByAttributes(array('variable' => $value));
                    if (!empty($variable)) {
                        $string = explode(',', $variable->relation);
                        switch (count($string)) {
                            case 1:
                                if (isset($unidadHabitacional->$string[0])) {
                                    $valor = $unidadHabitacional->$string[0];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 2:
                                if (isset($unidadHabitacional->$string[0]->$string[1])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 3:
                                if (isset($unidadHabitacional->$string[0]->$string[1]->$string[2])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1]->$string[2];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 4:
                                if (isset($unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 5:
                                if (isset($unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 6:
                                if (isset($unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 7:
                                if (isset($unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5]->$string[6])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5]->$string[6];
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
                            array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ' . $variable->label . ' ');
                        }
                    }
                }
            }
            $ids_unidad_familiar = implode(',', $ids_unidad_familiar); // UD DE LAS UNIDADES FALIMILARES ASOCIADAS DEL DOCUMENTO MULTI
            if (empty($error)) {
                $cont = $model->documento = implode(' ', $array);
//                echo json_encode(array('cont' => $cont, 'sms' => '2'));
                echo json_encode(array('cont' => $cont, 'sms' => '2', 'ids_unidad_familiar' => $ids_unidad_familiar));
            } else {
                $error = implode('<br /> ', $error);
//                echo json_encode(array('cont' => $error, 'sms' => '3'));
                echo json_encode(array('cont' => $error, 'sms' => '3', 'ids_unidad_familiar' => $ids_unidad_familiar));
            }
        }
    }
    public function actionPdf($id) {
        $Documentacion = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'es_activo' => true, 'ente_documento' => 311));
        //$titilo = $Documentacion->tipoDocumento->descripcion;
        $documento = $Documentacion->documento;
        $id = $Documentacion->id_documentacion;
        $this->render('pdf', array('documento' => $documento, 'id' => $id));
    }
    public function actionPdfById($id) {
        $Documentacion = Documentacion::model()->findBypK($id);
//        $titilo = $Documentacion->tipoDocumento->descripcion;
        $documento = $Documentacion->documento;
        $id = $Documentacion->id_documentacion;
        $this->render('pdf', array('documento' => $documento, 'id' => $id));
    }
    /*
     * Funcion que genera el view de documento perteneciente al beneficiario
     */
    public function actionGenerar($id) { //generar documento del beneficiario
        $model = new Documentacion;
        if (isset($_POST['PlantillaDocumento']) || isset($_POST['Documentacion'])) {
            $documento = new Documentacion;
            $buscarBeneficiario = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $id, 'estatus' => 53));
            if (!empty($buscarBeneficiario)) {
                Documentacion::model()->updateByPk($buscarBeneficiario->id_documentacion, array(
                    'estatus' => 54, //ESTATUS INACTIVO
                    'fecha_actualizacion' => 'now()',
                    'usuario_id_actualizacion' => Yii::app()->user->id,
                        )
                );
            }
            $beneficiario = Beneficiario::model()->findByPk($id);
            $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
            $documento->tipo_documento_id = $beneficiario->unidadFamiliars[0]->analisisCreditos[0]->tipo_documento_id;
            $documento->estatus = 53; //ESTATUS ACTIVO
            $documento->fecha_creacion = 'now()';
            $documento->fecha_actualizacion = 'now()';
            $documento->usuario_id_creacion = Yii::app()->user->id;
            $documento->fk_beneficiario = $id;
            $documento->ente_documento = 311;
            $documento->doc_primera_vez = TRUE;
            if ($documento->save()) {
                $this->redirect(array('/documentacion/adminbeneficiario'));
            }
        }
        $this->render('generar', array('model' => $model));
    }
    /*
     * Listar Adendum
     */
    public function actionListarAdendum($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('listadoAdendum', array('model' => $id), false, true);
        }
    }
    /*
     * Action to Document Adendum
     */
    public function actionAdendum($id) {
        $model = new Documentacion;
        if (isset($_POST['PlantillaDocumento']) || isset($_POST['Documentacion'])) {
//            var_dump($_POST['ids_unidad_familiar']);die;
            /*  ACTUALIZACION DE TABLA UNIDAD_FAMILIAR PARA LA IDENTICACION DE DOCUMENTO MULTI  */
            $documento = new Documentacion;
            $documento->documento = isset($_POST['PlantillaDocumento']['documento']) ? $_POST['PlantillaDocumento']['documento'] : $_POST['Documentacion']['documento'];
            $documento->tipo_documento_id = 277;
            $documento->estatus = 53; //ESTATUS ACTIVO
            $documento->fecha_creacion = 'now()';
            $documento->fecha_actualizacion = 'now()';
            $documento->usuario_id_creacion = Yii::app()->user->id;
            $documento->fk_beneficiario = $id;
            $documento->es_multi = true;
            if ($documento->save()) {
                $ids_unidad_familiar = explode(',', $_POST['ids_unidad_familiar']);
                foreach ($ids_unidad_familiar as $id) {
                    UnidadFamiliar::model()->updateByPk($id, array(
                        'fk_tipo_documento_multi' => 277, //DOC MULTI
                        'fecha_actualizacion' => 'now()',
                        'usuario_id_actualizacion' => Yii::app()->user->id,
                        'documentacion_id' => $documento->id_documentacion
                            )
                    );
                }
                $this->redirect(array('/documentacion/adminmultifamiliar'));
            }
        }
        $this->render('adendum', array('model' => $model));
    }
    /*
     * FUNCION QUE LISTA LA INFORMACION DE LA UNIDAD MULTIFAMULIAR // DESARROLLO
     */
    public function actionListarDocumentoAdendum() {
        $agent_documentacion = $_POST['Documentacion']['agente_documentacion'];
        $apoderado = $_POST['Documentacion']['apoderado'];
        $error = array();
        $ids_unidad_familiar = array();
//        $id_beneficiario = 53;
        $idUnidadHabitacional = $_POST['id_unidad_habitacional'];
//            var_dump($idUnidadHabitacional);die;
        if (empty($apoderado) || empty($agent_documentacion)) {
            echo json_encode(array('cont' => '', 'sms' => '1'));
        } else {
//            $unidadHabitacional = UnidadHabitacional::model()->findByPk($idUnidadHabitacional);
            $unidadHabitacional = UnidadHabitacional::model()->findByAttributes(array('desarrollo_id' => $idUnidadHabitacional));
            if (empty($unidadHabitacional)) {
                array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> EL BENEFICIARIO NO PRESENTA UN ANÁLISIS DE CREDITO');
                echo json_encode(array('cont' => $error, 'sms' => '3'));
                Yii::app()->end();
            }
//            $model = Documentacion::model()->findByAttributes(array('fk_beneficiario' => $idUnidadHabitacional, 'es_activo' => 1, 'es_multi' => 1));
//            if (empty($model)) {
            $model = PlantillaDocumento::model()->findByAttributes(array('fk_tipo_documento' => 277));
//            }
            /* BUSQUEDA DE LOS DATOS DEL APODERADO */
            $data_apoderado = Abogados::model()->findByPk($apoderado);
            $info_apoderado = ConsultaOracle::setPersona("*", (int) $data_apoderado->persona_id);
//            /* BUSQUEDA DE LOS DATOS DEL AGENTE DE DOCUMENTACION */
            $data_agente = Abogados::model()->findByPk($agent_documentacion);
            $info_agente = ConsultaOracle::setPersona("*", (int) $data_agente->persona_id);
            $array = explode(" ", $model->documento);
            foreach ($array as &$value) {
                /* ------------------- DATOS DEL APODERADO ------------------- */
                if (stristr($value, '&MULTI_NOMBRE_APODERADO')) {
                    $value = $info_apoderado['PRIMER_NOMBRE'] . ' ' . $info_apoderado['PRIMER_APELLIDO'];
                }
                if (stristr($value, '&MULTI_CEDULA_APODERADO')) {
                    $value = ($info_apoderado['NACIONALIDAD'] == 1) ? "V-" . $info_apoderado['CEDULA'] : "E-" . '-' . $info_apoderado['CEDULA'];
                }
                if (stristr($value, '&MULTI_RIF_APODERADO')) {
                    if (isset($data_apoderado->rif_abogado)) {
                        $value = strtoupper($data_apoderado->rif_abogado);
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> RIF DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&MULTI_APODERADO_FOLIO')) {
                    if (isset($data_apoderado->folio)) {
                        $value = strtoupper($data_apoderado->folio);
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> FOLIO DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&MULTI_APODERADO_TOMO')) {
                    if (isset($data_apoderado->tomo)) {
                        $value = $data_apoderado->tomo;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> TOMO DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&MULTI_APODERADO_AÑO')) {
                    if (isset($data_apoderado->anio)) {
                        $value = $data_apoderado->anio;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> AÑO DEL REGISTRO DEL APODERADO');
                    }
                }
                if (stristr($value, '&MULTI_REGISTRO_PUBLICO_ESTADO_APODERADO')) {
                    if (isset($data_apoderado->registroPublico->fkParroquia->clvmunicipio0->clvestado0->strdescripcion)) {
                        $value = $data_apoderado->registroPublico->fkParroquia->clvmunicipio0->clvestado0->strdescripcion;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ESTADO DEL REGISTRO PÚBLICO AL QUE PERTENECE EL APODERADO');
                    }
                }
                if (stristr($value, '&MULTI_REGISTRO_PUBLICO_MUNICIPIO_APODERADO')) {
                    if (isset($data_apoderado->registroPublico->fkParroquia->clvmunicipio0->strdescripcion)) {
                        $value = $data_apoderado->registroPublico->fkParroquia->clvmunicipio0->strdescripcion;
                    } else {
                        array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> MUNICIPIO DEL REGISTRO PÚBLICO AL QUE PERTENECE EL APODERADO');
                    }
                }
                //nombre de la oficina del  registro publico
//                if (stristr($value, '&IMPRE_ABOGADO')) {
//                    $value = $data_apoderado->inpreabogado;
//                }
//                /* ------------------- FIN DATOS DEL APODERADO ------------------- */
                /* ------------------- DATOS DEL AGENTE DE DOCUMENTACION------------------- */
                if (stristr($value, '&NOMBRE_ABOGADO')) {
                    $value = $info_agente['PRIMER_NOMBRE'] . ' ' . $info_agente['PRIMER_APELLIDO'];
                }
                if (stristr($value, '&IMPRE_ABOGADO')) {
                    $value = $data_agente->inpreabogado;
                }
                /* ------------------- FIN DATOS DEL AGENTE DE DOCUMENTACION------------------- */
                if (stristr($value, '&')) {
//                    echo '<pre>';var_dump($value);
                    /*                     * ** SEARCH COSOLICITANTE * ** */
                    if ($value == '&MULTI_UNIFAMILIAR_ALL') {
                        $consulta = Yii::app()->db->createCommand("SELECT be.id_beneficiario, unif.fk_tipo_documento_multi, unif.id_unidad_familiar AS id, unif.nombre, CASE WHEN tmp.nacionalidad = 97 THEN 'V' ELSE 'E' END || '-'||tmp.cedula AS cedula, tmp.nombre_completo 
                                        FROM unidad_familiar unif
                                        JOIN beneficiario be ON unif.beneficiario_id = be.id_beneficiario 
                                        JOIN beneficiario_temporal tmp ON be.beneficiario_temporal_id = tmp.id_beneficiario_temporal AND tmp.estatus = 272
                                        JOIN maestro ma ON tmp.nacionalidad = ma.id_maestro
                                        WHERE unif.fk_tipo_documento_multi IS NULL AND  tmp.desarrollo_id = " . $unidadHabitacional->desarrollo_id . " 
                                        ORDER BY unif.nombre ASC")->queryAll();
                        $cont = '';
                        foreach ($consulta as $valor) {
                            array_push($ids_unidad_familiar, $valor['id']);
                            $cont.='<b>' . $valor['nombre'] . ':</b> representada en este acto por la ciudadana <b> ' . $valor['nombre_completo'] . '</b> , titular de la Cédula de Identidad <b> Nº ' . $valor['cedula'] . '</b>, ';
                        }
                        $value = $cont;
                    }
                    if ($value == '&MULTI_CANT_UNIFA_LETRA') {
                        $count_unif = count($consulta);
                        $value = str_replace('00', '', Generico::numtoletras($count_unif));
                    }
                    if ($value == '&MULTI_CANT_UNIFAMILIAR_NUM') {
                        $count_unif = count($consulta);
                        $value = $count_unif;
                    }
                    if ($value == '&MULTI_TOTAL_EDIFICIOS') {
                        $count_total_unif = UnidadHabitacional::model()->count('desarrollo_id=:desarrollo_id', array('desarrollo_id' => $unidadHabitacional->desarrollo_id));
                        $value = $count_total_unif;
                    }
                    $variable = VariablesDocumentos::model()->findByAttributes(array('variable' => $value));
                    if (!empty($variable)) {
                        $string = explode(',', $variable->relation);
                        switch (count($string)) {
                            case 1:
                                if (isset($unidadHabitacional->$string[0])) {
                                    $valor = $unidadHabitacional->$string[0];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 2:
                                if (isset($unidadHabitacional->$string[0]->$string[1])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 3:
                                if (isset($unidadHabitacional->$string[0]->$string[1]->$string[2])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1]->$string[2];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 4:
                                if (isset($unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 5:
                                if (isset($unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 6:
                                if (isset($unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5];
                                } else {
                                    $valor = null;
                                }
                                break;
                            case 7:
                                if (isset($unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5]->$string[6])) {
                                    $valor = $unidadHabitacional->$string[0]->$string[1]->$string[2]->$string[3]->$string[4]->$string[5]->$string[6];
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
                            array_push($error, '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ' . $variable->label . ' ');
                        }
                    }
                }
            }
            $ids_unidad_familiar = implode(',', $ids_unidad_familiar); // UD DE LAS UNIDADES FALIMILARES ASOCIADAS DEL DOCUMENTO MULTI
            if (empty($error)) {
                $cont = $model->documento = implode(' ', $array);
//                echo json_encode(array('cont' => $cont, 'sms' => '2'));
                echo json_encode(array('cont' => $cont, 'sms' => '2', 'ids_unidad_familiar' => $ids_unidad_familiar));
            } else {
                $error = implode('<br /> ', $error);
//                echo json_encode(array('cont' => $error, 'sms' => '3'));
                echo json_encode(array('cont' => $error, 'sms' => '3', 'ids_unidad_familiar' => $ids_unidad_familiar));
            }
        }
    }
    public function actionAdminsarenBene() {
        $model = new Beneficiario('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Beneficiario']))
            $model->attributes = $_GET['Beneficiario'];
        
        
        $sql = "select iduser from cruge_user where iduser =" . Yii::app()->user->id;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $row = $command->queryAll();
        $idUser = $row[0]["iduser"];
//        $idPersona = $row[0]["id_persona"];
        $cruge_estado = CrugeFieldValue::model()->findByAttributes(array('iduser' => $idUser, 'idfield' => 5));
//        $cruge_cargo = CrugeFieldValue::model()->findByAttributes(array('iduser' => $idUser, 'idfield' => 0));
        $field = CrugeField::model()->findByAttributes(array('idfield' => 5));
        $arOpt = CrugeUtil::explodeOptions($field->predetvalue);
        $estado = $arOpt[$cruge_estado->value];
//        var_dump($cruge_estado);die;
//        if ($cruge_estado->value >= 17 && $cruge_estado->value <= 20) {
//            $tipo_poa = MaestroPoa::model()->findByPk(70);
//        } else {
//            $tipo_poa = MaestroPoa::model()->findByPk(71);
//        }
        $this->render('adminsarenBene', array(
            'model' => $model,
            'estado' => $estado,
//            'cruge_estado' => $cruge_estado,
            
        ));
//        $this->render('adminsarenBene', array('model' => $model,));
    }
    public function actionAdminsarenMulti() {
        $model = new VswMultifamiliar('search');
//        $model->unsetAttributes();  // clear any default values
//        if (isset($_GET['VswMultifamiliar']))
//            $model->attributes = $_GET['VswMultifamiliar'];
        $sql = "select iduser from cruge_user where iduser =" . Yii::app()->user->id;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $row = $command->queryAll();
        
//        var_dump($row[0]);die;
        $idUser = $row[0]["iduser"];
//        $idPersona = $row[0]["id_persona"];
        $cruge_estado = CrugeFieldValue::model()->findByAttributes(array('iduser' => $idUser, 'idfield' => 5));
//        $cruge_cargo = CrugeFieldValue::model()->findByAttributes(array('iduser' => $idUser, 'idfield' => 0));
        $field = CrugeField::model()->findByAttributes(array('idfield' => 5));
        $arOpt = CrugeUtil::explodeOptions($field->predetvalue);
        $estado = $arOpt[$cruge_estado->value];
        
//        if ($cruge_estado->value >= 17 && $cruge_estado->value <= 20) {
//            $tipo_poa = MaestroPoa::model()->findByPk(70);
//        } else {
//            $tipo_poa = MaestroPoa::model()->findByPk(71);
//        }
        $this->render('adminsarenMulti', array(
            'model' => $model,
            'estado' => $estado,
            'cruge_estado' => $cruge_estado,
        ));
    }
    public function actionCambioEstatusDocumento() {
//        $model = new Documentacion;
        $caso = $_POST['caso'];
        $id = $_POST['codigo'];
        if ($caso == 1) {
            $sql1 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 311 and es_multi = true)");
            $sql2 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 312 and es_multi = true)");
            $docBanavih = Yii::app()->db->createCommand($sql1)->queryColumn();
            $docSaren = Yii::app()->db->createCommand($sql2)->queryRow();
//            var_dump($docSaren);die;
            foreach ($docBanavih as $idDocBanavih) {
                
            }
            if ($docSaren != false) {
                foreach ($docSaren as $idDocSaren) {
                    
                }
            } else {
                $idDocSaren = 0;
            }
            if ($idDocBanavih < $idDocSaren) {
                echo json_encode(2);
            } else if ($idDocBanavih > $idDocSaren) {
                $model = Documentacion::model()->findAllByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1));
                foreach ($model as $documentos) {
//            var_dump($documentos);die;
//                var_dump($id);die;
                    $desarrollo = UnidadHabitacional::model()->findByPk($id);
//                var_dump($desarrollo);die;
                    $documentos->estatus = 285; //ESTATUS VALIDADO POR BANAVIH (MULTIFAMILIAR)
                    $documentos->usuario_id_creacion = Yii::app()->user->id;
                    $documentos->fecha_creacion = 'now()';
                    if ($documentos->save()) {
                        $desarrollo->estatus_msj = 'VALIDADO POR BANAVIH (EN ESPERA DE SAREN)';
                        $desarrollo->fecha_actualizacion = 'now()';
                        $desarrollo->usuario_id_actualizacion = Yii::app()->user->id;
                        $desarrollo->update();
                    }
                }
                if ($documentos->save()) {
                    echo json_encode(1);
                }
            }
        } else if ($caso == 2) {
            $sql1 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 311 and es_multi = true)");
            $sql2 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 312 and es_multi = true)");
            $docBanavih = Yii::app()->db->createCommand($sql1)->queryColumn();
            $docSaren = Yii::app()->db->createCommand($sql2)->queryRow();
            foreach ($docBanavih as $idDocBanavih) {
                
            }
            if ($docSaren != false) {
                foreach ($docSaren as $idDocSaren) {
                    
                }
            } else {
                $idDocSaren = 0;
            }
            if ($idDocBanavih < $idDocSaren) {
                echo json_encode(2);
            } else {
                $model = Documentacion::model()->findAllByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1));
                foreach ($model as $documentos) {
                    $desarrollo = UnidadHabitacional::model()->findByPk($id);
                    $documentos->estatus = 286; //ESTATUS VALIDADO POR SAREN (MULTIFAMILIAR)
                    $documentos->usuario_id_creacion = Yii::app()->user->id;
                    $documentos->fecha_creacion = 'now()';
                    if ($documentos->save()) {
                        $desarrollo->estatus_msj = 'VALIDADO POR SAREN';
                        $desarrollo->fecha_actualizacion = 'now()';
                        $desarrollo->usuario_id_actualizacion = Yii::app()->user->id;
                        $desarrollo->update();
                    }
                }
                if ($documentos->save()) {
                    echo json_encode(1);
                }
            }
        } else if ($caso == 3) {
            $sql1 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 311 and es_multi = false)");
            $sql2 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 312 and es_multi = false)");
            $docBanavih = Yii::app()->db->createCommand($sql1)->queryColumn();
            $docSaren = Yii::app()->db->createCommand($sql2)->queryRow();
//            var_dump($docSaren);die;
            foreach ($docBanavih as $idDocBanavih) {
                
            }
            if ($docSaren != false) {
                foreach ($docSaren as $idDocSaren) {
                    
                }
            } else {
                $idDocSaren = 0;
            }
            if ($idDocBanavih < $idDocSaren) {
                echo json_encode(2);
            } else if ($idDocBanavih > $idDocSaren) {
                $model = Documentacion::model()->findAllByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1));
//            var_dump($bene->update());die;
                foreach ($model as $documentos) {
                    $bene = Beneficiario::model()->findByPk($id);
                    $documentos->estatus = 292; //ESTATUS VALIDADO POR BANAVIH (UNIFAMILIAR)
                    $documentos->usuario_id_creacion = Yii::app()->user->id;
                    $documentos->fecha_creacion = 'now()';
//                $documentos->ente_documento = 311;
                    if ($documentos->save()) {
                        $bene->estatus_msj = 'VALIDADO POR BANAVIH (EN ESPERA DE SAREN)';
                        $bene->fecha_actualizacion = 'now()';
                        $bene->usuario_id_actualizacion = Yii::app()->user->id;
                        $bene->update();
                    }
//                var_dump($documentos->save());die;
                }
                if ($documentos->save()) {
                    echo json_encode(1);
                }
            }
        } else if ($caso == 4) {
            $sql1 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 311 and es_multi = false)");
            $sql2 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 312 and es_multi = false)");
            $docBanavih = Yii::app()->db->createCommand($sql1)->queryColumn();
            $docSaren = Yii::app()->db->createCommand($sql2)->queryRow();
            foreach ($docBanavih as $idDocBanavih) {
                
            }
            if ($docSaren != false) {
                foreach ($docSaren as $idDocSaren) {
                    
                }
            } else {
                $idDocSaren = 0;
            }
            if ($idDocBanavih < $idDocSaren) {
                echo json_encode(2);
            } else {
                $model = Documentacion::model()->findAllByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1));
                foreach ($model as $documentos) {
                    $bene = Beneficiario::model()->findByPk($id);
                    $documentos->estatus = 293; //ESTATUS VALIDADO POR SAREN (UNIFAMILIAR)
                    $documentos->usuario_id_creacion = Yii::app()->user->id;
                    $documentos->fecha_creacion = 'now()';
//                $documentos->ente_documento = 312;
                    if ($documentos->save()) {
                        $bene->estatus_msj = 'VALIDADO POR SAREN';
                        $bene->fecha_actualizacion = 'now()';
                        $bene->usuario_id_actualizacion = Yii::app()->user->id;
                        $bene->update();
                        $updateBeneTemp = BeneficiarioTemporal::model()->updateByPk($bene->beneficiario_temporal_id, array(
                        'estatus' => 80,
                        'usuario_id_actualizacion' => Yii::app()->user->id,
                        'fecha_actualizacion' => 'now()'
        ));
                        
                    }
                }
                if ($documentos->save()) {
                    echo json_encode(1);
                }
            }
        } else if ($caso == 5) {
//            VALIDACION PARA CUANDO EL DOCUMENTO A DEVOLVER A BANAVIH NO HA SIDO CORREGIDO
            $sql1 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 311 and es_multi = false)");
            $sql2 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 312 and es_multi = false)");
            $docBanavih = Yii::app()->db->createCommand($sql1)->queryColumn();
            $docSaren = Yii::app()->db->createCommand($sql2)->queryRow();
            foreach ($docBanavih as $idDocBanavih) {
                
            }
            if ($docSaren != false) {
                foreach ($docSaren as $idDocSaren) {
                    
                }
            } else {
                $idDocSaren = 0;
            }
            if ($idDocBanavih > $idDocSaren) {
                echo json_encode(2);
            } else { //FIN DE LA VALIDACION
                $model = Documentacion::model()->findAllByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1));
                foreach ($model as $documentos) {
                    $bene = Beneficiario::model()->findByPk($id);
                    $documentos->estatus = 294; //ESTATUS DEVUELTO POR SAREN (UNIFAMILIAR)
                    $documentos->usuario_id_creacion = Yii::app()->user->id;
                    $documentos->fecha_creacion = 'now()';
                    if ($documentos->save()) {
                        $bene->estatus_msj = 'DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)';
                        $bene->fecha_actualizacion = 'now()';
                        $bene->usuario_id_actualizacion = Yii::app()->user->id;
                        $bene->update();
                    }
                }
                if ($documentos->save()) {
                    echo json_encode(1);
                }
                $model2 = Documentacion::model()->findAllByAttributes(array('fk_beneficiario' => $id, 'doc_primera_vez' => 1));
                if ($model2 != "") {
//            var_dump($model2);die;
                    foreach ($model2 as $documentoss) {
                        $documentoss->doc_primera_vez = false;
                        $documentoss->save();
                    }
                }
            }
        } else if ($caso == 6) {
//            VALIDACION PARA CUANDO EL DOCUMENTO A DEVOLVER A BANAVIH NO HA SIDO CORREGIDO
            $sql1 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 311 and es_multi = true)");
            $sql2 = ("SELECT id_documentacion FROM documentacion WHERE id_documentacion = (SELECT MAX (id_documentacion) FROM documentacion where fk_beneficiario =" . $id . "and es_activo = true and ente_documento = 312 and es_multi = true)");
            $docBanavih = Yii::app()->db->createCommand($sql1)->queryColumn();
            $docSaren = Yii::app()->db->createCommand($sql2)->queryRow();
            foreach ($docBanavih as $idDocBanavih) {
                
            }
            if ($docSaren != false) {
                foreach ($docSaren as $idDocSaren) {
                    
                }
            } else {
                $idDocSaren = 0;
            }
            if ($idDocBanavih > $idDocSaren) {
                echo json_encode(2);
            } else { //FIN DE LA VALIDACION
                $model = Documentacion::model()->findAllByAttributes(array('fk_beneficiario' => $id, 'es_activo' => 1));
//            $model2 = Documentacion::model()->findAll('fk_beneficiario=' . $id);
                foreach ($model as $documentos) {
                    $desarrollo = UnidadHabitacional::model()->findByPk($id);
//                if (empty($desarrollo->observaciones)) {
////                    echo json_encode(2);
//                } else {
                    $documentos->estatus = 295; //ESTATUS DEVUELTO POR SAREN (MULTIFAMILIAR)
                    $documentos->usuario_id_creacion = Yii::app()->user->id;
                    $documentos->fecha_creacion = 'now()';
//                $documentos->doc_primera_vez = false; 
                    if ($documentos->save()) {
                        $desarrollo->estatus_msj = 'DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)';
                        $desarrollo->fecha_actualizacion = 'now()';
                        $desarrollo->usuario_id_actualizacion = Yii::app()->user->id;
                        $desarrollo->update();
                    }
                }
                if ($documentos->save()) {
                    echo json_encode(1);
                }
                $model2 = Documentacion::model()->findAllByAttributes(array('fk_beneficiario' => $id, 'doc_primera_vez' => 1));
                if ($model2 != "") {
//            var_dump($model2);die;
                    foreach ($model2 as $documentoss) {
                        $documentoss->doc_primera_vez = false;
                        $documentoss->save();
                    }
                }
            }
        }
    }
}