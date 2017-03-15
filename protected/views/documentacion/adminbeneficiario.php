<?php

$baseUrl = Yii::app()->baseUrl;
$validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');

function traza($iD) {
    $traza = Traza::getTraza($iD);
    return $traza;
}

/*
 * VERIFICA SI EXISTE UN DOCUMENTO CREADO
 */

function DocumentoExist($iD) {
    if (Documentacion::model()->exists('fk_beneficiario=:fk_beneficiario AND es_multi=:es_multi', array(':fk_beneficiario' => $iD, ':es_multi' => false))) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//function DocumentoImprimir($iD) {
//    if (Documentacion::model()->exists('fk_beneficiario=:fk_beneficiario AND es_multi=:es_multi', array(':fk_beneficiario' => $iD, ':es_multi' => false, ':estatus' => 293, ':ente_documento' => 1))) {
//        return TRUE;
//    } else {
//        return FALSE;
//    }
//}

function DocumentoExistMulti2($iD) {
    $sql = 'SELECT * FROM documentacion WHERE fk_beneficiario=' . $iD . ' AND (tipo_documento_id!=88 or  tipo_documento_id!=277)  AND registro_documento_id IS NULL';
    $query = Yii::app()->db->createCommand($sql)->queryAll();
    if ($query != null)
        return TRUE;
    else
        return FALSE;
}

function nombre($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_NOMBRE'];
}

function apellido($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_APELLIDO'];
}

function GenerarDocumento($id) {
    $beneficiario = Beneficiario::model()->findByPk($id);
    if (Documentacion::model()->exists('fk_beneficiario=:fk_beneficiario AND es_multi=:es_multi', array(':fk_beneficiario' => $beneficiario->beneficiarioTemporal->unidadHabitacional->id_unidad_habitacional, ':es_multi' => true))) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function EstatusDocumentoAprobado($id_beneficiario) {
    $sql_documento = 'select * from beneficiario t join documentacion a ON a.fk_beneficiario =' . $id_beneficiario . 'where a.estatus = 293';
    $queryy = Yii::app()->db->createCommand($sql_documento)->queryScalar();

//    var_dump($queryy);die;

    if ($queryy != null) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function EstatusDocumentoDevuelto($id_beneficiario) {
    $sql_documento = 'select * from beneficiario t join documentacion a ON a.fk_beneficiario =' . $id_beneficiario . 'where a.estatus = 294';
    $queryy = Yii::app()->db->createCommand($sql_documento)->queryScalar();

//    var_dump($queryy);die;

    if ($queryy != null) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function ColorEstatus($color) {


    switch ($color) {
        case "VALIDADO POR SAREN":
            $color = 'aprobado';
            break;
        case "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)":
            $color = 'devuelto';
            break;
        case "VALIDADO POR BANAVIH (EN ESPERA DE SAREN)":
            $color = 'espera';
            break;
        case 4:
            $color = 'white';
            break;
    }
    return $color;
}
?>


<style>


    .aprobado
    {
        background: #CEF6F5 !important;
    }

    .devuelto {
        background:#F5A9BC !important;
        /*color:#514721 !important;*/
    }
    .espera {
        background:#F5F6CE !important;
        /*color:#514721 !important;*/
    }

</style>

<!--<h1 class="text-center">Documentación Beneficiario</h1>-->
<h1 class="text-center">Proceso de Documentación del Beneficiario</h1>


<div class="row">

    <div class="col-md-4" >

        <table class="table">
            <!--<tr >-->

            <!--</tr>--> 
            <tr bgcolor="#CEF6F5"><font color="black"><B><center>Leyenda Estatus Documento</center></font></tr>
                <tr>
                    <td bgcolor="#CEF6F5"><font color="black"><center>VALIDADO</center></font></td>
                <td bgcolor="#F5F6CE"><font color="BLACK"><center>EN ESPERA</center></font></td>
                <td bgcolor="#F5A9BC"><font color="BLACK"><center>DEVUELTO</center></font></td>
                </tr> 
        </table>
    </div>
</div>

<?php

$model->estatus_beneficiario_id = 271;
//if(Yii::app()->user->checkAccess("analista_documentacion")){
//    $DataProviderGridUNI = new CActiveDataProvider('Beneficiario', array(
//        'criteria' => array(
//            'order' => 't.id_beneficiario ASC',
//            'join' => 'join beneficiario_temporal tmp ON t.beneficiario_temporal_id = tmp.id_beneficiario_temporal
//                       join vsw_asignaciones_documentos doc ON doc.fk_caso_asignado = tmp.unidad_habitacional_id and doc.es_activo=true
//                       ',
//            //'condition' => 'doc.fk_usuario_asignado ='.Yii::app()->user->id,
//        ),
//        'pagination' => array('pageSize' => Yii::app()->user->getState('pageSize', 10),),
//            )
//            );
//}else if(Yii::app()->user->checkAccess("administrador_documentacion")){
//    $DataProviderGridUNI =$model->search();
//}

//$model->estatus_beneficiario_id = 269;
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'beneficiario-grid',
    'dataProvider' => $model->searchBeneficiariosDocumentacion(),
    'filter' => $model,
    'type' => 'striped bordered condensed',
//    'dataProvider' => $DataProviderGridUNI,
    'columns' => array(
//        array(
//            'name' => 'id_beneficiario',
//            'header' => 'N°',
//            'value' => '$data->id_beneficiario',
//            'htmlOptions' => array('style' => 'text-align: center', 'width' => '90px'),
//        ),
        'cedula_rel' =>array(
            'name' => 'cedula_rel',
            'header' => 'Cédula',
            'value' => '$data->beneficiarioTemporal->cedula',
        ),
        array(
            'name' => 'persona_id',
            'header' => 'Nombre',
            'value' => 'nombre("PRIMER_NOMBRE",$data->persona_id)',
            'filter' => false,
            'sortable' => false
        ),
        array(
            'name' => 'persona_id',
            'header' => 'Apellido',
            'value' => 'apellido("PRIMER_APELLIDO",$data->persona_id)',
            'filter' => false,
            'sortable' => false
        ),
        'Estado' => array(
            'header' => 'Estado',
            'name' => 'estado_rel',
            'value' => 'Tblparroquia::model()->findByPK(Desarrollo::model()->findByPK($data->beneficiarioTemporal->desarrollo_id)->parroquia_id)->clvmunicipio0->clvestado0->strdescripcion',
            'filter' => CHtml::listData(Tblestado::model()->findall(), 'clvcodigo', 'strdescripcion'),
        ),
//        'Desarrollo' => array(
//            'header' => 'Desarrollo',
//            'name' => 'beneficiarioTemporal',
//            'value' => '$data->beneficiarioTemporal->desarrollo->nombre',
//            'filter' => CHtml::listData(Desarrollo::model()->findall(), 'id_desarrollo', 'nombre'),
//        ),
        'Desarrollo' => array(
            'header' => 'Desarrollo',
            'name' => 'desarrollo_rel',
            'value' => '$data->beneficiarioTemporal->desarrollo->nombre',
            'filter' => CHtml::listData(Desarrollo::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
//        'Unidad Habitacional' => array(
//            'header' => 'UNIDAD<br/>MULTIFAMILIAR',
//            'name' => 'beneficiarioTemporal',
//            'value' => '$data->beneficiarioTemporal->unidadHabitacional->nombre',
//            'filter' => CHtml::listData(UnidadHabitacional::model()->findall(), 'id_unidad_habitacional', 'nombre'),
//        ),
        'Unidad_multifamiliar' => array(
            'header' => 'UNIDAD<br/>MULTIFAMILIAR',
            'name' => 'unidad_multifamiliar_rel',
            'value' => '$data->beneficiarioTemporal->unidadHabitacional->nombre',
            'filter' => CHtml::listData(UnidadHabitacional::model()->findall(), 'id_unidad_habitacional', 'nombre'),
        ),
        'n_vivienda_piso' => array(
            'header' => 'N° Vivienda/Piso',
            'name' => 'n_vivienda_piso_rel',
            'value' => ('$data->beneficiarioTemporal->vivienda->nro_piso')!=""?'"N° ". $data->beneficiarioTemporal->vivienda->nro_vivienda." / Piso. ".$data->beneficiarioTemporal->vivienda->nro_piso':'"N° ".$data->beneficiarioTemporal->vivienda->nro_vivienda',
            //'filter' => CHtml::listData(UnidadHabitacional::model()->findall(), 'id_unidad_habitacional', 'nombre'),
            'filter' => false
        ),
        array(
            'header' => 'Estatus Documento',
            'name' => 'estatus_msj',
            'value' => '$data->estatus_msj',
            'cssClassExpression' => 'ColorEstatus($data["estatus_msj"])',
            'filter' =>  array('VALIDADO POR SAREN'=>"VALIDADO POR SAREN","VALIDADO POR BANAVIH (EN ESPERA DE SAREN)"=>"VALIDADO POR BANAVIH (EN ESPERA DE SAREN)","DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)"=>"DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)"),
//            'filter' => CHtml::listData(Desarrollo::model()->findall(), 'id_desarrollo', 'nombre'),
            'sortable' => false
        ),
//            'estatus' => array(
//           // 'header' => 'Estatus',
//            'name' => 'estatus',
//            'value' => 'VswAsignacionesDocumentos::buscarEstatus($data->id_beneficiario)',
//            //'filter' => CHtml::listData(TempCensoValidadoFaovFasp::model()->findall(), 'id_desarrollo', 'nombre'),
//        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'visible' => (Yii::app()->user->checkAccess("analista_documentacion")),
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{ver}{documento}{Genratedocumento}{imprimir}',
            'buttons' => array(
                'ver' => array(
                    'label' => 'Ver',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_beneficiario_view")))',
                    'url' => 'Yii::app()->createUrl("beneficiario/view/", array("id"=>$data->id_beneficiario))',
                ),
                'documento' => array(
                    'label' => 'Editar Documento',
                    'icon' => 'glyphicon glyphicon-list-alt',
                    'size' => 'medium',
//                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_documento")))',
                    'visible' => '($data["estatus_msj"] == "") && (Yii::app()->user->checkAccess("action_vivienda_documento")) && GenerarDocumento($data->id_beneficiario) && DocumentoExist($data->id_beneficiario) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data->id_beneficiario) && EstatusDocumentoDevuelto($data->id_beneficiario) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data->id_beneficiario) && EstatusDocumentoDevuelto($data->id_beneficiario)',
                    'url' => 'Yii::app()->createUrl("vivienda/documento/", array("id"=>$data->id_beneficiario))',
                ),
                'Genratedocumento' => array(
                    'label' => 'Generar Documento',
                    'icon' => 'glyphicon glyphicon-pencil',
                    'size' => 'medium',
                    'visible' => '($data["estatus_msj"] == "") && ((Yii::app()->user->checkAccess("action_vivienda_documento")) && GenerarDocumento($data->id_beneficiario) && !DocumentoExist($data->id_beneficiario) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data->id_beneficiario)&& EstatusDocumentoDevuelto($data->id_beneficiario))',
                    'url' => 'Yii::app()->createUrl("documentacion/generar/", array("id"=>$data->id_beneficiario))',
                ),
                'imprimir' => array(
                    'label' => 'Imprimir Documento',
                    'icon' => 'glyphicon glyphicon-print',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("documentacion/pdf", array("id"=>$data->id_beneficiario))',
                    'options' => array("target" => "_blank"),
                    'visible' => 'DocumentoExist($data->id_beneficiario) && EstatusDocumentoAprobado($data->id_beneficiario) && !EstatusDocumentoDevuelto($data->id_beneficiario) || ($data["estatus_msj"] == "VALIDADO POR SAREN")'
                ),
                'registral' => array(
                    'label' => 'Datos Magistrales',
                    'icon' => 'glyphicon glyphicon-folder-open',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("desarrollo/registralBeneficiario", array("id"=>$data["id_beneficiario"]))',
                    //'options' => array("target" => "_blank"),
                    'visible' => 'DocumentoExistMulti2($data["id_beneficiario"]);'
                ),
//                'tablaamortizacion' => array(
//                    'label' => 'Descargar Tabla de Amortización',
//                    'icon' => 'glyphicon glyphicon-download-alt',
//                    'size' => 'medium',
//                    'visible' => '((Yii::app()->user->checkAccess("action_analisiscredito_tablaAmortizacionpdf")))',
//                    'url' => 'Yii::app()->createUrl("/analisisCredito/tablaAmortizacionpdf/", array("id"=>$data->id_beneficiario))',
//                ),
//                'validar' => array(
//                    'label' => 'Validar',
//                    'icon' => 'ok',
//                    'size' => 'medium',
//                    'options' => array('style' => 'margin-left:28px;',),
//                    'url' => '$data["id_beneficiario"]',
//                    'click' => 'js: function(s){CambiarEstatusDocumento($(this).attr("href"), 1 ,3); return false; }',
//                    'visible' => '($data["estatus_msj"] == "") && DocumentoExist($data->id_beneficiario) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data->id_beneficiario) && EstatusDocumentoDevuelto($data->id_beneficiario) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data->id_beneficiario) && EstatusDocumentoDevuelto($data->id_beneficiario)',
//                    'options' => array(
//                        'style' => 'margin-left:17px;', 'id' => 'cambiarEstatus'
//                    ),
//                ),
            ),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'visible' => (Yii::app()->user->checkAccess("administrador_documentacion")),
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{ver}{validar} {documento}',
            'buttons' => array(
                'ver' => array(
                    'label' => 'Ver',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_beneficiario_view")))',
                    'url' => 'Yii::app()->createUrl("beneficiario/view/", array("id"=>$data->id_beneficiario))',
                ),
//                'imprimir' => array(
//                    'label' => 'Imprimir Documento',
//                    'icon' => 'glyphicon glyphicon-print',
//                    'size' => 'medium',
//                    'url' => 'Yii::app()->createUrl("documentacion/pdf", array("id"=>$data->id_beneficiario))',
//                    'options' => array("target" => "_blank"),
//                    'visible' => 'DocumentoExist($data->id_beneficiario) && EstatusDocumentoAprobado($data->id_beneficiario) && !EstatusDocumentoDevuelto($data->id_beneficiario) || ($data["estatus_msj"] == "VALIDADO POR SAREN")'
//                ),
//                'tablaamortizacion' => array(
//                    'label' => 'Descargar Tabla de Amortización',
//                    'icon' => 'glyphicon glyphicon-download-alt',
//                    'size' => 'medium',
//                    'visible' => '((Yii::app()->user->checkAccess("action_analisiscredito_tablaAmortizacionpdf")))',
//                    'url' => 'Yii::app()->createUrl("/analisisCredito/tablaAmortizacionpdf/", array("id"=>$data->id_beneficiario))',
//                ),
                'validar' => array(
                    'label' => 'Validar',
                    'icon' => 'ok',
                    'size' => 'medium',
                    'options' => array('style' => 'margin-left:28px;',),
                    'url' => '$data["id_beneficiario"]',
                    'click' => 'js: function(s){CambiarEstatusDocumento($(this).attr("href"), 1 ,3); return false; }',
                    'visible' => '($data["estatus_msj"] == "") && DocumentoExist($data->id_beneficiario) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data->id_beneficiario) && EstatusDocumentoDevuelto($data->id_beneficiario) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data->id_beneficiario) && EstatusDocumentoDevuelto($data->id_beneficiario)',
                    'options' => array(
                        'style' => 'margin-left:17px;', 'id' => 'cambiarEstatus'
                    ),
                ),
                'documento' => array(
                    'label' => 'Ver Documento',
                    'icon' => 'glyphicon glyphicon-list-alt',
                    'size' => 'medium',
//                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_documento")))',
                    'visible' => '($data["estatus_msj"] == "") && (Yii::app()->user->checkAccess("action_vivienda_documento")) && GenerarDocumento($data->id_beneficiario) && DocumentoExist($data->id_beneficiario) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data->id_beneficiario) && EstatusDocumentoDevuelto($data->id_beneficiario) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data->id_beneficiario) && EstatusDocumentoDevuelto($data->id_beneficiario)',
                    'url' => 'Yii::app()->createUrl("vivienda/documento/", array("id"=>$data->id_beneficiario))',
                ),
            ),
        ),
    ),
));
?>
<?php
//$this->endWidget(); ?>