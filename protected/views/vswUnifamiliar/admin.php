


<h1 class="text-center">Gestión del Inmueble Familiar</h1>



<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'vsw-unifamiliar-grid',
    'type' => 'striped bordered condensed',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'beforeAjaxUpdate' => 'js:function(id,options){
        //RECOGE LOS VALORES DE LOS CAMPOS ANTES DEL SUBMIT
        desarrolloSeleccionado = $("#VswUnifamiliar_id_desarrollo").val(); 
        unidadSeleccionado = $("#VswUnifamiliar_id_unidad_habitacional").val(); 
     }',
    //DESPUES DEL RECARGAR EL GRID CARGA LOS COMBOS Y SELECCIONA EL VALOR CORRESPONDIENTE 
    'afterAjaxUpdate' => 'js:function(id,options){
           $("#VswUnifamiliar_cod_estado option:selected").each(function () {
           elegido=$(this).val();
           $.get("' . CController::createUrl('ValidacionJs/BuscarDesarrollosEstado') . '", { cod_estado: elegido}, function(data){
               $("#VswUnifamiliar_id_desarrollo").html(data);     
               if(data){
                   $("#VswUnifamiliar_id_desarrollo").val(desarrolloSeleccionado);
                    $("#VswUnifamiliar_id_desarrollo option:selected").each(function () {
                      elegido=$(this).val();
                        $.get("' . CController::createUrl('ValidacionJs/BuscarUnidadH') . '", { id_desarrollo: elegido}, function(data){  
                             $("#VswUnifamiliar_id_unidad_habitacional").html(data);
                                if(data){
                                    $("#VswUnifamiliar_id_unidad_habitacional").val(unidadSeleccionado);
                                }
                        }); // fin unidad_habitacional_id
                     }); // fin id_desarrollo
              } //fin data 
            });
        }); //fin cod_estado
    }',
    'columns' => array(
        'id_vivienda' => array(
            'header' => 'N°',
            'name' => 'id_vivienda',
            'value' => '$data->id_vivienda',
            'htmlOptions' => array('width' => '80', 'style' => 'text-align: center;'),
        ),
        'cod_estado' => array(
            'header' => 'Estado',
            'name' => 'cod_estado',
            'value' => '$data->estado',
            'filter' => CHtml::listData(VswUnifamiliar::model()->findAll(), 'cod_estado', 'estado')
        ),
        'id_desarrollo' => array(
            'header' => 'Nombre de Desarrollo',
            'name' => 'id_desarrollo',
            'value' => '$data->nombre_desarrollo',
            'filter' => CHtml::listData(array(), 'id_desarrollo', 'nombre_desarrollo'),
        ),
        'id_unidad_habitacional' => array(
            'name' => 'id_unidad_habitacional',
            'header' => 'Unidad Multifamiliar',
            'value' => '$data->nombre_unidad_habitacional',
            'filter' => CHtml::listData(array(), 'id_unidad_habitacional', 'nombre_unidad_habitacional'),
        ),
        'tipo_vivienda' => array(
            'name' => 'tipo_vivienda_id',
            'header' => 'Tipo de Vivienda',
            'value' => '$data->tipo_vivienda',
            'filter' => CHtml::listData(VswUnifamiliar::model()->findAll(), 'tipo_vivienda_id', 'tipo_vivienda'),
        ),
        'nro_vivienda' => array(
            'name' => 'nro_vivienda',
            'header' => 'Numéro de Vivienda',
            'value' => '$data->nro_vivienda',
            'filter' => CHtml::listData(VswUnifamiliar::model()->findAll(), 'nro_vivienda', 'nro_vivienda'),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{ver} {modificar} {pdf}',
            'buttons' => array(
                'ver' => array(
                    'label' => 'Ver',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_view")))',
                    'url' => 'Yii::app()->createUrl("vivienda/view/", array("id"=>$data->id_vivienda))',
                ),
                'modificar' => array(
                    'label' => 'Modificar',
                    'icon' => 'glyphicon glyphicon-pencil',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_update")))',
                    'url' => 'Yii::app()->createUrl("vivienda/update/", array("id"=>$data->id_vivienda))',
                //                    'visible' => 'Asignar($data->username);'
                ),
                'pdf' => array(
                    'label' => 'Generar PDF',
                    'icon' => 'glyphicon glyphicon-file',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_pdf")))',
                    'url' => 'Yii::app()->createUrl("vivienda/pdf/", array("id"=>$data->id_vivienda))',
//                    'visible' => 'Asignar($data->username);'
                ),
//                'documento' => array(
//                    'label' => 'Generar Documento',
//                    'icon' => 'glyphicon glyphicon-list-alt',
//                    'size' => 'medium',
//                    'visible' => '((Yii::app()->user->checkAccess("action_vivienda_documento")))',
//                    'url' => 'Yii::app()->createUrl("vivienda/documento/", array("id"=>$data->id_vivienda))',
////                    'visible' => 'Asignar($data->username);'
//                ),
            ),
        ),
    ),
));
?>
