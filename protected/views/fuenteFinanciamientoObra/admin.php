<?php
/* @var $this FuenteFinanciamientoObraController */
/* @var $model FuenteFinanciamientoObra */

$this->breadcrumbs=array(
	'Fuente Financiamiento Obras'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List FuenteFinanciamientoObra', 'url'=>array('index')),
	array('label'=>'Create FuenteFinanciamientoObra', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#fuente-financiamiento-obra-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Fuente Financiamiento Obras</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fuente-financiamiento-obra-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_fuente_financiamiento_obra',
		'nombre_fuente_financiamiento_obra',
		'fecha_creacion',
		'fecha_actualizacion',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

