<?php
$this->breadcrumbs=array(
	'Maestros'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Maestro','url'=>array('index')),
array('label'=>'Manage Maestro','url'=>array('admin')),
);
?>

<h1><?php echo $titulo ?> Maestro</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
