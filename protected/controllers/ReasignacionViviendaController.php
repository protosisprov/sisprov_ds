<?php

class ReasignacionViviendaController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
//    public $layout = '//layouts/column2';

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
    public function actionCreate($id) {
        $model = new ReasignacionVivienda;
        $beneficiarioTemporal = BeneficiarioTemporal::model()->findByPk($id);
        $adjudicadoEmpa = AdjudicadoEmpadronador::model()->find('beneficiario_temporal_id=' . $id . '');
        $beneficiario = new Beneficiario;
        $unidad_familiar = new UnidadFamiliar;
        $adjudicadoEmpaNuevo = new AdjudicadoEmpadronador();
        $beneficiarioTemNuevo = new BeneficiarioTemporal;
        $vivienda = $beneficiarioTemporal->vivienda;
//        var_dump($adjudicadoEmpa);die();
        if (!empty($beneficiarioTemporal)) {
            $model->beneficiario_id_anterior = $beneficiarioTemporal->id_beneficiario_temporal;
            $model->nacionalidadAnterior = $beneficiarioTemporal->nacionalidad;
            $model->cedulaAnterior = $beneficiarioTemporal->cedula;
            $model->nombreCompletoAnterior = $beneficiarioTemporal->nombre_completo;
            $model->id_desarrollo = $beneficiarioTemporal->desarrollo->id_desarrollo;
            $model->desarrollo = $beneficiarioTemporal->desarrollo->nombre;
            $model->unidad_habitacional = $beneficiarioTemporal->unidadHabitacional->nombre;
            $model->id_unidad_habitacional = $beneficiarioTemporal->unidadHabitacional->id_unidad_habitacional;
            $model->id_vivienda = $beneficiarioTemporal->vivienda->id_vivienda;
            $model->tipo_vivienda = $beneficiarioTemporal->vivienda->tipoVivienda->descripcion;
            $model->nro_piso = $beneficiarioTemporal->vivienda->nro_piso;
            $model->nro_vivienda = $beneficiarioTemporal->vivienda->nro_vivienda;
            $model->estado = $beneficiarioTemporal->desarrollo->fkParroquia->clvmunicipio0->clvestado0->strdescripcion;
            $model->municipio = $beneficiarioTemporal->desarrollo->fkParroquia->clvmunicipio0->strdescripcion;
            $model->parroquia = $beneficiarioTemporal->desarrollo->fkParroquia->strdescripcion;
            $model->urban_barrio = $beneficiarioTemporal->desarrollo->urban_barrio;
            $model->av_call_esq_carr = $beneficiarioTemporal->desarrollo->av_call_esq_carr;
           
        }



        if (isset($_POST['ReasignacionVivienda'])) {
            $beneficiarioTemNuevo->attributes = $_POST['ReasignacionVivienda'];
            switch ($_POST['ReasignacionVivienda']['estado_civilActual']) {
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
            if ($beneficiarioTemNuevo->persona_id == '') {
                $teleHab = str_replace('-', ' ', $_POST['ReasignacionVivienda']['telf_habitacionActual']);
                $codigo_hab = substr($teleHab, 0, 4);
                $telf_habitacion = substr($teleHab, 4, 11);

                $telemovi = str_replace('-', ' ', $_POST['ReasignacionVivienda']['telf_celularActual']);
                $codigo_movil = substr($telemovi, 0, 4);
                $telf_movil = substr($telemovi, 4, 11);


                $idPersona = ConsultaOracle::insertPersona(array(
                            'CEDULA' => $_POST['ReasignacionVivienda']['cedula'],
                            'NACIONALIDAD' => ($_POST['ReasignacionVivienda']['nacionalidad'] == 97) ? 1 : 0,
                            'PRIMER_NOMBRE' => trim(strtoupper($_POST['ReasignacionVivienda']['primer_nombreActual'])),
                            'SEGUNDO_NOMBRE' => trim(strtoupper($_POST['ReasignacionVivienda']['segundo_nombreActual'])),
                            'PRIMER_APELLIDO' => trim(strtoupper($_POST['ReasignacionVivienda']['primer_apellidoActual'])),
                            'SEGUNDO_APELLIDO' => trim(strtoupper($_POST['ReasignacionVivienda']['segundo_apellidoActual'])),
                            'FECHA_NACIMIENTO' => $_POST['ReasignacionVivienda']['fecha_nacimientoActual'],
                            'GEN_SEXO_ID' => $_POST['ReasignacionVivienda']['sexoActual'],
                            'GEN_EDO_CIVIL_ID' => $edoCivil,
                            'CODIGO_HAB' => (string) $codigo_hab,
                            'TELEFONO_HAB' => (string) $telf_habitacion,
                            'CODIGO_MOVIL' => (string) $codigo_movil,
                            'TELEFONO_MOVIL' => (string) $telf_movil,
                            'CORREO_PRINCIPAL' => $_POST['ReasignacionVivienda_correo_electronicoActual'],
                                )
                );
            } else {

                $idPersona = $_POST['ReasignacionVivienda']['persona_id'];

                $teleHab = str_replace('-', ' ', $_POST['ReasignacionVivienda']['telf_habitacionActual']);
                $codigo_hab = substr($teleHab, 0, 4);
                $telf_habitacion = substr($teleHab, 4, 11);

                $telemovi = str_replace('-', ' ', $_POST['ReasignacionVivienda']['telf_celularActual']);
                $codigo_movil = substr($telemovi, 0, 4);
                $telf_movil = substr($telemovi, 4, 11);


                /*   ----------  UPDATE    -------------------  */
                $idPersona = ConsultaOracle::updatePersona(array(
//  'CEDULA'           => $_POST["BeneficiarioTemporal"]["cedula"],
// 'NACIONALIDAD'     => ($_POST["BeneficiarioTemporal"]['nacionalidad'] == 97) ? 1 : 0,
                            'PRIMER_NOMBRE' => trim(strtoupper($_POST['ReasignacionVivienda']['primer_nombreActual'])),
                            'SEGUNDO_NOMBRE' => trim(strtoupper($_POST['ReasignacionVivienda']['segundo_nombreActual'])),
                            'PRIMER_APELLIDO' => trim(strtoupper($_POST['ReasignacionVivienda']['primer_apellidoActual'])),
                            'SEGUNDO_APELLIDO' => trim(strtoupper($_POST['ReasignacionVivienda']['segundo_apellidoActual'])),
                            'FECHA_NACIMIENTO' => $_POST['ReasignacionVivienda']['fecha_nacimientoActual'],
                            'GEN_SEXO_ID' => $_POST['ReasignacionVivienda']['sexoActual'],
                            'GEN_EDO_CIVIL_ID' => $edoCivil,
                            'CODIGO_HAB' => (string) $codigo_hab,
                            'TELEFONO_HAB' => (string) $telf_habitacion,
                            'CODIGO_MOVIL' => (string) $codigo_movil,
                            'TELEFONO_MOVIL' => (string) $telf_movil,
                            'CORREO_PRINCIPAL' => $_POST['ReasignacionVivienda_correo_electronicoActual'],
                                ), $idPersona
                );

                /*   -----------------------------------------  */
            }


            /*
             * INSERT DE DATOS EN BENEFICIARIO ADJUDICADO NUEVO
             */
            $nombre_completo = $_POST['ReasignacionVivienda']['primer_apellidoActual'] . ' ';
            $nombre_completo.= $_POST['ReasignacionVivienda']['segundo_apellidoActual'] . ' ';
            $nombre_completo.= $_POST['ReasignacionVivienda']['primer_nombreActual'] . ' ';
            $nombre_completo.= $_POST['ReasignacionVivienda']['segundo_nombreActual'];

            $beneficiarioTemNuevo->persona_id = (int) $idPersona;
            $beneficiarioTemNuevo->desarrollo_id = (int) $_POST['ReasignacionVivienda']['id_desarrollo'];
            $beneficiarioTemNuevo->unidad_habitacional_id = (int) $_POST['ReasignacionVivienda']['id_unidad_habitacional'];
            $beneficiarioTemNuevo->vivienda_id = (int) $_POST['ReasignacionVivienda']['id_vivienda'];
            $beneficiarioTemNuevo->nacionalidad = (int) $_POST['ReasignacionVivienda']['nacionalidad'];
            $beneficiarioTemNuevo->cedula = (int) $_POST['ReasignacionVivienda']['cedula'];
            $beneficiarioTemNuevo->nombre_completo = strtoupper($nombre_completo);
            $beneficiarioTemNuevo->fecha_creacion = 'now';
            $beneficiarioTemNuevo->usuario_id_creacion = Yii::app()->user->id;
            $beneficiarioTemNuevo->fecha_actualizacion = 'now';
            $beneficiarioTemNuevo->estatus = 221; // POR ASIGNAR

            if ($beneficiarioTemNuevo->save()) {
                $id_benetemp = $beneficiarioTemNuevo->id_beneficiario_temporal;
                /*
                 * ACTUALIZACION DE ESTATUS DEL BENEFICIARIO ADJUDICADO ANTERIOR 
                 */
                $beneficiarioTemporal->estatus = 186; //SITUACION IRREGULAR
                $beneficiarioTemporal->fecha_actualizacion = 'now';
                $beneficiarioTemporal->usuario_id_actualizacion = Yii::app()->user->id;
                if ($beneficiarioTemporal->save()) { // true 
                    /*
                     * INSERT REASIGNACION VIVIENDA
                     */
                    $model->attributes = $_POST['ReasignacionVivienda'];
                    $model->beneficiario_id_anterior = $_POST['ReasignacionVivienda']['beneficiario_id_anterior'];
                    $model->beneficiario_id_actual = $id_benetemp;
                    $model->vivienda_id = $_POST['ReasignacionVivienda']['id_vivienda'];
                    $model->tipo_reasignacion_id = $_POST['ReasignacionVivienda']['tipo_reasignacion_id'];
                    $model->persona_id_autoriza = Yii::app()->user->id;
                    $model->observaciones = trim(strtoupper($_POST['ReasignacionVivienda']['observaciones']));
                    $model->fecha_reasignacion = $model->fecha_reasignacion = Generico::formatoFecha($_POST['ReasignacionVivienda']['fecha_reasignacion']);
                    $model->fecha_creacion = 'now';
                    $model->fecha_actualizacion = 'now';
                    $model->usuario_id_creacion = Yii::app()->user->id;
                    $model->estatus = 50; //ACTIVO

                    if ($model->save()) {
                        /*
                         * UPDATE DE ADJUDICADO_EMPADRONADOR PARA EL BENEFICIARIO ANTERIOR
                         */
                        $adjudicadoEmpa->fecha_actualizacion = 'now';
                        $adjudicadoEmpa->estatus = 215; //INACTIVO
                        $adjudicadoEmpa->usuario_modificacion = Yii::app()->user->id;

                        if ($adjudicadoEmpa->save()) {
                            /*
                             * INSERT DE ADJUDICADO_EMPADRONADOR NUEVO
                             */
                            $adjudicadoEmpaNuevo->empadronador_censo_id = $adjudicadoEmpa->empadronador_censo_id;
                            $adjudicadoEmpaNuevo->beneficiario_temporal_id = (int) $id_benetemp;
                            $adjudicadoEmpaNuevo->estatus = 214; //ACTIVO
                            $adjudicadoEmpaNuevo->fecha_creacion = 'now';
                            $adjudicadoEmpaNuevo->usuario_creacion = Yii::app()->user->id;
                            $adjudicadoEmpaNuevo->fecha_actualizacion = 'now';

                            if ($adjudicadoEmpaNuevo->save()) {

                                /*
                                 *  INSERT DE BENEFECIARIO NUEVO
                                 */
                                $beneficiario->cedula = 'campo';
                                $beneficiario->fecha_creacion = 'now()';
                                $beneficiario->fecha_actualizacion = 'now()';
                                $beneficiario->fecha_ultimo_censo = Generico::formatoFecha($_POST['Beneficiario']['fecha_ultimo_censo']);
                                $beneficiario->usuario_id_creacion = Yii::app()->user->id;
                                $beneficiario->persona_id = (int) $idPersona;
                                $beneficiario->estatus_beneficiario_id = 223; //EN PROCESO
                                $beneficiario->rif = $_POST['Beneficiario']['rif'];
                                $beneficiario->beneficiario_temporal_id = $id_benetemp;

                                if ($beneficiario->save()) {
//                                echo '<pre>';var_dump($beneficiario); die();
                                    $vivienda->construccion_mt2 = $_POST['Vivienda']['construccion_mt2'];
                                    if ($vivienda->save()) {

                                        /*
                                         * INSERT UNIDAD FAMILIAR 
                                         */
                                        $unidad_familiar->beneficiario_id = $beneficiario->id_beneficiario;
                                        $unidad_familiar->ingreso_total_familiar = '0.00';
                                        $unidad_familiar->fuente_datos_entrada_id = 90; //SISTEMA
                                        $unidad_familiar->condicion_unidad_familiar_id = $_POST['UnidadFamiliar']['condicion_unidad_familiar_id']; //Berifivar cual es el id
                                        $unidad_familiar->total_personas_cotizando = 0;
                                        $unidad_familiar->fecha_creacion = 'now()';
                                        $unidad_familiar->fecha_actualizacion = 'now()';
                                        $unidad_familiar->usuario_id_creacion = Yii::app()->user->id;
                                        $unidad_familiar->estatus = 77; //EN PROCESO

                                        if ($unidad_familiar->save()) {
                                            /*
                                             * INSERT EN TRAZA
                                             */
                                            $traza = Traza::actionInsertUpdateTraza(1, $beneficiario->id_beneficiario, 1);
                                           /*
                                            * ACTUALIZACION EN BENEFICIARIO_TEMPORAL  NUEVO
                                            */
                                            $n = BeneficiarioTemporal::model()->updateByPk($beneficiario->beneficiario_temporal_id, array(
                                                'estatus' => 224, // EN PROCESO 
                                                'usuario_id_actualizacion' => Yii::app()->user->id,
                                                'fecha_actualizacion' => 'now()'
                                            ));


                                            $this->redirect(array('grupoFamiliar/create', 'id' => $unidad_familiar->id_unidad_familiar));
                                            Yii::app()->end();
                                        } // fin insert unidad_familiar 
                                    } //fin update vivienda ->construcion_mt2 
                                } //fin insert beneficiario nuevo
                            } //fin insert adjudicado_empadronador_nuevo ->beneficiario nuevo
                        } //fin actualizacion adjudicado_empadronador_anterior -> beneficiario anterior
                    } // fin insert en reasignacion_vivienda 
                } // fin actualizacion de Beneficiario_temporal_anterior
            } //fin insert Beneficiario_temporal_nuevo
        }
        $this->render('create', array(
            'model' => $model, 'unidad_familiar' => $unidad_familiar, 'beneficiario' => $beneficiario, 'vivienda' => $vivienda
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

        if (isset($_POST['ReasignacionVivienda'])) {
            $model->attributes = $_POST['ReasignacionVivienda'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_reasignacion_vivienda));
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
        $dataProvider = new CActiveDataProvider('ReasignacionVivienda');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ReasignacionVivienda('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ReasignacionVivienda']))
            $model->attributes = $_GET['ReasignacionVivienda'];

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
        $model = ReasignacionVivienda::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'reasignacion-vivienda-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
