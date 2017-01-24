<?php
$this->breadcrumbs=array(
	'Auditorias'=>array('index'),
	$model->id_auditoria,
);

$this->menu=array(
array('label'=>'List Auditoria','url'=>array('index')),
array('label'=>'Create Auditoria','url'=>array('create')),
array('label'=>'Update Auditoria','url'=>array('update','id'=>$model->id_auditoria)),
array('label'=>'Delete Auditoria','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_auditoria),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Auditoria','url'=>array('admin')),
);
?>

<h1>Pista de Auditoria #<?php echo $model->id_auditoria; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_auditoria',
		'tabla',
		'usuario_bd',
		'fecha',
		'accion',
		'valores_viejos',
		'valores_nuevos',
		'updated_cols',
		'query',
),
)); ?>
