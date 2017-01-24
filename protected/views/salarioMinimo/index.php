<?php

$this->breadcrumbs=array(
	'Salario Minimos',
);

$this->menu=array(
	array('label'=>'Create SalarioMinimo', 'url'=>array('create')),
	array('label'=>'Manage SalarioMinimo', 'url'=>array('admin')),
);
?>

<h1>Salario Minimos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
