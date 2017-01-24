<?php
/* @var $this SalarioMinimoController */
/* @var $model SalarioMinimo */

$this->breadcrumbs=array(
	'Salario Minimos'=>array('index'),
	$model->id_salario_minimo=>array('view','id'=>$model->id_salario_minimo),
	'Update',
);

$this->menu=array(
	array('label'=>'List SalarioMinimo', 'url'=>array('index')),
	array('label'=>'Create SalarioMinimo', 'url'=>array('create')),
	array('label'=>'View SalarioMinimo', 'url'=>array('view', 'id'=>$model->id_salario_minimo)),
	array('label'=>'Manage SalarioMinimo', 'url'=>array('admin')),
);
?>

<h1>Update SalarioMinimo <?php echo $model->id_salario_minimo; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>