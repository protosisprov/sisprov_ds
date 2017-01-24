<?php
$this->breadcrumbs=array(
	'Vsw Protocolizadoses'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List VswProtocolizados','url'=>array('index')),
array('label'=>'Manage VswProtocolizados','url'=>array('admin')),
);
?>

<h1>Create VswProtocolizados</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>