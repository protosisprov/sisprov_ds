<?php
$this->breadcrumbs=array(
	'Auditorias'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Auditoria','url'=>array('index')),
array('label'=>'Create Auditoria','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('auditoria-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Gestión de Auditorias</h1>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'auditoria-grid',
'type' => 'striped bordered condensed',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_auditoria',
		'tabla',
		'usuario_bd',
		'fecha',
		'accion' => array(
			'name' => 'accion',
			'value' => '$data->accion',
			'filter' => array( 'i' =>'Insert', 'u' =>'Update', 'd' =>'Delete'),
		),
		'valores_viejos',

		'valores_nuevos',
		'updated_cols',
		'query',

array(
'header'=>'Acción',
'class'=>'booster.widgets.TbButtonColumn',
'template' => '{ver}',

'buttons' => array(
	'ver' => array(
		'label' => 'Ver',
		'icon' => 'eye-open',
		'size' => 'medium',
		'url' => 'Yii::app()->createUrl("auditoria/view/", array("id"=>$data->id_auditoria))',
	),
)



),
),
)); ?>
