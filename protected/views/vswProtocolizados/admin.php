<?php
$this->breadcrumbs=array(
	'Vsw Protocolizadoses'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List VswProtocolizados','url'=>array('index')),
array('label'=>'Create VswProtocolizados','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('vsw-protocolizados-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Beneficiarios Protocolizados</h1>

<?php 
$this->widget('booster.widgets.TbGridView',array(
	'id'=>'vsw-protocolizados-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'template' => "{items}{pager}",
	'columns' => array_merge(array(
        /*'id_desarrollo' => array(
            //'class'=>'booster.widgets.TbRelationalColumn',
            'header' => 'Id del desarrollo',
            'name' => 'id_desarrollo',
            'value' => '$data->id_desarrollo',
//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        ),*/
        'nombre_desarrollo' => array(
            'class'=>'booster.widgets.TbRelationalColumn',
            'header' => 'Nombre',
            'name' => 'nombre_desarrollo',
            'url' => $this->createUrl('vswProtocolizados/relational'),
            'value' => '$data->nombre_desarrollo',
            'filter' => CHtml::listData(VswProtocolizados::model()->findall(), 'nombre_desarrollo', 'nombre_desarrollo'),
            //'filter' => CHtml::listData(Desarrollo::model()->findall(), 'nombre', 'nombre'),
//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        ),
        'nombre_estado' => array(
            'header' => 'Estado',
            'name' => 'nombre_estado',
            'value' => '$data->nombre_estado',
            //'value' => '$data->fkParroquia->clvmunicipio0->clvestado0->strdescripcion',
            'filter' => CHtml::listData(VswProtocolizados::model()->findall(), 'nombre_estado', 'nombre_estado'),
            //'filter' =>false,
            //'filter' => CHtml::listData(Tblestado::model()->findall(), 'clvcodigo', 'strdescripcion'),
            //'filter' => CHtml::listData(Tblestado::model()->findall(), 'clvcodigo', 'strdescripcion'),
//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        ),
    )),
)); ?>