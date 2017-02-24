<h1>Gestión de Activación del Crédito</h1>
<?php
function traza($iD) {
    $traza = Traza::getTraza($iD);
    return $traza;
}
?>
<?php

function buscarUNidad($id) {
    $unidadId = UnidadFamiliar::model()->findByAttributes(array('beneficiario_id' => $id));
    return $unidadId->id_unidad_familiar;
}

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
    'id' => 'vsw-censos-culminados-grid',
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'responsiveTable' => true,
    'filter' => $model,
    'columns' =>  array(
    array(
            'class' => 'CCheckBoxColumn', // Checkboxes
            'selectableRows' => 2, // Allow multiple selections 
            'value'=>'$data->id_beneficiario' , 
           // 'visible' => (Yii::app()->user->checkAccess("action_beneficiarioTemporal_certificadoVarios") == FALSE) ? FALSE: TRUE
        ),
        'id_beneficiario' => array(
            'header' => 'Número',
            'name' => 'id_beneficiario',
            'value' => '$data->id_beneficiario',
        ),
        'cedula' => array(
            'header' => 'Cedula',
            'name' => 'cedula',
        ),
        'nombre_adjudicado' => array(
            'header' => 'Nombre del Adjudicado',
            'name' => 'nombre_adjudicado',
            'filter' => CHtml::listData(VswCensosCulminados::model()->findall(), 'nombre_adjudicado', 'nombre_adjudicado'),
        ),
        'estado' => array(
            'header' => 'Estado',
            'name' => 'cod_estado',
            'value' => '$data->estado',
            'filter' => CHtml::listData(VswCensosCulminados::model()->findall(), 'cod_estado', 'estado'),
        ),
        'nombre_desarrollo' => array(
            'header' => 'Desarrollo Habitacional',
            'name' => 'id_desarrollo',
            'value' => '$data->nombre_desarrollo',
            'filter' => CHtml::listData(VswCensosCulminados::model()->findall(), 'id_desarrollo', 'nombre_desarrollo'),
        ),
        'nombre_unidad_multifamiliar' => array(
            'header' => 'Unidad Multifamiliar',
            'name' => 'id_unidad_habitacional',
            'value' => '$data->nombre_unidad_multifamiliar',
            'filter' => CHtml::listData(VswCensosCulminados::model()->findall(), 'id_unidad_habitacional', 'nombre_unidad_multifamiliar'),
        ),
        'empadronador_usuario' => array(
            'header' => 'Empadronador Asignado',
            'name' => 'iduser',
            'value' => '$data->empadronador_usuario',
            'filter' => CHtml::listData(VswCensosCulminados::model()->findall(), 'iduser', 'empadronador_usuario'),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{ver}{validarCenso}',
            'buttons' => array(
                'ver' => array(
                    'label' => 'Ver',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_beneficiario_view")))',
                    'url' => 'Yii::app()->createUrl("beneficiario/view/", array("id"=>$data->id_beneficiario))',
                ),
                'validarCenso' => array(
                    'label' => 'Activar Crédito',
                    'icon' => 'glyphicon glyphicon-ok',
                    'size' => 'medium',
//                    'visible' => '((Yii::app()->user->checkAccess("action_grupofamiliar_update")))',
                    'url' => 'Yii::app()->createUrl("beneficiario/activarCredito/", array("id"=>$data->id_beneficiario))',
                ),

            ),
        ),
    ),
));
?>

<div style="margin-top: 1%"></div>
<div class="text-center">


  <?php
    //if (Yii::app()->user->checkAccess("actionValidarVariosCenso")){ 
    $this->widget('booster.widgets.TbButton', array(// Button to delete
        'label' => 'Activar Créditos',
        'context' => 'info',
        'icon' => 'glyphicon glyphicon-ok',
        'size' => 'large',
        'id' => 'delete',
    ));
    //}
    ?>
</div>

<?php
/* * ********  Revisar codigo para ejecturar accion para imprimir                     ********* */
//$base64 = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/base64.js');
Yii::app()->clientScript->registerScript('delete2', "


    $('#delete').click(function(){
        var checked=$('#vsw-censos-culminados-grid').yiiGridView('getChecked','vsw-censos-culminados-grid_c0'); // _c0 means the checkboxes are located in the first column, change if you put the checkboxes somewhere else
        var count=checked.length;
        if(count==0){
            bootbox.alert('Debe seleccionar al menos un registro para exportar el documento');
            return false;
        }
        if(count>0 && confirm('Ha seleccionado  '+count+' Adjudicados.  ¿Está seguro de validar el censo para los beneficiarios seleccionados?')){
           //alert(checked);
            $(location).attr('href','" . $this->createUrl('/beneficiario/ValidarVariosCenso') . "/id/'+checked).attr('target','_blank');
        }
    });
");
/* * ********  Fin Revisar codigo para ejecturar accion para imprimir                     ********* */

?>
