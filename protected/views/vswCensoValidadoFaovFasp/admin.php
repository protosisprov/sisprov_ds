<?php
//$this->breadcrumbs=array(
//	'Vsw Censo Validado Faov Fasps'=>array('index'),
//	'Manage',
//);
//   
//   
//$this->menu=array(
//array('label'=>'List VswCensoValidadoFaovFasp','url'=>array('index')),
//array('label'=>'Create VswCensoValidadoFaovFasp','url'=>array('create')),
//);
//Yii::app()->clientScript->registerScript('search', "
//    $('.search-button').click(function(){
//    $('.search-form').toggle();
//    return false;
//        });
//    $('.search-form form').submit(function(){
//    $.fn.yiiGridView.update('vsw-censo-validado-faov-fasp-grid', {
//        data: $(this).serialize()
//    });
//        return false;
//    });
//");
?>

<h1 class="text-center">Gestión Análisis de Crédito Faov</h1>



<?php
$model->id_fuente_financiamiento = 2;
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'vsw-censo-validado-faov-fasp-grid',
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_beneficiario',
            'header' => 'Id Beneficiario',
            'value' => '$data->id_beneficiario',
        ),
        array(
            'name' => 'cedula',
            'header' => 'Cédula',
            'value' => '$data->cedula',
        ),
        array(
            'name' => 'nombre_completo',
            'header' => 'Nombre del Beneficiario',
            'value' => '$data->nombre_completo',
        ),
        'estado' => array(
            'header' => 'Estado',
            'name' => 'cod_estado',
            'value' => '$data->estado',
            'filter' => CHtml::listData(VswCensoValidadoFaovFasp::model()->findall(), 'cod_estado', 'estado'),
        ),
        'nombre' => array(
            'header' => 'Desarrollo Habitacional',
            'name' => 'id_desarrollo',
            'value' => '$data->nombre',
            'filter' => CHtml::listData(VswCensoValidadoFaovFasp::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
        'empadronador_usuario' => array(
            'header' => 'Empadronador Asignado',
            'name' => 'iduser',
            'value' => '$data->empadronador_usuario',
            'filter' => CHtml::listData(VswCensoValidadoFaovFasp::model()->findall(), 'iduser', 'empadronador_usuario'),
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'header' => 'Acciones',
            'htmlOptions' => array('width' => '85', 'style' => 'text-align: center;'),
            'template' => '{ver}{acreditacion}',
            'buttons' => array(
                'ver' => array(
                    'label' => 'Ver censo',
                    'icon' => 'eye-open',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_beneficiario_view")))',
                    'url' => 'Yii::app()->createUrl("beneficiario/view/", array("id"=>$data->id_beneficiario))',
                ),
                'acreditacion' => array(
                    'label' => 'Análisis de Credito',
                    'icon' => 'glyphicon glyphicon-list-alt',
                    'size' => 'medium',
                    'visible' => '((Yii::app()->user->checkAccess("action_analisiscredito_create")))',
                    'url' => 'Yii::app()->createUrl("/analisisCredito/create", array("id"=>$data->id_beneficiario))',
//                    'visible' => 'traza($data->id_beneficiario)==100'
                ),
            ),
        ),
    ),
));
?>
