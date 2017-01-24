<?php

class CalculosController extends Controller {
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
//                'actions' => array('CuotaFinancieraMaxima', 'MaximaCapacidadPago', 'CreditoSolicitado', 'FondoGarantia', 'MontoCoutaFinanciera', 'CreditoSolicitadoDamnificado', 'CreditoSolicitadoSae'),
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
     * Cuota Finaciera Máxima (35% IFM)
     */

    public function actionCuotaFinancieraMaxima($ingresoFamiliar) {
        return $ingresoFamiliar * 0.35;
    }

    /*
     * Maxima Capacidad Pago
     */

    public function actionMaximaCapacidadPago($interes, $anhios, $CuotaFinanaciadaMaxima) {
        $I = $interes / 12 / 100;
        $PREEXP = 1 + $I;
        $EXP = pow($PREEXP, -($anhios * 12));

        $MCP = $CuotaFinanaciadaMaxima * (1 - $EXP ) / $I;
        return $MCP;
    }

    /*
     * Monto Credito Requerido Damnificado
     */

    public function actionCreditoRequeridoDamnificado($restacostoAsubsidiar, $montoInical, $MontoReconocimientoVivienda) {
        return $restacostoAsubsidiar - $montoInical - $MontoReconocimientoVivienda;
    }

    /*
     * Monto Credito Requerido Sae
     */

    public function actionCreditoRequeridoSae($montoVivienda, $diferenciaPago) {
        return $montoVivienda - $diferenciaPago ;
    }

    /*
     * Cuota Inicial Fondo de Garantía (1,43%)
     */

    public function actionFondoGarantia($CreditoRequerido, $CreditoRequeCExtra = FALSE) {
        if (!$CreditoRequeCExtra) {
            return ($CreditoRequerido) * 0.0143;
        } else {
            return ($CreditoRequerido + $CreditoRequeCExtra) * 0.0143;
        }
    }

    /*
     * Monto couta financiera requerida
     */

    public function actionMontoCoutaFinanciera($tasaInteres, $anhios, $CreditoRequerido) {
        $I = (($tasaInteres / 12) / 100);
        $PREEXP = 1 + $I;
        $EXP = pow($PREEXP, -($anhios * 12));
        $MCF = ($I * $CreditoRequerido) / (1 - $EXP);
        return $MCF;
    }

    /*
     * Fondo de garantia mensual -$fongar=($creditorequerido*1,43%)/12 coutas por año
     */

    public function actionFondoGarantiaMensual($fongar) {
        return $fongar / 12;
    }

    /*
     * Couta total a pagar mensual
     */

    public function actionCoutaTotalMensual($montoCoutaFinanciera, $fondoGarantiaMensual) {
        return $montoCoutaFinanciera + $fondoGarantiaMensual;
    }

    //CALCULOS DE FAOV
    /*
     * fondo de garantia en faov
     */
    public function actionFondoGarantiaFaov($CreditoRequerido) {
        return $CreditoRequerido * 0.0143;
    }

    /*
     * Fondo de garantia mensual -$fongar=($capacidadpago*1,43%)/12 coutas por año
     */

    public function actionFondoGarantiaMensualfaov($fongarfaov) {
        return $fongarfaov / 12;
    }

    /*
     * MONTO DE CREDITO HIPOTECARIO SE CALCULA SI LA CAPACIDAD DE PAGO ES MAYOR
     * AL MONTO DE LA VIVIENDA
     */

    public function actionMontoCHMensual($montoVivienda, $montoInical) {
        return ($montoVivienda - $montoInical);
    }

    /*
     * couta mensuales Total a pagar $CuotaFinanciamientoMaximo + $fondoGarantiaMensual
     */

    public function actionCoutaMensualfaov($CuotaFinanciamientoMaximo, $fondoGarantiaMensual) {
        return (+$CuotaFinanciamientoMaximo + $fondoGarantiaMensual);
    }

    /*
     * CALCULOS DE CUOTAS EXTRAORDINARIAS PARA FASP Y FAOV 
     */

    /*
     * Maxima cuota financiera (cuotas extraordinarias)
     * $CuotaFinanciamientoMaximo * 2 cuotas semestrales
     */

    public function actionCoutaExtraEspecial($CuotaFinanciamientoMaximo) {
        return $CuotaFinanciamientoMaximo * 2;
    }

    /*
     * Maxima Capacidad Pago para aplicar 2 coutas extraordinarias semestral
     * $interes=4,66%
     * $anhios= plazo en años
     * $cuotaExtraEspecial= $cuotaFinanciamientoMaximo*2cuotasExtraordinarias
     */

    public function actionMaximaCapPagoCuotasExtra($interes, $anhios, $cuotaExtraEspecial) {
        $I = $interes / 2 / 100;
        $PREEXP = 1 + $I;
        $EXP = pow($PREEXP, -($anhios * 2));

        $MCP = $cuotaExtraEspecial * (1 - $EXP ) / $I;
        return $MCP;
    }

    /*
     * Monto couta financiera requerida para (cuotas extraordinarias)
     * $interes=4,66%
     * $anhios= plazo en años
     * $diferenciaPago=$montoVivienda - $capacidadPago
     */

    public function actionMontoCoutaFinancieraFaov($tasaInteres, $anhios, $diferenciaPago) {
        $I = (($tasaInteres / 2) / 100);
        $PREEXP = 1 + $I;
        $EXP = pow($PREEXP, -($anhios * 2));
        $MCF = ($I * $diferenciaPago) / (1 - $EXP);
        return $MCF;
    }

    /*
     * Fondo de garantia en fasp para coutas extraordinaria
     * $diferenciaPago= $montoVivienda - $CapacidadPago
     * tasafongar=1,43% = 0.0143
     * 2 cuotas extraordinarias
     */

    public function actionFondoGarantiaCExtra($diferenciaPago) {
        $fondoGarantiaCExtra = ($diferenciaPago * 0.0143) / 2;
        return $fondoGarantiaCExtra;
    }
    /*
     * Prima Inicial Fongar (Credito A Otorgar Por Cuotas Extraordinarias)
     * 
     */
    public function actionInicialFongarCExtra($diferenciaPago) {
        return $diferenciaPago * 0.0143;
    }


    
    }