<?php

class AsignacionesController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

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
//                'actions' => array('create', 'update'),
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
        $model = new Asignaciones;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Asignaciones'])) {
            $model->attributes = $_POST['Asignaciones'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_asignaciones));
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

        if (isset($_POST['Asignaciones'])) {
            $model->attributes = $_POST['Asignaciones'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_asignaciones));
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
        $dataProvider = new CActiveDataProvider('Asignaciones');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Asignaciones('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Asignaciones']))
            $model->attributes = $_GET['Asignaciones'];

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
        $model = Asignaciones::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'asignaciones-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAsignarAnalista() {

        // var_dump($_POST);dIE;
        $check_list = $_POST['checked'];
        $id_seleccionado = explode(',', $check_list); // SEPARO LOS ID SELECCIONADOS POR COMA
        $asignado = (int) $_POST['asignado'];
        $caso = (int) $_POST['caso'];
        $cantInsert = 0; //INICIO EN 0
//        var_dump($id_beneficiarios);die;

        foreach ($id_seleccionado as $id):
            $model = new Asignaciones;
            if ($caso == 308) { //ANALISIS DE CRÉDITO

                $consulta = TempCensoValidadoFaovFasp::model()->findByPk($id);
                $codigo = $consulta->id_beneficiario;
            } 
//            else if ($caso == 2) { //ASIGNACION DE UNIFAMILIAR
//              $consulta2= UnidadFamiliar::findByAttributes(array('beneficiario_id'=>$id));
//                $codigo = $consulta2->id_unidad_familiar;
//       
//            }
            else if($caso == 309){ // ASIGNAR DOCUMENTOS MULTIFAMILIARES
                $codigo= $id;
            }
            $ID_CASO = (int) $codigo;
//            $sql = ("select value from cruge_fieldvalue where iduser= " . $asignado);
//            $NombreAnalista = Yii::app()->db->createCommand($sql)->queryScalar();
//            $consulta_id = Asignaciones::model()->find('fk_adjudicado=' . $fk_adjudicado);
 
            if ($ID_CASO != NULL) {
               // var_dump($consulta2);die;
                $buscarAsignacion = Asignaciones::model()->findByAttributes(array('fk_caso_asignado' => $ID_CASO, 'es_activo' => TRUE, 'fk_entidad'=>$caso));
                if (!empty($buscarAsignacion)) {
                    $bandera = 3; //CASO ASIGANDO
                } else {

                    $model->fk_entidad = $caso;
                    $model->fk_usuario_q_asigna = Yii::app()->user->id;
                    $model->fk_usuario_asignado = $asignado;
                    $model->fk_caso_asignado = $ID_CASO;
                    $model->fk_estatus = 304; //ESTATUS ASIGNADO
                    $model->fecha_creacion = 'now()';
                    $model->usuario_id_creacion = Yii::app()->user->id;
                    $model->es_activo = TRUE;

                    if ($model->save()) {
                        $cantInsert++;
                        $bandera = 1; //ASIGNO
                    } else {
                        $bandera = 2; //NO ASIGNO
                    }
                }
            }
        endforeach;

        if ($bandera == 1) {

            echo json_encode($caso); //Asignados
        } else if ($bandera == 2) {

            echo json_encode($caso); //no guardo la asignacion
        } 
        else if ($bandera == 3) {
            echo json_encode(3); //caso ya asignado
        }
    }

}
