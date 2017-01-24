<?php
$this->breadcrumbs=array(
	'Vsw Protocolizadoses'=>array('index'),
	$model->id_desarrollo=>array('view','id'=>$model->id_desarrollo),
	'Update',
);

	$this->menu=array(
	array('label'=>'List VswProtocolizados','url'=>array('index')),
	array('label'=>'Create VswProtocolizados','url'=>array('create')),
	array('label'=>'View VswProtocolizados','url'=>array('view','id'=>$model->id_desarrollo)),
	array('label'=>'Manage VswProtocolizados','url'=>array('admin')),
	);
	?>

	<h1>Update VswProtocolizados <?php echo $model->id_desarrollo; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>