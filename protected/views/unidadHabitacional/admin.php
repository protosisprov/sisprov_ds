<?php
//$this->breadcrumbs=array(
//	'Unidad Habitacionals'=>array('index'),
//	'Manage',
//);
//
//$this->menu=array(
//array('label'=>'List UnidadHabitacional','url'=>array('index')),
//array('label'=>'Create UnidadHabitacional','url'=>array('create')),
//);
//
//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//$('.search-form').toggle();
//return false;
//});
//$('.search-form form').submit(function(){
//$.fn.yiiGridView.update('unidad-habitacional-grid', {
//data: $(this).serialize()
//});
//return false;
//});
//");
?>

<h1>Gestión de Unidades Multifamiliares</h1>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'unidad-habitacional-grid',
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,

    'columns' => array(
      'id_unidad_habitacional' => array(
          'header' => 'N°',
          'name' => 'id_unidad_habitacional',
          'value' => '$data->id_unidad_habitacional',
          'htmlOptions' => array('style' => 'text-align: center', 'width' => '15px'),

//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
      ),
        'nombre' => array(
            'header' => 'Unidad Multifamiliar',
            'name' => 'nombre',
            'value' => '$data->nombre',
//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        ),
        'desarrollo_id' => array(
            'header' => 'Nombre de Desarrollo',
            'name' => 'desarrollo_id',
            'value' => '$data->desarrollo->nombre',

        ),

        'Estado' => array(
            'header' => 'Estado',
            'name' => 'nombre',
            'value' => '$data->desarrollo->fkParroquia->clvmunicipio0->clvestado0->strdescripcion',
//            'filter' => Maestro::FindMaestrosByPadreSelect(71),
        ),

        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{ver} {pdf}',
            'buttons' => array(
                'ver' => array(
                    'label' => 'Ver',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("UnidadHabitacional/view/", array("id"=>$data->id_unidad_habitacional))',
                ),
                'pdf' => array(
                    'label' => 'Generar PDF',
                    'icon' => 'glyphicon glyphicon-file',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("UnidadHabitacional/pdf/", array("id"=>$data->id_unidad_habitacional))',
                ),
                /*'modificar' => array(
                    'label' => 'Modificar',
                    'icon' => 'glyphicon glyphicon-pencil',
                    'size' => 'medium',
                    'url' => 'Yii::app()->createUrl("UnidadHabitacional/update/", array("id"=>$data->id_unidad_habitacional))',
//                    'visible' => 'Asignar($data->username);'
                ),*/

            ),
        ),
    ),
));
?>


<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<!--<div class="search-form" style="display:none">
<?php
// $this->renderPartial('_search',array(
//	'model'=>$model,
//));
?>
</div> search-form -->

<?php
//$this->widget('booster.widgets.TbGridView', array(
//    'id' => 'unidad-habitacional-grid',
//    'dataProvider' => $model->search(),
//    'filter' => $model,
//    'columns' => array(
//        'id_unidad_habitacional',
//        'nombre',
//        'desarrollo_id',
//        'gen_tipo_inmueble_id',
//        'total_unidades',
//        'registro_publico_id',
        /*
          'tipo_documento_id',
          'fecha_registro',
          'tomo',
          'ano',
          'nro_documento',
          'asiento_registral',
          'folio_real',
          'nro_matricula',
          'fuente_datos_entrada_id',
          'fecha_creacion',
          'fecha_actualizacion',
          'usuario_id_creacion',
          'usuario_id_actualizacion',
          'estatus',
          'num_protocolo',
         */
//        array(
//            'class' => 'booster.widgets.TbButtonColumn',
//        ),
//    ),
//));
?>
