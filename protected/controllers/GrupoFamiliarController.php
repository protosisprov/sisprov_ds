<?php

class GrupoFamiliarController extends Controller {
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
    public function actionCreate($id, $caso = NULL) {
//        var_dump($id);
        $model = new GrupoFamiliar;
        $idBeneficiario = UnidadFamiliar::model()->findByPk($id);
        $traza = Traza::VerificarTraza($idBeneficiario->beneficiario_id); // verifica el guardado de la traza

        if ($traza != 1) {
            Generico::renderTraza($idBeneficiario->beneficiario_id); //renderiza a la traza
        }
// Uncomment the following line if AJAX validation is needed
//    $this->performAjaxValidation($model);

        if (!empty($caso)) {
            //SUMA DEL INGRESO MESUAL SEGUN FAOV DE LOS INTEGRANTES DEL GRUPO FAMILIAR
            $list = Yii::app()->db->createCommand('select sum(ingreso_mensual_faov) as promedio from grupo_familiar where unidad_familiar_id =' . $id)->queryAll();
            $list = number_format($list[0]['promedio'], 2, '.', '');

            //SUMA DEL INGRESO MESUAL DECLARADO POR EL GRUPO FAMILIAR
            $sqlIngreso = "select sum(ingreso_mensual) as ingreso from grupo_familiar where unidad_familiar_id=" . $id . ""; //consulta que suma cuanto es el ingreso de grupo familiar por id_beneficiario
            $rowingreso = Yii::app()->db->createCommand($sqlIngreso)->queryRow();
            $rowingreso = number_format($rowingreso['ingreso'], 2, '.', '');
            UnidadFamiliar::model()->updateByPk($id, array('ingreso_total_familiar_suma_faov' => $list, 'ingreso_total_familiar' => $rowingreso));

            $idtraza = Traza::ObtenerIdTraza($idBeneficiario->beneficiario_id); // pemite la busqueda de la id de la traza 
            $guardartraza = Traza::actionInsertUpdateTraza(2, $idBeneficiario->beneficiario_id, 2, $idtraza); // permite insertar y actualizar la traza segun el caso 
            $this->redirect(array('beneficiario/createDatos', 'id' => $idBeneficiario->beneficiario_id));
        }

        $this->render('create', array('model' => $model));
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
        $dataProvider = new CActiveDataProvider('GrupoFamiliar');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new GrupoFamiliar('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['GrupoFamiliar']))
            $model->attributes = $_GET['GrupoFamiliar'];

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
        $model = GrupoFamiliar::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'grupo-familiar-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     * Funcion que ingresa en tabla grupo familiar
     */

    public function actionInsertFamiliar() {
        $Familiar = new GrupoFamiliar;
        if ($_POST['idPersona'] == '' && $_POST['cedula'] != '0') {
            $idPersona = ConsultaOracle::insertPersona(array(
                        'CEDULA' => $_POST['cedula'],
                        'NACIONALIDAD' => ($_POST['nacionalida'] == 97) ? 1 : 0,
                        'PRIMER_NOMBRE' => trim(strtoupper($_POST['primerNombre'])),
                        'SEGUNDO_NOMBRE' => trim(strtoupper($_POST['segundoNombre'])),
                        'PRIMER_APELLIDO' => trim(strtoupper($_POST['primerApellido'])),
                        'SEGUNDO_APELLIDO' => trim(strtoupper($_POST['segundoApellido'])),
                        'FECHA_NACIMIENTO' => ($_POST['fechaNacMenor'] != '') ? date('d-M-y', strtotime(Generico::formatoFecha($_POST['fechaNacMenor']))) : $_POST['fechaNac'],
                            )
            );
        } else if ($_POST['idPersona'] == '' && $_POST['cedula'] == '0') {

            $edad = Generico::edad(Generico::formatoFecha($_POST['fechaNacMenor']));
            /* +++++  Verifica que no posee cedula y el parentesco diferente a:
             * 156 = PADRE
             * 152 = MADRE
             * 150 = ABUELO
             *  ++++++ */
            if ($edad <= 15 && ($_POST['parentesco'] != '156' || $_POST['parentesco'] != '152' || $_POST['parentesco'] == '150' )) {
                $CeduldaPersona = UnidadFamiliar::model()->findByPk($_POST['IdUnidadF'])->beneficiario->beneficiarioTemporal->cedula;
                $buscarCantHijos = (int) ConsultaOracle::cantHijo($CeduldaPersona) + 1;
                $logitud = strlen($buscarCantHijos);
                $cantHijo = ($logitud == 1) ? '0' . $buscarCantHijos : $buscarCantHijos;
                $idPersona = ConsultaOracle::getInsertMenorEdad(array(
                            'CEDULA' => $CeduldaPersona . '' . $cantHijo,
                            'NACIONALIDAD' => 'M',
                            'PRIMER_NOMBRE' => trim(strtoupper($_POST['primerNombre'])),
                            'SEGUNDO_NOMBRE' => trim(strtoupper($_POST['segundoNombre'])),
                            'PRIMER_APELLIDO' => trim(strtoupper($_POST['primerApellido'])),
                            'SEGUNDO_APELLIDO' => trim(strtoupper($_POST['segundoApellido'])),
                            'FECHA_NACIMIENTO' => date('d-M-y', strtotime(Generico::formatoFecha($_POST['fechaNacMenor']))),
                                )
                );
            } else {
                $idPersona = 'mayor';
            }
        } else {
            $idPersona = $_POST['idPersona'];
        }

        if ($idPersona == 'mayor') {
            echo CJSON::encode(4);
        } else {
            $ExisteBeneficiario = Beneficiario::model()->findByAttributes(array('persona_id' => $idPersona));
            $ExisteFamiliar = $this->FindByIdPersona($idPersona);
            if (!empty($ExisteFamiliar) || !empty($ExisteBeneficiario)) {
                echo CJSON::encode(1);
            } else {
                $Familiar->persona_id = $idPersona;
                $Familiar->gen_parentesco_id = $_POST['parentesco'];
                $Familiar->tipo_sujeto_atencion = $_POST['tipoSujeto'];
                $Familiar->cotiza_faov = $_POST['faov'];
                
//                Reemplazo la coma por el punto debido a que la base de datos no acepta esa nomeclatura
                $ingresom = $_POST['ingresoM'];
                $ingresot = str_replace(",", ".", $ingresom);
                $Familiar->ingreso_mensual = $ingresot;
                // aqui termina el reemplazo
                $Familiar->unidad_familiar_id = $_POST['IdUnidadF'];
                $Familiar->estatus = 41;
                $Familiar->fuente_datos_entrada_id = 5;
                $Familiar->fecha_creacion = 'now()';
                $Familiar->fecha_actualizacion = 'now()';
                $Familiar->usuario_id_creacion = Yii::app()->user->id;
                $Familiar->ingreso_mensual_faov = ($_POST['ingresoMFaov']) ? ($_POST['ingresoMFaov']) : '0.00';
                $Familiar->tipo_persona_faov = $_POST['tipoPersonaFaov'];
                if ($Familiar->save()) {
                    echo CJSON::encode(3);
                } else {
                    echo CJSON::encode(2);
                }
            }
        }
    }

    /**
     * @param integer the ID of the model to be loaded
     */
    public function FindByIdPersona($id) {
        $model = GrupoFamiliar::model()->findByAttributes(array('persona_id' => $id, 'estatus' => 41));
        if ($model === null)
            return FALSE;
        return $model;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
//        $idUNidad = UnidadFamiliar::model()->findByAttributes();
        $model = new GrupoFamiliar;

        $this->render('update', array('id' => $id, 'model' => $model));
    }

    /*
     * Modificar persona 
     */

    public function actionActualizarPersona($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('actualizarPersona', array('model' => $id), false, true);
        } else {

            $this->render('anular', array('model' => $id));
        }
    }

    /*
     * cambio de estatus para eliminar persona del grupo familiar
     */

    public function actionDeleteGrupoFamiliar($id) {

        $model = GrupoFamiliar::model()->findByPk($id);

//        var_dump($model);die;
//         var_dump($model, $id_bene); die();
        $model->estatus = 200;
        $model->fecha_actualizacion = 'now';
        $model->usuario_id_actualizacion = Yii::app()->user->id;
        $model->save();
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('update', 'id' => $model->unidad_familiar_id));
    }

    public function actionActualizar() { {
            Yii :: import('booster.components.TbEditableSaver');
            $es = new TbEditableSaver('GrupoFamiliar');
//       var_dump($es);die;
//Con onBeforeUpdate agrego los atrubitos adicionales que quiero actualizar
            $es->onBeforeUpdate = function($event) {
                $event->sender->setAttribute('fecha_actualizacion', date('Y-m-d H:i:s'));
                $event->sender->setAttribute('usuario_id_actualizacion', Yii::app()->user->id);
            };
            $es->update();
        }
    }

}
