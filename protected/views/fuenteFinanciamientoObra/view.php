<?php
/* @var $this FuenteFinanciamientoObraController */
/* @var $model FuenteFinanciamientoObra */

$this->breadcrumbs=array(
	'Fuente Financiamiento Obras'=>array('index'),
	$model->id_fuente_financiamiento_obra,
);

$this->menu=array(
	array('label'=>'List FuenteFinanciamientoObra', 'url'=>array('index')),
	array('label'=>'Create FuenteFinanciamientoObra', 'url'=>array('create')),
	array('label'=>'Update FuenteFinanciamientoObra', 'url'=>array('update', 'id'=>$model->id_fuente_financiamiento_obra)),
	array('label'=>'Delete FuenteFinanciamientoObra', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_fuente_financiamiento_obra),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FuenteFinanciamientoObra', 'url'=>array('admin')),
);
?>

<h1>View FuenteFinanciamientoObra #<?php echo $model->id_fuente_financiamiento_obra; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_fuente_financiamiento_obra',
		'nombre_fuente_financiamiento_obra',
		'fecha_creacion',
		'fecha_actualizacion',
	),
)); ?>
