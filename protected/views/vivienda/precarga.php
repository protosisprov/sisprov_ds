<?php  
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
?>

<?php

$this->breadcrumbs = array(
    'Viviendas' => array('index'),
    $model->id_vivienda => array('view', 'id' => $model->id_vivienda),
    'Precarga',
);
?>

<?php Yii::app()->clientScript->registerScript('desarrolloVal', "
            
    $(document).ready(function(){
        var fieldDescripcion = $('#Maestro_descripcion').val();
            if(fieldDescripcion == 'PARCELA' || fieldDescripcion == 'TETRA' || fieldDescripcion == 'PENDIENTE'){
                html = '<option value=\'\'>SELECCIONE</option><option value=\'93\'>CASA</option><option value=\'94\'>APARTAMENTO</option><option value=\'95\'>TOWNHOUSE</option>';
                $('#Vivienda_tipo_vivienda_id').html(html);
                $('#Vivienda_nro_piso').val('');
                $('#piso_vivienda').hide();
            }else{
                html = '<option value=\'\'>SELECCIONE</option><option value=\'94\'>APARTAMENTO</option><option value=\'95\'>TOWNHOUSE</option>';
                $('#Vivienda_tipo_vivienda_id').html(html);
                $('#piso_vivienda').show();
                $('#Vivienda_nro_piso').val('');
            }
            //$('#Vivienda_tipo_vivienda').val(fieldDescripcion);
    });
"); ?>

<?php
if (isset($sms) && !empty($sms)) {
    $user = Yii::app()->getComponent('user');
    switch ($sms) {
        case 1:
            $user->setFlash(
                'warning', "<strong>Número de vivienda ya se encuentra registado.</strong>"
            );
            $tipo = 'warning';
            break;
        case 2:
            $user->setFlash(
                'success', "<strong>Vivienda registrada exitósamente.</strong>"
            );
            $tipo = 'success';
            break;
    }

    $this->widget('booster.widgets.TbAlert', array(
        'fade' => true,
        'closeText' => '&times;', // false equals no close link
        'events' => array(),
        'htmlOptions' => array(),
        'userComponentId' => 'user',
        'alerts' => array(// configurations per alert type
            $tipo => array('closeText' => false),
        ),
    ));
    
    Yii::app()->clientScript->registerScript(
        'myHideEffect',
        '$("#yw0").animate({opacity: 0.2}, 5000, function(){$("#yw0").css("visibility","hidden")});',
        CClientScript::POS_READY
    );
}
?>

<?php

if (!empty($unidad_habitacional->id_unidad_habitacional)) {
    
    
    $id_unidad = $unidad_habitacional->id_unidad_habitacional;
    $id_desarrollo = $unidad_habitacional->desarrollo_id;
 
    $id_parroquia = $unidad_habitacional->desarrollo->parroquia_id;
    //$id_municipio = $unidad_habitacional->desarrollo->fkParroquia->clvmunicipio0->clvcodigo;
    
    $id_municipio = $unidad_habitacional->desarrollo->fkParroquia->clvmunicipio0->clvcodigo;
    $id_estado = $unidad_habitacional->desarrollo->fkParroquia->clvmunicipio0->clvestado0->clvcodigo;

}
?>
<?php
Yii::app()->clientScript->registerScript('vivienda', "


        $(document).ready(function(){
        
                    
         $('#Tblestado_clvcodigo').val(" . $id_estado . ");
          $.get('" . CController::createUrl('ValidacionJs/ConsultaMunicipios') . "', {clvcodigo: " . $id_municipio . "}, function(data){
                $('#Tblmunicipio_clvcodigo').html(data);
            });
          $.get('" . CController::createUrl('ValidacionJs/BuscarParroquias') . "', {municipio: " . $id_municipio . "}, function(data){
                $('#Tblparroquia_clvcodigo').html(data);
                $('#Tblparroquia_clvcodigo').val(" . $id_parroquia . ");
            });
          $.get('" . CController::createUrl('ValidacionJs/BuscarDesarrollo') . "', {desarrollo: " . $id_parroquia . "}, function(data){
                $('#Desarrollo_id_desarrollo').html(data);
                $('#Desarrollo_id_desarrollo').val(" . $id_desarrollo . ");
            });
            $.get('" . CController::createUrl('ValidacionJs/BuscarUnidadHabitacional') . "', {unidad: " . $id_desarrollo . "}, function(data){
                $('#Vivienda_unidad_habitacional_id').html(data);
                $('#Vivienda_unidad_habitacional_id').val(" . $unidad_habitacional->id_unidad_habitacional . ");
            });


        });


     ");
?>
<h1> Precarga del Inmueble Familiar</h1>

<?php

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'vivienda-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    ),
        ));
?>

<div class="row">
    <div class="col-md-12">
<?php
$this->widget(
    'booster.widgets.TbPanel', array(
    'title' => 'Precarga del Inmueble Familiar',
    'context' => 'info',
    'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
    'headerIcon' => 'globe',
    'content' => $this->renderPartial('_formPrecarga', array('form' => $form, 'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia, 'desarrollo' => $desarrollo, 'unidad_habitacional' => $unidad_habitacional), TRUE),
        )
);
?>
    </div>
</div>

<div class="well">
    <div class="pull-center" style="text-align: right;">
<?php
$this->widget('booster.widgets.TbButton', array(
    'buttonType' => 'button',
    'icon' => 'glyphicon glyphicon glyphicon-step-backward',
    'size' => 'large',
    'id' => 'cancelar',
    'context' => 'danger',
    'label' => 'Cancelar',
    //'url' => $this->createURL('/desarrollo/admin'),
    'htmlOptions' => array(
        'onclick' => 'document.location.href ="' . $this->createUrl('vswUnifamiliar/admin') . '"'),
        //'onclick' => 'goBack()'),    
));
?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'large',
            'id' => 'guardar',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Guardar' : 'Actualizar',
        ));
        ?>
        
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'large',
            'id' => 'cargar_inmueble',
            'context' => 'primary',
            'label' => 'Guardar y Cargar Nueva Vivienda' ,
            'htmlOptions'=>array('name'=>'cargar_inmueble', 'value'=>'1')
        ));
        ?>
    </div>
</div>

<?php //echo $this->renderPartial('_form', array('model'=>$model));    ?>

<?php $this->endWidget(); ?>
