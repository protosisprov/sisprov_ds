<?php
/* @var $this FuenteFinanciamientoObraController */
/* @var $model FuenteFinanciamientoObra */

$this->breadcrumbs=array(
	'Fuente Financiamiento Obras'=>array('index'),
	$model->id_fuente_financiamiento_obra=>array('view','id'=>$model->id_fuente_financiamiento_obra),
	'Update',
);

$this->menu=array(
	array('label'=>'List FuenteFinanciamientoObra', 'url'=>array('index')),
	array('label'=>'Create FuenteFinanciamientoObra', 'url'=>array('create')),
	array('label'=>'View FuenteFinanciamientoObra', 'url'=>array('view', 'id'=>$model->id_fuente_financiamiento_obra)),
	array('label'=>'Manage FuenteFinanciamientoObra', 'url'=>array('admin')),
);
?>

<h1>Update FuenteFinanciamientoObra <?php echo $model->id_fuente_financiamiento_obra; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>