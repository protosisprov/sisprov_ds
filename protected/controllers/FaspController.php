<?php

class FaspController extends Controller {
    /**
     * @return array action filters
     */
//    public function filters() {
//        return array(array('CrugeAccessControlFilter'));
//    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//    public function accessRules() {
//        return array(
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('Subsidio', 'MontoReconocidoPerdidaVivienda'),
//                'users' => array('*'),
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

    public function actionSubsidio($capacidadPago, $costoVivienda, $idUnidadFamiliar, $ingresoFamiliar) {

        $SM = Maestro::model()->findByAttributes(array('padre' => 237, 'es_activo' => TRUE))->descripcion; //SELECCION EL SUELDO MINIMO DE LA TABLA MAESTRO 9648,18
        $SM = str_replace('.', '', $SM); // REEMPLAZA  EL (.)  9.000.00 EL UN '' QUEDANDO 9000,00
        $SM = (float) str_replace(',', '.', $SM); // REEMPLAZA  EL (,)  9.000.00 EL UN '' QUEDANDO 9000.00
        // INICIO DE LAS CONDICIONES PARA VERIFICARA SI APLICA O NO SUBSIDIO
        if ($capacidadPago >= $costoVivienda) {
            // EN CASO QUE LA CAPACIDAD DE PAGO SEA MAYOR QUE EL COSTO DE LA VIVIENDA
            return '0';
        } else if ($ingresoFamiliar > 2 * $SM) {
            // EN CASO QUE EL INGRESO FAMILIAR SEA MAYOR A 2 SUELDOS MINIMOS 
            return '0';
        } else if ($ingresoFamiliar < $SM) {
            // EN CASO QUE EL INGRESO FAMILIAR SEA MENOR AL UN (1) MINIMOS : 25%
            return '0';
        } else {
            // EN CASO QUE NO APLICA NINGUNAS DE LA LAS ANTERIORES
            // BUSQUEDA QUE SE EJECUTYA PARA LISTAR TODOS LOS INTEGRANTES REGISTRADOS DEL BENEFICIARIO
//            $criteria = new CDbCriteria;
//            $criteria->addCondition('t.unidad_familiar_id = :unidad_familiar_id');
//            $criteria->params = array(':unidad_familiar_id' => $idUnidadFamiliar);
//            $grupoFamiliar = GrupoFamiliar::model()->findAll($criteria);
//
//            // DEFINICION DE VARIABLES. UTILIES PARA DETERMINAR EL TIPO DE SUBSIDO A APLICAR
//            $mayorEdad = 0;
//            $discapacidad = 0;
//            $menoresEdad = 0;
//            $conyugue = 0;
//
//            // INICIO BUCLE DE LA COSULTA DE  ($grupoFamiliar)
//            foreach ($grupoFamiliar AS $value) {
//                // CONSULTA DEL LA FECHA DE NACIMIENTO. CONSULTA ORIGEN DE ORACLE TABLE PERSONA 
//                $fechaNac = ConsultaOracle::setPersona("TO_CHAR(FECHA_NACIMIENTO, 'DD/MM/YYYY' ) AS fecha", $value->persona_id);
//                // CALCULO QUE GENERA LA EDDA A PARTIR DE LA FECHA DE NACIMIENTO
//                $edad = Generico::edad($fechaNac['FECHA']);
//
//                // SWITCH QUE EVALUA LA EDAD DE CADA INTEGRANTE DEL GRUPO FAMILIAR
//                switch ($edad) {
//                    case ($edad >= 60): //EN CASO QUE SEA > 60 AUTOINCREMENTE VARIABLE $mayorEdad , CON FIN DE DETERMINAR LA CANT DE PERSONA MAYORES DE 60 AÑOS
//                        $mayorEdad++;
//                        break;
//                    case ($edad < 18 && $value->gen_parentesco_id == 158):
//                        //EN CASO QUE SEA < 18 Y CON  PARENTESCO DE HIJO. AUTOINCREMENTE VARIABLE $menoresEdad , CON FIN DE DETERMINAR LA CANT DE HIJOS MENORES DE EDAD POSEE EL BENEFICIARIO
//                        $menoresEdad++;
//                        break;
//                }
//
//                if ($value->tipo_sujeto_atencion == 231)// CONDICION QUE DETERMINA SI EL INTEGRANTE POSEE UNA DISCAPACIDAD, AUTOINCREMENTO DE LA VARIABLE $discapacidad
//                    $discapacidad++;
//                if ($value->gen_parentesco_id == 155 || $value->gen_parentesco_id == 161) // CONDICION QUE DETERMINA EL PARENTESCO (CONYUGE, CONCUBINATO), AUTOINCREMENTO DE LA VARIABLE $conyugue
//                    $conyugue++;
//            } // FIN DEL BUCLE DE LOS INTEGRANTES DEL GRUPO FAMILIAR DEL BENEFICIARIO
//            // BOOLEAN QUE DETERMINA SI APLICA SUBSIDO DE ACUERDO A CONDICIONES PREVIAS -- TRUE= APLICA, FALSE= NO APLICA
//            if ($mayorEdad >= 2 || $discapacidad >= 1 || $menoresEdad > 3) {
//                $procesa = true;
//            } else if ($conyugue == 0 && $menoresEdad > 2) {
//                $procesa = true;
//            } else {
//                $procesa = false;
//            }

            // INICIO DE LAS CONDICIONES  PARA DETERMINAR LA CANTIDAD DEL PORCENTAJE QUE APLICARA EL SUBSIDIO 
//            if ($procesa) { // TRUE
                $ingresoFPor = $ingresoFamiliar / $SM; // CALCULO QUE DETERMINA LA CANTIDAD DE SUELDOS MINIMO QUE POSSE EL GRUPO FAMILIAR
                $valor = round($ingresoFPor, 1); // RFEDONDEA A UN DECIAMLES LA VARIABLE $ingresoFPor EXSMPLE (1.2)
                if ($valor >= 1 || $valor <= 2) { // CONDICIONAL QUE DETERMINA SI ESTA ENTRE EL RANGO DE 1 - 2 PARA QUE APLIQUE EL SUBSIDIO
                    $Subsidio = TablaSubsidio::model()->findByAttributes(array('ingreso_familiar_sm' => $valor)); // BUSQUEDA DEL PORCENTAJE DE SUBSIDIO A APPLICAR SEGUN RESULTADO DE VARIABLE $valor
                    return $Subsidio->subsidio_porcentaje; // RETURN DEL VALOR EN TABLA  subsidio_porcentaje SEGUN COINCIDENCIA
                } else {
                    return '0'; // RETUNRN 0 EN CASO QUE SEA MAYOR A 2.00 
                }
//            } else { // FALSE
//                return '0';
//            }
        }
    }

        /*
     *  Calculo de Reconocimiento de VIvienda Perdida
     */

    public function actionMontoReconocidoPerdidaVivienda($montoSdh) {

        return $montoSdh * 0.50;
    }

}
