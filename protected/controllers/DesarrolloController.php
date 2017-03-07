
<?php

class DesarrolloController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    // public $layout = '//layouts/column2';

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
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'estado' => $estado,
            'municipio' => $municipio,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Desarrollo;
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;
        $enteEjecutor = new EnteEjecutor;
        $fuenteFinacimiento = new FuenteFinanciamiento;
        $fuenteFinacimientoObra = new FuenteFinanciamientoObra;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Desarrollo'])) {
//            echo '<pre>';var_dump($_POST);die;
            $nombre = trim(strtoupper($_POST['Desarrollo']['nombre']));
            $id_parroquia = $_POST['Desarrollo']['parroquia_id'];
            $consulta = Desarrollo::model()->findByAttributes(array('nombre' => $nombre, 'parroquia_id' => $id_parroquia));
//            echo '<pre>';var_dump($consulta);die;
            
            if (empty($consulta)) {
                $model->attributes = $_POST['Desarrollo'];
                $model->nombre = $nombre;
                $model->parroquia_id = $id_parroquia;
                $model->descripcion = trim(strtoupper($_POST['Desarrollo']['descripcion']));
                $model->urban_barrio = trim(strtoupper($_POST['Desarrollo']['urban_barrio']));
                $model->av_call_esq_carr = trim(strtoupper($_POST['Desarrollo']['av_call_esq_carr']));
                $model->zona = trim(strtoupper($_POST['Desarrollo']['zona']));
                $model->lote_terreno_mt2 = ($_POST['Desarrollo']['lote_terreno_mt2']) ? $_POST['Desarrollo']['lote_terreno_mt2'] : '0';
                $model->lindero_norte = trim(strtoupper($_POST['Desarrollo']['lindero_norte']));
                $model->lindero_este = trim(strtoupper($_POST['Desarrollo']['lindero_este']));
                $model->lindero_oeste = trim(strtoupper($_POST['Desarrollo']['lindero_oeste']));
                $model->lindero_sur = trim(strtoupper($_POST['Desarrollo']['lindero_sur']));
                $model->coordenadas = $_POST['Desarrollo']['coordenadas'];
                $model->ente_ejecutor_id = $_POST['Desarrollo']['ente_ejecutor_id'];
                $model->fuente_financiamiento_id = $_POST['Desarrollo']['fuente_financiamiento_id'];
                $model->id_fuente_financiamiento_obra = $_POST['Desarrollo']['id_fuente_financiamiento_obra'];
                $model->fuente_datos_entrada_id = 5;
                $model->titularidad_del_terreno = isset($_POST['titularidad_del_terreno']) ? true : false;
                $model->fecha_transferencia = ($_POST['Desarrollo']['fecha_transferencia'] !='') ? Generico::formatoFecha($_POST['Desarrollo']['fecha_transferencia']) : '0001-01-01 00:00:00';
                $model->fecha_creacion = 'now()';
                $model->fecha_actualizacion = 'now()';
                $model->usuario_id_creacion = Yii::app()->user->id;
                $model->estatus = 30;
                $model->matricula = isset($_POST['matricula']) ? true : false;
                // nuevos campos;
                $model->fecha_registro = ($_POST['Desarrollo']['fecha_registro'] !='') ? Generico::formatoFecha($_POST['Desarrollo']['fecha_registro']) : '0001-01-01 00:00:00';
                $model->ano = $_POST['Desarrollo']['ano'];
                $model->asiento_registral = $_POST['Desarrollo']['asiento_registral'];
                $model->registro_publico_id = $_POST['Desarrollo']['registro_publico_id'];
//                $model->tipo_documento_id = $_POST['Desarrollo']['tipo_documento_id'];
                $model->num_protocolo = $_POST['Desarrollo']['num_protocolo'];
                $model->tomo = $_POST['Desarrollo']['tomo'];
                $model->folio_real = $_POST['Desarrollo']['folio_real'];
                $model->num_matricula = $_POST['Desarrollo']['num_matricula'];
//                echo '<pre>';var_dump($model); die();
                if ($model->save()) {
                    
                    if (isset($_POST['CARGAR_OTRO'])) {
                        $this->render('create', array(
                            'model' => new Desarrollo, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia, 'enteEjecutor' => $enteEjecutor, 'fuenteFinacimiento' => $fuenteFinacimiento, 'fuenteFinacimientoObra' => $fuenteFinacimientoObra
                        ));
                        Yii::app()->end();
                    }
                    
                   /* } else {
                        $this->redirect(array('admin'));
                        Yii::app()->end();
                    }*/
                    
                    if (isset($_POST['cargar_unidad'])) {
                        $this->redirect(array('unidadHabitacional/precarga/'.$model->id_desarrollo));
                        Yii::app()->end();
                    }
                }
            } else {
                $this->render('create', array(
                    'model' => $model, 'estado' => $estado,
                    'municipio' => $municipio, 'parroquia' => $parroquia,
                    'enteEjecutor' => $enteEjecutor, 'fuenteFinacimiento' => $fuenteFinacimiento, 'fuenteFinacimientoObra' => $fuenteFinacimientoObra,
                    'sms' => 1
                ));
                Yii::app()->end();
            }
        }
        $this->render('create', array(
            'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia, 'enteEjecutor' => $enteEjecutor, 'fuenteFinacimiento' => $fuenteFinacimiento,  'fuenteFinacimientoObra' => $fuenteFinacimientoObra
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        //$model = new Desarrollo;
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;
        $enteEjecutor = new EnteEjecutor;
        $fuenteFinacimiento = new FuenteFinanciamiento;
        $fuenteFinacimientoObra = new FuenteFinanciamientoObra;
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        
        if (isset($_POST['Desarrollo'])) {
            $model->attributes = $_POST['Desarrollo'];
            $model->nombre = trim(strtoupper($_POST['Desarrollo']['nombre']));
            $model->descripcion = trim(strtoupper($_POST['Desarrollo']['descripcion']));
            $model->urban_barrio = trim(strtoupper($_POST['Desarrollo']['urban_barrio']));
            $model->av_call_esq_carr = trim(strtoupper($_POST['Desarrollo']['av_call_esq_carr']));
            $model->zona = trim(strtoupper($_POST['Desarrollo']['zona']));
            $model->lindero_norte = trim(strtoupper($_POST['Desarrollo']['lindero_norte']));
            $model->lindero_este = trim(strtoupper($_POST['Desarrollo']['lindero_este']));
            $model->lindero_oeste = trim(strtoupper($_POST['Desarrollo']['lindero_oeste']));
            $model->lindero_sur = trim(strtoupper($_POST['Desarrollo']['lindero_sur']));
            $model->usuario_id_actualizacion = Yii::app()->user->id;
            $model->fecha_actualizacion = 'now()';
            $model->titularidad_del_terreno = isset($_POST['titularidad_del_terreno']) ? true : false;
            $model->matricula = isset($_POST['matricula']) ? true : false;
            
//            $model->matricula = isset($_POST['matricula']) ? true : false;
            $model->fecha_transferencia = ($model->titularidad_del_terreno) ? Generico::formatoFecha($_POST['Desarrollo']['fecha_transferencia']) : '0001-01-01 00:00:00';
            // nuevos campos;
            
            //$model->fecha_registro = ($model->titularidad_del_terreno) ? Generico::formatoFecha($_POST['Desarrollo']['fecha_registro']) : '0001-01-01 00:00:00';
            //$model->ano = $_POST['Desarrollo']['ano'];
            //$model->asiento_registral = $_POST['Desarrollo']['asiento_registral'];
            //$model->registro_publico_id = $_POST['Desarrollo']['registro_publico_id'];
//            $model->tipo_documento_id = $_POST['Desarrollo']['tipo_documento_id'];
            //$model->num_protocolo = $_POST['Desarrollo']['num_protocolo'];
            //$model->tomo = $_POST['Desarrollo']['tomo'];
            //$model->folio_real = $_POST['Desarrollo']['folio_real'];
            //$model->num_matricula = $_POST['Desarrollo']['num_matricula'];
            
            
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_desarrollo));
        }

        $this->render('update', array(
            'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia, 'enteEjecutor' => $enteEjecutor, 'fuenteFinacimiento' => $fuenteFinacimiento, 'fuenteFinacimientoObra' => $fuenteFinacimientoObra
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
        $dataProvider = new CActiveDataProvider('Desarrollo');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionPdf($id) {
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $this->render('pdf', array(
            'model' => $this->loadModel($id),
            'estado' => $estado,
            'municipio' => $municipio,
        ));
    }

    public function actionAdmin() {
        $model = new Desarrollo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Desarrollo']))
            $model->attributes = $_GET['Desarrollo'];

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
        $model = Desarrollo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'desarrollo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionAdminProtocolizados()
    {
        $model = new VswMultifamiliar('searchGroupBy');
        //$model->searchGroupBy();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['VswMultifamiliar']))
            $model->attributes = $_GET['VswMultifamiliar'];

        $this->render('adminProtocolizados', array(
            'model' => $model,
        ));
    }


    public function actionRegistral($id)
    {
         function docs($id){
            return Yii::app()->db->createCommand()
                    ->select('id_documentacion,tipo_documento_id,fecha_creacion')
                    ->from('documentacion')
                    ->where(array('in','tipo_documento_id',array(88,277)))
                    ->andWhere('estatus=:estatus',array(':estatus'=>53))
                    ->andWhere('fk_beneficiario=:fk_beneficiario',array(':fk_beneficiario'=>$id))
                    ->andWhere('registro_documento_id IS NULL')
                    ->queryAll();
         }
          $model = new RegistroDocumento;
          $docs = docs($id);
           // echo '<pre>';var_dump($docs);die;
 
          //$model = new Desarrollo;
          if (isset($_POST['RegistroDocumento'])) {
              if (isset($_POST['RegistroDocumento'])) {
                  //var_dump($_POST['id_doc']);die;
                  $model->attributes = $_POST['RegistroDocumento'];
                  //$model->nombre = trim(strtoupper($_POST['Desarrollo']['nombre']));
                  //$model->descripcion = trim(strtoupper($_POST['Desarrollo']['descripcion']));
                  //$model->urban_barrio = trim(strtoupper($_POST['Desarrollo']['urban_barrio']));
                  //$model->av_call_esq_carr = trim(strtoupper($_POST['Desarrollo']['av_call_esq_carr']));
                  //$model->zona = trim(strtoupper($_POST['Desarrollo']['zona']));
                 //$model->lindero_norte = trim(strtoupper($_POST['Desarrollo']['lindero_norte']));
                 //$model->lindero_este = trim(strtoupper($_POST['Desarrollo']['lindero_este']));
                 //$model->lindero_oeste = trim(strtoupper($_POST['Desarrollo']['lindero_oeste']));
                 //$model->lindero_sur = trim(strtoupper($_POST['Desarrollo']['lindero_sur']));
                 $model->usuario_id_actualizacion = Yii::app()->user->id;
                 $model->fecha_actualizacion = 'now()';
                 //$model->titularidad_del_terreno = isset($_POST['titularidad_del_terreno']) ? true : false;
                 //$model->fecha_transferencia = ($model->titularidad_del_terreno) ? Generico::formatoFecha($_POST['Desarrollo']['fecha_transferencia']) : '0001-01-01 00:00:00';
                 // nuevos campos;
                 $model->fecha_registro = Generico::formatoFecha($_POST['RegistroDocumento']['fecha_registro']);
                 $model->ano = $_POST['RegistroDocumento']['ano'];
                 $model->asiento_registral = $_POST['RegistroDocumento']['asiento_registral'];
                 $model->registro_publico_id = $_POST['RegistroDocumento']['registro_publico_id'];
                 //$model->tipo_documento_id = $_POST['Desarrollo']['tipo_documento_id'];
                 //$model->num_protocolo = $_POST['Desarrollo']['num_protocolo'];
                 //$model->tomo = $_POST['Desarrollo']['folio_real'];
                 $model->folio_real = $_POST['RegistroDocumento']['folio_real'];
                 $model->nro_matricula = $_POST['RegistroDocumento']['nro_matricula'];

                 $hs_registro_publico_id = $_POST['RegistroDocumento']['registro_publico_id'];
                 $hs_fecha_registro = $_POST['RegistroDocumento']['fecha_registro'];
                 $hs_num_protocolo = $_POST['RegistroDocumento']['nro_protocolo'];
                 $hs_ano = $_POST['RegistroDocumento']['ano'];
                 $hs_asiento_registral = $_POST['RegistroDocumento']['asiento_registral'];
                 $hs_folio_real = $_POST['RegistroDocumento']['folio_real'];
                 $hs_num_matricula = $_POST['RegistroDocumento']['nro_matricula'];
                 $hs_tomo = $_POST['RegistroDocumento']['tomo'];
                 $hs_estatus = $model->estatus = 53;
                 $hs_fecha_creacion = $model->fecha_creacion = 'now()';
                 $hs_fecha_actualizacion = $model->fecha_actualizacion = 'now()';
                 $hs_usuario_id_creacion = $model->usuario_id_creacion = Yii::app()->user->id;


                        $id_doc = $_POST['id_doc'];
                        $hstore='select fn_reg_doc_documentacion(\'
                            "registro_publico_id"=>"'.$hs_registro_publico_id.'",
                            "fecha_registro"=>"'.$hs_fecha_registro.'",
                            "tomo"=>"'.$hs_tomo.'",
                            "ano"=>"'.$hs_ano.'",
                            "asiento_registral"=>"'.$hs_asiento_registral.'",
                            "folio_real"=>"'.$hs_folio_real.'",
                            "nro_protocolo"=>"'.$hs_num_protocolo.'",
                            "nro_matricula"=>"'.$hs_num_matricula.'",
                            "estatus"=>"'.$hs_estatus.'",
                            "fecha_creacion"=>"'.$hs_fecha_creacion.'",
                            "fecha_actualizacion"=>"'.$hs_fecha_actualizacion.'",
                            "usuario_id_creacion"=>"'.$hs_usuario_id_creacion.'"
                            \'
                            ,'.$id_doc.',\'m\')';

                 

                  $function = Yii::app()->db->createCommand($hstore)->queryAll();

                  $docs = docs($id);
                  
                  if($docs!=null){

                    $this->render('registral',array(
                         'model'=>$model,
                         'docs'=>$docs
                         ));
                  }else{
                    $this->redirect(array('documentacion/adminmultifamiliar'));
                  }

 
                 //if ($model->save())
                     
         }
          }else{
             $this->render('registral',array(
                 'model'=>$model,
                 'docs'=>$docs
                 ));
          }
     }

    public function actionRegistralBeneficiario($id)
    {
        $fk_beneficiario = $id;
        function docs($id){
            $docs = Yii::app()->db->createCommand()
                    ->select('id_documentacion')
                    ->from('documentacion')
                    ->where(array('not in','tipo_documento_id',array(88,277)))
                    ->andWhere('estatus=:estatus',array(':estatus'=>53))
                    ->andWhere('fk_beneficiario=:fk_beneficiario',array(':fk_beneficiario'=>$id))
                    ->andWhere('registro_documento_id IS NULL')
                    ->queryAll();
            return $docs['id_documentacion'];
         }
          //$model = $this->loadModel($id);
           // echo '<pre>';var_dump($docs);die;
         $model = new RegistroDocumento;

          //$model = new Desarrollo;
          if (isset($_POST['RegistroDocumento'])) {
              if (isset($_POST['RegistroDocumento'])) {
                  //var_dump($_POST['id_doc']);die;
                  $model->attributes = $_POST['RegistroDocumento'];
                  //$model->nombre = trim(strtoupper($_POST['Desarrollo']['nombre']));
                 //$model->descripcion = trim(strtoupper($_POST['Desarrollo']['descripcion']));
                 //$model->urban_barrio = trim(strtoupper($_POST['Desarrollo']['urban_barrio']));
                //$model->av_call_esq_carr = trim(strtoupper($_POST['Desarrollo']['av_call_esq_carr']));
                //$model->zona = trim(strtoupper($_POST['Desarrollo']['zona']));
                 //$model->lindero_norte = trim(strtoupper($_POST['Desarrollo']['lindero_norte']));
                 //$model->lindero_este = trim(strtoupper($_POST['Desarrollo']['lindero_este']));
                 //$model->lindero_oeste = trim(strtoupper($_POST['Desarrollo']['lindero_oeste']));
                 //$model->lindero_sur = trim(strtoupper($_POST['Desarrollo']['lindero_sur']));
                 $model->usuario_id_actualizacion = Yii::app()->user->id;
                 $model->fecha_actualizacion = 'now()';
                 //$model->titularidad_del_terreno = isset($_POST['titularidad_del_terreno']) ? true : false;
                 //$model->fecha_transferencia = ($model->titularidad_del_terreno) ? Generico::formatoFecha($_POST['Desarrollo']['fecha_transferencia']) : '0001-01-01 00:00:00';
                 // nuevos campos;
                 $model->fecha_registro = Generico::formatoFecha($_POST['RegistroDocumento']['fecha_registro']);
                 $model->ano = $_POST['RegistroDocumento']['ano'];
                 $model->asiento_registral = $_POST['RegistroDocumento']['asiento_registral'];
                 $model->registro_publico_id = $_POST['RegistroDocumento']['registro_publico_id'];
                 //$model->tipo_documento_id = $_POST['Desarrollo']['tipo_documento_id'];
                 //$model->num_protocolo = $_POST['Desarrollo']['num_protocolo'];
                 //$model->tomo = $_POST['Desarrollo']['folio_real'];
                 $model->folio_real = $_POST['RegistroDocumento']['folio_real'];
                 $model->nro_matricula = $_POST['RegistroDocumento']['nro_matricula'];

                 $hs_registro_publico_id = $_POST['RegistroDocumento']['registro_publico_id'];
                 $hs_fecha_registro = $_POST['RegistroDocumento']['fecha_registro'];
                 $hs_num_protocolo = $_POST['RegistroDocumento']['nro_protocolo'];
                 $hs_ano = $_POST['RegistroDocumento']['ano'];
                 $hs_asiento_registral = $_POST['RegistroDocumento']['asiento_registral'];
                 $hs_folio_real = $_POST['RegistroDocumento']['folio_real'];
                 $hs_num_matricula = $_POST['RegistroDocumento']['nro_matricula'];
                 $hs_tomo = $_POST['RegistroDocumento']['tomo'];
                 $hs_estatus = $model->estatus = 53;
                 $hs_fecha_creacion = $model->fecha_creacion = 'now()';
                 $hs_fecha_actualizacion = $model->fecha_actualizacion = 'now()';
                 $hs_usuario_id_creacion = $model->usuario_id_creacion = Yii::app()->user->id;


                        $id_doc = $fk_beneficiario;
                        $hstore='select fn_reg_doc_documentacion(\'
                            "registro_publico_id"=>"'.$hs_registro_publico_id.'",
                            "fecha_registro"=>"'.$hs_fecha_registro.'",
                            "tomo"=>"'.$hs_tomo.'",
                            "ano"=>"'.$hs_ano.'",
                            "asiento_registral"=>"'.$hs_asiento_registral.'",
                            "folio_real"=>"'.$hs_folio_real.'",
                            "nro_protocolo"=>"'.$hs_num_protocolo.'",
                            "nro_matricula"=>"'.$hs_num_matricula.'",
                            "estatus"=>"'.$hs_estatus.'",
                            "fecha_creacion"=>"'.$hs_fecha_creacion.'",
                            "fecha_actualizacion"=>"'.$hs_fecha_actualizacion.'",
                            "usuario_id_creacion"=>"'.$hs_usuario_id_creacion.'"
                            \'
                            ,'.$id_doc.',\'u\')';

                 

                  $function = Yii::app()->db->createCommand($hstore)->queryAll();

                  $this->redirect(array('documentacion/adminbeneficiario'));

                 //if ($model->save())                     
         }
          }else{

             $this->render('registralBeneficiario',array(
                 'model'=>$model,
                 //'docs'=>$docs
                 ));
          }
    }
    
    public function actionActualizar() { {
        
        $id = (int)yii::app()->request->getParam('pk');
        $model = $this->loadModel($id);
        $model->observaciones = yii::app()->request->getParam('value');
//            Yii :: import('booster.components.TbEditableSaver');
//            $es = new TbEditableSaver('Desarrollo');
//       var_dump($es);die;
//Con onBeforeUpdate agrego los atrubitos adicionales que quiero actualizar
//            $es->onBeforeUpdate = function($event) {
//                $event->sender->setAttribute('fecha_actualizacion', date('Y-m-d H:i:s'));
//                $event->sender->setAttribute('usuario_id_actualizacion', Yii::app()->user->id);
//            };
            $model->update();
        }
    }

}
