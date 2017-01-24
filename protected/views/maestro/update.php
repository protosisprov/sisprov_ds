<?php
$this->breadcrumbs=array(
	'Maestros'=>array('index'),
	$model->id_maestro=>array('view','id'=>$model->id_maestro),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Maestro','url'=>array('index')),
	array('label'=>'Create Maestro','url'=>array('create')),
	array('label'=>'View Maestro','url'=>array('view','id'=>$model->id_maestro)),
	array('label'=>'Manage Maestro','url'=>array('admin')),
	);
	?>

	<h1>Actualizar Maestro <?php echo $model->id_maestro; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
