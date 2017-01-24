<?php
//var_dump($id);die;

function nombre($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_NOMBRE'];
}

function apellido($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_APELLIDO'];
}

function cedula($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['CEDULA'];
}

function nacionalidad($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return ($saime['NACIONALIDAD']==1)?'V':'E';
}

function GenerarDocumento($id) {
    $beneficiario = Beneficiario::model()->findByPk($id);
    if (Documentacion::model()->exists('fk_beneficiario=:fk_beneficiario AND es_multi=:es_multi', array(':fk_beneficiario' => $beneficiario->beneficiarioTemporal->desarrollo->id_desarrollo, ':es_multi' => true))) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function DocumentoExist($iD) {
    if (Documentacion::model()->exists('fk_beneficiario=:fk_beneficiario AND es_multi=:es_multi', array(':fk_beneficiario' => $iD, ':es_multi' => false))) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function id_beneficiario($id_beneficiario_temporal)
{
	$beneficiario_id = Beneficiario::model()->findByAttributes(array('beneficiario_temporal_id' => $id_beneficiario_temporal));
	return $beneficiario_id['id_beneficiario'];
}



echo CHtml::tag('h3',array(),'DESARROLLO : "'.$nombre_desarrollo->nombre.'"');

$model_beneficiario->estatus = 80;
$model_beneficiario->desarrollo_id = $id;
// $model->beneficiario_temporal_id = $beneficiario_temporal->id;
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'beneficiario-grid',
    'dataProvider' => $model_beneficiario->search(),
    'type' => 'striped bordered condensed',
    'filter' => $model_beneficiario,
    'columns' => array(
         /*array(
             'name' => 'id_beneficiario_temporal',
             'header' => 'N°',
             'value' => '$data->id_beneficiario_temporal',
             'htmlOptions' => array('style' => 'text-align: center', 'width' => '90px'),
         ),*/
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
        array(
            'name' => 'persona_id',
            'header' => 'Cédula',
            'value' => 'nacionalidad("NACIONALIDAD",$data->persona_id)."-".cedula("CEDULA",$data->persona_id)',
        ),
        /*'Estado' => array(
            'header' => 'Estado',
            'name' => 'desarrollo_id',
            'value' => 'Tblparroquia::model()->findByPK(Desarrollo::model()->findByPK($data->desarrollo_id)->parroquia_id)->clvmunicipio0->clvestado0->strdescripcion',
            // 'filter' => CHtml::listData(Tblestado::model()->findall(), 'clvcodigo', 'strdescripcion'),
            'filter' => false,
        ),*/
        /*'Desarrollo' => array(
            'header' => 'Desarrollo',
            'name' => 'beneficiarioTemporal',
            'value' => '$data->beneficiarioTemporal->desarrollo->nombre',
            'filter' => CHtml::listData(Desarrollo::model()->findall(), 'id_desarrollo', 'nombre'),
        ),*/
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            //'template' => '{ver}{documento}{Genratedocumento}{imprimir}',
            'template' => '{ver} {imprimir}',
            'buttons' => array(
                'ver' => array(
                    'label' => 'Ver',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_beneficiario_view")))',
                    'url' => 'Yii::app()->createUrl("beneficiario/view/", array("id"=>id_beneficiario($data->id_beneficiario_temporal)))',
                    // 'url' => 'Yii::app()->createUrl("beneficiario/view/", array("id"=>$data->id_beneficiario))',
                ),
                /*'documento' => array(
                    'label' => 'Editar Documento',
                    'icon' => 'glyphicon glyphicon-list-alt',
                    'size' => 'medium',
//                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_documento")))',
                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_documento")) && GenerarDocumento($data->id_beneficiario))',
                    'url' => 'Yii::app()->createUrl("vivienda/documento/", array("id"=>$data->id_beneficiario))',
                ),*/
                /*'Genratedocumento' => array(
                    'label' => 'Generar Documento',
                    'icon' => 'glyphicon glyphicon-pencil',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_documento")) && GenerarDocumento($data->id_beneficiario))',
                    'url' => 'Yii::app()->createUrl("documentacion/generar/", array("id"=>$data->id_beneficiario))',
                ),*/
                'imprimir' => array(
                    'label' => 'Imprimir Documento',
                    'icon' => 'glyphicon glyphicon-print',
                    'size' => 'medium',
                     'url' => 'Yii::app()->createUrl("documentacion/pdf", array("id"=>id_beneficiario($data->id_beneficiario_temporal)))',
                    'options' => array("target" => "_blank"),
                    // 'url' => 'Yii::app()->createUrl("documentacion/pdf", array("id"=>$data->id_beneficiario))',
                    // 'visible' => 'DocumentoExist($data->id_beneficiario);'
                ),
            ),
        ),
    ),
));
?>