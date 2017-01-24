<?php
/* @var $this SalarioMinimoController */
/* @var $model SalarioMinimo */

$this->breadcrumbs=array(
	'Salario Minimos'=>array('index'),
	$model->id_salario_minimo,
);

$this->menu=array(
	array('label'=>'List SalarioMinimo', 'url'=>array('index')),
	array('label'=>'Create SalarioMinimo', 'url'=>array('create')),
	array('label'=>'Update SalarioMinimo', 'url'=>array('update', 'id'=>$model->id_salario_minimo)),
	array('label'=>'Delete SalarioMinimo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_salario_minimo),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SalarioMinimo', 'url'=>array('admin')),
);
?>

<h1>Salario Mínimo #<?php echo $model->id_salario_minimo; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'valor_salario',
		'observaciones',
),
)); ?>
