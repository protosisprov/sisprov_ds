<?php
$this->breadcrumbs=array(
	'Asignaciones'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Asignaciones','url'=>array('index')),
array('label'=>'Create Asignaciones','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('asignaciones-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Asignaciones</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'asignaciones-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_asignaciones',
		'fk_entidad',
		'fk_usuario_asignado',
		'fk_usuario_q_asigna',
		'fk_caso_asignado',
		'fecha_creacion',
		/*
		'fecha_actualizacion',
		'usuario_id_creacion',
		'usuario_id_actualizacion',
		'es_activo',
		'fk_estatus',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
