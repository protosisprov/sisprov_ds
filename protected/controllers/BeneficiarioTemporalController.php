<?php

class BeneficiarioTemporalController extends Controller {
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
    /* public function accessRules() {
      return array(
      array('allow',
      'actions' => array('*'),
      'users' => array('@'),
      ),
      );
      } */

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $desarrollo = new Desarrollo;
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'desarrollo' => $desarrollo,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionCertificadoVarios($id) {
        $idTmp = explode(',', $id);
        $recordBeneTemp = BeneficiarioTemporal::model()->findAllByAttributes(array('id_beneficiario_temporal' => $idTmp));

        $this->render('certificadoVarios', array('recordBeneTemp' => $recordBeneTemp));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
         public function actionCreate() {
        $model = new BeneficiarioTemporal;
        $desarrollo = new Desarrollo;
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;
        $persona = new Persona;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
//         var_dump($_POST);  die();
//        var_dump($_POST); die,
//        exit;
//      echo $_POST["BeneficiarioTemporal"];
        if (isset($_POST['BeneficiarioTemporal'])) {

            switch ($_POST["BeneficiarioTemporal"]['estado_civil']) {
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
            //  var_dump($_POST["BeneficiarioTemporal"]["persona_id"]); die();
            /*  - - - -- Persona - - -- - - - */
            if ($_POST["BeneficiarioTemporal"]["persona_id"] == '') {

                $teleHab = str_replace('-', '', $_POST["BeneficiarioTemporal"]["telf_habitacion"]);
                $codigo_hab = substr($teleHab, 0, 4);
                $telf_habitacion = substr($teleHab, 4, 11);

                $telemovi = str_replace('-', '', $_POST["BeneficiarioTemporal"]["telf_celular"]);
                $codigo_movil = substr($telemovi, 0, 4);
                $telf_movil = substr($telemovi, 4, 11);


                $idPersona = ConsultaOracle::BuscarPersona(array(
                            'CEDULA' => $_POST["BeneficiarioTemporal"]["cedula"],
                            'NACIONALIDAD' => ($_POST["BeneficiarioTemporal"]['nacionalidad'] == 97) ? 1 : 0,
                            'PRIMER_NOMBRE' => trim(strtoupper($_POST["BeneficiarioTemporal"]['primer_nombre'])),
                            'SEGUNDO_NOMBRE' => trim(strtoupper($_POST["BeneficiarioTemporal"]['segundo_nombre'])),
                            'PRIMER_APELLIDO' => trim(strtoupper($_POST["BeneficiarioTemporal"]['primer_apellido'])),
                            'SEGUNDO_APELLIDO' => trim(strtoupper($_POST["BeneficiarioTemporal"]['segundo_apellido'])),
                            'FECHA_NACIMIENTO' => $_POST["BeneficiarioTemporal"]['fecha_nacimiento'],
                            'GEN_SEXO_ID' => $_POST["BeneficiarioTemporal"]['sexo'],
                            'GEN_EDO_CIVIL_ID' => $edoCivil,
                            'CODIGO_HAB' => (string) $codigo_hab,
                            'TELEFONO_HAB' => (string) $telf_habitacion,
                            'CODIGO_MOVIL' => (string) $codigo_movil,
                            'TELEFONO_MOVIL' => (string) $telf_movil,
                                //'CORREO_PRINCIPAL' => $_POST['BeneficiarioTemporal_correo_electronico'],
                                )
                );
            } else {

                $idPersona = $_POST["BeneficiarioTemporal"]["persona_id"];
                $teleHab = str_replace('-', '', $_POST["BeneficiarioTemporal"]["telf_habitacion"]);
                $codigo_hab = substr($teleHab, 0, 4);
                $telf_habitacion = substr($teleHab, 4, 11);

                $telemovi = str_replace('-', '', $_POST["BeneficiarioTemporal"]["telf_celular"]);
                $codigo_movil = substr($telemovi, 0, 4);
                $telf_movil = substr($telemovi, 4, 11);


                /*   ----------  UPDATE    -------------------  */
                $idPersona = ConsultaOracle::updatePersona(array(
                            //  'CEDULA'           => $_POST["BeneficiarioTemporal"]["cedula"],
                            // 'NACIONALIDAD'     => ($_POST["BeneficiarioTemporal"]['nacionalidad'] == 97) ? 1 : 0,
                            'PRIMER_NOMBRE' => trim(strtoupper($_POST["BeneficiarioTemporal"]['primer_nombre'])),
                            'SEGUNDO_NOMBRE' => trim(strtoupper($_POST["BeneficiarioTemporal"]['segundo_nombre'])),
                            'PRIMER_APELLIDO' => trim(strtoupper($_POST["BeneficiarioTemporal"]['primer_apellido'])),
                            'SEGUNDO_APELLIDO' => trim(strtoupper($_POST["BeneficiarioTemporal"]['segundo_apellido'])),
                            'FECHA_NACIMIENTO' => $_POST["BeneficiarioTemporal"]['fecha_nacimiento'],
                            'GEN_SEXO_ID' => $_POST["BeneficiarioTemporal"]['sexo'],
                            'GEN_EDO_CIVIL_ID' => $edoCivil,
                            'CODIGO_HAB' => (string) $codigo_hab,
                            'TELEFONO_HAB' => (string) $telf_habitacion,
                            'CODIGO_MOVIL' => (string) $codigo_movil,
                            'TELEFONO_MOVIL' => (string) $telf_movil,
                                //'CORREO_PRINCIPAL' => $_POST['BeneficiarioTemporal_correo_electronico'],
                                ), $idPersona
                );

                /*   -----------------------------------------  */
            }

            /*   -- - -  --  - - - -- - - - - --  */

            /*  - - - --  Vivienda  Update  - - -- - - - */
            $vivienda = ViviendaController::loadModel($_POST["BeneficiarioTemporal"]["vivienda_nro"]);
            $vivienda->asignada = 1;
            $vivienda->save();

            /*   - - - - - - - -- - - - - - - - - */


             $persona = new Persona;
                /// var_dump($persona); die();
                $persona->persona_id_faov = (int) $_POST["BeneficiarioTemporal"]["persona_id"];
                $persona->nacionalidad = (int) $_POST["BeneficiarioTemporal"]["nacionalidad"];
                $persona->cedula = (int) $_POST["BeneficiarioTemporal"]["cedula"];
                $persona->primer_nombre = $_POST["BeneficiarioTemporal"]["primer_nombre"];
                $persona->segundo_nombre = $_POST["BeneficiarioTemporal"]["segundo_nombre"];
                $persona->primer_apellido = $_POST["BeneficiarioTemporal"]["primer_apellido"];
                $persona->segundo_apellido = $_POST["BeneficiarioTemporal"]["segundo_apellido"];
                $persona->fecha_nacimiento = $_POST["BeneficiarioTemporal"]["fecha_nacimiento"];
                $persona->fk_sexo = $_POST["BeneficiarioTemporal"]["sexo"];
                $persona->fk_estado_civil = $_POST["BeneficiarioTemporal"]["estado_civil"];
                $persona->telf_habitacion = $_POST["BeneficiarioTemporal"]["telf_habitacion"];
                $persona->telf_celular = $_POST["BeneficiarioTemporal"]["telf_celular"];
                $persona->correo_electronico = $_POST["correo_electronico"];
                $persona->fecha_creacion = 'now()';
                $persona->fecha_actualizacion = 'now()';
                $persona->usuario_id_creacion = Yii::app()->user->id;
                $persona->usuario_id_actualizacion = Yii::app()->user->id;
            

            // var_dump($beneficiarioTemp); // die();


            if ($persona->save()) {
                
                $id_persona=$persona->id_persona;//id persona de SISPROV
                
                
               /*  - - - -- Beneficiario - - -- - - - */

            $beneficiarioTemp = new BeneficiarioTemporal;

            $nombre_completo = $_POST["BeneficiarioTemporal"]["primer_apellido"] . ' ';
            $nombre_completo .= $_POST["BeneficiarioTemporal"]["segundo_apellido"] . ' ';
            $nombre_completo .= $_POST["BeneficiarioTemporal"]["primer_nombre"] . ' ';
            $nombre_completo .= $_POST["BeneficiarioTemporal"]["segundo_nombre"];

            $beneficiarioTemp->persona_id = (int) $id_persona;
            
            $beneficiarioTemp->desarrollo_id = (int) $_POST["Desarrollo"]["id_desarrollo"];
            $beneficiarioTemp->unidad_habitacional_id = (int) $_POST["BeneficiarioTemporal"]["unidad_habitacional_id"];
            $beneficiarioTemp->vivienda_id = (int) $_POST["BeneficiarioTemporal"]["vivienda_nro"];

            $beneficiarioTemp->nacionalidad = (int) $_POST["BeneficiarioTemporal"]["nacionalidad"];
            $beneficiarioTemp->cedula = (int) $_POST["BeneficiarioTemporal"]["cedula"];
            $beneficiarioTemp->nombre_completo = strtoupper($nombre_completo);
            $beneficiarioTemp->fecha_creacion = date('Y-m-d H:i:s');
            $beneficiarioTemp->usuario_id_creacion = Yii::app()->user->id;
            $beneficiarioTemp->usuario_id_actualizacion = Yii::app()->user->id;
            $beneficiarioTemp->fecha_actualizacion = date('Y-m-d H:i:s');

            $beneficiarioTemp->estatus = 221;

                if ($beneficiarioTemp->save()) {
                    if (isset($_POST['CARGAR_OTRO'])) {
                         $desarrolloPrecarga = Desarrollo::model()->findByAttributes(array('id_desarrollo'=> $_POST["Desarrollo"]["id_desarrollo"]));  
                        $this->render('create', array(
                            'model' => $model,'vivienda' => $vivienda,
                            'desarrollo' => $desarrolloPrecarga, 'municipio' => $municipio,
                            'estado' => $estado, 'parroquia' => $parroquia,'carga_otro' => $_POST['CARGAR_OTRO'],
                                )
                        );
                        Yii::app()->end();
                    } else {
                        $id_beneficiarioTemp = $beneficiarioTemp->id_beneficiario_temporal;
                        Yii::app()->user->setFlash('success', "Beneficiario Temporal " . $nombre_completo . " Registrado !!");
                        $this->redirect(array('admin'));
                        Yii::app()->end();
                    }
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'desarrollo' => $desarrollo, 'municipio' => $municipio,
            'estado' => $estado, 'parroquia' => $parroquia,
                )
        );
    }
    
//     public function actionCreate() { /// yely
//        $model = new BeneficiarioTemporal;
//        $desarrollo = new Desarrollo;
//        $estado = new Tblestado;
//        $municipio = new Tblmunicipio;
//        $parroquia = new Tblparroquia;
//        $persona = new Persona;
//
//// Uncomment the following line if AJAX validation is needed
//// $this->performAjaxValidation($model);
////         var_dump($_POST);  die();
////        var_dump($_POST); die,
////        exit;
////      echo $_POST["BeneficiarioTemporal"];
//        if (isset($_POST['BeneficiarioTemporal'])) {
////
////            switch ($_POST["BeneficiarioTemporal"]['estado_civil']) {
////                case 164:
////                    $edoCivil = 2;
////                    break;
////                case 165:
////                    $edoCivil = 4;
////                    break;
////                case 163:
////                    $edoCivil = 1;
////                    break;
////                case 166:
////                    $edoCivil = 3;
////                    break;
////            }
////            //  var_dump($_POST["BeneficiarioTemporal"]["persona_id"]); die();
////            /*  - - - -- Persona - - -- - - - */
////            if ($_POST["BeneficiarioTemporal"]["persona_id"] == '') {
////
////                $teleHab = str_replace('-', '', $_POST["BeneficiarioTemporal"]["telf_habitacion"]);
////                $codigo_hab = substr($teleHab, 0, 4);
////                $telf_habitacion = substr($teleHab, 4, 11);
////
////                $telemovi = str_replace('-', '', $_POST["BeneficiarioTemporal"]["telf_celular"]);
////                $codigo_movil = substr($telemovi, 0, 4);
////                $telf_movil = substr($telemovi, 4, 11);
////
////
////                $idPersona = ConsultaOracle::BuscarPersona(array(
////                            'CEDULA' => $_POST["BeneficiarioTemporal"]["cedula"],
////                            'NACIONALIDAD' => ($_POST["BeneficiarioTemporal"]['nacionalidad'] == 97) ? 1 : 0,
////                            'PRIMER_NOMBRE' => trim(strtoupper($_POST["BeneficiarioTemporal"]['primer_nombre'])),
////                            'SEGUNDO_NOMBRE' => trim(strtoupper($_POST["BeneficiarioTemporal"]['segundo_nombre'])),
////                            'PRIMER_APELLIDO' => trim(strtoupper($_POST["BeneficiarioTemporal"]['primer_apellido'])),
////                            'SEGUNDO_APELLIDO' => trim(strtoupper($_POST["BeneficiarioTemporal"]['segundo_apellido'])),
////                            'FECHA_NACIMIENTO' => $_POST["BeneficiarioTemporal"]['fecha_nacimiento'],
////                            'GEN_SEXO_ID' => $_POST["BeneficiarioTemporal"]['sexo'],
////                            'GEN_EDO_CIVIL_ID' => $edoCivil,
////                            'CODIGO_HAB' => (string) $codigo_hab,
////                            'TELEFONO_HAB' => (string) $telf_habitacion,
////                            'CODIGO_MOVIL' => (string) $codigo_movil,
////                            'TELEFONO_MOVIL' => (string) $telf_movil,
////                                //'CORREO_PRINCIPAL' => $_POST['BeneficiarioTemporal_correo_electronico'],
////                                )
////                );
////            } else {
////
////                $idPersona = $_POST["BeneficiarioTemporal"]["persona_id"];
////                $teleHab = str_replace('-', '', $_POST["BeneficiarioTemporal"]["telf_habitacion"]);
////                $codigo_hab = substr($teleHab, 0, 4);
////                $telf_habitacion = substr($teleHab, 4, 11);
////
////                $telemovi = str_replace('-', '', $_POST["BeneficiarioTemporal"]["telf_celular"]);
////                $codigo_movil = substr($telemovi, 0, 4);
////                $telf_movil = substr($telemovi, 4, 11);
////
////
////                /*   ----------  UPDATE    -------------------  */
////                $idPersona = ConsultaOracle::updatePersona(array(
////                            //  'CEDULA'           => $_POST["BeneficiarioTemporal"]["cedula"],
////                            // 'NACIONALIDAD'     => ($_POST["BeneficiarioTemporal"]['nacionalidad'] == 97) ? 1 : 0,
////                            'PRIMER_NOMBRE' => trim(strtoupper($_POST["BeneficiarioTemporal"]['primer_nombre'])),
////                            'SEGUNDO_NOMBRE' => trim(strtoupper($_POST["BeneficiarioTemporal"]['segundo_nombre'])),
////                            'PRIMER_APELLIDO' => trim(strtoupper($_POST["BeneficiarioTemporal"]['primer_apellido'])),
////                            'SEGUNDO_APELLIDO' => trim(strtoupper($_POST["BeneficiarioTemporal"]['segundo_apellido'])),
////                            'FECHA_NACIMIENTO' => $_POST["BeneficiarioTemporal"]['fecha_nacimiento'],
////                            'GEN_SEXO_ID' => $_POST["BeneficiarioTemporal"]['sexo'],
////                            'GEN_EDO_CIVIL_ID' => $edoCivil,
////                            'CODIGO_HAB' => (string) $codigo_hab,
////                            'TELEFONO_HAB' => (string) $telf_habitacion,
////                            'CODIGO_MOVIL' => (string) $codigo_movil,
////                            'TELEFONO_MOVIL' => (string) $telf_movil,
////                                //'CORREO_PRINCIPAL' => $_POST['BeneficiarioTemporal_correo_electronico'],
////                                ), $idPersona
////                );
////
////                /*   -----------------------------------------  */
////            }
////
////            /*   -- - -  --  - - - -- - - - - --  */
////
////            /*  - - - --  Vivienda  Update  - - -- - - - */
//            $vivienda = ViviendaController::loadModel($_POST["BeneficiarioTemporal"]["vivienda_nro"]);
////            $vivienda->asignada = 1; //false true
////            $vivienda->save();
////
////            /*   - - - - - - - -- - - - - - - - - */
//
//
////             $persona = new Persona;
////                /// var_dump($persona); die();
////                $persona->persona_id_faov = (int) $_POST["BeneficiarioTemporal"]["persona_id"];
////                $persona->nacionalidad = (int) $_POST["BeneficiarioTemporal"]["nacionalidad"];
////                $persona->cedula = (int) $_POST["BeneficiarioTemporal"]["cedula"];
////                $persona->primer_nombre = $_POST["BeneficiarioTemporal"]["primer_nombre"];
////                $persona->segundo_nombre = $_POST["BeneficiarioTemporal"]["segundo_nombre"];
////                $persona->primer_apellido = $_POST["BeneficiarioTemporal"]["primer_apellido"];
////                $persona->segundo_apellido = $_POST["BeneficiarioTemporal"]["segundo_apellido"];
////                $persona->fecha_nacimiento = $_POST["BeneficiarioTemporal"]["fecha_nacimiento"];
////                $persona->fk_sexo = $_POST["BeneficiarioTemporal"]["sexo"];
////                $persona->fk_estado_civil = $_POST["BeneficiarioTemporal"]["estado_civil"];
////                $persona->telf_habitacion = $_POST["BeneficiarioTemporal"]["telf_habitacion"];
////                $persona->telf_celular = $_POST["BeneficiarioTemporal"]["telf_celular"];
////                $persona->correo_electronico = $_POST["correo_electronico"];
////                $persona->fecha_creacion = 'now()';
////                $persona->fecha_actualizacion = 'now()';
////                $persona->usuario_id_creacion = Yii::app()->user->id;
////                $persona->usuario_id_actualizacion = Yii::app()->user->id;
////            
////
////            // var_dump($beneficiarioTemp); // die();
////
////
////            if ($persona->save()) {
////                
////                $id_persona=$persona->id_persona;//id persona de SISPROV
//                
//                
//               /*  - - - -- Beneficiario - - -- - - - */
////
////            $beneficiarioTemp = new BeneficiarioTemporal;
////
////            $nombre_completo = $_POST["BeneficiarioTemporal"]["primer_apellido"] . ' ';
////            $nombre_completo .= $_POST["BeneficiarioTemporal"]["segundo_apellido"] . ' ';
////            $nombre_completo .= $_POST["BeneficiarioTemporal"]["primer_nombre"] . ' ';
////            $nombre_completo .= $_POST["BeneficiarioTemporal"]["segundo_nombre"];
////            $beneficiarioTemp->persona_id = (int) $id_persona;
////            $beneficiarioTemp->desarrollo_id = (int) $_POST["Desarrollo"]["id_desarrollo"];
////            $beneficiarioTemp->unidad_habitacional_id = (int) $_POST["BeneficiarioTemporal"]["unidad_habitacional_id"];
////            $beneficiarioTemp->vivienda_id = (int) $_POST["BeneficiarioTemporal"]["vivienda_nro"];
////            $beneficiarioTemp->nacionalidad = (int) $_POST["BeneficiarioTemporal"]["nacionalidad"];
////            $beneficiarioTemp->cedula = (int) $_POST["BeneficiarioTemporal"]["cedula"];
////            $beneficiarioTemp->nombre_completo = strtoupper($nombre_completo);
////            $beneficiarioTemp->fecha_creacion = date('Y-m-d H:i:s');
////            $beneficiarioTemp->usuario_id_creacion = Yii::app()->user->id;
////            $beneficiarioTemp->usuario_id_actualizacion = Yii::app()->user->id;
////            $beneficiarioTemp->fecha_actualizacion = date('Y-m-d H:i:s');
////            $beneficiarioTemp->estatus = 221;
////
////                if ($beneficiarioTemp->save()) {
//                    if (isset($_POST['CARGAR_OTRO'])) {
//                         $desarrolloPrecarga = Desarrollo::model()->findByAttributes(array('id_desarrollo'=> $_POST["Desarrollo"]["id_desarrollo"]));  
//                        $this->render('create', array(
//                            'model' => $model,'vivienda' => $vivienda,
//                            'desarrollo' => $desarrolloPrecarga, 'municipio' => $municipio,
//                            'estado' => $estado, 'parroquia' => $parroquia,'carga_otro' => $_POST['CARGAR_OTRO'],
//                                )
//                        );
//                        Yii::app()->end();
//                    } else {
//                        $id_beneficiarioTemp = $beneficiarioTemp->id_beneficiario_temporal;
//                        Yii::app()->user->setFlash('success', "Beneficiario Temporal " . $nombre_completo . " Registrado !!");
//                        $this->redirect(array('admin'));
//                        Yii::app()->end();
//                    }
//                }
////            }
////        }
//
//        $this->render('create', array(
//            'model' => $model,
//            'desarrollo' => $desarrollo, 'municipio' => $municipio,
//            'estado' => $estado, 'parroquia' => $parroquia,
//                )
//        );
//    }
    
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $desarrollo = new Desarrollo;
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;

        // var_dump($model); die();
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['BeneficiarioTemporal'])) {

            $idPersona = $_POST["BeneficiarioTemporal"]["persona_id"];

//            $codigo_hab = substr($_POST["BeneficiarioTemporal_telf_habitacion"], 0, 4);
//            $telf_habitacion = substr($_POST["BeneficiarioTemporal_telf_habitacion"], 4, 11);
//
//            $codigo_movil = substr($_POST["BeneficiarioTemporal_telf_celular"], 0, 4);
//            $telf_movil = substr($_POST["BeneficiarioTemporal_telf_celular"], 4, 11);


            /*   ----------  UPDATE    -------------------  */
//            $idPersona = ConsultaOracle::updatePersona(array(
//                        //  'CEDULA'           => $_POST["BeneficiarioTemporal"]["cedula"],
//                        // 'NACIONALIDAD'     => ($_POST["BeneficiarioTemporal"]['nacionalidad'] == 97) ? 1 : 0,
//                        'PRIMER_NOMBRE' => trim(strtoupper($_POST["BeneficiarioTemporal"]['nombre_completo'])),
////                        'SEGUNDO_NOMBRE' => trim(strtoupper($_POST["BeneficiarioTemporal"]['segundo_nombre'])),
////                        'PRIMER_APELLIDO' => trim(strtoupper($_POST["BeneficiarioTemporal"]['primer_apellido'])),
////                        'SEGUNDO_APELLIDO' => trim(strtoupper($_POST["BeneficiarioTemporal"]['segundo_apellido'])),
////                        'FECHA_NACIMIENTO' => $_POST["BeneficiarioTemporal"]['fecha_nacimiento'],
////                        'GEN_SEXO_ID' => $_POST["BeneficiarioTemporal"]['sexo'],
////                        //  'GEN_EDO_CIVIL_ID' => $_POST["BeneficiarioTemporal"]['estado_civil'],
////                        'CODIGO_HAB' => (string) $codigo_hab,
////                        'TELEFONO_HAB' => (string) $telf_habitacion,
////                        'CODIGO_MOVIL' => (string) $codigo_movil,
////                        'TELEFONO_MOVIL' => (string) $telf_movil,
////                        'CORREO_PRINCIPAL' => $_POST["BeneficiarioTemporal"]['correo_electronico'],
//                            ), $idPersona
//            );

            /*   -----------------------------------------  */

            $model->attributes = $_POST['BeneficiarioTemporal'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_beneficiario_temporal));
        }

        $this->render('update', array(
            'model' => $model,
//            'desarrollo' => $desarrollo, 'municipio' => $municipio,
//            'estado' => $estado, 'parroquia' => $parroquia,
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
        $dataProvider = new CActiveDataProvider('BeneficiarioTemporal');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new BeneficiarioTemporal('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BeneficiarioTemporal']))
            $model->attributes = $_GET['BeneficiarioTemporal'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionModificarNombre() {
        $model = new BeneficiarioTemporal('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BeneficiarioTemporal']))
            $model->attributes = $_GET['BeneficiarioTemporal'];

        $this->render('modificarNombre', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = BeneficiarioTemporal::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'beneficiario-temporal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPdf($id) {
        $desarrollo = new Desarrollo;
        $this->render('pdf', array(
            'model' => $this->loadModel($id),
            'desarrollo' => $desarrollo,
        ));
    }

}
