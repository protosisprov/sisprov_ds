<?php

class AjaxController extends Controller {
    /**
     * @return array action filters
     * 
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
//                'actions' => array('TipoInterresAplicable', 'CalculoTasaAmortizacion'),
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

    /*
     * FUNCTION QUE DETERMINAL EL TIPO DE INTERES APLICABLE SEGUN CADA CASO
     */

    public function actionTipoInterresAplicable() {
        $SalarioFamiliar = (float) $_POST['SalarioFamiliar'];
//        $SueldoMinimo = str_replace(".", "", Maestro::model()->findByAttributes(array('padre' => 237, 'es_activo' => TRUE))->descripcion);
        $SueldoMinimo = str_replace(".", ",", SalarioMinimo::model()->findByAttributes(array('es_activo' => TRUE))->valor_salario);


        $cantidadSalarios = round($SalarioFamiliar / $SueldoMinimo);

        switch ($cantidadSalarios) {
            case ($cantidadSalarios >= 1 && $cantidadSalarios <= 4):
                $cantidad = 1;
                break;
            case ($cantidadSalarios > 4 && $cantidadSalarios <= 6):
                $cantidad = 2;
                break;
            case ($cantidadSalarios > 6 && $cantidadSalarios <= 8):
                $cantidad = 3;
                break;
            case ($cantidadSalarios > 8):
                $cantidad = 4;
                break;
        }
        echo CJSON::encode($cantidad);
    }

    /*
     * FUNCION QUE REALIZA TODOS LOS CALCULOS DE LA TABLA DE AMORTIZACION 
     * TANTO PARA FAOV , COMO PARA FASP
     * 
     */

    public function actionCalculoTasaAmortizacion() {
        $fuenteFinanciamineto = $_POST['fuenteFinanciamineto'];
        $programa = $_POST['programa'];
        $montoInical = $_POST['montoInical'];
        $montoVivienda = (float) $_POST['montoVivienda'];
        $idUnidadFamiliar = $_POST['idUnidadFamiliar'];
        $igresoFamiliar = $_POST['valorSalario'];
        $reconocimientoVivienda = $_POST['damnificado'];
        $tasaInteres = TasaInteres::model()->findByPk($_POST['tasaInteres'])->tasa_interes;
        $plazoCredito = $_POST['plazoCredito'];
        $fechaProtocolizacion = Generico::formatoFecha($_POST['fechaProtocolizacion']);
        $cuotasExtras = $_POST['cuotasExtras'];

        //MAXIMA CUOTA FINANCIERA  $ingresofamiliar * 35%
        $CuotaFinanciamientoMaximo = CalculosController::actionCuotaFinancieraMaxima($igresoFamiliar);
        //MAXIMA CAPACIDAD DE PAGO         
        $CapacidadPago = floatval(CalculosController::actionMaximaCapacidadPago($tasaInteres, $plazoCredito, $CuotaFinanciamientoMaximo));

        /* INICIO DE CONDIONES DE CALCULOS PARA FASP  */
        if ($fuenteFinanciamineto == '3') { // FUENTE DE FINANCIAMIENTO FASP
            //PORCENTAJE DEL SUBSIDIO QUE LE CORRESPONDE AL BENEFICIARIO , DE ACUERDO A LAS CONDICIONES  DE FINANCIAMIENTO
            $subsidio = FaspController::actionSubsidio($CapacidadPago, $montoVivienda, $idUnidadFamiliar, $igresoFamiliar);
            //SUBSIDIO DIRECTO HABITACIONAL QUE LE CORRESPONDE AL BENEFICIARIO            
            if ($subsidio == '0') {
                $costoASubsidiar = 0.00;
            } else {
                $costoASubsidiar = $montoVivienda * ($subsidio / 100);
            }


            //DIFERENCIA DE PAGO ENTRE LA CAPACIDAD DE PAGO Y EL MONTO DE LA VIVIENDA
            if ($CapacidadPago >= $montoVivienda) {
                $diferenciaPago = 0.00;
            } else if ($CapacidadPago < $montoVivienda) {
                $diferenciaPago = (-($CapacidadPago - $montoVivienda)) * 1;
            }

            //MONTO RESTANTE DEL PRECIO DE LA VIVIENDA Y EL SUDSIDIO DIRECTO HABITACIONAL
            if ($diferenciaPago < $costoASubsidiar) {
                $restacostoAsubsidiar = $montoVivienda - $montoInical - $diferenciaPago;
            } else {
                $restacostoAsubsidiar = $montoVivienda - $montoInical - $costoASubsidiar;
            }


            /*
             * CONDICION SI ES DIGNIFICADO APLICA EL 50% / SOBRE EL MONTO RESTANTE 
             * SI EN EL CENSO SE CARGO COMO (140)CENSO REFUGIADOS
             */
            if ($reconocimientoVivienda == '1') {
                $MontoReconocimientoVivienda = FaspController::actionMontoReconocidoPerdidaVivienda($restacostoAsubsidiar);
                //NUEVO MONTO CREDITO REQUERIDO     
                $CreditoRequerido = CalculosController::actionCreditoRequeridoDamnificado($restacostoAsubsidiar, $montoInical, $MontoReconocimientoVivienda);
            } else {
                $MontoReconocimientoVivienda = 0.00;
                // NUEVO MONTO CREDITO REQUERIDO
                $CreditoRequerido = CalculosController::actionCreditoRequeridoSae($montoVivienda, $diferenciaPago);
            }

            /*
             * NUEVO CREDITO REQUERIDO PARA CUOTAS EXTRAORDINARIAS
             */
            if (($CreditoRequerido + $costoASubsidiar) < $montoVivienda) {
                $CreditoRequeCExtra = $montoVivienda - $CreditoRequerido - $costoASubsidiar;
            } else {
                $CreditoRequeCExtra = 0.00;
            }
            if ($cuotasExtras == 'true') {

                $fongar = CalculosController::actionFondoGarantia($CreditoRequerido, $CreditoRequeCExtra);
                $fongar_2 = CalculosController::actionFondoGarantia($CreditoRequerido);
                
            } else {
                $fongar_2 = CalculosController::actionFondoGarantia($CreditoRequerido);
                //CUOTA  INICIAL FONGAR $creditorequerido + $creditorequeridocuotasestras *1,43%
                $fongar = CalculosController::actionFondoGarantia($CreditoRequerido);
            }
            //MONTO CUOTA FINANCIERA REQUERIDA
            $montoCoutaFinanciera = CalculosController::actionMontoCoutaFinanciera($tasaInteres, $plazoCredito, $CreditoRequerido);
            //FONDO DE GARANTIA MENSUAL   $creditoRequerido * 1,43%/ 12 cuotas al año 
            $fondoGarantiaMensual = CalculosController:: actionFondoGarantiaMensual($fongar_2);
            //CUOTA TOTAL A PAGAR MENSUAL $montoCoutaFinanciera + $fondoGarantiaMensual
            $cuotaMensual = CalculosController::actionCoutaTotalMensual($montoCoutaFinanciera, $fondoGarantiaMensual);
            // % MAXIMA CUOTA FINANCIERA (> 35%)
            $maximacoutafinan = ($montoCoutaFinanciera / $igresoFamiliar) * 100;

            /*
             * CUOTAS EXTRAORDINARIAS
             * si el credito requerido y el subsidio directo no cubre el precio de la vivienda se 
             * se calcula las cuotas extraordinarias  
             */


            if ($cuotasExtras == 'true') {
                if ($CreditoRequerido <= $restacostoAsubsidiar) {
                    //CUOTAS FINANCIERA MAXIMA PARA CUOTAS EXTRAORDINARIAS (2 coutas al año) 
                    $cuotaExtraEspecial = CalculosController::actionCoutaExtraEspecial($CuotaFinanciamientoMaximo);
                    //CAPACIDAD DE PAGO PARA 2 CUOTAS EXTRAORDINARIAS 
                    $capacidadPagoExtra = CalculosController::actionMaximaCapPagoCuotasExtra($tasaInteres, $plazoCredito, $cuotaExtraEspecial);
                    // FONDO DE GARANTIA SEMESTRAL C/U(2coutas extraordinarias) DE ACUERDO AL NUEVO CREDITO REQUERIDO
                    $fondoGarantiaCExtra = CalculosController::actionFondoGarantiaCExtra($CreditoRequeCExtra);
                    /*
                     * MONTO DE LA CUOTA FINANCIERA REQUERIDA POR 2 CUOTAS EXTRAORDINARIAS 
                     * $plazoCredito = cantidad de años 
                     * $tasa interes aplicable
                     * $CreditoRequeridoCExtra = montoVivienda - $CreditoReuerido() - $costoAsubsidiar(subsioAplicable)
                     */
                    $CuotaFinancieraCExtra = CalculosController::actionMontoCoutaFinancieraFaov($tasaInteres, $plazoCredito, $CreditoRequeCExtra);
                    //CUOTA TOTAL A PAGAR SEMESTRAL 
                    $cuotaTotal = $CuotaFinancieraCExtra + $fondoGarantiaCExtra;
                } else {
                    $cuotaExtraEspecial = 0.00;
                    $capacidadPagoExtra = 0.00;
                    $fondoGarantiaCExtra = 0.00;
                    $CuotaFinancieraCExtra = 0.00;
                    $cuotaTotal = 0.00;
                }
            } else {
                $cuotaExtraEspecial = 0;
                $cuotaExtraEspecial = 0.00;
                $capacidadPagoExtra = 0.00;
                $fondoGarantiaCExtra = 0.00;
                $CuotaFinancieraCExtra = 0.00;
                $cuotaTotal = 0.00;
            }


            $totalCreditoSDH = $CapacidadPago + $capacidadPagoExtra + $MontoReconocimientoVivienda + $costoASubsidiar;

            $data = array(
                'cantidadDisponible' => number_format($totalCreditoSDH, 2, ',', ''),
                'coutaFinanciamientoMaxima' => number_format($CuotaFinanciamientoMaximo, 2, ',', '.'),
                'plazoMeses' => $plazoCredito * 12,
                'capacidadPago' => number_format($CapacidadPago, 2, ',', '.'),
                'subsidioCorreponde' => $subsidio . '%',
                'subsidioMaximo' => number_format($costoASubsidiar, 2, ',', '.'),
                'diferenciaPago' => number_format($diferenciaPago, 2, ',', '.'),
                'restaCostoAsudsidiar' => number_format($restacostoAsubsidiar, 2, ',', '.'),
                'reconocimientoViviendaPerdida' => number_format($MontoReconocimientoVivienda, 2, ',', '.'),
                'creditoRequerido' => number_format($CreditoRequerido, 2, ',', '.'),
                'coutaInicialFongar' => number_format($fongar, 2, ',', ''),
                'montoCoutaFinaciera' => number_format($montoCoutaFinanciera, 2, ',', '.'),
                'tasaFongar' => '1,43%',
                'fondoGarantiaMensual' => number_format($fondoGarantiaMensual, 2, ',', '.'),
                'coutaMensualPagar' => number_format($cuotaMensual, 2, ',', '.'),
                'maxCoutaFinan' => ((number_format($maximacoutafinan, 0, ',', '')) > 35) ? '35%' : number_format($maximacoutafinan, 0, ',', '') . '%',
                'cuotaExtraEspecial' => number_format($cuotaExtraEspecial, 2, ',', '.'),
                'capacidadPagoExtra' => number_format($capacidadPagoExtra, 2, ',', '.'),
                'fondoGarantiaCExtra' => number_format($fondoGarantiaCExtra, 2, ',', '.'),
                'cuotaTotal' => number_format($cuotaTotal, 2, ',', '.'),
            );
            echo json_encode($data);

            /* INICIO CONDICIONES PARA CALCULOS DE FAOV */
        } else if ($fuenteFinanciamineto == '2') {  // FUENTE DE FINANCIAMIENTO FAOV
            //$Credito Requerido es el Monto del credito Hipotecarioa a Otorgar Cuotas Mensuales 
            if ($CapacidadPago > $montoVivienda) {
                $CreditoRequerido = CalculosController::actionMontoCHMensual($montoVivienda, $montoInical);
            } else {
                $CreditoRequerido = $CapacidadPago;
            }
            // fondo de garantia para faov
            $fongarfaov = CalculosController::actionFondoGarantiaFaov($CreditoRequerido);
            //fondo de garantia 
            $fondoGarantiaMensual = CalculosController::actionFondoGarantiaMensualfaov($fongarfaov);
            //monto couta financiera requerida
            $montoCoutaFinanciera = CalculosController::actionMontoCoutaFinanciera($tasaInteres, $plazoCredito, $CreditoRequerido);
            //couta mensuales Total a pagar $CuotaFinanciamientoMaximo + $fondoGarantiaMensual
            $cuotaMensual = CalculosController::actionCoutaMensualfaov($montoCoutaFinanciera, $fondoGarantiaMensual);
            //% de la couta financiera en relacion al ingreso familiar lo maximo sera el 35%
            $maximacoutafinan = ($montoCoutaFinanciera / $igresoFamiliar) * 100;
            //Prima inicial fongar $CreditoRequerido * $tasafongar
            $fongar = CalculosController::actionFondoGarantia($CreditoRequerido);
            //Comision flat $CreditoRequerido * 5%
            $comisionFlat = FaovController::actionComisionFlat($CreditoRequerido);
            //diferencia de pago -> Monto Credito Hipotecario A otorgar(Cuotas Extraordinarias)
            
            $diferenciaPago = $montoVivienda - $CapacidadPago - $montoInical;
            if ($diferenciaPago< 0){
                
                $diferenciaPago = ($montoVivienda - $CapacidadPago - $montoInical) *-1;
            }
            //$cuotasExtras swich para indicar si desea aplicar las cuotas extraordinarias
            if ($cuotasExtras == 'true') {
                //Maxima cuota Financiera * 2 cuotas extraordinarias 
                $maxCuotafina = CalculosController::actionCoutaExtraEspecial($CuotaFinanciamientoMaximo);
                //Nueva capacidad de pago con 2 cuotas extraordinarias
                $capacidadPagoExtra = CalculosController::actionMaximaCapPagoCuotasExtra($tasaInteres, $plazoCredito, $maxCuotafina);
                //Cuota Financiera Requerida (para 2 cuotas extraordinarias) 
                $montoCoutaFinanExtra = CalculosController::actionMontoCoutaFinancieraFaov($tasaInteres, $plazoCredito, $diferenciaPago);
                //Fondo Garantia para cuotas extraordinarias
                $fondoGarantiaCExtra = CalculosController::actionFondoGarantiaCExtra($diferenciaPago);
                //cuota semestral a total a pagar
                $totalSemestral = $montoCoutaFinanExtra + $fondoGarantiaCExtra;
                //prima inicial fongar $difereciaPago * 1,43% tasafongar 
                $primaInicialFongar = CalculosController::actionInicialFongarCExtra($diferenciaPago);


                if ($diferenciaPago > $capacidadPagoExtra) {

                    //Subsidio Directo Habitacional 25% del pvp
                    $subsidioDHPvp = FaovController::actionSubsidioDH($montoVivienda);
                    //Subsidio Directo Habitacional Requerido 
                    $subsidioRequerido = FaovController::actionSubsidioDHRequerido($montoVivienda, $CreditoRequerido, $capacidadPagoExtra);


                    //Monto Total del Credito  y subsidio // suma de la maxima capacidad de pago + nueva capacidad de pago con cuotaExtra + Subsidio al credito25%pvp
                    $totalCreditoSDH = FaovController::actionTotalCreditoSubsidioDH($CreditoRequerido, $capacidadPagoExtra, $subsidioDHPvp);
                    $totalCreditoSDH = $totalCreditoSDH + $montoInical;
                    //Monto total Credito A otorgar (Cuotas Mensuales y Extraordinarias mas el subsidio)
                    $totalCSDHExtra = $CreditoRequerido + $diferenciaPago;
                } else {
                    $subsidioDHPvp = 0.00;
                    $subsidioRequerido = 0.00;
                    $totalCreditoSDH = 0.00;
                    $totalCSDHExtra = 0.00;
                }
                $h = '';
            } else {
                $h = '';
                $maxCuotafina = 0.00;
                $capacidadPagoExtra = 0.00;
                $montoCoutaFinanExtra = 0.00;
                $fondoGarantiaCExtra = 0.00;
                $totalSemestral = 0.00;
                $primaInicialFongar = 0.00;

                $subsidioDHPvp = 0.00;
                $totalCreditoSDH = FaovController::actionTotalCreditoSubsidioDH($CreditoRequerido, $capacidadPagoExtra, $subsidioDHPvp);
                $totalCreditoSDH = $totalCreditoSDH + $montoInical;
                $subsidioRequerido = 0.00;
                $totalCSDHExtra = 0.00;
            }


            $data = array(
                'cantidadDisponible' => number_format($totalCreditoSDH, 2, ',', ''),
                'coutaFinanciamientoMaxima' => number_format($CuotaFinanciamientoMaximo, 2, ',', '.'), //maxima couta financiera
                'plazoMeses' => $plazoCredito * 12,
                'capacidadPago' => number_format($CapacidadPago, 2, ',', '.'), // monto credito al largo plazo
                'diferenciaPago' => number_format($diferenciaPago, 2, ',', '.'),
                'creditoRequerido' => number_format($CreditoRequerido, 2, ',', '.'),
                'maxCoutaFinan' => ((number_format($maximacoutafinan, 0, ',', '')) > 35) ? '30%' : number_format($maximacoutafinan, 0, ',', '') . '%',
                'montoCoutaFinaciera' => number_format($montoCoutaFinanciera, 2, ',', '.'),
                'fondoGarantiaMensual' => number_format($fondoGarantiaMensual, 2, ',', '.'),
                'coutaMensualPagar' => number_format($cuotaMensual, 2, ',', '.'),
                'coutaInicialFongar' => number_format($fongar, 2, ',', '.'),
                'comisionFlat' => number_format($comisionFlat, 2, ',', '.'),
                'tasaFongar' => '1,43%',
                'maxCuotafina' => number_format($maxCuotafina, 2, ',', '.'),
                'capacidadPagoExtra' => number_format($capacidadPagoExtra, 2, ',', '.'),
                'montoCoutaFinanExtra' => number_format($montoCoutaFinanExtra, 2, ',', '.'),
                'fondoGarantiaCExtra' => number_format($fondoGarantiaCExtra, 2, ',', '.'),
                'totalSemestral' => number_format($totalSemestral, 2, ',', '.'),
                'subsidioDHPvp' => number_format($subsidioDHPvp, 2, ',', '.'),
                'subsidioRequerido' => number_format($subsidioRequerido, 2, ',', '.'),
                'h' => $h,
            );
            echo json_encode($data);
        }
    }

}
