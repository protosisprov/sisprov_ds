<?php

class AsignacionCensoController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
//    public $layout = '//layouts/column2';

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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new AsignacionCenso;
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;
        $persona = new Persona;

        
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['AsignacionCenso'])) {
//        var_dump($_POST); die();
            if ($_POST['AsignacionCenso']['persona_id'] == '') {
                $idPersona = ConsultaOracle::BuscarPersona(array(
                            'CEDULA' => $_POST['AsignacionCenso']['cedula'],
                            'NACIONALIDAD' => ($_POST['AsignacionCenso']['nacionalidad'] == 97) ? 1 : 0,
                            'PRIMER_NOMBRE' => trim(strtoupper($_POST['AsignacionCenso']['primer_nombre'])),
                            'SEGUNDO_NOMBRE' => trim(strtoupper($_POST['AsignacionCenso']['segundo_nombre'])),
                            'PRIMER_APELLIDO' => trim(strtoupper($_POST['AsignacionCenso']['primer_apellido'])),
                            'SEGUNDO_APELLIDO' => trim(strtoupper($_POST['AsignacionCenso']['segundo_apellido'])),
                            'FECHA_NACIMIENTO' => $_POST['AsignacionCenso']['fecha_nac'],
                                )
                );
            } else {
                $idPersona = $_POST['AsignacionCenso']['persona_id'];
            }
            $persona = new Persona;
            // $persona->attributes = $_POST['AsignacionCenso'];
            $persona->persona_id_faov = (int) $_POST["AsignacionCenso"]["persona_id"];
            $persona->nacionalidad = (int) $_POST["AsignacionCenso"]["nacionalidad"];
            $persona->cedula = (int) $_POST["AsignacionCenso"]["cedula"];
            $persona->primer_nombre = $_POST["AsignacionCenso"]["primer_nombre"];
            $persona->segundo_nombre = $_POST["AsignacionCenso"]["segundo_nombre"];
            $persona->primer_apellido = $_POST["AsignacionCenso"]["primer_apellido"];
            $persona->segundo_apellido = $_POST["AsignacionCenso"]["segundo_apellido"];
            $persona->fecha_nacimiento = $_POST["AsignacionCenso"]["fecha_nac"];
//            $persona->fecha_nacimiento = $_POST["AsignacionCenso"]["fecha_nac"];
            $persona->fecha_creacion = 'now()';
            $persona->fecha_actualizacion = 'now()';
            $persona->usuario_id_creacion = Yii::app()->user->id;
            $persona->usuario_id_actualizacion = Yii::app()->user->id;
//            echo '<pre>';
//             var_dump($persona); die();
            if ($persona->save()) {
                $id_persona = $persona->id_persona; //id persona de SISPROV
                $model->attributes = $_POST['AsignacionCenso'];
                $model->desarrollo_id = $_POST['AsignacionCenso_desarrollo_id'];
                $model->persona_id = $id_persona;
                $model->oficina_id = $_POST['AsignacionCenso_oficina_id'];
                $model->censado = isset($_POST['censado']) ? true : false;
                $model->fecha_asignacion = Generico::formatoFecha($_POST['AsignacionCenso']['fecha_asignacion']);
                $model->observaciones = $_POST['AsignacionCenso']['observaciones'];
                $model->fecha_creacion = 'now()';
                $model->fecha_actualizacion = 'now()';
                $model->usuario_id_creacion = Yii::app()->user->id;
                $model->estatus = 11;

                if ($model->save()) {
                    $this->redirect(array('view', 'id' => $model->id_asignacion_censo));
                }
            }else{
                echo "<pre>";
                var_dump($persona->Errors);
                exit;
            }
        }
        $this->render('create', array(
            'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia
        ));
    }
 
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->fecha_asignacion = date('d/m/Y', strtotime($model->fecha_asignacion));
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;
        
        //var_dump($model); die();
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        $consulta = Persona::model()->findByAttributes(array('id_persona' => $model->persona_id));
        $model->nacionalidad = ($consulta['nacionalidad'] == 97) ? 97 : 98;
        $model->cedula = $consulta['cedula'];
        $model->primer_nombre = $consulta['primer_nombre'];
        $model->segundo_nombre = $consulta['segundo_nombre'];
        $model->primer_apellido = $consulta['primer_apellido'];
        $model->segundo_apellido = $consulta['segundo_apellido'];
        if (isset($_POST['AsignacionCenso'])) {
            if ($_POST['AsignacionCenso']['persona_id'] == '') {
                $idPersona = ConsultaOracle::updatePersona(array(
                            'CEDULA' => $_POST['AsignacionCenso']['cedula'],
                            'NACIONALIDAD' => ($_POST['AsignacionCenso']['nacionalidad'] == 97) ? 1 : 0,
                            'PRIMER_NOMBRE' => trim(strtoupper($_POST['AsignacionCenso']['primer_nombre'])),
                            'SEGUNDO_NOMBRE' => trim(strtoupper($_POST['AsignacionCenso']['segundo_nombre'])),
                            'PRIMER_APELLIDO' => trim(strtoupper($_POST['AsignacionCenso']['primer_apellido'])),
                            'SEGUNDO_APELLIDO' => trim(strtoupper($_POST['AsignacionCenso']['segundo_apellido'])),
                            'FECHA_NACIMIENTO' => $_POST['AsignacionCenso']['fecha_nac'],
                                )
                );
            } else {
                $idPersona = $_POST['AsignacionCenso']['persona_id'];
                $idAsignacion = $_POST['AsignacionCenso']['persona_id'];
                /// var_dump($model); die();      
            }

            $model->persona_id = $idAsignacion;
            $model->fecha_asignacion = Generico::formatoFecha($_POST['AsignacionCenso']['fecha_asignacion']);
            $model->observaciones = trim(strtoupper($_POST['AsignacionCenso']['observaciones']));
            $model->fecha_actualizacion = 'now()';
            $model->usuario_id_creacion = Yii::app()->user->id;

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id_asignacion_censo));
//                    $this->render(array('admin'));
            }
        }
        $this->render('update', array(
            'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia
        ));
    }

    //FUNCION PARA LA REASIGNACION DE OFICINA 
    public function actionCreateReasignacion($id) {
        $model = new AsignacionCenso;
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;
        $persona = new Persona;

        $model = $this->loadModel($id);
        $model->fecha_asignacion = date('d/m/Y', strtotime($model->fecha_asignacion));
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;

        $consulta = Persona::model()->findByAttributes(array('id_persona' => $model->persona_id));
        $model->nacionalidad = ($consulta['nacionalidad'] == 97) ? 97 : 98;
        $model->cedula = $consulta['cedula'];
        $model->primer_nombre = $consulta['primer_nombre'];
        $model->segundo_nombre = $consulta['segundo_nombre'];
        $model->primer_apellido = $consulta['primer_apellido'];
        $model->segundo_apellido = $consulta['segundo_apellido'];

        if (isset($_POST['AsignacionCenso'])) { // es el post- traigo datos  
            if ($id == '') { //si no esta registro en persona TABLA ASIGNACIONCENSO   
            } else { //si esta cambio estatus inactivo y registro de nuevo
//                 $modelddd = AsignacionCenso::model()->findByPk($id);
                $modelUpdate = AsignacionCenso::model()->updateByPk($model->id_asignacion_censo, array(
                    'estatus' => 12,
                    'usuario_id_creacion' => Yii::app()->user->id,
                    'fecha_actualizacion' => 'now()'
                ));
            }
            //// aqui empiezo a insertat persona
            $consultaNuevaPersona = Persona::model()->findByAttributes(array('nacionalidad' => $_POST["AsignacionCenso"]["nacionalidad"], 'cedula' => $_POST["AsignacionCenso"]["cedula"]));
            if (isset($consultaNuevaPersona)) { // si tiene datos es que la persona esta registrada y tiene su ID TABAL PERSONA
                $id_persona = $consultaNuevaPersona->id_persona;
            } else {
                $idPersonaFaov = ConsultaOracle::BuscarPersona(array(
                            'CEDULA' => $_POST["AsignacionCenso"]["cedula"],
                            'NACIONALIDAD' => ($_POST["AsignacionCenso"]['nacionalidad'] == 97) ? 1 : 0,
                            'PRIMER_NOMBRE' => trim(strtoupper($_POST["AsignacionCenso"]['primer_nombre'])),
                            'SEGUNDO_NOMBRE' => trim(strtoupper($_POST["AsignacionCenso"]['segundo_nombre'])),
                            'PRIMER_APELLIDO' => trim(strtoupper($_POST["AsignacionCenso"]['primer_apellido'])),
                            'SEGUNDO_APELLIDO' => trim(strtoupper($_POST["AsignacionCenso"]['segundo_apellido'])),
                                )
                );
                $persona = new Persona;
                
                $persona->persona_id_faov = (isset($idPersonaFaov)) ? $idPersonaFaov : 0;
                $persona->nacionalidad = (int) $_POST["AsignacionCenso"]["nacionalidad"];
                $persona->cedula = (int) $_POST["AsignacionCenso"]["cedula"];
                $persona->primer_nombre = $_POST["AsignacionCenso"]["primer_nombre"];
                $persona->segundo_nombre = $_POST["AsignacionCenso"]["segundo_nombre"];
                $persona->primer_apellido = $_POST["AsignacionCenso"]["primer_apellido"];
                $persona->segundo_apellido = $_POST["AsignacionCenso"]["segundo_apellido"];
                $persona->fecha_nacimiento = $_POST["AsignacionCenso"]["fecha_nac"];
                $persona->fecha_creacion = 'now()';
                $persona->fecha_actualizacion = 'now()';
                $persona->usuario_id_creacion = Yii::app()->user->id;
                $persona->usuario_id_actualizacion = Yii::app()->user->id;
                if ($persona->save()) {
                    $id_persona = $persona->id_persona; //id persona de SISPROV
                    //registramos persona
                } else {
                    echo "<pre>";
                    var_dump($persona->Errors);
                    exit;
                }
            }
            if (isset($id_persona)) {
                $model->attributes = $_POST['AsignacionCenso'];
                $model->desarrollo_id = $_POST['AsignacionCenso']['desarrollo_id'];
                $model->persona_id = $id_persona;
                $model->oficina_id = $_POST['AsignacionCenso_oficina_id'];
                $model->censado = isset($_POST['censado']) ? true : false;
                $model->fecha_asignacion = Generico::formatoFecha($_POST['AsignacionCenso']['fecha_asignacion']);
                $model->observaciones = $_POST['AsignacionCenso']['observaciones'];
                $model->censado = isset($_POST['censado']) ? true : false;
                $model->fecha_creacion = 'now()';
                $model->fecha_actualizacion = 'now()';
                $model->usuario_id_creacion = Yii::app()->user->id;
                $model->estatus = 11;
                if ($model->save()) {
                    $this->redirect(array('view', 'id' => $model->id_asignacion_censo));
                } else {
                    echo "<pre>";
                    var_dump($model->Errors);
                    exit;
                }
            }
        }
        $this->render('createReasignacion', array(
            'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia
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
        $dataProvider = new CActiveDataProvider('AsignacionCenso');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AsignacionCenso('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AsignacionCenso']))
            $model->attributes = $_GET['AsignacionCenso'];

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
        $model = AsignacionCenso::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'asignacion-censo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPdf($id) {
        $model = $this->loadModel($id);
        $consultaNuevaPersona = Persona::model()->findByAttributes(array('id_persona' => $model->persona_id));
//        var_dump($consultaNuevaPersona); die();
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $this->render('pdf', array(
            'model' => $model,
            'estado' => $estado,
            'municipio' => $municipio,
            'consultaNuevaPersona' => $consultaNuevaPersona,
        ));
    }

    public function FindByIdPersona($id) {
        $model = AsignacionCenso::model()->findByAttributes(array('persona_id' => $id));
        if ($model === null)
            return FALSE;
        return $model;
    }

}
