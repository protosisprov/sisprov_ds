<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<h1>Gestión de Adjudicados</h1>

<?php
//$model->estatus=221;
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'beneficiario-temporal-grid',
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
       
        'id_beneficiario_temporal' => array(
            'header' => 'N°',
            'name' => 'id_beneficiario_temporal',
            'value' => '$data->id_beneficiario_temporal',
            'htmlOptions' => array('width' => '50', 'style' => 'text-align: center;'),
        ),
        'cedula',
        'nombre_completo' => array(
            'header' => 'Nombre',
            'name' => 'nombre_completo',
            'value' => '$data->nombre_completo',
            'htmlOptions' => array('width' => '300', 'style' => 'text-align: center;'),
        ),
        'desarrollo_id' => array(
            'header' => 'Desarrollo',
            'name' => 'desarrollo_id',
            'value' => '$data->desarrollo->nombre',
            'filter' => CHtml::listData(Desarrollo::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
        'unidad_habitacional_id' => array(
            'name' => 'unidad_habitacional_id',
            'header' => 'Unidad MultiFamiliar',
            'value' => '$data->unidadHabitacional->nombre',
            'filter' => CHtml::listData(UnidadHabitacional::model()->findall(), 'id_unidad_habitacional', 'nombre'),
        ),
        array(
            'name' => 'fecha_creacion',
            'value' => 'Yii::app()->dateFormatter->format("d/M/y - hh:mm a", strtotime($data->fecha_creacion))',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{modificar}',
            'buttons' => array(
                'modificar' => array(
                    'label' => 'Modificar',
                    'icon' => 'glyphicon glyphicon-pencil',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_beneficiariotemporal_update")))',
                    'url' => 'Yii::app()->createUrl("beneficiarioTemporal/update/", array("id"=>$data->id_beneficiario_temporal))',
//                    'visible' => 'Asignar($data->username);'
                ),
                
               
                
            ),
        ),
    ),
));
?>
<div style="margin-top: 1%"></div>
<div class="text-center">


  <?php
//    if (Yii::app()->user->checkAccess("action_beneficiarioTemporal_certificadoVarios")){ 
//    $this->widget('booster.widgets.TbButton', array(// Button to delete
//        'label' => 'Imprimir Adjudicados',
//        'context' => 'info',
//        'icon' => 'glyphicon glyphicon-print',
//        'size' => 'large',
//        'id' => 'delete',
//    ));
//    }
    ?>
</div>

<?php

/* * ********  Revisar codigo para ejecturar accion para imprimir                     ********* */
$base64 = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/base64.js');
Yii::app()->clientScript->registerScript('delete', "


    $('#delete').click(function(){
        var checked=$('#beneficiario-temporal-grid').yiiGridView('getChecked','beneficiario-temporal-grid_c0'); // _c0 means the checkboxes are located in the first column, change if you put the checkboxes somewhere else
        var count=checked.length;
        if(count==0){
            bootbox.alert('Debe seleccionar al menos un registro para exportar el documento');
            return false;
        }
        if(count>0 && confirm('Ha seleccionado  '+count+' Adjudicados.  ¿Está seguro de exportar todos las planillas seleccionadas?')){
           // alert(checked);
            $(location).attr('href','" . $this->createUrl('certificadoVarios') . "/id/'+checked).attr('target','_blank');
        }
    });
");
/* * ********  Fin Revisar codigo para ejecturar accion para impromir                     ********* */

?>