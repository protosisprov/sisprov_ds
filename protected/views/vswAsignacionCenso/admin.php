
<h1>Listado de Asignación de Censo</h1>

<?php

function nombre($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_NOMBRE'];
}

function apellido($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_APELLIDO'];
}

function nacionalidadCedula($selec, $select2, $iD) {
    $saime = ConsultaOracle::getNacionalidadCedulaPersonaByPk($selec, $select2, (int) $iD);
    return $saime['NACIONALIDAD'] . " - " . $saime['CEDULA'];
}
?>

<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'vsw-asignacion-censo-grid',
    'type' => 'striped bordered condensed',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id_asignacion_censo' => array(
            'header' => 'N°',
            'name' => 'id_asignacion_censo',
            'value' => '$data->id_asignacion_censo',
        ),
       /* 'estado' => array(
            'header' => 'Estado',
            'name' => 'estado',
            'value' => '$data->estado',
            'filter' => CHtml::listData(Tblestado::model()->findAll(array('order' => 'strdescripcion ASC')), 'strdescripcion', 'strdescripcion')
        ),*/
        'nombre_oficina' => array(
            'header' => 'Oficina',
            'name' => 'id_oficina',
            'value' => '$data->nombre_oficina',
            'filter' => CHtml::listData(VswAsignacionCenso::model()->findAll(), 'id_oficina', 'nombre_oficina'),
        ),
        'nombre_desarrollo' => array(
            'header' => 'Desarrollo',
            'name' => 'id_desarrollo',
            'value' => '$data->nombre_desarrollo',
            'filter' => CHtml::listData(VswAsignacionCenso::model()->findAll(), 'id_desarrollo', 'nombre_desarrollo'),
        ),
        'persona_id' => array(
            'header' => 'Responsable del Censo',
            'name' => 'persona_id',
            'value' => 'nombre("PRIMER_NOMBRE",$data->persona_id)." ".apellido("PRIMER_APELLIDO",$data->persona_id)',
            'filter' => false,
        ),
        'fecha_asignacion' => array(
            'header' => 'Fecha Asignación',
            'name' => 'fecha_asignacion',
            'value' => '$data->fecha_asignacion',
            'filter' => false,
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{ver} {empadronador} {modificar}{pdf}{reasignacionCenso}',
            'buttons' => array(
                'ver' => array(
                    'label' => 'Ver',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_asignacioncenso_view")))',
                    'url' => 'Yii::app()->createUrl("asignacionCenso/view/", array("id"=>$data->id_asignacion_censo))',
                ),
                'pdf' => array(
                    'label' => 'Generar PDF',
                    'icon' => 'glyphicon glyphicon-file',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("asignacionCenso/pdf/", array("id"=>$data->id_asignacion_censo))',
//                    'visible' => 'Asignar($data->username);'
                ),
                'empadronador' => array(
                    'label' => 'Asignar Empadronador',
                    'icon' => 'glyphicon glyphicon-user',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_empadronadorcenso_create")))',
                    'url' => 'Yii::app()->createUrl("/empadronadorCenso/create/", array("id"=>$data->id_asignacion_censo))',
//                    'visible' => 'Asignar($data->username);'
                ),
                'modificar' => array(
                    'label' => 'Modificar',
                    'icon' => 'glyphicon glyphicon-pencil',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_asignacioncenso_update")))',
                    'url' => 'Yii::app()->createUrl("asignacionCenso/update/", array("id"=>$data->id_asignacion_censo))',
//                    'visible' => 'Asignar($data->username);'
                ),
                'reasignacionCenso' => array(
                    'label' => 'Re-Asignación Censo',
                    'icon' => 'glyphicon glyphicon-new-window',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_asignacioncenso_createreasignacion")))',
                    'url' => 'Yii::app()->createUrl("asignacionCenso/createReasignacion/", array("id"=>$data->id_asignacion_censo))',
//                    'visible' => 'Asignar($data->username);'
                ),
            ),
        ),
    ),
));
?>


<?php
//$this->widget('booster.widgets.TbGridView', array(
//    'id' => 'vsw-asignacion-censo-grid',
//    'dataProvider' => $model->search(),
//    'filter' => $model,
//    'columns' => array(
//        'id_asignacion_censo',
//        'cod_estado',
//        'estado',
//        'id_oficina',
//        'nombre_oficina',
//        'id_desarrollo',
//        /*
//          'nombre_desarrollo',
//          'fecha_asignacion',
//         */
//        array(
//            'class' => 'booster.widgets.TbButtonColumn',
//        ),
//    ),
//));
?>
