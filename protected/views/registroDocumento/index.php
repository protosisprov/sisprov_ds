<?php
/* @var $this RegistroDocumentoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Registro Documentos',
);

$this->menu=array(
	array('label'=>'Create RegistroDocumento', 'url'=>array('create')),
	array('label'=>'Manage RegistroDocumento', 'url'=>array('admin')),
);
?>

<h1>Registro Documentos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
