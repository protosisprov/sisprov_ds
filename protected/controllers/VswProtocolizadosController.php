<?php

class VswProtocolizadosController extends Controller
{
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
	public function actionView($id)
	{
		$this->render('view',array(
		'model'=>$this->loadModel($id),
		));
	}

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{
		$model=new VswProtocolizados;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VswProtocolizados']))
		{
			$model->attributes=$_POST['VswProtocolizados'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_desarrollo));
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
	public function actionUpdate($id)
	{
	$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VswProtocolizados']))
		{
			$model->attributes=$_POST['VswProtocolizados'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_desarrollo));
		}

		$this->render('update',array(
		'model'=>$model,
		));
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('VswProtocolizados');
		$this->render('index',array(
		'dataProvider'=>$dataProvider,
		));
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new VswProtocolizados('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VswProtocolizados']))
			$model->attributes=$_GET['VswProtocolizados'];

		$this->render('admin',array(
		'model'=>$model,
		));
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=VswProtocolizados::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vsw-protocolizados-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionRelational()
    {
        // partially rendering "_relational" view
        /*$this->renderPartial('_relational', array(
            'id' => Yii::app()->getRequest()->getParam('id'),
            'gridDataProvider' => $this->getGridDataProvider(),
            'gridColumns' => $this->getGridColumns()
        ));*/

        $id = Yii::app()->getRequest()->getParam('id');
        $nombre_desarrollo = Desarrollo::model()->findByPk($id);
        // $beneficiario_temporal = BeneficiarioTemporal::model()->findByAttributes(array('desarrollo_id' => $id));


        $model_beneficiario = new BeneficiarioTemporal('search');
        $model_beneficiario->unsetAttributes();  // clear any default values
        if (isset($_GET['BeneficiarioTemporal']))
            $model_beneficiario->attributes = $_GET['BeneficiarioTemporal'];

       $this->renderPartial('_relational', array(
            'model_beneficiario' => $model_beneficiario,
            'id' => $id,
            'nombre_desarrollo' => $nombre_desarrollo,
            // 'beneficiario_temporal'=>$beneficiario_temporal

        ));
    }
}
