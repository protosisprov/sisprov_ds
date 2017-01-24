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
//var_dump($estado);die;
function DocumentoExistMulti2($iD) {
    $sql = "SELECT * FROM documentacion WHERE fk_beneficiario=" . $iD . " AND (tipo_documento_id!=88 or  tipo_documento_id!=277) AND  registro_documento_id IS NULL";
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
    if (Documentacion::model()->exists('fk_beneficiario=:fk_beneficiario AND es_multi=:es_multi', array(':fk_beneficiario' => $beneficiario->beneficiarioTemporal->desarrollo->id_desarrollo, ':es_multi' => true))) {
        return TRUE;
    } else {
        return FALSE;
    }
} 
?>

<h1 class="text-center">Gestión Documentación Beneficiario Saren</h1>
<?php

$model->estatus_beneficiario_id = 271;

$this->widget('booster.widgets.TbGridView', array(
    'id' => 'beneficiario-grid-2',
    'dataProvider' => new CActiveDataProvider('Beneficiario', array(
        'criteria' => array(
//            'order' => 't.id_beneficiario ASC',
            'join' => 'JOIN documentacion a ON a.fk_beneficiario = t.id_beneficiario 
                        JOIN beneficiario_temporal bt ON bt.id_beneficiario_temporal = t.beneficiario_temporal_id
                        JOIN desarrollo d ON d.id_desarrollo = desarrollo_id
                        JOIN vsw_sector sec ON sec.cod_parroquia = d.parroquia_id',
            'condition' => "a.estatus = 292 and es_activo = true and ente_documento = 311 and sec.estado = '".$estado."'",
        ),
        'pagination' => array('pageSize' => Yii::app()->user->getState('pageSize', 10),),
            )),
    'type' => 'striped bordered condensed',
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_beneficiario',
            'header' => 'N°',
            'value' => '$data->id_beneficiario',
            'htmlOptions' => array('style' => 'text-align: center', 'width' => '90px'),
        ),
        array(
            'name' => 'persona_id',
            'header' => 'Nombre',
            'value' => 'nombre("PRIMER_NOMBRE",$data->persona_id)',
        ),
        array(
            'name' => 'persona_id',
            'header' => 'Apellido',
            'value' => 'apellido("PRIMER_APELLIDO",$data->persona_id)',
        ),
        'Estado' => array(
            'header' => 'Estado',
            'name' => 'beneficiarioTemporal',
            'value' => 'Tblparroquia::model()->findByPK(Desarrollo::model()->findByPK($data->beneficiarioTemporal->desarrollo_id)->parroquia_id)->clvmunicipio0->clvestado0->strdescripcion',
//            'value' => 'Estado($data->id_beneficiario)',
//            'filter' => CHtml::listData(Tblestado::model()->findall("strdescripcion='$estado'"), 'clvcodigo', 'strdescripcion'),
        ),
        'Desarrollo' => array(
            'header' => 'Desarrollo',
            'name' => 'beneficiarioTemporal',
            'value' => '$data->beneficiarioTemporal->desarrollo->nombre',
//            'filter' => CHtml::listData(Desarrollo::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
//        array(
//            'class' => 'booster.widgets.TbEditableColumn',
//            'name' => 'observacion',
//            'header' => 'Observaciones',
//            'htmlOptions' => array('style' => 'text-align:center', 'title' => 'Indeque alguna observación', 'id' => 'editable'),
//            'headerHtmlOptions' => array('style' => 'width: 110px; text-align: center'),
//            'editable' => array(
//                'type' => 'textarea',
//                'emptytext' => 'indique observaciones',
//                //   'inputclass' => 'input-large',
//                'url' => $this->createUrl('Beneficiario/Actualizar'),
//                'placement' => 'left',
////                'validate' => 'function(value) {
////                             if(!value) return "Disculpe, debe indicar la observación"
////                            }'
//            )
//        ),
        array(
            'header' => 'Estatus Documento',
            'name' => 'estatus_msj',
            'value' => '$data->estatus_msj',
//            'filter' => CHtml::listData(Desarrollo::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{documento}{devolver}{validar}{registral} ',
            'buttons' => array(
//                'ver' => array(
//                    'label' => 'Ver',
//                    'icon' => 'eye-open',
//                    'size' => 'medium',
//                    'visible' => '((Yii::app()->user->checkAccess("action_beneficiario_view")))',
//                    'url' => 'Yii::app()->createUrl("beneficiario/view/", array("id"=>$data->id_beneficiario))',
//                ),
                'documento' => array(
                    'label' => 'Editar Documento',
                    'icon' => 'glyphicon glyphicon-list-alt',
                    'size' => 'medium',
//                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_documento")))',
//                    'visible' => '($data["estatus_msj"] == "") && (Yii::app()->user->checkAccess("action_vivienda_documento")) && GenerarDocumento($data->id_beneficiario) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data->id_beneficiario) && EstatusDocumentoDevuelto($data->id_beneficiario) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data->id_beneficiario) && EstatusDocumentoDevuelto($data->id_beneficiario)',
                    'url' => 'Yii::app()->createUrl("vivienda/documento/", array("id"=>$data->id_beneficiario))',
                ),
                'Genratedocumento' => array(
                    'label' => 'Ver Documento',
                    'icon' => 'glyphicon glyphicon-pencil',
                    'size' => 'medium',
//                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_documento")) && GenerarDocumento($data->id_beneficiario))',
                    'url' => 'Yii::app()->createUrl("documentacion/generar/", array("id"=>$data->id_beneficiario))',
                ),
//                'imprimir' => array(
//                    'label' => 'Imprimir Documento',
//                    'icon' => 'glyphicon glyphicon-print',
//                    'size' => 'medium',
//                    'url' => 'Yii::app()->createUrl("documentacion/pdf", array("id"=>$data->id_beneficiario))',
//                    'options' => array("target" => "_blank"),
//                    'visible' => 'DocumentoExist($data->id_beneficiario);'
//                ),
                'validar' => array(
                    'label' => 'Conforme',
                    'icon' => 'ok',
                    'size' => 'medium',
                    'options' => array('style' => 'margin-left:28px;',),
                    'url' => '$data["id_beneficiario"]',
                    'click' => 'js: function(s){CambiarEstatusDocumento($(this).attr("href"), 1 ,4); return false; }',
                    'visible' => 'DocumentoExist($data->id_beneficiario);',
                    'options' => array(
                        'style' => 'margin-left:17px;', 'id' => 'cambiarEstatus'
                    ),
                ),
                'devolver' => array(
                    'label' => 'Devolver',
                    'icon' => 'remove',
                    'size' => 'medium',
                    'options' => array('style' => 'margin-left:28px;',),
                    'url' => '$data["id_beneficiario"]',
                    'click' => 'js: function(s){CambiarEstatusDocumento($(this).attr("href"), 1 ,5); return false; }',
                    'visible' => 'DocumentoExist($data->id_beneficiario);',
                    'options' => array(
                        'style' => 'margin-left:17px;', 'id' => 'cambiarEstatus'
                    ),
                ),
                'registral' => array(
                    'label' => 'Datos Magistrales',
                    'icon' => 'glyphicon glyphicon-folder-open',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("desarrollo/registralBeneficiario", array("id"=>$data["id_beneficiario"]))',
                    //'options' => array("target" => "_blank"),
                    'visible' => 'DocumentoExistMulti2($data["id_beneficiario"]);'
                ),
            ),
        ),
    ),
));
?>
