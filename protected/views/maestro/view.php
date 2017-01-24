<?php
$this->breadcrumbs=array(
	'Maestros'=>array('index'),
	$model->id_maestro,
);

$this->menu=array(
array('label'=>'List Maestro','url'=>array('index')),
array('label'=>'Create Maestro','url'=>array('create')),
array('label'=>'Update Maestro','url'=>array('update','id'=>$model->id_maestro)),
array('label'=>'Delete Maestro','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_maestro),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Maestro','url'=>array('admin')),
);
?>

<h1>View Maestro #<?php echo $model->id_maestro; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_maestro',
		'descripcion',
		'padre',
		'hijo',
		'es_activo',
		'fecha_creacion',
		'fecha_actualizacion',
		array(
			'name'=>'usuario_id_creacion',
			'value'=>$model->username($model->usuario_id_creacion),
		),
		array(
			'name'=>'usuario_id_actualizacion',
			'value'=>$model->usuario_id_actualizacion ? $model->username($model->usuario_id_actualizacion) :'No se ha actualizado',
		),

),
)); ?>
