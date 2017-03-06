<?php
 function traza($iD) {
     $traza = Traza::getTraza($iD);
     return $traza;
 }

function nombre($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_NOMBRE'];
}

function apellido($selec, $iD) {
    $saime = ConsultaOracle::getPersonaByPk($selec, (int) $iD);
    return $saime['PRIMER_APELLIDO'];
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('beneficiario-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1 class="text-center">Gestión Análisis de Crédito</h1>



<?php
$model->estatus_beneficiario_id=273;
//$model->beneficiarioTemporal->desarrollo->fuente_financiamiento_id = 3;
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'beneficiario-grid',
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id_beneficiario',
            'header' => 'N°',
            'value' => '$data->id_beneficiario',
            'htmlOptions' => array('style' => 'text-align: center', 'width' => '90px'),
        ),
        array(
            'name' => 'persona_id',
            'header' => 'Nombre',
            'value' => 'nombre("PRIMER_NOMBRE",$data->persona_id)',
        ),
        array(
            'name' => 'persona_id',
            'header' => 'Apellido',
            'value' => 'apellido("PRIMER_APELLIDO",$data->persona_id)',
        ),
        'Estado' => array(
            'header' => 'Estado',
            'name' => 'beneficiarioTemporal',
            'value' => 'Tblparroquia::model()->findByPK(Desarrollo::model()->findByPK($data->beneficiarioTemporal->desarrollo_id)->parroquia_id)->clvmunicipio0->clvestado0->strdescripcion',
            'filter' => CHtml::listData(Tblestado::model()->findall(), 'clvcodigo', 'strdescripcion'),
        ),
        'Desarrollo' => array(
            'header' => 'Desarrollo',
            'name' => 'beneficiarioTemporal',
            'value' => '$data->beneficiarioTemporal->desarrollo->nombre',
            'filter' => CHtml::listData(Desarrollo::model()->findall(), 'id_desarrollo', 'nombre'),
        ),
        array(
            'name' => 'fecha_ultimo_censo',
            'value' => 'Yii::app()->dateFormatter->format("d/MM/y", strtotime($data->fecha_ultimo_censo))',
            'htmlOptions' => array('style' => 'text-align: center', 'width' => '100px'),

        //'header' => 'Creación',
        ),
        array(
             'name' => 'id_beneficiario',
             'header' => 'Avance',
             'value' => 'traza($data->id_beneficiario)',
             'htmlOptions' => array('style' => 'text-align: center', 'width' => '10px'),

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
