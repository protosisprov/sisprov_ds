<?php
/* @var $this RegistroDocumentoController */
/* @var $model RegistroDocumento */

$this->breadcrumbs=array(
	'Registro Documentos'=>array('index'),
	$model->id_registro_documento,
);

$this->menu=array(
	array('label'=>'List RegistroDocumento', 'url'=>array('index')),
	array('label'=>'Create RegistroDocumento', 'url'=>array('create')),
	array('label'=>'Update RegistroDocumento', 'url'=>array('update', 'id'=>$model->id_registro_documento)),
	array('label'=>'Delete RegistroDocumento', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_registro_documento),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RegistroDocumento', 'url'=>array('admin')),
);
?>

<h1>View RegistroDocumento #<?php echo $model->id_registro_documento; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_registro_documento',
		'registro_publico_id',
		'fecha_registro',
		'tomo',
		'ano',
		'asiento_registral',
		'folio_real',
		'nro_protocolo',
		'nro_matricula',
		'estatus',
		'fecha_creacion',
		'fecha_actualizacion',
		'usuario_id_creacion',
		'usuario_id_actualizacion',
		'nro_documento',
	),
)); ?>
