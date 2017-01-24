<?php

class TempCensoValidadoFaovFaspController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

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
        $model = new TempCensoValidadoFaovFasp;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TempCensoValidadoFaovFasp'])) {
            $model->attributes = $_POST['TempCensoValidadoFaovFasp'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_temp_censo_validado_faov_fasp));
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

        if (isset($_POST['TempCensoValidadoFaovFasp'])) {
            $model->attributes = $_POST['TempCensoValidadoFaovFasp'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_temp_censo_validado_faov_fasp));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /*
     * ACCION QUE CAMBIA DE FUENTE DE FINANCIAMIENTO DE FAOV PARA FASP
     */

    public function actionChangeFaovFasp($id) {
        $model = TempCensoValidadoFaovFasp::model()->findByAttributes(array('id_beneficiario' => $id));
        $model->attributes = array('id_fuente_financiamiento' => 3, 'nombre_fuente_financiamiento' => 'FASP');
        $model->save();

        $this->redirect(array('admin'));
    }

    /*
     * ACCION QUE CAMBIA DE FUENTE DE FINANCIAMIENTO DE FASP PARA FAOV
     */

    public function actionChangeFaspFaov($id) {
        $model = TempCensoValidadoFaovFasp::model()->findByAttributes(array('id_beneficiario' => $id));
        $model->attributes = array('id_fuente_financiamiento' => 2, 'nombre_fuente_financiamiento' => 'FAOV');
        $model->save();
        $this->redirect(array('adminfasp'));
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
        $dataProvider = new CActiveDataProvider('TempCensoValidadoFaovFasp');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $asignaciones = new Asignaciones;
        $vswAsignaciones = new VswAsignacionesCasos('search');
        $vswAsignaciones->unsetAttributes();  // clear any default values
        $vswAsignaciones->fk_usuario_asignado = Yii::app()->user->id;
        $vswAsignaciones->es_activo = TRUE;
        $vswAsignaciones->id_fuente_financiamiento = 2;
        if (isset($_GET['VswAsignacionesCasos']))
            $vswAsignaciones->attributes = $_GET['VswAsignacionesCasos'];
            $model = new TempCensoValidadoFaovFasp('search');
            $model->unsetAttributes();  // clear any default values
            $model->id_fuente_financiamiento = 2;
        if (isset($_GET['TempCensoValidadoFaovFasp']))
            $model->attributes = $_GET['TempCensoValidadoFaovFasp'];

        $this->render('admin', array(
            'model' => $model, 'asignaciones' => $asignaciones, 'vswAsignaciones' => $vswAsignaciones
        ));
    }

    public function actionAdminfasp() {
        $asignaciones = new Asignaciones;
        $vswAsignaciones = new VswAsignacionesCasos('search');
        $vswAsignaciones->unsetAttributes();  // clear any default values
        $vswAsignaciones->fk_usuario_asignado = Yii::app()->user->id;
        $vswAsignaciones->es_activo = TRUE;
        $vswAsignaciones->id_fuente_financiamiento = 3;
        if (isset($_GET['VswAsignacionesCasos']))
            $vswAsignaciones->attributes = $_GET['VswAsignacionesCasos'];
        $model = new TempCensoValidadoFaovFasp('search');
        $model->unsetAttributes();  // clear any default values
        $model->id_fuente_financiamiento = 3;
        if (isset($_GET['TempCensoValidadoFaovFasp']))
            $model->attributes = $_GET['TempCensoValidadoFaovFasp'];

        $this->render('adminfasp', array(
            'model' => $model, 'asignaciones' => $asignaciones, 'vswAsignaciones' => $vswAsignaciones
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = TempCensoValidadoFaovFasp::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'temp-censo-validado-faov-fasp-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
