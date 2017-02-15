<?php

class BeneficiarioController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
#public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
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
        $condUnidadFam = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'condUnidadFam' => $condUnidadFam,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionCulminarRegistro($id) {
        Generico::renderTraza($id);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    //PRIMER INSERT EN BENEFICIARIO
    public function actionCreate() {
        
        $model = new Beneficiario;
        $desarrollo = new Desarrollo;
        $vivienda = new Vivienda;
        $unidad_familiar = new UnidadFamiliar;
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Beneficiario'])) {
            
            $model->attributes = $_POST['Beneficiario'];
            
            $Existe = BeneficiarioTemporal::model()->findByPk($model->beneficiario_temporal_id);
            
            if (empty($Existe)) {
                
                $this->render('create', array(
                    'model' => $model, 'desarrollo' => $desarrollo, 'municipio' => $municipio, 'estado' => $estado, 'parroquia' => $parroquia, 'unidad_familiar' => $unidad_familiar, 'vivienda' => $vivienda, 'error' => 1
                ));
                
                Yii::app()->end();
                
            } else {

                $censado = Beneficiario::model()->findByAttributes(array('beneficiario_temporal_id' => $Existe->id_beneficiario_temporal));

                if (empty($censado)) {

                    $model->fecha_creacion = 'now()';
                    $model->fecha_actualizacion = 'now()';
                    $model->fecha_ultimo_censo = Generico::formatoFecha($_POST['Beneficiario']['fecha_ultimo_censo']);
                    $model->usuario_id_creacion = Yii::app()->user->id;
                    $model->persona_id = $Existe->persona_id;
                    $model->estatus_beneficiario_id = 223;
                    if ($model->save()) {
//                        $Existe->estatus = 224;
//                        $Existe->save();

                        $viviendaUpdate = ViviendaController::loadModel($Existe->vivienda_id);
                        $viviendaUpdate->construccion_mt2 = $_POST['Vivienda']['construccion_mt2'];
                        if ($viviendaUpdate->save()) {
//                            $unidad_familiar->nombre = $Existe->nombre_completo;
                            $unidad_familiar->beneficiario_id = $model->id_beneficiario;
                            $unidad_familiar->ingreso_total_familiar = '0.00';
//                            $unidad_familiar->procedencia_beneficio_id = 140; //INIDICAR EN QUE MOMENTO SE CARGA ESTE DATO
                            $unidad_familiar->fuente_datos_entrada_id = 90;
                            $unidad_familiar->condicion_unidad_familiar_id = $_POST['UnidadFamiliar']['condicion_unidad_familiar_id']; //Berifivar cual es el id
                            $unidad_familiar->total_personas_cotizando = 0;
                            $unidad_familiar->fecha_creacion = 'now()';
                            $unidad_familiar->fecha_actualizacion = 'now()';
                            $unidad_familiar->usuario_id_creacion = Yii::app()->user->id;
                            $unidad_familiar->estatus = 77;
                            if ($unidad_familiar->save()) {
                                $traza = Traza::actionInsertUpdateTraza(1, $model->id_beneficiario, 1);

                                $n = BeneficiarioTemporal::model()->updateByPk($model->beneficiario_temporal_id, array(
                                    'estatus' => 224,
                                    'usuario_id_actualizacion' => Yii::app()->user->id,
                                    'fecha_actualizacion' => 'now()'
                                ));


                                $this->redirect(array('grupoFamiliar/create', 'id' => $unidad_familiar->id_unidad_familiar));
                                Yii::app()->end();
                            }
                        }
                    }
                } else {

                    $this->render('create', array(
                        'model' => $model, 'desarrollo' => $desarrollo, 'municipio' => $municipio, 'estado' => $estado, 'parroquia' => $parroquia, 'unidad_familiar' => $unidad_familiar, 'vivienda' => $vivienda, 'error' => 2
                    ));
                    Yii::app()->end();
                }
            }
        }
        $this->render('create', array(
            'model' => $model, 'desarrollo' => $desarrollo, 'municipio' => $municipio, 'estado' => $estado, 'parroquia' => $parroquia, 'unidad_familiar' => $unidad_familiar, 'vivienda' => $vivienda
        ));
    }

    //PRECARGADO DE DATOS PARA INICIO DE CENSO EN VIEW EMPADRONADOR
    
    public function actionCreateCenso($id) {
        
        $model = new Beneficiario;
        $desarrollo = new Desarrollo;
        $vivienda = new Vivienda;
        $unidad_familiar = new UnidadFamiliar;
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;

        $beneficiarioTmp = BeneficiarioTemporal::model()->findByPk($id);



// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Beneficiario'])) {
            
            $model->attributes = $_POST['Beneficiario'];
            $Existe = BeneficiarioTemporal::model()->findByPk($model->beneficiario_temporal_id);
            
            if (empty($Existe)) {
                $this->render('create', array(
                    'model' => $model, 'desarrollo' => $desarrollo, 'municipio' => $municipio, 'estado' => $estado, 'parroquia' => $parroquia, 'unidad_familiar' => $unidad_familiar, 'vivienda' => $vivienda, 'error' => 1
                ));
                Yii::app()->end();
            } else {
                $idPersona = $Existe->persona_id;

                $telfhabi = str_replace('-', '', $_POST['Beneficiario']['telf_habitacion']);
                $codigo_hab = empty($telfhabi) ? '' : substr($telfhabi, 0, 4);
                $telf_habitacion = empty($telfhabi) ? '' : substr($telfhabi, 4, 11);

                $telfmov = str_replace('-', '', $_POST['Beneficiario']['telf_celular']);
                $codigo_movil = empty($telfmov) ? '' : substr($telfmov, 0, 4);
                $telf_movil = empty($telfmov) ? '' : substr($telfmov, 4, 11);
                switch ($_POST['Beneficiario']['estado_civil']) {
                    case 164:
                        $edoCivil = 2;
                        break;
                    case 165:
                        $edoCivil = 4;
                        break;
                    case 163:
                        $edoCivil = 1;
                        break;
                    case 166:
                        $edoCivil = 3;
                        break;
                }

                /*   ----------  UPDATE    -------------------  */
                $idPersona = ConsultaOracle::updatePersona(array(
                            'FECHA_NACIMIENTO' => $_POST['Beneficiario']['fecha_nacimiento'],
                            'GEN_SEXO_ID' => $_POST['Beneficiario']['sexo'],
                            'GEN_EDO_CIVIL_ID' => $edoCivil,
                            'CODIGO_HAB' => (string) $codigo_hab,
                            'TELEFONO_HAB' => (string) $telf_habitacion,
                            'CODIGO_MOVIL' => (string) $codigo_movil,
                            'TELEFONO_MOVIL' => (string) $telf_movil,
                            'CORREO_PRINCIPAL' => $_POST['Beneficiario']['correo_electronico'],
                                ), $idPersona
                );
                /*   -----------------------------------------  */

                $censado = Beneficiario::model()->findByAttributes(array('beneficiario_temporal_id' => $Existe->id_beneficiario_temporal));

                if (empty($censado)) {

                    $model->fecha_creacion = 'now()';
                    $model->fecha_actualizacion = 'now()';
                    $model->fecha_ultimo_censo = Generico::formatoFecha($_POST['Beneficiario']['fecha_ultimo_censo']);
                    $model->usuario_id_creacion = Yii::app()->user->id;
                    $model->persona_id = $Existe->persona_id;
                    $model->estatus_beneficiario_id = 223;
                    if ($model->save()) {
//                        $Existe->estatus = 224;
//                        $Existe->save();

                        $viviendaUpdate = ViviendaController::loadModel($Existe->vivienda_id);
                        $viviendaUpdate->construccion_mt2 = $_POST['Vivienda']['construccion_mt2'];
                        if ($viviendaUpdate->save()) {
//                            $unidad_familiar->nombre = $Existe->nombre_completo;
                            $unidad_familiar->beneficiario_id = $model->id_beneficiario;
                            $unidad_familiar->ingreso_total_familiar = '0.00';
//                            $unidad_familiar->procedencia_beneficio_id = 140; //INIDICAR EN QUE MOMENTO SE CARGA ESTE DATO
                            $unidad_familiar->fuente_datos_entrada_id = 90;
                            $unidad_familiar->condicion_unidad_familiar_id = $_POST['UnidadFamiliar']['condicion_unidad_familiar_id']; //Berifivar cual es el id
                            $unidad_familiar->total_personas_cotizando = 0;
                            $unidad_familiar->fecha_creacion = 'now()';
                            $unidad_familiar->fecha_actualizacion = 'now()';
                            $unidad_familiar->usuario_id_creacion = Yii::app()->user->id;
                            $unidad_familiar->estatus = 77;
                            if ($unidad_familiar->save()) {
                                $traza = Traza::actionInsertUpdateTraza(1, $model->id_beneficiario, 1);

                                $n = BeneficiarioTemporal::model()->updateByPk($model->beneficiario_temporal_id, array(
                                    'estatus' => 224,
                                    'usuario_id_actualizacion' => Yii::app()->user->id,
                                    'fecha_actualizacion' => 'now()'
                                ));


                                $this->redirect(array('grupoFamiliar/create', 'id' => $unidad_familiar->id_unidad_familiar));
                                Yii::app()->end();
                            }
                        }
                    }
                } else {

                    $this->render('createCenso', array('beneficiarioTmp' => $beneficiarioTmp,
                        'model' => $model, 'desarrollo' => $desarrollo, 'municipio' => $municipio, 'estado' => $estado, 'parroquia' => $parroquia, 'unidad_familiar' => $unidad_familiar, 'vivienda' => $vivienda, 'error' => 2
                    ));
                    Yii::app()->end();
                }
            }
        }
        $this->render('createCenso', array('beneficiarioTmp' => $beneficiarioTmp,
            'model' => $model, 'desarrollo' => $desarrollo, 'municipio' => $municipio, 'estado' => $estado, 'parroquia' => $parroquia, 'unidad_familiar' => $unidad_familiar, 'vivienda' => $vivienda
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    //UPDATE DE BENEFICIARIO ULTIMA PANTALLA DE CENSO
    
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;
        $faovPromedio = ConsultaOracle::getFaov($model->persona_id, 1); //consulta la funcion faov por id de persona, para mostrar el calculo de promedio FAOV- FAOV/FAVV - FAVV
        $faovMensual = ConsultaOracle::getFaov($model->persona_id, 2); //consulta la funcion faov por id de persona, para mostrar el calculo de ingreso mesual FAOV- FAOV/FAVV - FAVV
        $model->ingreso_promedio_faov = ($faovPromedio) ? $faovPromedio : '0.00';

        $consulta = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id)); // consulta a Unidad Familiar por el id_beneficiario

        $sqlIngreso = "select sum(ingreso_mensual) as ingreso from grupo_familiar where estatus = 41 and unidad_familiar_id=" . $consulta->id_unidad_familiar . ""; //consulta que suma cuanto es el ingreso de grupo familiar por id_beneficiario
        
        $rowingreso = Yii::app()->db->createCommand($sqlIngreso)->queryRow();
        $model->ingreso_mensual = ($rowingreso['ingreso']) ? $rowingreso['ingreso'] : '0.00';
        //var_dump($model->ingreso_mensual);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Beneficiario'])) {

            $model->cedula = 'campo';
            $model->attributes = $_POST['Beneficiario'];
            $model->parroquia_id = $_POST['Beneficiario']['parroquia_id'];
            $model->urban_barrio = $_POST['Beneficiario']['urban_barrio'];
            $model->av_call_esq_carr = $_POST['Beneficiario']['av_call_esq_carr'];
            $model->zona = $_POST['Beneficiario']['zona'];
            $model->condicion_trabajo_id = $_POST['Beneficiario']['condicion_trabajo_id'];
            $model->fuente_ingreso_id = $_POST['Beneficiario']['fuente_ingreso_id'];
            $model->condicion_laboral = $_POST['Beneficiario']['condicion_laboral'];
            $model->sector_trabajo_id = $_POST['Beneficiario']['sector_trabajo_id'];
            $model->nombre_empresa = $_POST['Beneficiario']['nombre_empresa'];
            $model->direccion_empresa = $_POST['Beneficiario']['direccion_empresa'];
            $model->telefono_trabajo = $_POST['Beneficiario']['telefono_trabajo'];
            $model->gen_cargo_id = $_POST['Beneficiario']['gen_cargo_id'];
            $model->observacion = $_POST['Beneficiario']['observacion'];
            $model->estatus_beneficiario_id = 222;
            $model->usuario_id_actualizacion = Yii::app()->user->id;

            if ($model->save()) {
                $this->redirect(array('vswCensosCulminados/admin'));
                Yii::app()->end();
            }
        }

        $this->render('update', array(
            'model' => $model, 'municipio' => $municipio, 'estado' => $estado, 'parroquia' => $parroquia,
        ));
    }

    //ACTUALIZACION DE DATOS DE BENEFICIARIO //tercera pantalla de censo
    public function actionCreateDatos($id) {
       
        $traza = Traza::VerificarTraza($id); // verifica el guardado de la traza
        if ($traza != 2) {
            Generico::renderTraza($id); //renderiza a la traza
        }

        $model = Beneficiario::model()->findByPk($id);
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;

        $faovPromedio = ConsultaOracle::getFaov($model->persona_id, 1); //consulta la funcion faov por id de persona, para mostrar el calculo de promedio FAOV- FAOV/FAVV - FAVV
        $faovMensual = ConsultaOracle::getFaov($model->persona_id, 2); //consulta la funcion faov por id de persona, para mostrar el calculo de ingreso mesual FAOV- FAOV/FAVV - FAVV
        $model->ingreso_promedio_faov = ($faovPromedio) ? $faovPromedio : '0.00';

        $consulta = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id)); // consulta a Unidad Familiar por el id_beneficiario

        $sqlIngreso = "select sum(ingreso_mensual) as ingreso from grupo_familiar where estatus = 41 and unidad_familiar_id=" . $consulta->id_unidad_familiar . ""; //consulta que suma cuanto es el ingreso de grupo familiar por id_beneficiario
        $rowingreso = Yii::app()->db->createCommand($sqlIngreso)->queryRow();
        $model->ingreso_mensual = ($rowingreso['ingreso']) ? $rowingreso['ingreso'] : '0.00';
        //echo '<pre>'; var_dump($model->ingreso_mensual); die();
//        $consulta->ingreso_total_familiar=$rowingreso['ingreso'];  //insert para unidad familiar ingreso_total_familiar
//
//        $sqlFaov = "select count(*) as faov from grupo_familiar where unidad_familiar_id=".$consulta->id_unidad_familiar.""; //consulta que suma cuantos cotizan en faov del grupo familiar por id_beneficiario
//        $rowFaov = Yii::app()->db->createCommand($sqlFaov)->queryRow();
//        $consulta->total_personas_cotizando=$rowFaov['faov'];  //insert para unidad familiar total de personas cotizando


        if (isset($_POST['Beneficiario']['parroquia_id'])) {
            
            $model->cedula = 'campo';
            $model->attributes = $_POST['Beneficiario'];
            $model->parroquia_id = $_POST['Beneficiario']['parroquia_id'];
            $model->urban_barrio = $_POST['Beneficiario']['urban_barrio'];
            $model->av_call_esq_carr = $_POST['Beneficiario']['av_call_esq_carr'];
            $model->zona = $_POST['Beneficiario']['zona'];
            $model->condicion_trabajo_id = $_POST['Beneficiario']['condicion_trabajo_id'];
            $model->fuente_ingreso_id = $_POST['Beneficiario']['fuente_ingreso_id'];
            $model->condicion_laboral = $_POST['Beneficiario']['condicion_laboral'];
            $model->sector_trabajo_id = $_POST['Beneficiario']['sector_trabajo_id'];
            $model->nombre_empresa = $_POST['Beneficiario']['nombre_empresa'];
            $model->direccion_empresa = $_POST['Beneficiario']['direccion_empresa'];
            $model->telefono_trabajo = $_POST['Beneficiario']['telefono_trabajo'];
            $model->gen_cargo_id = $_POST['Beneficiario']['gen_cargo_id'];
            $model->observacion = $_POST['Beneficiario']['observacion'];
            $model->estatus_beneficiario_id = 222;
            $model->usuario_id_actualizacion = Yii::app()->user->id;


            if ($model->save()) {

                $IdBeneficiarioTmp = $model->beneficiario_temporal_id;
                $n = BeneficiarioTemporal::model()->updateByPk($IdBeneficiarioTmp, array(
                    'estatus' => 79,
                    'usuario_id_actualizacion' => Yii::app()->user->id,
                    'fecha_actualizacion' => 'now()'
                ));

                $idtraza = Traza::ObtenerIdTraza($model->id_beneficiario); // pemite la busqueda de la id de la traza
                $delete = Traza::model()->findByPk($idtraza)->delete();

                $this->redirect(array('vswCensosCulminados/admin'));
                Yii::app()->end();
            }
        }

        $this->render('createDatos', array(
            'model' => $model, 'municipio' => $municipio, 'estado' => $estado, 'parroquia' => $parroquia,
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
        $dataProvider = new CActiveDataProvider('Beneficiario');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Beneficiario('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Beneficiario']))
            $model->attributes = $_GET['Beneficiario'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    //VIEW PARA MOSTRAR LOS BENEFICIARIOS CON ESTATUS 222 QUE CULMINARON CNSO
    public function actionCensoCulminado() {
        $model = new Beneficiario('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Beneficiario']))
            $model->attributes = $_GET['Beneficiario'];

        $this->render('censoCulminado', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Beneficiario::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'beneficiario-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionValidarCenso($id) {

        $model = Beneficiario::model()->findByPk($id);

        $updateBene = Beneficiario::model()->updateByPk($model->id_beneficiario, array(
            'estatus_beneficiario_id' => 273,
            'usuario_id_actualizacion' => Yii::app()->user->id,
            'fecha_actualizacion' => 'now()'
        ));
        $updateBeneTemp = BeneficiarioTemporal::model()->updateByPk($model->beneficiario_temporal_id, array(
            'estatus' => 274,
            'usuario_id_actualizacion' => Yii::app()->user->id,
            'fecha_actualizacion' => 'now()'
        ));

        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/vswCensosCulminados/admin'));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionValidarVariosCenso($id) {

        $idTmp = explode(',', $id);

        foreach ($idTmp as $ids) {

            $model = Beneficiario::model()->findByPk($ids);

            $updateBene = Beneficiario::model()->updateByPk($model->id_beneficiario, array(
                'estatus_beneficiario_id' => 273,
                'usuario_id_actualizacion' => Yii::app()->user->id,
                'fecha_actualizacion' => 'now()'
            ));
            $updateBeneTemp = BeneficiarioTemporal::model()->updateByPk($model->beneficiario_temporal_id, array(
                'estatus' => 274,
                'usuario_id_actualizacion' => Yii::app()->user->id,
                'fecha_actualizacion' => 'now()'
            ));
        }


        // $recordBeneTemp = BeneficiarioTemporal::model()->findAllByAttributes(array('id_beneficiario_temporal' => $idTmp));

        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/vswCensosCulminados/admin'));
    }

    public function actionActualizar() { {
            Yii :: import('booster.components.TbEditableSaver');
            $es = new TbEditableSaver('Beneficiario');
//       var_dump($es);die;
//Con onBeforeUpdate agrego los atrubitos adicionales que quiero actualizar
            $es->onBeforeUpdate = function($event) {
                $event->sender->setAttribute('fecha_actualizacion', date('Y-m-d H:i:s'));
                $event->sender->setAttribute('usuario_id_actualizacion', Yii::app()->user->id);
            };
            $es->update();
           
            
              
        }
    }
    

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
}
