<?php //
/* @var $this FuenteFinanciamientoObraController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Fuente Financiamiento Obras',
);

$this->menu=array(
	array('label'=>'Create FuenteFinanciamientoObra', 'url'=>array('create')),
	array('label'=>'Manage FuenteFinanciamientoObra', 'url'=>array('admin')),
);
?>

<h1>Fuente Financiamiento Obras</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
