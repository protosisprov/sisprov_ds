<?php
$this->breadcrumbs=array(
	'Temp Censo Validado Faov Fasps'=>array('index'),
	$model->id_temp_censo_validado_faov_fasp,
);

$this->menu=array(
array('label'=>'List TempCensoValidadoFaovFasp','url'=>array('index')),
array('label'=>'Create TempCensoValidadoFaovFasp','url'=>array('create')),
array('label'=>'Update TempCensoValidadoFaovFasp','url'=>array('update','id'=>$model->id_temp_censo_validado_faov_fasp)),
array('label'=>'Delete TempCensoValidadoFaovFasp','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_temp_censo_validado_faov_fasp),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage TempCensoValidadoFaovFasp','url'=>array('admin')),
);
?>

<h1>View TempCensoValidadoFaovFasp #<?php echo $model->id_temp_censo_validado_faov_fasp; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_temp_censo_validado_faov_fasp',
		'id_beneficiario',
		'id_beneficiario_temporal',
		'cedula',
		'nombre_completo',
		'cod_estado',
		'estado',
		'id_desarrollo',
		'nombre_desarrollo',
		'id_fuente_financiamiento',
		'nombre_fuente_financiamiento',
		'iduser',
		'empadronador_usuario',
),
)); ?>
