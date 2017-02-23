<?php

class AnalisisCreditoController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
//    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
//    public function filters() {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//        );
//    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//    public function accessRules() {
//        return array(
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index', 'view', 'cotizacionesFaov', 'tablaAmortizacionPdf', 'AdminAnalisisCredito'),
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

    /*
     *  FUNCION QUE MUESTRA LA ULTIMAS 12 COTIZACIONES EN FAOV PASANDO COMO PARAMETRO 
     * EL ID DE LA PERSONA 
     * @autores YURASMY RODRIGUEZ/BRUNO PALACIOS   
     */

    public function actionCotizacionesFaov($id) {
        $id = $_POST['id'];
        $valor = ConsultaOracle::ultimoPagoFaov($id);
        if (!$valor) {
            echo $TableCotizaciones = 'no posee cotizaciones';
        } else {
            $TableCotizaciones = '<table class="table table-bordered table-striped" >';
            $TableCotizaciones.= '<tr><th>PERIODO</th><th>FECHA DE PAGO</th><th>SALARIO AL 1%</th><th>MONTO</th></tr>';
            /*
             * foreach para recorrer la segunda columna de la funcion de fecha de pago (01010001)
             * para darle el formato de fecha
             */
            foreach ($valor AS &$n):
                $x = explode(',', $n);
                $dia = substr($x[1], 0, 2);  // devuelve "01"
                $mes = substr($x[1], 2, 2);  // devuelve "01"
                $year = substr($x[1], 4, 4);  // devuelve "0001"
                $x[1] = $dia . '/' . $mes . '/' . $year;
                $TableCotizaciones.= '<tr><td>' . $x[0] . '</td><td>' . $x[1] . '</td><td>' . $x[2] . '</td><td>' . $x[3] . '</td></tr>';

            endforeach;
            $TableCotizaciones.= '</table>';
            echo $TableCotizaciones;
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id) {
        
       
        
   //     var_dump($id);die;
        //$id=>id_unidad_familiar 
        $beneficiario = Beneficiario::model()->findByPk($id);
        $benetemp = TempCensoValidadoFaovFasp::model()->findByAttributes(array('id_beneficiario' => $beneficiario->id_beneficiario));

        $model = new AnalisisCredito;
        $model->unidad_familiar_id = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $beneficiario->id_beneficiario))->id_unidad_familiar;
        $desarrollo = $beneficiario->beneficiarioTemporal->desarrollo;
        $desarrollo->fuente_financiamiento_id = $benetemp->id_fuente_financiamiento;
        $vivienda = $beneficiario->beneficiarioTemporal->vivienda;


        //fuente_financiamiento(3 FASP, 2 FAOV)
        if ($desarrollo->fuente_financiamiento_id == 3) {
            $faov = 'AND tipo_persona_faov = 235 '; //tipo_persona_faov=235-> COSOLICITANTE
        } else {
            $faov = ' ';
        }


//        $grupoFamiliar = "SELECT  gr.persona_id, gr.ingreso_mensual, gr.ingreso_mensual_faov  FROM grupo_familiar gr
//                        JOIN unidad_familiar fa ON  gr.unidad_familiar_id= fa.id_unidad_familiar AND fa.beneficiario_id = " . $id . "AND fa.estatus = 77
//                        WHERE gr.estatus = 41 " . $faov;
//        $result = Yii::app()->db->createCommand($grupoFamiliar)->queryAll();

        $totalSueldoDeclarado = array();
        $totalSueldoFaov = array();
        //TABLA DE SUELDO MENSUAL DEL BENEFICIARIO Y GRUPO_FAMILIAR

        //$TableSueldo = '<table class="table table-bordered">';
        $TableSueldo='<th>Beneficiario/Grupo Familiar</th><th>Sueldo Declarado</th><th>Ingreso Mensual Nuevo</th>';

       // $TableSueldo = '<table class="table table-bordered">';
        //$TableSueldo.='<th>Beneficiario/Grupo Familiar</th><th>Sueldo Declarado</th>';

        // TABLA DE SUELDO FAOV DEL BENEFICIARIO Y GRUPO_FAMILIAR
        
        $TableSueldoFaov = '<table class="table table-bordered">';
        if ($desarrollo->fuente_financiamiento_id == 2) {
        $TableSueldoFaov.='<th>Sueldo Según Faov</th>';
        }
        $sueldoBeneficiario = number_format($beneficiario->ingreso_declarado, 2, '.', '');
        
        //INGRESO FAOV DEL BENEFICIARIO
        $ingresoFaovBene = ConsultaOracle::getFaov($beneficiario->persona_id, 1);
        $ingresoFaovBene = number_format($ingresoFaovBene, 2, '.', '');
        //INGRESO MENSUAL DEL BENEFICIARIO DECLARADO EN EL CENSO


       $td_benef='<td>Beneficiario</td><td>Bs. ' . $sueldoBeneficiario . '<input type="radio" name="opciones_0" id="opciones" onclick="RecalculoDeInteres()"  value="' . $sueldoBeneficiario . '"></td>'
            //. '<td><input type="radio" name="opciones_0" id="opciones" onclick="RecalculoDeInteres()">&nbsp;&nbsp;<a style="cursor:pointer"><i class="glyphicon glyphicon-edit">Editar<br>Ingreso Mensual</i></a></td>'
           ;
        
       
        
       

//ULTIMAS 12 COTIZACIONES FAOV DEL BENEFICIARIO 
if ($desarrollo->fuente_financiamiento_id == 2) {
        $TableSueldoFaov.='<tr><td>Bs. ' . $ingresoFaovBene . '<input  onclick="RecalculoDeInteres()" type="radio" name="opciones_0" id="opciones_0" value="' . $ingresoFaovBene . '"></td>'
                . '<td>' . CHtml::ajaxLink('<span class="glyphicon glyphicon-eye-open"></span> Ultimas 12 Cotizaciones', Yii::app()->createUrl('AnalisisCredito/CotizacionesFaov', array('id' => $beneficiario->persona_id)), array(
                    'type' => 'POST',
                    'data' => 'id=' . $beneficiario->persona_id,
                    'success' => 'function(data) { $(".modal-body").html(data); $("#myModal").modal(); }'
                        ), array('class' => 'icon-print', 'data-toggle' => "modal", 'data-target' => "#myModal")) . '</td></tr>';

}
        /*
         * CONSULTA POR EL BENEFICIARIO SU GRUPO FAMILIAR 
         */
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.unidad_familiar_id = :unidad_familiar_id ' . $faov . ' AND estatus=41');
        $criteria->params = array(':unidad_familiar_id' => $model->unidad_familiar_id);
        $grupoFamiliar = GrupoFamiliar::model()->findAll($criteria);

        /*
         * EL FOREACH RECORRE EL GRUPO FAMILIAR DEL BENEFICIARIO 
         * DETERMINANDO SU INGRESO MENSUAL
         * INGRESO FAOV DESDE LA FUNCION faoveel.F_BUSCA_DATOS_AHORRISTA(id) recibiendo como parametro el persona_id 
         * ULTIMAS 12 COTIZACIONES EN FAOV DESDE LA ACCION COTIZACIONES DE FAOV 
         */
       
       
       
        
        
        $i = 1;
        $conut_id = 1;
        foreach ($grupoFamiliar AS $fila) {
            
            //var_dump($grupoFamiliar);die;
            
            $consultafaov = ConsultaOracle::getFaov($fila->persona_id, 1);
            
            $cant_fam=count($grupoFamiliar);
            $nombregrfamiliar = Generico::nombreApellido('PRIMER_NOMBRE, PRIMER_APELLIDO', (int) $fila['persona_id']); //consulta oracle para traerme el nombre y apellido de la persona por persona_id
            
//            $TableSueldo.='<tr><td>' . $nombregrfamiliar . '</td><td> Bs.' . $fila['ingreso_mensual'] . '<input class="a" onclick="RecalculoDeInteres()" type="radio" name="opciones_' . $i . '" id="opciones_' . $conut_id . '"  checked value="' . $fila['ingreso_mensual'] . '"></td>'
//                    . '<td></td></tr>';
           
            
           
            
            $conut_id++;

            $TableSueldoFaov.='<tr><td> Bs.' . $consultafaov . '<input class="a" onclick="RecalculoDeInteres()" type="radio" name="opciones_' . $i . '" id="opciones_' . $conut_id . '" value="' . $consultafaov . '"></td>'
                    . '<td>' . CHtml::ajaxLink('<span class="glyphicon glyphicon-eye-open"></span> Ultimas 12 Cotizaciones', Yii::app()->createUrl('AnalisisCredito/CotizacionesFaov', array('id' => $fila['persona_id'])), array(
                        'type' => 'POST',
                        'data' => 'id=' . $fila['persona_id'],
                        'success' => 'function(data) { $(".modal-body").html(data); $("#myModal").modal(); }'
                            ), array('class' => 'icon-print', 'data-toggle' => "modal", 'data-target' => "#myModal")) . '</td></tr>';

            $i++;
            $conut_id++;
        }

        $TableSueldoFaov.='</table>';
       // $TableSueldo.='</table>';


        if (isset($_POST['AnalisisCredito'])) {


            if ($_POST['Desarrollo']['fuente_financiamiento_id'] = 3) {
                if (empty($_POST['AnalisisCredito']['sub_vivienda_perdida']) && !isset($_POST['cuota_extraordinarias'])) {
                    $tipo_documen = 266; //PERSONA NATURAL
                } else if (isset($_POST['cuota_extraordinarias'])) {
                    $tipo_documen = 275; //SUBSIDIO DIRECTO Y CUOTAS EXTRAORDINARIAS
                } else if (!empty($_POST['AnalisisCredito']['sub_vivienda_perdida'])) {
                    $tipo_documen = 243; //REBAJA SOLIDARIA
                } else if ($_POST['AnalisisCredito']['sub_directo_habitacional'] != '0,00' && !empty($_POST['AnalisisCredito']['sub_vivienda_perdida'])) {
                    $tipo_documen = 265; //SUBSIDIO DIRECTO Y REBAJA SOLIDARIA
                }
            } else {
                if (!empty($_POST['AnalisisCredito']['monto_inicial'])) {
                    $tipo_documen = 287; // CON INICIAL
                } else {
                    $tipo_documen = 283; //SIN INICIAL
                }
            }

            $totalIngreso = number_format($_POST['AnalisisCredito']['total'], 2, '.', ''); //total de ingreso familiar
            $model->vivienda_id = $_POST['AnalisisCredito']['vivienda_id']; //vivienda_id que el adjudicado tiene asignada
            $vivienda->precio_vivienda = $_POST['AnalisisCredito']['costo_vivienda']; //precio de la vivienda actualizar si viene 0.00
            $model->unidad_familiar_id = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $beneficiario->id_beneficiario))->id_unidad_familiar; // id_unidad_familiar para traer el beneficiario
            $model->tipo_documento_id = $tipo_documen; // TIPO DE DOCUMENTO
            $model->ingreso_total_familiar = $totalIngreso; // TOTAL INGRESO FAMILIAR
            $model->monto_credito = str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['monto_credito'])); // MONTO CREDITO REQUERIDO
            $model->monto_inicial = !empty($_POST['AnalisisCredito']['monto_inicial']) ? $_POST['AnalisisCredito']['monto_inicial'] : '0.00'; //MONTO INICIAL
            $model->sub_directo_habitacional = !empty($_POST['AnalisisCredito']['sub_directo_habitacional']) ? str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['sub_directo_habitacional'])) : '0.00'; //SUBSIDIO DIRECTO HABITACIONAL APLICA CUANDO ESTA POR DEBAJO DE DOS SUELDO MINIMO 
            $model->sub_vivienda_perdida = !empty($_POST['AnalisisCredito']['sub_vivienda_perdida']) ? str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['sub_vivienda_perdida'])) : '0.00'; //SUBSIDIO POR VIVIENDA PERDIDA 50% 
            $model->plazo_credito_ano = $_POST['AnalisisCredito']['plazo_credito_ano']; //numero de años para pagar el credito
            $model->nro_cuotas = $_POST['AnalisisCredito']['nro_cuotas ']; // numero de cuotas mensuales (2*)
            $model->monto_cuota_financiera = str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['monto_cuota_financiera'])); //maxima cuota financiera
            $model->monto_cuota_f_total = str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['monto_cuota_f_total'])); // cuota total a pagar mensual
            $model->monto_prima_inicial_fg = str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['monto_prima_inicial_fg'])); //cuota inicial fongar
            $model->alicuota_fondo_garantia = str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['alicuota_fondo_garantia'])); // fondo de garantia mensual
            $model->maxima_capacidad_pago = str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['maxima_capacidad_pago'])); // Maxima capacidad de pago
            $model->tasa_interes_id = $_POST['AnalisisCredito']['tasa_interes_id']; // tasa interes aplicable 
            $model->tasa_fongar_id = 0.0143; //tasa fongar 1.43%
            $model->fuente_financiamiento_id = $_POST['Desarrollo']['fuente_financiamiento_id']; // fuente de finaciamiento del desarrollo (FASP / FAOV)
            $model->programa_id = $_POST['Desarrollo']['programa_id']; //Progama dependiente de la fuente de financiamiento
            $model->fuente_datos_entrada_id = 90; // Estatus datos de entrada (90->SISTEMA)
            $model->estatus = 5; // Estatus analisis_credito (5->ACTIVO)
            $model->fecha_creacion = 'now';
            $model->fecha_actualizacion = 'now';
            $model->usuario_id_creacion = Yii::app()->user->id; //USUARIO DE CREACCIÓN 
            $model->diferencia_pago = str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['diferencia_pago'])); //Diferencia de pago resta el precio de la vivienda - capacidad de pago
            $model->tasa_mora_id = ($_POST['Desarrollo']['fuente_financiamiento_id'] == 2 ) ? 3 : 2; // tasa_mora guarda 2% para fasp, 3% para faov 
            $model->fecha_protocolizacion = $_POST['AnalisisCredito']['fecha_protocolizacion']; // fecha en la que se hace el analisis 
            $model->fecha_analisis = $_POST['AnalisisCredito']['fecha_protocolizacion']; // fecha en la que se hace el analisis 
            $model->monto_cuota_finan_requerida = str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['monto_cuota_finan_requerida'])); //monto cuota financiera requerida
            
            //comision flat 
            //$model->comision_flat = str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['comisionFlat'])); 
            
            $flat = isset($_POST['flat']) ? true : false;
            
            if ($flat==true){
                
                $model->comision_flat = str_replace(',', '.', str_replace('.', '', $_POST['AnalisisCredito']['comisionFlat'])); 
                
            }else if ($flat==false){
                
                
                
                $model->comision_flat = NULL;
            }
            
            
            $cuota_extraordinarias = isset($_POST['cuota_extraordinarias']) ? true : false; //  si aplica cuotas extraordinarias guarda true 
            //   echo '<pre>'; var_dump($_POST['AnalisisCredito']['diferencia_pago']);die;
            //
            //$model->cuota_extraordinarias = isset($_POST['cuota_extraordinarias']) ? true : false;
//            $model->max_cuota_finan_porct = $_POST['AnalisisCredito']['max_cuota_finan_porct'];
//            $model->subsidio_id_fasp = $_POST['AnalisisCredito']['subsidio_id_fasp'];
//            var_dump($model, $cuota_extraordinarias);
            if ($model->save()) {
                /*
                 * ACTUALIZACION DE ESTATUS DE LA TABLA BENEFICIARIO Y BENEFICIARIO_TEMPORAL UNA VEZ GUARDADO EL ANALISIS DE CREDITO
                 */


                $buscarCaso = Asignaciones::model()->findByAttributes(array('fk_caso_asignado' => $beneficiario->id_beneficiario, 'fk_estatus' => 304, 'es_activo' => TRUE));

                //var_dump($buscarCaso);die;
                if (!empty($buscarCaso)) {
                    $buscarCaso->es_activo = FALSE;
                    $buscarCaso->fecha_actualizacion = 'now()';
                    $buscarCaso->usuario_id_actualizacion = Yii::app()->user->id;
                    if ($buscarCaso->save()) {

                        $modelAsignaciones = new Asignaciones;
                        $modelAsignaciones->fk_estatus = 305; //ANALIZADO
                        $modelAsignaciones->fk_entidad = $buscarCaso->fk_entidad;
                        $modelAsignaciones->fk_usuario_asignado = $buscarCaso->fk_usuario_asignado;
                        $modelAsignaciones->fk_usuario_q_asigna = $buscarCaso->fk_usuario_q_asigna;
                        $modelAsignaciones->fk_caso_asignado = $buscarCaso->fk_caso_asignado;
                        $modelAsignaciones->fecha_creacion = 'now()';
                        $modelAsignaciones->usuario_id_creacion = Yii::app()->user->id;
                        $modelAsignaciones->es_activo = TRUE;
                        $modelAsignaciones->save();

//                $updateBene = Beneficiario::model()->updateByPk($beneficiario->id_beneficiario, array(
//                    'estatus_beneficiario_id' => 269, // ANALISIS DE CREDITO 
//                    'usuario_id_actualizacion' => Yii::app()->user->id,
//                    'fecha_actualizacion' => 'now()'
//                ));
//                $updateBeneTemp = BeneficiarioTemporal::model()->updateByPk($beneficiario->beneficiario_temporal_id, array(
//                    'estatus' => 270, // ANALISIS DE CREDITO
//                    'usuario_id_actualizacion' => Yii::app()->user->id,
//                    'fecha_actualizacion' => 'now()'
//                ));

                        /*
                         *  BUSQUEDA DEL BENEFICIARIO POR id_beneficiario ADEMAS DE ELIMINAR 
                         * DE LA TABLA TEMPORAL TempCensoValidadoFaovFasp ESE BENEFICIARIO
                         */
//                $idtemcenso = TempCensoValidadoFaovFasp::ObtenerIdTempCenso($id);
//                $busquedatabletemp = TempCensoValidadoFaovFasp::model()->findByPk($idtemcenso)->delete();
                        /*                         * ******************************************************************************************************************* */
                        /*
                         * SI EXISTEN CUOTAS EXTRAORDINARIAS HAGO UN SEGUNDO INSERT EN LA TABLA ANALISIS DE CREDITO
                         */
                        if ($cuota_extraordinarias) {

                            $extra = new AnalisisCredito;
                            $extra->vivienda_id = $model->vivienda_id; // ID DE LA VIVIENDA QUE ESTA ASOCIADO AL BENEFICIARIO
                            $extra->unidad_familiar_id = $model->unidad_familiar_id; //ID UNIDAD FAMILIAR QUE ESTA ASOCIADO AL BENEFICIARIO
                            $extra->tipo_documento_id = $model->tipo_documento_id; //TIPO DE DOCUMENTO
                            $extra->ingreso_total_familiar = $model->ingreso_total_familiar; //TOTAL DE INGRESO FAMILIAR 
                            $extra->monto_inicial = $model->monto_inicial; //INICIAL DEL BENEFICIARIO 
                            $extra->sub_directo_habitacional = $model->sub_directo_habitacional;
                            $extra->sub_vivienda_perdida = $model->sub_vivienda_perdida; // SUBSIDIO POR VIVIENDA PERDIDA 50%
                            $extra->plazo_credito_ano = $model->plazo_credito_ano; //PLAZO EN AÑOS
                            $extra->nro_cuotas = ($model->plazo_credito_ano * 2); // PLAZO EN MESES PARA DOS CUOTAS EXTRAORDINARIAS
                            $extra->monto_cuota_financiera = str_replace(',', '.', str_replace('.', '', $_POST['monto_couta_finan_extra'])); //MAXIMA COUTA FINACIERA
                            $extra->monto_cuota_f_total = str_replace(',', '.', str_replace('.', '', $_POST['monto_cuota_f_total'])); //CUOTA TOTAL SEMESTRAL 
                            $extra->monto_prima_inicial_fg = ($model->diferencia_pago) * 0.0143; //cuota inicial fongar
                            $extra->maxima_capacidad_pago = str_replace(',', '.', str_replace('.', '', $_POST['maxima_capacidad_pago'])); // Maxima capacidad de pago
                            $extra->alicuota_fondo_garantia = str_replace(',', '.', str_replace('.', '', $_POST['alicuota_fondo_garantia'])); // FONDO DE GARANTIA SEMESTRAL
                            $extra->monto_credito = ($vivienda->precio_vivienda - $model->monto_credito - $model->sub_directo_habitacional);
                            $extra->programa_id = $model->programa_id;
                            $extra->fuente_financiamiento_id = $model->fuente_financiamiento_id;
                            $extra->estatus = 5;
                            $extra->usuario_id_creacion = Yii::app()->user->id;
                            $extra->fecha_creacion = 'now()';
                            $extra->fecha_actualizacion = 'now()';
                            $extra->fuente_datos_entrada_id = 90;
                            $extra->tasa_fongar_id = $model->tasa_fongar_id;
                            $extra->tasa_interes_id = $model->tasa_interes_id;
                            $extra->fecha_protocolizacion = $model->fecha_protocolizacion;
                            $extra->fecha_analisis=$model->fecha_analisis;
                            $extra->cuota_extraordinarias = true;
                            $extra->tasa_mora_id = $model->tasa_mora_id;
                            $extra->diferencia_pago = $model->diferencia_pago;
//                    echo '<pre>'; var_dump($extra); die();
                            if ($extra->save()) {
                                if ($extra->fuente_financiamiento_id == 3) {
                                    $this->redirect(array('TempCensoValidadoFaovFasp/adminfasp'));
                                } else {
                                    $this->redirect(array('TempCensoValidadoFaovFasp/admin'));
                                }
                            } else {
                                var_dump($extra->errors);
                                die();
                            }
                            /*                             * ******************************************************************************************************************** */
                        } else {
                            if ($model->fuente_financiamiento_id == 3) {
                                $this->redirect(array('TempCensoValidadoFaovFasp/adminfasp'));
                            } else {
                                $this->redirect(array('TempCensoValidadoFaovFasp/admin'));
                            }
                        }
//                 var_dump($busquedatabletemp); die();
                    }
                    // echo 'VACIOOOO';var_dump($buscarCaso);die;
                }
            } else {
                echo '<pre>';
                var_dump($model->errors);
                die();
            }
        }

        $this->render('create', array('model' => $model, 'beneficiario' => $beneficiario, 'desarrollo' => $desarrollo, 'TableSueldo' => $TableSueldo, 'TableSueldoFaov' => $TableSueldoFaov,
            'benetemp' => $benetemp,'td_benef'=>$td_benef,'grupoFamiliar'=>$grupoFamiliar));
        
       
    }

    /*
     * PDF DE TABLA DE AMORTIZACION
     */

            
    public function actionTablaAmortizacionPdf($id) {
        $id_unidad_familiar = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id))->id_unidad_familiar; // ID DE LA UNIDAD_FAMILIAR PARA TRAER EL BENEFICIARIO
        $analicredito = AnalisisCredito::model()->findByAttributes(array('unidad_familiar_id' => $id_unidad_familiar)); // BUSQUEDA DEL ID_UNIDAD_FAMILIAR EN ANALISIS DE CREDITO 
        $beneficiario = Beneficiario::model()->findByPk($id); //ID DEL BENEFICIARIO
//        $n = new AnalisisCredito();
        $criteria = new CDbCriteria;
        $criteria->condition = 'unidad_familiar_id= :unidad_familiar';
        $criteria->params = array(":unidad_familiar" => (int) $id_unidad_familiar);
        $credito = AnalisisCredito::model()->findAll($criteria);


        $htmlprincipal = "<table align='right' width='100%' border='0'> ";
        foreach ($credito AS $analisis) {
//      var_dump($analisis->tasaInteres->tasa_interes);die();

            /* monto de la cuota finaciera es la funcion que se calcula de acuerdo al interes,  los años , y el monto de credito a pagar ; funcion PMT EN EXCEL
             * $tasainteres=> 4.66/100/12
             * $años=> cantidad de años
             * $monto credito=> monto a pagar solicitado
             */
            $meses = $analisis->nro_cuotas; //meses para pagar
            $años = $analisis->plazo_credito_ano; // cantidad en años para los meses 
            $cuotamensual = $analisis->monto_cuota_f_total; //cuota total mensual a pagar
            $montocredito = $analisis->monto_credito; //monto total a pagar del credito
            $tasainteres = $analisis->tasaInteres->tasa_interes; // tasa de interes 
            $montoCoutaFinanciera = CalculosController::actionMontoCoutaFinanciera($tasainteres, $años, $montocredito);
            $montoCoutaFinanciera = number_format($montoCoutaFinanciera, 2, '.', '');
            $totalInteres = 0;
            $totalCuotaFongar = 0;
            $totalMontoCuotaFinan = 0;
            $htmlprincipal = "<table align='right' width='100%' border='0'>       
                                <tr>
                                    <td colspan='4' align='center'><b><font size='4'>DATOS DEL CRÉDITO</br></br></font></td>
                                </tr>		
                              </table>
        
                    <table width='100%' >
                        <tr  style='background:#E5E2E2'>
                            <td colspan='1'><b>Monto Solicitado: </b></td><td colspan='1'>" . number_format($analisis->unidadFamiliar->beneficiario->beneficiarioTemporal->vivienda->precio_vivienda, 2, ',', '.') . "</td> 
                        </tr>";
                        if ($analisis->sub_directo_habitacional!='0.00'){
                       $htmlprincipal .= "
                         <tr>
                            <td colspan='1'><b>Subsidio Directo Habitacional:</b></td><td colspan='1'>" . $analisis->sub_directo_habitacional . "</td>
                        </tr>";
                        }
                         if ($analisis->sub_vivienda_perdida!='0.00'){
                         $htmlprincipal .= "
                         <tr   style='background:#E5E2E2'>
                            <td colspan='1'><b>Reconocimiento Vivienda Perdida:</b></td><td colspan='1'>" . number_format($analisis->sub_vivienda_perdida, 2, ',', '.') . "</td>
                        </tr>";
                          }
                           if (($analisis->sub_directo_habitacional!='0.00')&&($analisis->sub_vivienda_perdida!='0.00')){
                         $htmlprincipal .= "
                        <tr>
                            <td colspan=''><b>Subsidio Total (Bs.):</b></td><td colspan='1'>" . number_format($analisis->sub_directo_habitacional + $analisis->sub_vivienda_perdida, 2, ',', '.') . "</td>
                        </tr>"; 
                           }
                           
                          if ($analisis->monto_inicial!='0.00'){
                          $htmlprincipal .= "
                        <tr   style='background:#E5E2E2'>
                                <td colspan='1'><b>Cuota Inicial Pagada (Bs.):</b></td><td colspan='1'>" . number_format($analisis->monto_inicial, 2, ',', '.') . "</td>
                        </tr>";
                          }
                        $htmlprincipal .= "  
                        <tr>
                            <td colspan='1'><b>Monto Credito A Otorgar: </b></td><td colspan='1'>" . number_format($analisis->monto_credito, 2, ',', '.') . "</td>             
                        </tr>
                        
                        <tr   style='background:#E5E2E2'>
                            <td colspan='1'><b> Tasa Interes:</b></td><td colspan='1'>" . $analicredito->tasaInteres->tasa_interes . " %</td>
                        </tr>
                        
                        <tr>
                            <td colspan='1'><b>Plazo del Credito:</b></td><td colspan='1'>" . number_format($analisis->nro_cuotas/12  )." - AÑOS</td>
                        </tr>
                        <tr    style='background:#E5E2E2'>
                            <td colspan='1'><b>Pago Total Mensual:</b></td><td colspan='1'>" . number_format($analisis->monto_cuota_f_total, 2, ',', '.') . "</td>
                        </tr>
                        
                    </table>  <br/>";

            $htmlprincipal.=" <table align='right' width='100%'  border='0'> 
                            <tr >
                                <td colspan='4' align='center'><b><font size='4'>DATOS PARA LA CANCELACIÓN</br></br></font><font size='6'> </font></td>
                            </tr>
                             </table>
                             <table width='100%'>
                            <tr style='background:#E5E2E2'>
                                <td colspan='2'><b>Institución Bancaria:</b></td><td  colspan='2'> BANCO DE VENEZUELA </td>
                            </tr>
                            <tr >
                                <td colspan='2'><b>Cuenta Corriente:</b></td><td  colspan='2'> 0102-0552-23-0000027685 </td>
                            </tr>
                            <tr style='background:#E5E2E2'>
                                <td colspan='2'><b>A nombre de:</b></td><td  colspan='2'> <b>BANAVIH COBRANZAS</b></td>
                            </tr>
                            <tr >
                                <td colspan='2'><b>Serial de Cliente:</b></td><td  colspan='2'>" . date('Y') . " " . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->cedula . " </td>
                            </tr> 
                            <tr style='background:#E5E2E2'>
                                <td colspan='2'><b>Fecha Primer Pago:</b></td><td  colspan='2'>" . date("d/m/Y", strtotime($analisis->fecha_protocolizacion)) . "</td>
                            </tr>
                            </table>
                            <br/>";

//            $htmlprincipal.="<table align='right' width='100%'  border='0'>       
//                        <tr>
//                            <td colspan='4' align='center'><b><font size='4'>PRIMA INICIAL FONDO DE GARANTIA</br></br></font><font size='6'> </font></td>
//                        </tr>		
//                        <tr  style='background:#E5E2E2'>
//                            <td colspan='2'><b>Prima Inicial Fondo de Garantia (Bs.):</b></td><td  colspan='2'>" . number_format($analisis->monto_prima_inicial_fg, 2, ',', '.') . "</td>
//                        <tr>
//                            <td colspan='2'><b>Porcentaje de la Prima Inicial (Bs.):</b></td><td  colspan='2'> 1,43% </td>
//                        </tr>		
//                        </tr>
//                        </table>";




//            $tablaAmortiz = '<table border=1 cellspacing=1 cellpadding=0 bordercolor="E5E2E2">';
//            $tablaAmortiz.= ' <tr><th colspan="4" style="background:#E5E2E2; tex-algn:center;"><b>CUOTA FINANCIERA</th><th colspan="1" style="background:#E5E2E2">PRIMA <br/>RENOVAC. <br/>FONGAR</th>
//                            <th colspan="2" style="background:#E5E2E2">CUOTA <br/>TOTAL<br/>MENSUAL</th>
//                        </tr>';
//            $tablaAmortiz.= '<tr  style="background:#E5E2E2"> <th colspan="1">N-MESES</th><th colspan="1">SALDO<br/>DEUDOR (Bs.)</th><th colspan="1">AMORTIZACION <br>DE CAPITAL</th><th colspan="1">INTERESES<br/>(Bs.)</th>
//                            <th colspan="1">PRIMA DEL <br/>FONDO DE<br/> GARANTIA (Bs.)</th><th colspan="1">PAGO TOTAL <br/> MENSUAL (Bs.)</th><th colspan="1">FECHA DE <br/> VENCIMIENTO</th><th colspan="1"></th>
//                        </tr>';
            $tasaFongar = 0.0143; //tasa fongar al 1.43%
            $fechaprotocolizacion = $analisis->fecha_protocolizacion; //fecha en que se hizo genero el calculo
            $mes = 1; //variable definida en 1 para la sumar por meses 

            for ($i = 1; $i <= $meses; $i++) { // inicio for para incrementar los meses   
                $primaFondoGa = number_format($montocredito * ($tasaFongar / 12), 2, '.', '');
                $intereses = number_format($montocredito * (($tasainteres / 100) / 12), 2, '.', '');
                $amortizacion = number_format(($montoCoutaFinanciera - $intereses), 2, '.', '');
                $cuotamen = number_format(($intereses + $primaFondoGa + $amortizacion), 2, '.', '');
                $nuevafecha = strtotime('+' . $mes . ' month', strtotime($fechaprotocolizacion)); //$nuevafecha  fecha de Protocolizacion 01/01/0001 00:00:00 convertida en fecha, sumando el mes siguiente
                $mes++;
                $nuevafecha = date('d/m/Y', $nuevafecha); //formato de la fecha nueva

                $saldoAnt = $montocredito - $amortizacion; // saldo nuevo una vez restada en el $montocredito - $amortizacion

                if ($i == $meses) { //inicio if
                    $saldo = number_format(0.00, 2, '.', ''); //saldo deudor
                } else {

                    $saldo = number_format($saldoAnt, 2, '.', ''); //saldo deudor
                } //fin if 

                $totalInteres = $totalInteres + $intereses;
                $totalCuotaFongar = $totalCuotaFongar + $primaFondoGa;
                $totalMontoCuotaFinan = $totalMontoCuotaFinan + $montoCoutaFinanciera;
                $totalCancelar = $totalCuotaFongar + $totalMontoCuotaFinan;
//                $tablaAmortiz.='<tr><td>' . $i . '</td><td style="text-align:center;">' . number_format($saldo, 2, ',', '.') . '</td><td style="text-align:center;">' . number_format($amortizacion, 2, ',', '.') . '</td><td style="text-align:center;">' . number_format($intereses, 2, ',', '.') . '</td>'
//                        . '<td style="text-align:center;">' . number_format($primaFondoGa, 2, ',', '.') . '</td><td style="text-align:center;">' . number_format($cuotamen, 2, ',', '.') . '</td><td style="text-align:center;">' . $nuevafecha . '</td></tr>';
                $montocredito = $saldoAnt; // saldo deudor
            }//fin del for
//            $tablaAmortiz.='</table>';
//            $htmlprincipal.="<table  align='right' width='100%' border='0'>       
//                                <tr>
//                                    <td colspan='2' align='center'><b><font size='5'>RESUMEN DEL PRESTAMO AL FINAL DE " . $analisis->nro_cuotas . " MESES</br></br></font><font size='6'> </font>
//                                    </td>
//                                    <br/>
//                                </tr>		
//                                <tr style='background:#E5E2E2'>
//                                    <td colspan='1'><b>Total Capital (Bs.):</b></td><td colspan='1'>" . number_format($analisis->monto_credito, 2, ',', '.') . "</td>
//                                </tr>
//                                <tr>
//                                    <td colspan='1'><b>Total Interes (Bs.):</b></td><td colspan='1'>" . number_format($totalInteres, 2, ',', '.') . "</td>
//                                </tr>
//                                <tr style='background:#E5E2E2'>
//                                    <td colspan='1'><b>Total Cuota Financiera (Bs.):</b></td><td colspan='1'>" . number_format($totalMontoCuotaFinan, 2, ',', '.') . "</td>
//                                </tr>
//                                <tr>
//                                    <td colspan='1'><b>Total Cuota FONDO DE GARANTÍA (Bs.):</b></td><td colspan='1'>" . number_format($totalCuotaFongar, 2, ',', '.') . "</td>
//                                </tr>
//                                <tr  style='background:#E5E2E2'>
//                                    <td colspan='1'><b>TOTAL A CANCELAR (Bs.):</b></td><td colspan='1'>" . number_format($totalCancelar, 2, ',', '.') . "</td>
//                                </tr>
//                            </table> <br/><br/><br/><br/><br/><br/><br/><br/>";
        }

        $updateBene = Beneficiario::model()->updateByPk($beneficiario->id_beneficiario, array(
            'estatus_beneficiario_id' => 271,
            'usuario_id_actualizacion' => Yii::app()->user->id,
            'fecha_actualizacion' => 'now()'
        ));
        $updateBeneTemp = BeneficiarioTemporal::model()->updateByPk($beneficiario->beneficiario_temporal_id, array(
            'estatus' => 272,
            'usuario_id_actualizacion' => Yii::app()->user->id,
            'fecha_actualizacion' => 'now()'
        ));

        $this->render('tablaAmortizacionpdf', array(
            'model' => $credito, 'totalInteres' => $totalInteres, 'totalCuotaFongar' => $totalCuotaFongar, 'analicredito' => $analicredito,
            'totalMontoCuotaFinan' => $totalMontoCuotaFinan, 'totalCancelar' => $totalCancelar, 'htmlprincipal' => $htmlprincipal
        ));
    }
    /*
     * PDF DE TABLA DE AMORTIZACION completa
     */

            
    public function actionTablaAmortizacionCompletaPdf($id) {
        $id_unidad_familiar = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id))->id_unidad_familiar; // ID DE LA UNIDAD_FAMILIAR PARA TRAER EL BENEFICIARIO
        $analicredito = AnalisisCredito::model()->findByAttributes(array('unidad_familiar_id' => $id_unidad_familiar)); // BUSQUEDA DEL ID_UNIDAD_FAMILIAR EN ANALISIS DE CREDITO 
        $beneficiario = Beneficiario::model()->findByPk($id); //ID DEL BENEFICIARIO
//        $n = new AnalisisCredito();
        $criteria = new CDbCriteria;
        $criteria->condition = 'unidad_familiar_id= :unidad_familiar';
        $criteria->params = array(":unidad_familiar" => (int) $id_unidad_familiar);
        $credito = AnalisisCredito::model()->findAll($criteria);


        $htmlprincipal = "<table align='right' width='100%' border='0'> ";
        foreach ($credito AS $analisis) {
//      var_dump($analisis->tasaInteres->tasa_interes);die();

            /* monto de la cuota finaciera es la funcion que se calcula de acuerdo al interes,  los años , y el monto de credito a pagar ; funcion PMT EN EXCEL
             * $tasainteres=> 4.66/100/12
             * $años=> cantidad de años
             * $monto credito=> monto a pagar solicitado
             */
            $meses = $analisis->nro_cuotas; //meses para pagar
            $años = $analisis->plazo_credito_ano; // cantidad en años para los meses 
            $cuotamensual = $analisis->monto_cuota_f_total; //cuota total mensual a pagar
            $montocredito = $analisis->monto_credito; //monto total a pagar del credito
            $tasainteres = $analisis->tasaInteres->tasa_interes; // tasa de interes 
            $montoCoutaFinanciera = CalculosController::actionMontoCoutaFinanciera($tasainteres, $años, $montocredito);
            $montoCoutaFinanciera = number_format($montoCoutaFinanciera, 2, '.', '');
            $totalInteres = 0;
            $totalCuotaFongar = 0;
            $totalMontoCuotaFinan = 0;
            $htmlprincipal = "<table align='right' width='100%' border='0'>       
                                <tr>
                                    <td colspan='4' align='center'><b><font size='5'>DATOS DEL CRÉDITO</br></br></font></td>
                                </tr>		
                              </table>
        
                    <table width='100%' >
                        <tr  style='background:#E5E2E2'>
                            <td colspan='1'><b>Monto Solicitado: </b></td><td colspan='1'>" . number_format($analisis->unidadFamiliar->beneficiario->beneficiarioTemporal->vivienda->precio_vivienda, 2, ',', '.') . "</td> 
                        </tr>";
                        if ($analisis->sub_directo_habitacional!='0.00'){
                       $htmlprincipal .= "
                         <tr>
                            <td colspan='1'><b>Subsidio Directo Habitacional:</b></td><td colspan='1'>" . $analisis->sub_directo_habitacional . "</td>
                        </tr>";
                        }
                         if ($analisis->sub_vivienda_perdida!='0.00'){
                         $htmlprincipal .= "
                         <tr   style='background:#E5E2E2'>
                            <td colspan='1'><b>Reconosimiento Vivienda Perdida:</b></td><td colspan='1'>" . number_format($analisis->sub_vivienda_perdida, 2, ',', '.') . "</td>
                        </tr>";
                          }
                           if (($analisis->sub_directo_habitacional!='0.00')&&($analisis->sub_vivienda_perdida!='0.00')){
                         $htmlprincipal .= "
                        <tr>
                            <td colspan=''><b>Subsidio Total (Bs.):</b></td><td colspan='1'>" . number_format($analisis->sub_directo_habitacional + $analisis->sub_vivienda_perdida, 2, ',', '.') . "</td>
                        </tr>"; 
                           }
                           
                          if ($analisis->monto_inicial!='0.00'){
                          $htmlprincipal .= "
                        <tr   style='background:#E5E2E2'>
                                <td colspan='1'><b>Cuota Inicial Pagada (Bs.):</b></td><td colspan='1'>" . number_format($analisis->monto_inicial, 2, ',', '.') . "</td>
                        </tr>";
                          }
                        $htmlprincipal .= "  
                        <tr>
                            <td colspan='1'><b>Monto Credito A Otorgar: </b></td><td colspan='1'>" . number_format($analisis->monto_credito, 2, ',', '.') . "</td>             
                        </tr>
                        
                        <tr   style='background:#E5E2E2'>
                            <td colspan='1'><b> Tasa Interes:</b></td><td colspan='1'>" . $analicredito->tasaInteres->tasa_interes . " %</td>
                        </tr>
                        
                        <tr>
                            <td colspan='1'><b>Plazo del Credito:</b></td><td colspan='1'>" . $analisis->nro_cuotas . " - MESES</td>
                        </tr>
                        <tr    style='background:#E5E2E2'>
                            <td colspan='1'><b>Pago Total Mensual:</b></td><td colspan='1'>" . $analisis->monto_cuota_f_total . "</td>
                        </tr>
                        
                    </table>  <br/>";

            $htmlprincipal.=" <table align='right' width='100%'  border='0'> 
                            <tr >
                                <td colspan='4' align='center'><b><font size='5'>DATOS PARA LA CANCELACIÓN</br></br></font><font size='6'> </font></td>
                            </tr>
                             </table>
                             <table width='100%'>
                            <tr style='background:#E5E2E2'>
                                <td colspan='2'><b>Institución Bancaria:</b></td><td  colspan='2'> BANCO DE VENEZUELA </td>
                            </tr>
                            <tr >
                                <td colspan='2'><b>Cuenta Corriente:</b></td><td  colspan='2'> 0102-0552-23-0000027685 </td>
                            </tr>
                            <tr style='background:#E5E2E2'>
                                <td colspan='2'><b>A nombre de:</b></td><td  colspan='2'> <b>BANAVIH COBRANZAS</b></td>
                            </tr>
                            <tr >
                                <td colspan='2'><b>Serial de Cliente:</b></td><td  colspan='2'>" . date('Y') . " " . $analicredito->unidadFamiliar->beneficiario->beneficiarioTemporal->cedula . " </td>
                            </tr> 
                            <tr style='background:#E5E2E2'>
                                <td colspan='2'><b>Fecha Primer Pago:</b></td><td  colspan='2'>" . date("d/m/Y", strtotime($analisis->fecha_protocolizacion)) . "</td>
                            </tr>
                            </table>
                            <br/>";

            $htmlprincipal.="<table align='right' width='100%'  border='0'>       
                        <tr>
                            <td colspan='4' align='center'><b><font size='5'>PRIMA INICIAL FONDO DE GARANTIA</br></br></font><font size='6'> </font></td>
                        </tr>		
                        <tr  style='background:#E5E2E2'>
                            <td colspan='2'><b>Prima Inicial Fondo de Garantia (Bs.):</b></td><td  colspan='2'>" . number_format($analisis->monto_prima_inicial_fg, 2, ',', '.') . "</td>
                        <tr>
                            <td colspan='2'><b>Porcentaje de la Prima Inicial (Bs.):</b></td><td  colspan='2'> 1,43% </td>
                        </tr>		
                        </tr>
                        </table> <br/>";




            $tablaAmortiz = '<table border=1 cellspacing=1 cellpadding=0 bordercolor="E5E2E2">';
            $tablaAmortiz.= ' <tr><th colspan="4" style="background:#E5E2E2; tex-algn:center;"><b>CUOTA FINANCIERA</th><th colspan="1" style="background:#E5E2E2">PRIMA <br/>RENOVAC. <br/>FONGAR</th>
                            <th colspan="2" style="background:#E5E2E2">CUOTA <br/>TOTAL<br/>MENSUAL</th>
                        </tr>';
            $tablaAmortiz.= '<tr  style="background:#E5E2E2"> <th colspan="1">N-MESES</th><th colspan="1">SALDO<br/>DEUDOR (Bs.)</th><th colspan="1">AMORTIZACION <br>DE CAPITAL</th><th colspan="1">INTERESES<br/>(Bs.)</th>
                            <th colspan="1">PRIMA DEL <br/>FONDO DE<br/> GARANTIA (Bs.)</th><th colspan="1">PAGO TOTAL <br/> MENSUAL (Bs.)</th><th colspan="1">FECHA DE <br/> VENCIMIENTO</th><th colspan="1"></th>
                        </tr>';
            $tasaFongar = 0.0143; //tasa fongar al 1.43%
            $fechaprotocolizacion = $analisis->fecha_protocolizacion; //fecha en que se hizo genero el calculo
            $mes = 1; //variable definida en 1 para la sumar por meses 

            for ($i = 1; $i <= $meses; $i++) { // inicio for para incrementar los meses   
                $primaFondoGa = number_format($montocredito * ($tasaFongar / 12), 2, '.', '');
                $intereses = number_format($montocredito * (($tasainteres / 100) / 12), 2, '.', '');
                $amortizacion = number_format(($montoCoutaFinanciera - $intereses), 2, '.', '');
                $cuotamen = number_format(($intereses + $primaFondoGa + $amortizacion), 2, '.', '');
                $nuevafecha = strtotime('+' . $mes . ' month', strtotime($fechaprotocolizacion)); //$nuevafecha  fecha de Protocolizacion 01/01/0001 00:00:00 convertida en fecha, sumando el mes siguiente
                $mes++;
                $nuevafecha = date('d/m/Y', $nuevafecha); //formato de la fecha nueva

                $saldoAnt = $montocredito - $amortizacion; // saldo nuevo una vez restada en el $montocredito - $amortizacion

                if ($i == $meses) { //inicio if
                    $saldo = number_format(0.00, 2, '.', ''); //saldo deudor
                } else {

                    $saldo = number_format($saldoAnt, 2, '.', ''); //saldo deudor
                } //fin if 

                $totalInteres = $totalInteres + $intereses;
                $totalCuotaFongar = $totalCuotaFongar + $primaFondoGa;
                $totalMontoCuotaFinan = $totalMontoCuotaFinan + $montoCoutaFinanciera;
                $totalCancelar = $totalCuotaFongar + $totalMontoCuotaFinan;
                $tablaAmortiz.='<tr><td>' . $i . '</td><td style="text-align:center;">' . number_format($saldo, 2, ',', '.') . '</td><td style="text-align:center;">' . number_format($amortizacion, 2, ',', '.') . '</td><td style="text-align:center;">' . number_format($intereses, 2, ',', '.') . '</td>'
                        . '<td style="text-align:center;">' . number_format($primaFondoGa, 2, ',', '.') . '</td><td style="text-align:center;">' . number_format($cuotamen, 2, ',', '.') . '</td><td style="text-align:center;">' . $nuevafecha . '</td></tr>';
                $montocredito = $saldoAnt; // saldo deudor
            }//fin del for
            $tablaAmortiz.='</table>';
            $htmlprincipal.="<table  align='right' width='100%' border='0'>       
                                <tr>
                                    <td colspan='2' align='center'><b><font size='5'>RESUMEN DEL PRESTAMO AL FINAL DE " . $analisis->nro_cuotas . " MESES</br></br></font><font size='6'> </font>
                                    </td>
                                    <br/>
                                </tr>		
                                <tr style='background:#E5E2E2'>
                                    <td colspan='1'><b>Total Capital (Bs.):</b></td><td colspan='1'>" . number_format($analisis->monto_credito, 2, ',', '.') . "</td>
                                </tr>
                                <tr>
                                    <td colspan='1'><b>Total Interes (Bs.):</b></td><td colspan='1'>" . number_format($totalInteres, 2, ',', '.') . "</td>
                                </tr>
                                <tr style='background:#E5E2E2'>
                                    <td colspan='1'><b>Total Cuota Financiera (Bs.):</b></td><td colspan='1'>" . number_format($totalMontoCuotaFinan, 2, ',', '.') . "</td>
                                </tr>
                                <tr>
                                    <td colspan='1'><b>Total Cuota FONDO DE GARANTÍA (Bs.):</b></td><td colspan='1'>" . number_format($totalCuotaFongar, 2, ',', '.') . "</td>
                                </tr>
                                <tr  style='background:#E5E2E2'>
                                    <td colspan='1'><b>TOTAL A CANCELAR (Bs.):</b></td><td colspan='1'>" . number_format($totalCancelar, 2, ',', '.') . "</td>
                                </tr>
                            </table> <br/><br/><br/><br/><br/><br/><br/><br/>";
        }

        $updateBene = Beneficiario::model()->updateByPk($beneficiario->id_beneficiario, array(
            'estatus_beneficiario_id' => 271,
            'usuario_id_actualizacion' => Yii::app()->user->id,
            'fecha_actualizacion' => 'now()'
        ));
        $updateBeneTemp = BeneficiarioTemporal::model()->updateByPk($beneficiario->beneficiario_temporal_id, array(
            'estatus' => 272,
            'usuario_id_actualizacion' => Yii::app()->user->id,
            'fecha_actualizacion' => 'now()'
        ));

        $this->render('tablaAmortizacionpdf', array(
            'model' => $credito, 'totalInteres' => $totalInteres, 'totalCuotaFongar' => $totalCuotaFongar, 'analicredito' => $analicredito,
            'totalMontoCuotaFinan' => $totalMontoCuotaFinan, 'totalCancelar' => $totalCancelar, 'tablaAmortiz' => $tablaAmortiz, 'htmlprincipal' => $htmlprincipal
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

        if (isset($_POST['AnalisisCredito'])) {
            $model->attributes = $_POST['AnalisisCredito'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_analisis_credito));
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
        $model = new Beneficiario('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Beneficiario']))
            $model->attributes = $_GET['Beneficiario'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Accion admin que muestra los beneficiario con estatus de tabla de amortizacion.
     */
    public function actionAdminAnalisisCredito() {
        $model = new Beneficiario('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Beneficiario']))
            $model->attributes = $_GET['Beneficiario'];

        $this->render('adminanalisiscredito', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = AnalisisCredito::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'analisis-credito-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     * FUNTION PARA CONSULTAR LAS CONDICIONES DEL GRUPO FAMILIAR DEL BENEFICIARIO
     */

    public function actionCondiciones() {
        $idUnidadFamiliar = $_POST['idUnidadFamiliar'];

        // EN CASO QUE NO APLICA NINGUNAS DE LA LAS ANTERIORES
        // BUSQUEDA QUE SE EJECUTYA PARA LISTAR TODOS LOS INTEGRANTES REGISTRADOS DEL BENEFICIARIO
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.unidad_familiar_id = :unidad_familiar_id');
        $criteria->params = array(':unidad_familiar_id' => $idUnidadFamiliar);
        $grupoFamiliar = GrupoFamiliar::model()->findAll($criteria);
        // DEFINICION DE VARIABLES. UTILIES PARA DETERMINAR EL TIPO DE SUBSIDO A APLICAR
        $mayorEdad = 0;
        $discapacidad = 0;
        $menoresEdad = 0;
        $conyugue = 0;

        // INICIO BUCLE DE LA COSULTA DE  ($grupoFamiliar)
        foreach ($grupoFamiliar AS $value) {

            // CONSULTA DEL LA FECHA DE NACIMIENTO. CONSULTA ORIGEN DE ORACLE TABLE PERSONA 
            $fechaNac = ConsultaOracle::setPersona("TO_CHAR(FECHA_NACIMIENTO, 'DD/MM/YYYY' ) AS fecha", $value->persona_id);
            // CALCULO QUE GENERA LA EDDA A PARTIR DE LA FECHA DE NACIMIENTO
            $edad = Generico::edad($fechaNac['FECHA']);

            // SWITCH QUE EVALUA LA EDAD DE CADA INTEGRANTE DEL GRUPO FAMILIAR
            switch ($edad) {
                case ($edad >= 60): //EN CASO QUE SEA > 60 AUTOINCREMENTE VARIABLE $mayorEdad , CON FIN DE DETERMINAR LA CANT DE PERSONA MAYORES DE 60 AÑOS
                    $mayorEdad++;
                    break;
                case ($edad < 18 && $value->gen_parentesco_id == 158):
                    //EN CASO QUE SEA < 18 Y CON  PARENTESCO DE HIJO. AUTOINCREMENTE VARIABLE $menoresEdad , CON FIN DE DETERMINAR LA CANT DE HIJOS MENORES DE EDAD POSEE EL BENEFICIARIO
                    $menoresEdad++;
                    break;
            }

            if ($value->tipo_sujeto_atencion == 231)// CONDICION QUE DETERMINA SI EL INTEGRANTE POSEE UNA DISCAPACIDAD, AUTOINCREMENTO DE LA VARIABLE $discapacidad
                $discapacidad++;
            if ($value->gen_parentesco_id == 155 || $value->gen_parentesco_id == 161) // CONDICION QUE DETERMINA EL PARENTESCO (CONYUGE, CONCUBINATO), AUTOINCREMENTO DE LA VARIABLE $conyugue
                $conyugue++;
        } // FIN DEL BUCLE DE LOS INTEGRANTES DEL GRUPO FAMILIAR DEL BENEFICIARIO
        $unidad_familiar = UnidadFamiliar::model()->findByPk($idUnidadFamiliar);
        $refigiaro = ( $unidad_familiar->condicion_unidad_familiar_id == 140) ? 'SI' : 'NO';
        $conyugue = ( $conyugue != 0) ? 'SI' : 'NO';

        $sms = '<dt>Dicha información proviene del censo realizado al beneficiario.</dt>
    <!--            <dt>Condiciones para el otorgamiento de subsidio.</dt>

                <ul class="list-inline">
                    <li>
                        <ul class="list-view">
                            <li>Unidad familiar integrada por dos (2) o más adultos mayores.</li>
                        </ul>
                    </li>
                    <li>
                        <ul class="list-view">
                            <li>Unidad familiar con una (1) o más personas con discapacidad o enfermedad grave.</li>
                        </ul>
                    </li>
                    <li>
                        <ul class="list-view">
                            <li>Unidad familiar constituida por madre o padre soltero con más de dos (2) hijos menores de edad.</li>
                        </ul>
                    </li>
                    <li>
                        <ul class="list-view">
                            <li>Unidad familiar con mpas de tres (3) hjijos menores de edad.</li>
                        </ul>
                    </li>
                </ul> -->
            ';

        $sms.='<br>
                <table class="table table-reflow table-responsive table-bordered">
                    <tr>
                        <th class="text-center">Adultos Mayores</th>
                        <th class="text-center">Personas con discapacidad</th>
                        <th class="text-center">Posee conyuge</th>
                        <th class="text-center">Hijos menores de edad</th>
                        <th class="text-center">Reconocimiento de Vivienda Perdida</th>
                    </tr>
                    <tr>
                        <td class="text-center">' . $mayorEdad . '</td>
                        <td class="text-center">' . $discapacidad . '</td>
                        <td class="text-center">' . $conyugue . '</td>
                        <td class="text-center">' . $menoresEdad . '</td>
                        <td class="text-center">' . $refigiaro . '</td>
                    </tr>
                </table>';
        echo json_encode($sms);
    }

    public function actionArmandoExcel($id_credito, $id_beneficiario, $cedula, $condunidadf, $tasainteres) {

        
        
        $model = Beneficiario::model()->findByPk($id_beneficiario); //para traerme los datos completos del beneficiario
        $nombre_completo = $model->beneficiarioTemporal->nombre_completo;
        
        $id_unidad_familiar = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id_beneficiario))->id_unidad_familiar; // ID DE LA UNIDAD_FAMILIAR PARA TRAER EL BENEFICIARIO

        $criteria = new CDbCriteria;
        $criteria->condition = 'unidad_familiar_id= :unidad_familiar';
        $criteria->params = array(":unidad_familiar" => (int) $id_unidad_familiar);
        $credito = AnalisisCredito::model()->findAll($criteria);

//        $monto_credito = $credito[0]['monto_credito'];
//        $monto_inicial = $credito[0]['monto_inicial'];
//        $ingreso_total = $credito[0]['ingreso_total_familiar'];
//        $plazo_credito = $credito[0]['plazo_credito_ano'];
//        $diferencia_pago = $credito[0]['diferencia_pago'];
//        $alicuota_fondo_garantia = $credito[0]['alicuota_fondo_garantia'];
        
//        var_dump($tasainteres)
        
            Yii::import('ext.phpexcel.XPHPExcel');
        $objPHPExcel = XPHPExcel::createPHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Banco Nacional de la Vivienda y Habitat - Banavih")
                ->setLastModifiedBy("Banco Nacional de la Vivienda y Habitat - Banavih")
                ->setTitle("Reporte generado desde sistema de protocolización")
                ->setSubject("Reporte generado desde sistema de protocolización")
                ->setDescription("Banco Nacional de la Vivienda y Habitat - Banavih");

        $estilo_etiquetas = new PHPExcel_Style();
        $estilo_etiquetas->applyFromArray(
                array('fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '1fb5ad')),
                    'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')),
                    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
                    'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,),)));

        $objPHPExcel->getActiveSheet()->SetCellValue("A1", 'Sistema de Protolización y Regularización de la Vivienda');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->setSharedStyle($estilo_etiquetas, "A1:F1");
        $objPHPExcel->getActiveSheet()->SetCellValue("A2", 'Generado el día: ' . date('d-m-Y') . ' a las ' . date('h:i a') . ' por el usuario "' . Yii::app()->user->name . '"');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:F2');

        $fila = 5;

        $objPHPExcel->getActiveSheet()->setSharedStyle($estilo_etiquetas, "A$fila:CJ$fila");


                //Coloco las etiquetas
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . "5", 'Nombre Completo');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'. "6", $nombre_completo);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . "5", 'Cédula');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'. "6", $cedula);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . "5", 'Condición Unidad Familiar');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'. "6", $condunidadf);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . "5", 'Monto del Crédito');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'. "6", $credito[0]['monto_credito']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . "5", 'Monto Inicial');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'. "6", $credito[0]['monto_inicial']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . "5", 'Ingreso Total Familiar');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'. "6", $credito[0]['ingreso_total_familiar']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . "5", 'Plazo del Crédito');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'. "6", $credito[0]['plazo_credito_ano']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . "5", 'Diferencia de Pago');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'. "6", $credito[0]['diferencia_pago']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . "5", 'Fongar');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'. "6", $credito[0]['alicuota_fondo_garantia']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . "5", 'Tasa Interés %');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'. "6", $tasainteres);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . "5", 'Tasa Fongar');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'. "6", $credito[0]['tasa_fongar_id']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . "5", 'Fuente de Financiamiento');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'. "6", $credito[0]['fuente_financiamiento_id']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . "5", 'Número de Cuotas');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'. "6", $credito[0]['nro_cuotas']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . "5", 'Monto Cuota Financiera');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'. "6", $credito[0]['monto_cuota_financiera']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . "5", 'Monto Cuota Financiera Total');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'. "6", $credito[0]['monto_cuota_f_total']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . "5", 'Monto Prima Inicial Fongar');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'. "6", $credito[0]['monto_prima_inicial_fg']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . "5", 'Máxima Capacidad de Pago');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'. "6", $credito[0]['maxima_capacidad_pago']);
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . "5", 'Monto Cuota Financiera Requerida');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'. "6", $credito[0]['monto_cuota_finan_requerida']);

        $nombrearchivo = "protocolizacion-" . date('Y-m-d-H_i_a') . ".xls";
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $nombrearchivo . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
   
    public function actionViewAnalisisCredito($id) {
        $condUnidadFam = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id));
//        var_dump($condUnidadFam);die;
        $model = Beneficiario::model()->findByPk($id);

        $id_unidad_familiar = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id))->id_unidad_familiar; // ID DE LA UNIDAD_FAMILIAR PARA TRAER EL BENEFICIARIO
//        $analicredito = AnalisisCredito::model()->findByAttributes(array('unidad_familiar_id' => $id_unidad_familiar)); // BUSQUEDA DEL ID_UNIDAD_FAMILIAR EN ANALISIS DE CREDITO 
//        var_dump($analicredito);die;

        $criteria = new CDbCriteria;
        $criteria->condition = 'unidad_familiar_id= :unidad_familiar';
        $criteria->params = array(":unidad_familiar" => (int) $id_unidad_familiar);
        $credito = AnalisisCredito::model()->findAll($criteria);

//        var_dump($credito);die;


        $this->render('_view', array('condUnidadFam' => $condUnidadFam, 'model' => $model, 'credito' => $credito));
    }

    public function actionEnviarDocumentacion() {
        $id = $_POST['id'];
        $id_unidad_familiar = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id))->id_unidad_familiar; // ID DE LA UNIDAD_FAMILIAR PARA TRAER EL BENEFICIARIO
        $analicredito = AnalisisCredito::model()->findByAttributes(array('unidad_familiar_id' => $id_unidad_familiar)); // BUSQUEDA DEL ID_UNIDAD_FAMILIAR EN ANALISIS DE CREDITO 
        $beneficiario = Beneficiario::model()->findByPk($id);
        if (!empty($analicredito)) {
            $buscarCaso = Asignaciones::model()->findByAttributes(array('fk_caso_asignado' => $beneficiario->id_beneficiario, 'fk_estatus' => 305, 'es_activo' => TRUE));

            //var_dump($buscarCaso);die;
            if (!empty($buscarCaso)) {
                $buscarCaso->es_activo = FALSE;
                $buscarCaso->fecha_actualizacion = 'now()';
                $buscarCaso->usuario_id_actualizacion = Yii::app()->user->id;
                if ($buscarCaso->save()) {

                    $modelAsignaciones = new Asignaciones;
                    $modelAsignaciones->fk_estatus = 306; //ENVIADO A DOCUMENTACION
                    $modelAsignaciones->fk_entidad = $buscarCaso->fk_entidad;
                    $modelAsignaciones->fk_usuario_asignado = $buscarCaso->fk_usuario_asignado;
                    $modelAsignaciones->fk_usuario_q_asigna = $buscarCaso->fk_usuario_q_asigna;
                    $modelAsignaciones->fk_caso_asignado = $buscarCaso->fk_caso_asignado;
                    $modelAsignaciones->fecha_creacion = 'now()';
                    $modelAsignaciones->usuario_id_creacion = Yii::app()->user->id;
                    $modelAsignaciones->es_activo = TRUE;
                    $modelAsignaciones->save();

                    $updateBene = Beneficiario::model()->updateByPk($beneficiario->id_beneficiario, array(
                        'estatus_beneficiario_id' => 271, // DOCUMENTACION
                        'usuario_id_actualizacion' => Yii::app()->user->id,
                        'fecha_actualizacion' => 'now()',
                    ));
//                    if ($updateBene->update()) {
                    $updateBeneTemp = BeneficiarioTemporal::model()->updateByPk($beneficiario->beneficiario_temporal_id, array(
                        'estatus' => 272, // DOCUMENTACION
                        'usuario_id_actualizacion' => Yii::app()->user->id,
                        'fecha_actualizacion' => 'now()'
                    ));
//                        if ($updateBeneTemp->update()) {
//                            if ($analicredito->fuente_financiamiento_id == 3) {
//                        $this->redirect(array('tempCensoValidadoFaovFas/adminfasp', 'msj' => 1));
                    echo json_encode(1);
//                            } else {
//                                echo json_encode(2);
//                        $this->redirect(array('tempCensoValidadoFaovFas/admin', 'msj' => 1));
//                            }
//                        }
//                    }
                }
            }
        } else {
            echo json_encode(3);
        }
    }

}
