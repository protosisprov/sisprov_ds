<?php
$this->breadcrumbs=array(
	'Temp Censo Validado Faov Fasps'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List TempCensoValidadoFaovFasp','url'=>array('index')),
array('label'=>'Manage TempCensoValidadoFaovFasp','url'=>array('admin')),
);
?>

<h1>Create TempCensoValidadoFaovFasp</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>