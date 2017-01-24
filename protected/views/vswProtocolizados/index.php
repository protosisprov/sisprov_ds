<?php
$this->breadcrumbs=array(
	'Vsw Protocolizadoses',
);

$this->menu=array(
array('label'=>'Create VswProtocolizados','url'=>array('create')),
array('label'=>'Manage VswProtocolizados','url'=>array('admin')),
);
?>

<h1>Vsw Protocolizadoses</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
