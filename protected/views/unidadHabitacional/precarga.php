<?php  
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
?>

<?php
$this->breadcrumbs = array(
    'Crear la Unidad Habitacional',
    $model->id_unidad_habitacional => array('view', 'id' => $model->id_unidad_habitacional),
    'Precarga',
);
?>

<?php
if (!empty($desarrollo->id_desarrollo)) {

    
    $id_desarrollo = $desarrollo->id_desarrollo;
    $id_parroquia = $desarrollo->parroquia_id;
    $id_municipio = $desarrollo->fkParroquia->clvmunicipio0->clvcodigo;
    $id_estado = $desarrollo->fkParroquia->clvmunicipio0->clvestado0->clvcodigo;
    
}

?>

<?php
Yii::app()->clientScript->registerScript('unidadHabitacional', "
         $('#guardarUnidad').click(function(){

                if($('#Tblestado_clvcodigo').val()==''){
                    bootbox.alert('Por favor seleccione Estado');
                    return false;
                }
                if($('#Tblmunicipio_clvcodigo').val()==''){
                   bootbox.alert('Por favor seleccione Municipio');
                    return false;
                }
                if($('#Tblparroquia_clvcodigo').val()==''){
                    bootbox.alert('Por favor seleccione Parroquia');
                    return false;
                }
                if($('#UnidadHabitacional_desarrollo_id').val()==''){
                    bootbox.alert('Por favor seleccione el Desarrollo');
                    return false;
                }

                if($('#UnidadHabitacional_nombre').val()==''){
                    bootbox.alert('Por favor indique nombre de la unidad habitacional');
                    return false;
                }
                if($('#UnidadHabitacional_gen_tipo_inmueble_id').val()==''){
                    bootbox.alert('Por favor indique tipo de inmueble');
                    return false;
                }
        });

      $(document).ready(function(){
      
       $('#UnidadHabitacional_registro_publico_id').attr('disabled', false);
       $('#UnidadHabitacional_fecha_registro').attr('disabled', false);
       $('#UnidadHabitacional_num_protocolo').attr('disabled', false);
       $('#UnidadHabitacional_tomo').attr('readonly', false);
       $('#UnidadHabitacional_tipo_documento_id').attr('disabled', false);
       $('#UnidadHabitacional_ano').attr('disabled', false);
       $('#UnidadHabitacional_nro_documento').attr('readonly', false);
       $('#UnidadHabitacional_asiento_registral').attr('readonly', false);
       $('#UnidadHabitacional_folio_real').attr('readonly', false);
       $('#UnidadHabitacional_nro_matricula').attr('readonly', false);
       $('#Tblestado_clvcodigo').val(" . $id_estado . ");
 
         $.get('" . CController::createUrl('ValidacionJs/BuscarMunicipios') . "', {clvcodigo: " . $id_estado . " }, function(data){
                $('#Tblmunicipio_clvcodigo').html(data);
                $('#Tblmunicipio_clvcodigo').val(" . $id_municipio . ");
                
            });
            $.get('" . CController::createUrl('ValidacionJs/BuscarParroquias') . "', {municipio: " . $id_municipio . "}, function(data){
                $('#Tblparroquia_clvcodigo').html(data);
                $('#Tblparroquia_clvcodigo').val(" . $id_parroquia . ");
            });
           
            $.get('" . CController::createUrl('ValidacionJs/ConsultaDesarrollo') . "', {desarrollo: " . $id_desarrollo . "}, function(data){
                $('#UnidadHabitacional_desarrollo_id').html(data);
                $('#UnidadHabitacional_desarrollo_id').val(" . $model->desarrollo_id . ");
            });
        });


        ");

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'unidad-habitacional-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
    'validateOnSubmit' => true,
    'validateOnChange' => true,
    'validateOnType' => true,
    ),
        ));
?>

<h1>Cargar Nueva Unidad Multifamiliar</h1>

<div>
    <?php
    $this->widget(
        'booster.widgets.TbPanel', array(
        'title' => 'Unidad Habitacional',
        'context' => 'info',
        'headerIcon' => 'user',
        'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
        'content' => $this->renderPartial('_formPrecarga', array('form' => $form, 'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia), TRUE),
            )
    );
    ?>
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
                'onclick' => 'document.location.href ="' . $this->createUrl('/VswMultifamiliar/admin') . '"',
                //'onclick' => 'goBack()',    
            )
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
            'id' => 'guardar',
            'context' => 'primary',
            'label' => 'Guardar-Agregar Inmueble' ,
            'htmlOptions'=>array('name'=>'cargar_inmueble', 'value'=>'1')
        ));
        ?>
    </div>
</div>


<?php $this->endWidget(); ?>
