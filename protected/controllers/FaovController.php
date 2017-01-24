<?php

class FaovController extends Controller {
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
//                'actions' => array('Subsidio'),
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
     * Comision Flat $CreditoRequerido * 5%
     */

    public function actionComisionFlat($CreditoRequerido) {
        return $CreditoRequerido * 0.005;
    }

    //CALCULOS DE SUBSIDIO PARA FAOV
    /*
     * subsidio directo habitacional  por el 25%
     */

    public function actionSubsidioDH($montoVivienda) {
        return $montoVivienda * 0.25;
    }

    /*
     * Subsidio Directo Habitacional Requerido
     * $montoVivienda = Precio de la vivienda
     * $CreditoRequerido = Monto del credito Hipotecarioa a Otorgar en  Cuotas Mensuales 
     * $capacidadPagoExtra = aplicada con las dos cuotas extraordinarias
     */

    public function actionSubsidioDHRequerido($montoVivienda, $CreditoRequerido, $capacidadPagoExtra) {
        $suma = $CreditoRequerido + $capacidadPagoExtra;
        $subsidioRequerido = ($montoVivienda - $suma);
        return $subsidioRequerido;
    }

    /*
     * Monto Total de Creditos y Subsidio
     */

    public function actionTotalCreditoSubsidioDH($CreditoRequerido, $capacidadPagoExtra, $subsidioDHPvp) {
        $totalCreditoSDH = $CreditoRequerido + $capacidadPagoExtra + $subsidioDHPvp;
        return $totalCreditoSDH;
    }

}
