<?php
function traza($iD) {
    $traza = Traza::getTraza($iD);
    return $traza;
}
function visibleReasignacion($iD) {
    $traza = Traza::getTraza($iD);
    if($traza=='0%'){
        return TRUE;
    } else {        
        return FALSE;
    }
}

function prueba($id) {
    $vswEmpadronador = VswEmpadronadorCensos::model()->findByAttributes(array('id_beneficiario_temporal' => $id));

    if (!empty($vswEmpadronador->id_beneficiario)) {
        return Yii::app()->createUrl("beneficiario/culminarRegistro", array("id" => $vswEmpadronador->id_beneficiario));
    } else {
        return Yii::app()->createUrl("/Beneficiario/createCenso", array("id" => $id));
    }
}
?>

<h1>Gestión de Empadronador</h1>

<?php
if (Yii::app()->user->name != "admin") {
    $rol = Yii::app()->db->createCommand('select itemname from cruge_authassignment where userid = ' . Yii::app()->user->id)->queryAll();
    $rol = (object) $rol;
    foreach ($rol as $fila) {
        if ($fila['itemname'] == 'empadronador') {
            $model->iduser = Yii::app()->user->id;
        }
    }
}

$this->widget('booster.widgets.TbGridView', array(
    'id' => 'vsw-empadronador-censos-grid',
    'type' => 'striped bordered condensed',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id_beneficiario_temporal' => array(
            'header' => 'N°',
            'name' => 'id_beneficiario_temporal',
            'value' => '$data->id_beneficiario_temporal',
            'htmlOptions' => array('style' => 'width: 2%',),
        ),
        'cedula' => array(
            'header' => 'Cedula',
            'name' => 'cedula',
            'value' => '$data->cedula',
        ),
        'nombre_adjudicado' => array(
            'header' => 'Adjudicado',
            'name' => 'nombre_adjudicado',
            'value' => '$data->nombre_adjudicado',
        ),
        'id_desarrollo' => array(
            'header' => 'Nombre del Desarrollo ',
            'name' => 'id_desarrollo',
            'value' => '$data->nombre_desarrollo',
            'filter' => CHtml::listData(VswEmpadronadorCensos::model()->findall(), 'id_desarrollo', 'nombre_desarrollo'),
        ),
        'id_unidad_habitacional' => array(
            'header' => 'Unidad Familiar',
            'name' => 'id_unidad_habitacional',
            'value' => '$data->nombre_unidad_multifamiliar',
            'filter' => CHtml::listData(VswEmpadronadorCensos::model()->findall(), 'id_unidad_habitacional', 'nombre_unidad_multifamiliar'),
        ),
        'iduser' => array(
            'header' => 'Empadronador Asignado',
            'name' => 'iduser',
            'value' => '$data->empadronador_usuario',
            'htmlOptions' => array('style' => 'text-align: center',),
            'filter' => CHtml::listData(VswEmpadronadorCensos::model()->findall(), 'iduser', 'empadronador_usuario'),
        ),
        array(
            'name' => 'id_beneficiario',
            'header' => 'Avance',
            'value' => 'traza($data->id_beneficiario)',
            'htmlOptions' => array('style' => 'text-align: center', 'width' => '10px'),
            'filter' => false,
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'template' => '{reasignacionv}{censo}',
            'buttons' => array(
                'reasignacionv' => array(
                    'label' => 'Re-asignacion Vivienda',
                    'icon' => 'glyphicon glyphicon-user',
                    'size' => 'medium',
                    'visible' => 'visibleReasignacion($data->id_beneficiario)',
                    'url' => 'Yii::app()->createUrl("reasignacionVivienda/create/", array("id"=>$data->id_beneficiario_temporal))',
                ),
                'censo' => array(
                    'label' => 'Generar Censo',
                    'icon' => 'glyphicon glyphicon-new-window',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_beneficiario_culminarcenso")))',
                    'url' => 'prueba($data->id_beneficiario_temporal)',
                ),
            ),
        ),
    ),
));
?>