<?php
$this->breadcrumbs=array(
	'Maestros',
);

$this->menu=array(
array('label'=>'Create Maestro','url'=>array('create')),
array('label'=>'Manage Maestro','url'=>array('admin')),
);
?>

<h1>Maestros</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
