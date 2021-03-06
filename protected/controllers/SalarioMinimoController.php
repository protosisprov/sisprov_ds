<?php

class SalarioMinimoController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
    public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    public function accessRules() {
		return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
			),
            array('deny', // deny all users
                'users' => array('*'),
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
        $model = new SalarioMinimo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

                
        if (isset($_POST['SalarioMinimo'])) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'es_activo= :es_activo';
        $criteria->params = array(":es_activo" => "true");
        $Salario = SalarioMinimo::model()->findAll($criteria);
        
        
        foreach ($Salario AS $SM) {
                          // $SM = SalarioMinimo::model()->findAll(array('es_activo' => 'true'));
        
        $update = SalarioMinimo::model()->updateByPk($SM->id_salario_minimo, array(
                    'es_activo' => false, // ANALISIS DE CREDITO
                    'usuario_id_actualizacion' => Yii::app()->user->id,
                    'fecha_actualizacion' => 'now()'
		  ));
        } 
        
//        die;
            $model->attributes = $_POST['SalarioMinimo'];
                        $model->valor_salario = str_replace(',', '', str_replace('.', '.', $_POST['SalarioMinimo']['valor_salario']));
                        $model->usuario_id_creacion = Yii::app()->user->id;
                        $model->fecha_creacion = 'now()';
                        $model->fecha_actualizacion = 'now()';
            if ($model->save())
                $this->redirect(array('create', 'id' => $model->id_salario_minimo));
		}
                
                
                
                
                

		$this->render('create',array(
			'model'=>$model,
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

        if (isset($_POST['SalarioMinimo'])) {
            $model->attributes = $_POST['SalarioMinimo'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_salario_minimo));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SalarioMinimo');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
    public function actionAdmin() {
        $model = new SalarioMinimo('search');
		$model->unsetAttributes();  // clear any default values
        if (isset($_GET['SalarioMinimo']))
            $model->attributes = $_GET['SalarioMinimo'];

        $this->render('admin', array(
            'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SalarioMinimo the loaded model
	 * @throws CHttpException
	 */
    public function loadModel($id) {
        $model = SalarioMinimo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SalarioMinimo $model the model to be validated
	 */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'salario-minimo-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
