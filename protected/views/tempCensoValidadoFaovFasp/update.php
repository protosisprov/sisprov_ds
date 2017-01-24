<?php
$this->breadcrumbs=array(
	'Temp Censo Validado Faov Fasps'=>array('index'),
	$model->id_temp_censo_validado_faov_fasp=>array('view','id'=>$model->id_temp_censo_validado_faov_fasp),
	'Update',
);

	$this->menu=array(
	array('label'=>'List TempCensoValidadoFaovFasp','url'=>array('index')),
	array('label'=>'Create TempCensoValidadoFaovFasp','url'=>array('create')),
	array('label'=>'View TempCensoValidadoFaovFasp','url'=>array('view','id'=>$model->id_temp_censo_validado_faov_fasp)),
	array('label'=>'Manage TempCensoValidadoFaovFasp','url'=>array('admin')),
	);
	?>

	<h1>Update TempCensoValidadoFaovFasp <?php echo $model->id_temp_censo_validado_faov_fasp; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>