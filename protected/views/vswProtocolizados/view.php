<?php
$this->breadcrumbs=array(
	'Vsw Protocolizadoses'=>array('index'),
	$model->id_desarrollo,
);

$this->menu=array(
array('label'=>'List VswProtocolizados','url'=>array('index')),
array('label'=>'Create VswProtocolizados','url'=>array('create')),
array('label'=>'Update VswProtocolizados','url'=>array('update','id'=>$model->id_desarrollo)),
array('label'=>'Delete VswProtocolizados','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_desarrollo),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage VswProtocolizados','url'=>array('admin')),
);
?>

<h1>View VswProtocolizados #<?php echo $model->id_desarrollo; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_desarrollo',
		'nombre_desarrollo',
		'id_estado',
		'nombre_estado',
),
)); ?>
