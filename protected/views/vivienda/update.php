<?php 
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
?>

<?php
$this->breadcrumbs = array(
    'Viviendas' => array('index'),
    $model->id_vivienda => array('view', 'id' => $model->id_vivienda),
    'Update',
);
?>
<?php
if (!empty($model->unidad_habitacional_id)) {
    $id_unidad = UnidadHabitacional::model()->findByPk($model->unidad_habitacional_id);
    $id_desarrollo = $id_unidad->desarrollo_id; // consulta en la tabla ciudad el id_ciudad y id_estado 
    $id_parroquia = $id_unidad->desarrollo->parroquia_id;
    $id_municipio = $id_unidad->desarrollo->fkParroquia->clvmunicipio0->clvcodigo;
    $id_estado = $id_unidad->desarrollo->fkParroquia->clvmunicipio0->clvestado0->clvcodigo;
    $id_tipo_inmueble = $id_unidad->genTipoInmueble->descripcion;
}
?>
<?php
Yii::app()->clientScript->registerScript('vivienda', "


        $(document).ready(function(){
        

            $('#Vivienda_tipo_vivienda').val('" . $id_tipo_inmueble . "');
            if (" . $model->tipo_vivienda_id . "== 94){
                $('#piso_vivienda').show();                               
            }else {
                $('#piso_vivienda').hide();                
            }
                    
         $('#Tblestado_clvcodigo').val(" . $id_estado . ");
          $.get('" . CController::createUrl('ValidacionJs/BuscarMunicipios') . "', {clvcodigo: " . $id_estado . "}, function(data){
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
                $('#Vivienda_unidad_habitacional_id').val(" . $model->unidad_habitacional_id . ");
            });
        });


     ");
?>
<h1>Actualizar Identificación del Inmueble Familiar</h1>
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
    'title' => 'Actualización de la vivienda N° ' . $model->id_vivienda,
    'context' => 'info',
    'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
    'headerIcon' => 'globe',
    'content' => $this->renderPartial('_formUpdate', array('form' => $form, 'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia, 'desarrollo' => $desarrollo), TRUE),
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
//        'onclick' => 'document.location.href ="' . $this->createUrl('vswUnifamiliar/admin') . '"'),
        'onclick' => 'goBack()'),    
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
    </div>
</div>

<?php //echo $this->renderPartial('_form', array('model'=>$model));    ?>

<?php $this->endWidget(); ?>
