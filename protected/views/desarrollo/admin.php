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
<h1>Gestión de Desarrollos</h1>

<?php // echo CHtml::link('Busqueda Avanzada', '#', array('class' => 'search-button btn')); ?>
<!--<div class="search-form" style="display:none">-->
<?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
?>
<!----></div><!-- search-form -->

<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'desarrollo-grid',
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id_desarrollo' => array(
            'header' => 'N°',
            'name' => 'id_desarrollo',
            'value' => '$data->id_desarrollo',
            'htmlOptions' => array('width' => '80', 'style' => 'text-align: center;'),
        ),
        'nombre' => array(
            'header' => 'Nombre',
            'name' => 'nombre',
            'value' => '$data->nombre',
            'filter' => CHtml::listData(Desarrollo::model()->findall(), 'nombre', 'nombre'),
//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        ),
        'ente_ejecutor_id' => array(
            'name' => 'ente_ejecutor_id',
            'value' => '$data->enteEjecutor->nombre_ente_ejecutor',
            'filter' => CHtml::listData(EnteEjecutor::model()->findall(), 'id_ente_ejecutor', 'nombre_ente_ejecutor'),
        ),
        'fuente_financiamiento_id' => array(
            'name' => 'fuente_financiamiento_id',
            'value' => '$data->fuenteFinanciamiento->nombre_fuente_financiamiento',
            'filter' => CHtml::listData(FuenteFinanciamiento::model()->findall(), 'id_fuente_financiamiento', 'nombre_fuente_financiamiento'),
        ),
//        'parroquia_id' => array(
//            'header' => 'Estado',
//            'name' => 'parroquia_id',
//            'value' => '$data->fkParroquia->clvmunicipio0->clvestado0->strdescripcion',
//            'filter' => CHtml::listData(Tblestado::model()->findall(), 'clvcodigo', 'strdescripcion'),
////            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        'estado_rel' => array(
            'header' => 'Estado',
            'name' => 'estado_rel',
            'value' => '$data->fkParroquia->clvmunicipio0->clvestado0->strdescripcion',
            'filter' => CHtml::listData(Tblestado::model()->findall(), 'clvcodigo', 'strdescripcion'),
//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        ),

        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{ver} {modificar} {pdf}',
            'buttons' => array(
                'ver' => array(
                    'label' => 'Ver',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_desarrollo_view")))',
                    'url' => 'Yii::app()->createUrl("desarrollo/view/", array("id"=>$data->id_desarrollo))',
                ),
                'modificar' => array(
                    'label' => 'Modificar',
                    'icon' => 'glyphicon glyphicon-pencil',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_desarrollo_update")))',
                    'url' => 'Yii::app()->createUrl("desarrollo/update/", array("id"=>$data->id_desarrollo))',
//                    'visible' => 'Asignar($data->username);'
                ),
                'pdf' => array(
                    'label' => 'Generar PDF',
                    'icon' => 'glyphicon glyphicon-file',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_desarrollo_pdf")))',
                    'url' => 'Yii::app()->createUrl("desarrollo/pdf/", array("id"=>$data->id_desarrollo))',
//                    'visible' => 'Asignar($data->username);'
                ),
            ),
        ),
    ),
));
?>
