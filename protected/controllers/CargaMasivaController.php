<?php

class CargaMasivaController extends Controller {
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
        //header('Content-Type: text/html; charset=utf-8');

        $model = new CargaMasiva;
        $estado = new Tblestado;
        $municipio = new Tblmunicipio;
        $parroquia = new Tblparroquia;
        $desarrollo = new Desarrollo;
        $unidadHabitacional = new UnidadHabitacional;

        $error = FALSE;

        $cant_columnas = 38;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $model->estatus = 100;
        $model->tipo_carga_masiva = 1;
        $model->usuario_id_creacion = 1;


        if (isset($_POST['CargaMasiva'])) {
           // echo '<pre>';
           // var_dump($_POST['UnidadHabitacional']['desarrollo_id']);
           // die;
            $model->attributes = $_POST['CargaMasiva'];

            $model->nombre_archivo = CUploadedFile::getInstance($model, 'nombre_archivo');

            $fp = fopen($model->nombre_archivo->tempName, 'w+');

            if (!$fp) {
                echo Yii::app()->user->setFlash('error', "No se pudo abrir el archivo para validarlo, asegurese que tiene permisos de lectura-escritura sobre el archivo.");
                $error = TRUE;
                //echo "no se pudo abrir el archivo";die();
                $this->redirect(array('cargaMasiva/index'));
            }

            //SEGMENTO DONDE SE VALIDA EL VALOR DE LA CABECERA PARA NO SER TOMADA EN EL PROCESO DE LA VALIDACIÓN DE LOS DATOS DE LAS FILAS
            $csv = array_map("str_getcsv", file($model->nombre_archivo->tempName, FILE_SKIP_EMPTY_LINES));
            $keys = array_shift($csv);
            $encabezado = explode(";", $keys[0]);
            $patron_alfanumeric = "/^[a-zA-Z0-9áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s\ñ\Ñ\-\.\_\°\,\(\)]+$/";
            $patron_numeric = "/^[0-9]+$/";
            $patron_alfa = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s\ñ\Ñ\'-\.\_\°\,\(\)]+$/";
            $patron_correo = "/^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(.[a-zA-Z]{2,4}+)*(.[a-zA-Z]{2,4})$/";
            $i = 0;
            $aErrores[][] = array();

            $TextMessage = array(
                0 => '<b>-</b> INICIO',
                1 => array(//ERROR DE CAMPOS VACIOS
                    2 => '<b>-</b> El campo <b>TIPO DE INMUEBLE</b> esta <b>VACIO</b> en las lineas: ',
                    1 => '<b>-</b> El campo de <b>NOMBRE UNIDAD MULTIFAMILIAR</b> esta <b>VACIO</b> en las lineas: ',
                    3 => '<b>-</b> El campo <b>TIPO DE VIVIENDA</b> esta <b>VACIO</b> en las lineas: ',
                    4 => '<b>-</b> El campo <b>NÚMERO DE PISO</b> esta <b>VACIO</b> en las lineas: ',
                    5 => '<b>-</b> El campo <b>NÚMERO DE VIVENDA</b> esta <b>VACIO</b> en las lineas: ',
                    6 => '<b>-</b> El campo <b>NACIONALIDAD</b> esta <b>VACIO</b> en las lineas: ',
                    7 => '<b>-</b> El campo <b>CÉDULA</b> esta <b>VACIO</b> en las lineas: ',
                    8 => '<b>-</b> El campo <b>PRIMER NOMBRE BENEFICIARIO</b> esta <b>VACIO</b> en las lineas: ',
                    9 => '<b>-</b> El campo <b>PRIMER APELLIDO BENEFICIARIO</b> esta <b>VACIO</b> en las lineas: ',
                    10 => '<b>-</b> El campo <b>SEXO</b> esta <b>VACIO</b> en las lineas: ',
                    11 => '<b>-</b> El campo <b>ESTADO CIVIL DEL BENEFICIARIO</b> esta <b>VACIO</b> en las lineas: ',
                ),
                2 => array(// ERROR DE : CAMPO ALFANUMERICOS
                    0 => '<b>-</b> El campo de <b>PARCELA</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    1 => '<b>-</b> El campo de <b>UNIDAD MULTIFAMILIAR</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    2 => '<b>-</b> El campo de <b>UNIDAD TIPO DE INMUEBLE</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    3 => '<b>-</b> El campo de <b>LINDERO NORTE MULTIFAMILIAR</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    4 => '<b>-</b> El campo de <b>LINDERO SUR MULTIFAMILIAR</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    5 => '<b>-</b> El campo de <b>LINDERO ESTE MULTIFAMILIAR</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    6 => '<b>-</b> El campo de <b>LINDERO OESTE MULTIFAMILIAR</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    7 => '<b>-</b> El campo de <b>NÚMERO DE PISO</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    8 => '<b>-</b> El campo de <b>NÚMERO DE VIVENDA</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    9 => '<b>-</b> El campo de <b>COORDENADAS</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    10 => '<b>-</b> El campo de <b>LINDERO NORTE VIVIENDA</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    11 => '<b>-</b> El campo de <b>LINDERO SUR VIVIENDA</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    12 => '<b>-</b> El campo de <b>LINDERO ESTE VIVIENDA</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    13 => '<b>-</b> El campo de <b>LINDERO OESTE VIVIENDA</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                    14 => '<b>-</b> El campo de <b>NÚMERO DE ESTATCIONAMIENTO</b> possen <b>CARACTERES ESPECIALES</b> en las lineas: ',
                ),
                3 => array(// ERROR DE: CAMPOS IGUALES A MAESTRO
                    1 => '<b>-</b> El campo <b>TIPO DE INMUEBLE</b> solo acepta <b>EDIFICIO DE APARTAMENTOS/TETRA/PENDIENTE/PARCELA</b>, verificar las lineas: ',
                    2 => '<b>-</b> El campo <b>TIPO DE VIVIENDA</b> solo acepta <b>APARTAMENTO/TOWNHOUSE/CASA</b>, verificar las lineas: ',
                    3 => '<b>-</b> El campo <b>SALA</b> solo acepta <b>SI/NO</b>, verificar las lineas: ',
                    4 => '<b>-</b> El campo <b>COMEDOR</b> solo acepta <b>SI/NO</b>, verificar las lineas: ',
                    5 => '<b>-</b> El campo <b>COCINA</b> solo acepta <b>SI/NO</b>, verificar las lineas: ',
                    6 => '<b>-</b> El campo <b>LAVADERO</b> solo acepta <b>SI/NO</b>, verificar las lineas: ',
                    7 => '<b>-</b> El campo <b>NACIONALIDAD</b> solo acepta <b>V/E</b>, verificar las lineas: ',
                    8 => '<b>-</b> El campo <b>SEXO</b> solo acepta <b>FEMENINO/MASCULINO</b>, verificar las lineas: ',
                    9 => '<b>-</b> El campo <b>ESTADO CIVIL</b> solo acepta <b>SOLTERO(A)/CASADO(A)/DIVORCIADO(A)/VIUDO(A)</b>, verificar las lineas: ',
                ),
                4 => array(// ERROR DE: CAMPOS NUMERICOS
                    1 => '<b>-</b> El campo <b>PORCENTAJE DE LA VIVIENDA</b> solo acepta <b>CARACTERES NUMERICOS Y (.)</b>, verificar las lineas: ',
                    2 => '<b>-</b> El campo <b>AREAS MTS2</b> solo acepta <b>CARACTERES NUMERICOS Y (.)</b>, verificar las lineas: ',
                    3 => '<b>-</b> El campo <b>NÚMERO DE HABITACIÓN</b> solo acepta <b>CARACTERES NUMERICOS</b>, verificar las lineas: ',
                    4 => '<b>-</b> El campo <b>NÚMERO DE BAÑOS</b> solo acepta <b>CARACTERES NUMERICOS</b>, verificar las lineas: ',
                    5 => '<b>-</b> El campo <b>NÚMERO DE BAÑOS AUXILIARES</b> solo acepta <b>CARACTERES NUMERICOS</b>, verificar las lineas: ',
                    6 => '<b>-</b> El campo <b>PUESTO DE ESTACIONAMIENTO</b> solo acepta <b>CARACTERES NUMERICOS</b>, verificar las lineas: ',
                    7 => '<b>-</b> El campo <b>PRECIO DE LA VIVIENDA</b> solo acepta <b>CARACTERES NUMERICOS Y (.)</b>, verificar las lineas: ',
                    8 => '<b>-</b> El campo <b>CÉDULA</b> solo acepta <b>CARACTERES NUMERICOS</b>, verificar las lineas: ',
                    9 => '<b>-</b> El campo <b>TELÉFONO HABITACIÓN</b> solo acepta <b>CARACTERES NUMERICOS</b>, verificar las lineas: ',
                    10 => '<b>-</b> El campo <b>TELÉFONO CELULAR</b> solo acepta <b>CARACTERES NUMERICOS</b>, verificar las lineas: ',
                ),
                5 => array(// ERROR DE: CAMPOS CON TAMAÑO MÁXIMO
                    1 => '<b>-</b> El campo <b>CÉDULA</b> no puede exceder de <b>9</b> número, verificar las lineas: ',
                    2 => '<b>-</b> El campo <b>TELÉFONO HABITACIÓN</b> debe de ser de <b>10</b> número, verificar las lineas: ',
                    3 => '<b>-</b> El campo <b>TELÉFONO CELULAR</b> debe de ser de <b>10</b> número, verificar las lineas: ',
                ),
                6 => array(// ERROR DE: CAMPOS ALFA / LETRAS
                    1 => '<b>-</b> El campo <b>PRIMER NOMBRE BENEFICIARIO</b> solo aceptan <b>LETRAS</b>, verificar las lineas: ',
                    2 => '<b>-</b> El campo <b>SEGUNDO NOMBRE BENEFICIARIO</b> solo aceptan <b>LETRAS</b>, verificar las lineas: ',
                    3 => '<b>-</b> El campo <b>PRIMER APELLIDO BENEFICIARIO</b> solo aceptan <b>LETRAS</b>, verificar las lineas: ',
                    4 => '<b>-</b> El campo <b>SEGUNDO APELLIDO BENEFICIARIO</b> solo aceptan <b>LETRAS</b>, verificar las lineas: ',
                ),
                7 => array(
                    1 => '<b>-</b> Los siguientes <b>BENEFICIARIOS</b> debe colocalr al menos un número telefónico, revisar las siguientes lineas: ',
                ),
                8 => array(
                    1 => '<b>-</b> El <b>CORREO ELECTRÓNICO</b> no tiene el formato adecuado, revisar las siguientes lineas: ',
                ),
            );

            $LineMensage[][][] = array();

            // VARIABLES QUE ACUMULA LAS LINEAS VACIAS O CON ERROR
//            $cant_empty_desarrollo= array();

            while (( $data = fgetcsv($fp, 1000, ";")) !== FALSE) {
                if ($i == 0) {
                    if (count($data) != $cant_columnas) {var_dump($_POST['UnidadHabitacional']['desarrollo_id']);
                        echo Yii::app()->user->setFlash('danger', "El archivo no tiene la cantidad de campos requeridos, por favor revise que existan solo $cant_columnas columnas en el archivo.");
                        $error = TRUE;
                    }
                }
                if ($error != TRUE) {
                    //INICIA EL PROCESEO DE VALIDACIONES DEL DOCUMENTO CSV POR COLUMNA SE HACEN DOS VALIDACIONES BÁSICAS SI NO ESTA VACIO Y SI ES ALFANUMERICO O NUMERICO 
                    //SEGÚN LO QUE CORRESPONDA AL CASO ADEMÁS SE ELIMINA LA CABEZARA DEL ARCHIVO DE LAS VALIDACIONES
                    //POR OTRO LADO DONDE SE CONSIGA UNA COLUMNA CON LOS VALORES DEFINIDOS EN LA TABLA MAESTRO SE VALIDA
                    //EL CAMPO "0" CORRESPONDE A EL NOMBRE DE LA "PARCELA" QUE EL MISMO NO ES OBLIGATORIO
                    if ($data[0] != $encabezado[0]) {
                        if (!empty($data[0])) {
                            if (!preg_match($patron_alfanumeric, $data[0])) {
                                $LineMensage[2][0][$i] = $i;
//                                $error = TRUE;
                            }
                        }
                    }

                    //EL CAMPO "1" CORRESPONDE A EL NOMBRE DE LA "UNIDAD MULTIFAMILIAR" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR
                    if (($data[1]) != $encabezado[1]) {
                        if (empty($data[1])) {
                            //array_push($cant_empty_desarrollo, $i);
                            $LineMensage[1][1][$i] = $i;
//                            $error = TRUE;
                        } elseif (!preg_match($patron_alfanumeric, $data[1])) {
                            $LineMensage[2][1][$i] = $i;
//                            $error = TRUE;
                        }
                    }

                    //EL CAMPO "2" CORRESPONDE A EL "TIPO DE INMUEBLE" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR ADEMÁS TIENE QUE CONSIDIR 
                    //CON EL LISTADO QUE SE ENCUENTRA EN MAESTRO
                    if (($data[2]) != $encabezado[2]) {
                        if (empty($data[2])) {
                            $LineMensage[1][2][$i] = $i;
//                            $error = TRUE;
                        } else {
                            if (strcasecmp($data[2], 'EDIFICIO DE APARTAMENTOS') != 0) {
                                if (strcasecmp($data[2], 'TETRA') != 0) {
                                    if (strcasecmp($data[2], 'PENDIENTE') != 0) {
                                        if (strcasecmp($data[2], 'PARCELA') != 0) {
                                            $LineMensage[3][1][$i] = $i;
//                                            $error = TRUE;
                                        }
                                    }
                                }
                            }
                        }
                    }
//7
//                    //EL CAMPO "3" CORRESPONDE A EL "LINDERO NORTE MULTIFAMILIAR" EL MISMO NO ES OBLIGATORIO 
                    if (($data[3]) != $encabezado[3]) {
                        if (!empty($data[3])) {
                            if (!preg_match($patron_alfanumeric, $data[3])) {
                                $LineMensage[2][3][$i] = $i;
//                                $error = TRUE;
                            }
                        }
                    }
//
//                    //EL CAMPO "4" CORRESPONDE A EL "LINDERO SUR MULTIFAMILIAR" EL MISMO NO ES OBLIGATORIO 
                    if (($data[4]) != $encabezado[4]) {
                        if (!empty($data[4])) {
                            if (!preg_match($patron_alfanumeric, $data[4])) {
                                $LineMensage[2][4][$i] = $i;
//                                $error = TRUE;
                            }
                        }
                    }
//
//                    //EL CAMPO "5" CORRESPONDE A EL "LINDERO ESTE MULTIFAMILIAR" EL MISMO NO ES OBLIGATORIO 
                    if (($data[5]) != $encabezado[5]) {
                        if (!empty($data[5])) {
                            if (!preg_match($patron_alfanumeric, $data[5])) {
                                $LineMensage[2][5][$i] = $i;
//                                $error = TRUE;
                            }
                        }
                    }
//
//                    //EL CAMPO "6" CORRESPONDE A EL "LINDERO OESTE MULTIFAMILIAR" EL MISMO NO ES OBLIGATORIO 
                    if (($data[6]) != $encabezado[6]) {
                        if (!empty($data[6])) {
                            if (!preg_match($patron_alfanumeric, $data[6])) {
                                $LineMensage[2][6][$i] = $i;
//                                $error = TRUE;
                            }
                        }
                    }
//
//                    //EL CAMPO "7" CORRESPONDE A EL "TIPO DE VIVIENDA" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR ADEMÁS TIENE QUE CONSIDIR 
//                    //CON EL LISTADO QUE SE ENCUENTRA EN MAESTRO
                    if (($data[7]) != $encabezado[7]) {
                        if (empty($data[7])) {
                            $LineMensage[1][3][$i] = $i;
//                            $error = TRUE;
                        } else {
                            if (strcasecmp($data[7], 'APARTAMENTO') != 0) {
                                if (strcasecmp($data[7], 'TOWNHOUSE') != 0) {
                                    if (strcasecmp($data[7], 'CASA') != 0) {
                                        $LineMensage[3][2][$i] = $i;
//                                            $error = TRUE;
                                    }
                                }
                            }
                        }
                    }

//                    //EL CAMPO "8" CORRESPONDE A EL "PORCENTAJE DE LA VIVIENDA" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR ADEMÁS 
//                    //LA VALIDACIÓN OBLIGA A QUE EL DECIMAL LO ESCRIBAN CON PUNTO "." Y NO CON COMA ","
                    if (($data[8]) != $encabezado[8]) {
                        if (!empty($data[8])) {
                            if (!is_numeric($data[8])) {
                                $LineMensage[4][1][$i] = $i;
//                                $error = TRUE;
                            }
                        }
                    }

//                    //EL CAMPO "9" CORRESPONDE A EL "NÚMERO DE PISO" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR 
                    if (($data[9]) != $encabezado[9]) {
                        if (empty($data[9])) {
                            $LineMensage[1][4][$i] = $i;
//                          $error = TRUE;
                        } else {
                            if (!preg_match($patron_alfanumeric, $data[9])) {
                                $LineMensage[2][7][$i] = $i;
//                                $error = TRUE;
                            }
                        }
                    }

//                    //EL CAMPO "10" CORRESPONDE A EL "NÚMERO DE VIVENDA" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR 
                    if (($data[10]) != $encabezado[10]) {
                        if (empty($data[10])) {
                            $LineMensage[1][5][$i] = $i;
//                          $error = TRUE;
                        } else {
                            if (!preg_match($patron_alfanumeric, $data[10])) {
                                $LineMensage[2][8][$i] = $i;
//                                $error = TRUE;
                            }
                        }
                    }

//                    //EL CAMPO "11" CORRESPONDE A EL "AREAS MTS2" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR ADEMÁS 
//                    //LA VALIDACIÓN OBLIGA A QUE EL DECIMAL LO ESCRIBAN CON PUNTO "." Y NO CON COMA ","
                    if (($data[11]) != $encabezado[11]) {
                        if (!empty($data[11])) {
                            if (!is_numeric($data[11])) {
                                $LineMensage[4][2][$i] = $i;
//                                $error = TRUE;
                            }
                        }
                    }

//                    //EL CAMPO "12" CORRESPONDE A EL "SALA" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR Y SU VALOR POSIBLRE ES "SI" O "NO"
                    if (($data[12]) != $encabezado[12]) {
                        if ((!empty($data[12])) || ($data[12] == '0')) {
                            if (strcasecmp($data[12], 'SI') != 0) {
                                if (strcasecmp($data[12], 'NO') != 0) {
                                    $LineMensage[3][3][$i] = $i;
                                }
                            }
                        }
                    }

                    //EL CAMPO "13" CORRESPONDE A EL "COMEDOR" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR Y SU VALOR POSIBLRE ES "SI" O "NO"
                    if (($data[13]) != $encabezado[13]) {
                        if ((!empty($data[13])) || ($data[13] == '0')) {
                            if (strcasecmp($data[13], 'SI') != 0) {
                                if (strcasecmp($data[13], 'NO') != 0) {
                                    $LineMensage[3][4][$i] = $i;
                                }
                            }
                        }
                    }

                    //EL CAMPO "14" CORRESPONDE A EL "COCINA" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR Y SU VALOR POSIBLRE ES "SI" O "NO"
                    if (($data[14]) != $encabezado[14]) {
                        if ((!empty($data[14])) || ($data[14] == '0')) {
                            if (strcasecmp($data[14], 'SI') != 0) {
                                if (strcasecmp($data[14], 'NO') != 0) {
                                    $LineMensage[3][5][$i] = $i;
                                }
                            }
                        }
                    }

                    //EL CAMPO "15" CORRESPONDE A EL "LAVANDERO" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR Y SU VALOR POSIBLRE ES "SI" O "NO"
                    if (($data[15]) != $encabezado[15]) {
                        if ((!empty($data[15])) || ($data[15] == '0')) {
                            if (strcasecmp($data[15], 'SI') != 0) {
                                if (strcasecmp($data[15], 'NO') != 0) {
                                    $LineMensage[3][6][$i] = $i;
                                }
                            }
                        }
                    }

                    //EL CAMPO "16" CORRESPONDE A EL "NÚMERO DE HABITACIONES" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR 
                    //Y SU VALOR ES UNICAMENTE UN ENTERO
                    if (($data[16]) != $encabezado[16]) {
                        if (!empty($data[16])) {
                            if (!preg_match($patron_numeric, $data[16])) {
                                $LineMensage[4][3][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "17" CORRESPONDE A EL "NÚMERO DE BAÑOS" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR 
                    //Y SU VALOR ES UNICAMENTE UN ENTERO
                    if (($data[17]) != $encabezado[17]) {
                        if (!empty($data[17])) {
                            if (!preg_match($patron_numeric, $data[17])) {
                                $LineMensage[4][4][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "18" CORRESPONDE A EL "NÚMERO DE BAÑOS AUXILIARES" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR 
                    //Y SU VALOR ES UNICAMENTE UN ENTERO
                    if (($data[18]) != $encabezado[18]) {
                        if (!empty($data[18])) {
                            if (!preg_match($patron_numeric, $data[18])) {
                                $LineMensage[4][5][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "19" CORRESPONDE A EL "COORDENADAS" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR 
                    if (($data[19]) != $encabezado[19]) {
                        if (!empty($data[19])) {
                            if (!preg_match($patron_alfanumeric, $data[19])) {
                                $LineMensage[2][9][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "20" CORRESPONDE A EL "LINDERO NORTE VIVIENDA" EL MISMO NO ES OBLIGATORIO 
                    if (($data[20]) != $encabezado[20]) {
                        if (!empty($data[20])) {
                            if (!preg_match($patron_alfanumeric, $data[20])) {
                                $LineMensage[2][10][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "21" CORRESPONDE A EL "LINDERO SUR VIVIENDA" EL MISMO NO ES OBLIGATORIO 
                    if (($data[21]) != $encabezado[21]) {
                        if (!empty($data[21])) {
                            if (!preg_match($patron_alfanumeric, $data[21])) {
                                $LineMensage[2][11][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "22" CORRESPONDE A EL "LINDERO ESTE VIVIENDA" EL MISMO NO ES OBLIGATORIO 
                    if (($data[22]) != $encabezado[22]) {
                        if (!empty($data[22])) {
                            if (!preg_match($patron_alfanumeric, $data[22])) {
                                $LineMensage[2][12][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "23" CORRESPONDE A EL "LINDERO OESTE VIVIENDA" EL MISMO NO ES OBLIGATORIO 
                    if (($data[23]) != $encabezado[23]) {
                        if (!empty($data[23])) {
                            if (!preg_match($patron_alfanumeric, $data[23])) {
                                $LineMensage[2][13][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "24" CORRESPONDE A EL "PUESTO DE ESTACIONAMIENTO" EL MISMO NO ES OBLIGATORIO 
                    if (($data[24]) != $encabezado[24]) {
                        if (!empty($data[24])) {
                            if (!preg_match($patron_numeric, $data[24])) {
                                $LineMensage[4][6][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "25" CORRESPONDE A EL "NÚMERO DE ESTATCIONAMIENTO" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR 
                    //Y SU VALOR ES UNICAMENTE UN ENTERO
                    if (($data[25]) != $encabezado[25]) {
                        if (!empty($data[25])) {
                            if (!preg_match($patron_alfanumeric, $data[25])) {
                                $LineMensage[2][14][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "26" CORRESPONDE A EL "PRECIO DE VIVIENDA" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR ADEMÁS 
                    //LA VALIDACIÓN OBLIGA A QUE EL DECIMAL LO ESCRIBAN CON PUNTO "." Y NO CON COMA ","
                    if (($data[26]) != $encabezado[26]) {
                        if (!empty($data[26])) {
                            if (!is_numeric($data[26])) {
                                $LineMensage[4][7][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "27" CORRESPONDE A EL "NACIONALIDAD" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR Y SU VALOR POSIBLRE ES "V" O "E"
                    if (($data[27]) != $encabezado[27]) {
                        if (empty($data[27])) {
                            $LineMensage[1][6][$i] = $i;
                        } else {
                            if (strcasecmp($data[27], 'V') != 0) {
                                if (strcasecmp($data[27], 'E') != 0) {
                                    $LineMensage[3][7][$i] = $i;
                                }
                            }
                        }
                    }

                    //EL CAMPO "28" CORRESPONDE A LA "CEDULA DEL BENEFICIARIO" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR Y NADA MÁS PERMITE NÚMEROS Y EL TAMAÑO
                    //DEL STRING NO PUEDE SER MENOR 1 Y MAYOR DE 8                    
                    if (($data[28]) != $encabezado[28]) {
                        if (empty($data[28])) {
                            $LineMensage[1][7][$i] = $i;
                        } else {
                            if (((strlen($data[28]) > 0) && (strlen($data[28]) < 9))) {
                                if (!preg_match($patron_numeric, $data[28])) {
                                    $LineMensage[4][8][$i] = $i;
                                }
                            } else {
                                $LineMensage[5][1][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "29" CORRESPONDE A EL "PRIMER NOMBRE BENEFICIARIO" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR
                    if (($data[29]) != $encabezado[29]) {
                        if (empty($data[29])) {
                            $LineMensage[1][8][$i] = $i;
                        } else {
                            if (!preg_match($patron_alfa, $data[29])) {
                                $LineMensage[6][1][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "30" CORRESPONDE A EL "SEGUNDO NOMBRE BENEFICIARIO" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR
                    if (($data[30]) != $encabezado[30]) {
                        if (!empty($data[30])) {
                            if (!preg_match($patron_alfa, $data[30])) {
                                $LineMensage[6][2][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "31" CORRESPONDE A EL "PRIMER APELLIDO BENEFICIARIO" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR
                    if (($data[31]) != $encabezado[31]) {
                        if (empty($data[31])) {
                            $LineMensage[1][9][$i] = $i;
                        } else {
                            if (!preg_match($patron_alfa, $data[31])) {
                                $LineMensage[6][3][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "32" CORRESPONDE A EL "SEGUNDO APELLIDO BENEFICIARIO" EL MISMO NO ES OBLIGATORIO PARA PODER CONTINUAR
                    if (($data[32]) != $encabezado[32]) {
                        if (!empty($data[32])) {
                            if (!preg_match($patron_alfa, $data[32])) {
                                $LineMensage[6][4][$i] = $i;
                            }
                        }
                    }

                    //EL CAMPO "33" CORRESPONDE A EL "SEXO DEL BENEFICIARIO" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR ADEMÁS TIENE QUE CONSIDIR 
                    //CON EL LISTADO QUE SE ENCUENTRA EN MAESTRO
                    if (($data[33]) != $encabezado[33]) {
                        if (empty($data[33])) {
                            $LineMensage[1][10][$i] = $i;
                        } else {
                            if (strcasecmp($data[33], 'FEMENINO') != 0) {
                                if (strcasecmp($data[33], 'MASCULINO') != 0) {
                                    $LineMensage[3][8][$i] = $i;
                                }
                            }
                        }
                    }

                    //EL CAMPO "34" CORRESPONDE A EL "ESTADO CIVIL DEL BENEFICIARIO" EL MISMO ES OBLIGATORIO PARA PODER CONTINUAR ADEMÁS TIENE QUE CONSIDIR 
                    //CON EL LISTADO QUE SE ENCUENTRA EN MAESTRO
                    if (($data[34]) != $encabezado[34]) {
                        if (empty($data[34])) {
                            $LineMensage[1][11][$i] = $i;
                        } else {
                            if (strcasecmp($data[34], 'SOLTERO(A)') != 0) {
                                if (strcasecmp($data[34], 'CASADO(A)') != 0) {
                                    if (strcasecmp($data[34], 'DIVORCIADO(A)') != 0) {
                                        if (strcasecmp($data[34], 'VIUDO(A)') != 0) {
                                            $LineMensage[3][9][$i] = $i;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // CAMPO "35" - "36" CORRESPONDIENTE A LOS NUMEROS TELEFONICOS. 
                    // VALIDACION QUE VERIFGICA QUE AL MENOS UNO DE LOS DOS ESTEN CON DATOS
                    if (empty($data[35]) && empty($data[36])) {
                        $LineMensage[7][1][$i] = $i;
                    }

                    //EL CAMPO "35" CORRESPONDE AL "TELÉFONO HABITACIÓN DEL BENEFICIARIO" EL MISMO ES NO ES OBLIGATORIO PARA PODER CONTINUAR, PERO ES NECESARIO 
                    //POR LO MENOS UN TELÉFONO Y NADA MÁS PERMITE NÚMEROS Y EL TAMAÑO DEL STRING NO PUEDE SER MENOR 1 Y MAYOR DE 10                    
                    if (($data[35]) != $encabezado[35]) {
                        if (!empty($data[35])) {
                            if (!preg_match($patron_numeric, $data[35])) {
                                $LineMensage[4][9][$i] = $i;
                            } else {
                                if ((strlen($data[35]) != 10)) {
                                    $LineMensage[5][2][$i] = $i;
                                }
                            }
                        }
                    }

                    //EL CAMPO "36" CORRESPONDE AL "TELÉFONO CELULAR DEL BENEFICIARIO" EL MISMO ES NO ES OBLIGATORIO PARA PODER CONTINUAR, PERO ES NECESARIO 
                    //POR LO MENOS UN TELÉFONO Y NADA MÁS PERMITE NÚMEROS Y EL TAMAÑO DEL STRING NO PUEDE SER MENOR 1 Y MAYOR DE 10                    
                    if (($data[36]) != $encabezado[36]) {
                        if (!empty($data[36])) {
                            if (!preg_match($patron_numeric, $data[36])) {
                                $LineMensage[4][10][$i] = $i;
                            } else {
                                if ((strlen($data[36]) != 10)) {
                                    $LineMensage[5][3][$i] = $i;
                                }
                            }
                        }
                    }

                    //EL CAMPO "37" CORRESPONDE AL "CORREO DEL BENEFICIARIO" EL MISMO ES NO ES OBLIGATORIO PARA PODER CONTINUAR
                    if (($data[37]) != $encabezado[37]) {
                        if (!empty($data[37])) {
                            if (!preg_match($patron_correo, $data[37])) {
                                $LineMensage[8][1][$i] = $i;
                            }
                        }
                    }

                    $i++;
                } else {
                    $this->render('create', array(
                        'model' => $model, 'estado' => $estado,
                        'municipio' => $municipio, 'parroquia' => $parroquia,
                        'desarrollo' => $desarrollo, 'unidadHabitacional' => $unidadHabitacional,
                        'sms' => 1
                    ));
                    Yii::app()->end();
                }
            }
            $existeError = 0;
            $result = 'VERIFIQUE LAS SIGUIENTES LINEAS:<br/><br/>';
            foreach ($LineMensage as $key => $value) {
                if ($key != 0) {
                    foreach ($value as $keyLine => $line) {
                        $result.= $TextMessage[$key][$keyLine] . implode(', ', $line) . '<br/>';
                        $existeError++;
                    }
                }
            }

            /* ---- NOTIFICACION DE ERRORES EN EL ARCHIVO CSV ----- */

            if ($existeError != 0) {
                echo Yii::app()->user->setFlash('warning', $result);
                $this->render('create', array(
                    'model' => $model, 'estado' => $estado,
                    'municipio' => $municipio, 'parroquia' => $parroquia,
                    'desarrollo' => $desarrollo, 'unidadHabitacional' => $unidadHabitacional,
                ));
                Yii::app()->end();
            } else {
		$nombre_archivo = pathinfo($model->nombre_archivo);
                $archivo = Yii::app()->basePath . '/../doc/' .$nombre_archivo['filename']."_".date("Y-m-d_h-m-s-A").".".$nombre_archivo['extension'];
                $model->nombre_archivo->saveAs($archivo);
		$model->nombre_archivo = basename( $archivo );
                $model->num_lineas = count(file($archivo));
                $model->tamano_archivo = filesize($archivo);
                $model->mensajes_carga = 'mensaje_inicio=>Background';

                /*
                 * VARIABLES REQUERIDOS PARA LA EJECUCION DEL ARCHIVO PL
                 */
                $id_usuario_creacion = Yii::app()->user->id;
                $id_desarrollo = $_POST['UnidadHabitacional']['desarrollo_id'];
                $ruta_archivo_pl = dirname(dirname(__DIR__)) . '/CargaMasiva-master/inicio.pl';

		if ( file_exists( $ruta_archivo_pl ) ) {
		        if ($model->save()) {
		            $id_carga_masiva = $model->id_carga_masiva;
		            $perl = "/usr/bin/perl";
		            $result = 0;
		            $result = shell_exec("$perl $ruta_archivo_pl $archivo $id_desarrollo $id_usuario_creacion $id_carga_masiva");

		
                            
		            //$this::model()->updateByPk($model->id_carga_masiva, array('observaciones' => "$archivo Despues del script: " . $result));
			    CargaMasiva::model()->updateByPk($model->id_carga_masiva, array('observaciones' => "$archivo Despues del script: "));
		            //$model->observaciones = "$archivo Despues del script: " . $result;
		            $this->redirect(array('view', 'id' => $model->id_carga_masiva));
		        }
		}else{
                        echo Yii::app()->user->setFlash('danger', "No existe el archivo que procesa su carga masiva, consulte con el personal de tecnología. Su carga masiva no fue procesada.");
                        $error = TRUE;
		}//fin si existe el archivo perl
            }
        }//fin del post global de carga masiva
        $this->render('create', array('model' => $model, 'estado' => $estado,
            'municipio' => $municipio, 'parroquia' => $parroquia, 'desarrollo' => $desarrollo, 'unidadHabitacional' => $unidadHabitacional));
    }

//fin accion create carga


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['CargaMasiva'])) {
            $model->attributes = $_POST['CargaMasiva'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_carga_masiva));
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
        $dataProvider = new CActiveDataProvider('CargaMasiva');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CargaMasiva('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CargaMasiva']))
            $model->attributes = $_GET['CargaMasiva'];

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
        $model = CargaMasiva::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'carga-masiva-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
