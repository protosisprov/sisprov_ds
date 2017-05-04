<?php

class EmpadronadorCensoController extends Controller {

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
        $vistaEmpadronador = new VswEmpadronadorCensos;
        $model = new EmpadronadorCenso;
        $asignacionC = AsignacionCenso::model()->findByPk($id);

        $model->Des = $asignacionC->desarrollo->nombre;
        $model->parqDes = $asignacionC->desarrollo->fkParroquia->strdescripcion;
        $model->munDes = $asignacionC->desarrollo->fkParroquia->clvmunicipio0->strdescripcion;
        $model->edoDes = $asignacionC->desarrollo->fkParroquia->clvmunicipio0->clvestado0->strdescripcion;

        $unidadHab = new CDbCriteria;
        $unidadHab->addCondition('t.desarrollo_id= :desarrollo_id');
        $unidadHab->params = array(':desarrollo_id' => $asignacionC->desarrollo_id);
        $unidadHab->order = 't.nombre ASC';


        if (isset($_POST['EmpadronadorCenso'])) {
            $model->attributes = $_POST['EmpadronadorCenso'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_empadronador_censo));
        }

        $this->render('create', array(
            'model' => $model, 'asignacionC' => $asignacionC,
            'unidadHab' => $unidadHab, 'vistaEmpadronador' => $vistaEmpadronador
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionReasignacionEmpadronador($id, $iduser, $idasignacioncenso) {
        $vswEmpadronador = VswEmpadronadorCensos::model()->findByAttributes(array('id_beneficiario_temporal' => $id));
        $EmpadronadorCenso = EmpadronadorCenso::model()->findByAttributes(array('asignacion_censo_id' => $idasignacioncenso));
        $model = new VswEmpadronadorCensos;
        $model->nombre_desarrollo = $vswEmpadronador->nombre_desarrollo;
        $model->nombre_unidad_multifamiliar = $vswEmpadronador->nombre_unidad_multifamiliar;
        $model->nombre_adjudicado = $vswEmpadronador->nombre_adjudicado;
        $model->iduser = $vswEmpadronador->iduser;
        $model->Emp = $vswEmpadronador->empadronador_usuario;
        if (isset($_POST['VswEmpadronadorCensos'])) {
            EmpadronadorCenso::model()->updateByPk($EmpadronadorCenso->id_empadronador_censo, array(
                'empadronador_usuario_id' => $_POST['EmpadronadorCenso']['empadronador_usuario_id'],
                'fecha_actualizacion' => 'now()',
                    )
            );
            $this->redirect(array('/empadronadorCenso/create/', 'id' => $_GET['idasignacioncenso']));
        }
        $this->render('reasignacionEmpadronador', array(
            'model' => $model, 'vswEmpadronador' => $vswEmpadronador
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['EmpadronadorCenso'])) {
            $model->attributes = $_POST['EmpadronadorCenso'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_empadronador_censo));
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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new EmpadronadorCenso('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['EmpadronadorCenso']))
            $model->attributes = $_GET['EmpadronadorCenso'];

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
        $model = EmpadronadorCenso::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'empadronador-censo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
