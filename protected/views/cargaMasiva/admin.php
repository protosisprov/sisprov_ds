<?php
$this->breadcrumbs=array(
	'Carga Masivas'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List CargaMasiva','url'=>array('index')),
array('label'=>'Create CargaMasiva','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('carga-masiva-grid', {
data: $(this).serialize()
});
return false;
});
");
?>
<h1>Cargas Masivas</h1>

<?php echo CHtml::link('Busqueda Avanzada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'carga-masiva-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
//		'id_carga_masiva',

		'nombre_archivo' => array(
			'name'  => 'nombre_archivo',
			'value' => 'CHtml::link( $data->nombre_archivo, Yii::app()->createUrl( "doc/$data->nombre_archivo" ) )',
			'type'  => 'raw',
		),

		'num_lineas' => array(
            'header' => 'Cant. Lineas',
            'name' => 'num_lineas',
            'value' => '$data->num_lineas',
            'htmlOptions' => array('width' => '100', 'style' => 'text-align: center;'),
        ),		
		'tamano_archivo' => array(
            'header' => 'Tamaño',
            'name' => 'tamano_archivo',
            'value' => '$data->tamano($data->tamano_archivo)',
            'htmlOptions' => array('width' => '40', 'style' => 'text-align: center;'),
        ),
                'observaciones' => array(
            'header' => 'Ruta',
            'name' => 'observaciones'    
         ),
    
		'fecha_inicio' => array(
            'name' => 'fecha_inicio',
            'value' => 'Yii::app()->dateFormatter->format("d/M/y - hh:mm a", strtotime($data->fecha_inicio))',
        ),
		/*
		'mensajes_carga',
		'estatus',
		'tipo_carga_masiva',
		'fecha_inicio',
		'fecha_fin',
		'usuario_id_creacion',
		*/
array(
    'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{view}',
            'buttons' => array(
                   'ver' => array(
                    'label' => 'Ver',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_cargamasiva_view")))',
                    'url' => 'Yii::app()->createUrl("cargaMasiva/view/", array("id"=>$data->id_carga_masiva))',
                ),
              /*     'update' => array(
                    'label' => 'Actualizar',
                    'icon' => 'glyphicon glyphicon-pencil',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_cargamasiva_update")))',
                    'url' => 'Yii::app()->createUrl("cargaMasiva/update/", array("id"=>$data->id_carga_masiva))',
                ),
                   'delete' => array(
                    'label' => 'Eliminar',
                    'icon' => 'glyphicon glyphicon-file',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_cargamasiva_delete")))',
                    'url' => 'Yii::app()->createUrl("cargaMasiva/delete/", array("id"=>$data->id_carga_masiva))',
                ),*/
                )),
),
)); ?>
