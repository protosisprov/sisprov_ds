<?php
$this->breadcrumbs=array(
	'Temp Censo Validado Faov Fasps',
);

$this->menu=array(
array('label'=>'Create TempCensoValidadoFaovFasp','url'=>array('create')),
array('label'=>'Manage TempCensoValidadoFaovFasp','url'=>array('admin')),
);
?>

<h1>Temp Censo Validado Faov Fasps</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
