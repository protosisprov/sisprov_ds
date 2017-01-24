<?php
$this->breadcrumbs = array(
    'Desarrollos' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Desarrollo', 'url' => array('index')),
    array('label' => 'Create Desarrollo', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
    });
    $('.search-form form').submit(function(){
    $.fn.yiiGridView.update('desarrollo-grid', {
    data: $(this).serialize()
    });
    return false;
    });
");
?>


<?php //echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn btn-info')); ?>
<h1>Beneficiarios Protocolizados</h1>

<?php // echo CHtml::link('Busqueda Avanzada', '#', array('class' => 'search-button btn')); ?>
<!--<div class="search-form" style="display:none">-->
<?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
?>
<!----></div><!-- search-form -->

<?php
// on your view
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'desarrollo-grid',
    'filter'=>$model,
    'type'=>'striped bordered condensed',
    'dataProvider' => $model->searchGroupBy(),
    'template' => "{items}{pager}",
    'columns' => array_merge(array(
        'id_desarrollo' => array(
            //'class'=>'booster.widgets.TbRelationalColumn',
            'header' => 'Id del desarrollo',
            'name' => 'id_desarrollo',
            'value' => '$data->id_desarrollo',
//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        ),
        'nombre_desarrollo' => array(
            'class'=>'booster.widgets.TbRelationalColumn',
            'header' => 'Nombre',
            'name' => 'nombre_desarrollo',
            'url' => $this->createUrl('desarrollo/relational'),
            'value' => '$data->nombre_desarrollo',
            'filter' => CHtml::listData(Desarrollo::model()->findall(array('order'=>'nombre asc')), 'nombre', 'nombre'),
//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        ),
        'cod_estado' => array(
            'header' => 'Estado',
            'name' => 'cod_estado',
            'value' => '$data->estado',
            //'value' => '$data->fkParroquia->clvmunicipio0->clvestado0->strdescripcion',
            //'filter' =>false,
            //'filter' => CHtml::listData(Tblestado::model()->findall(), 'clvcodigo', 'strdescripcion'),
            'filter' => CHtml::listData(Tblestado::model()->findall(), 'clvcodigo', 'strdescripcion'),
//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        ),
    )),
));
?>
