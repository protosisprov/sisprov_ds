<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'desarrollo-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    ),
        ));
?>
<?php
/*if (!empty($model->parroquia_id)) {

    $id_parroquia = Tblparroquia::model()->findByPk($model->parroquia_id); // consulta en la tabla ciudad el id_ciudad y id_estado 
    $id_municipio = $id_parroquia->clvmunicipio0->clvcodigo;
    $id_estado = $id_parroquia->clvmunicipio0->clvestado0->clvcodigo;
}*/
?>
<?php /* Yii::app()->clientScript->registerScript('desarrollo', "
         $('#guardar').click(function(){
                if($('#Desarrollo_nombre').val()==''){
                   bootbox.alert('Por favor indique el nombre del Desarrollo');
                    return false;
                }

                if($('#Tblestado_clvcodigo').val()==''){
                 alert('Por favor seleccione Estado');
                    return false;
                }
                if($('#Tblmunicipio_clvcodigo').val()==''){
                   alert('Por favor seleccione Municipio');
                    return false;
                }
                if($('#Desarrollo_parroquia_id').val()==''){
                   alert('Por favor seleccione Parroquia');
                    return false;
                }

                });

        $(document).ready(function(){
            var titularidad ='".$model->titularidad_del_terreno."';
                if(titularidad== true){
                    $('#titularidad_del_terreno').bootstrapSwitch('state', true, true);
                }   else {
                    $('#titularidad_del_terreno').bootstrapSwitch('state', false, false);
                }


            $('#Tblestado_clvcodigo').val(" . $id_estado . ");
                    
            $.get('" . CController::createUrl('ValidacionJs/BuscarMunicipios') . "', {clvcodigo: " . $id_estado . " }, function(data){
                $('#Tblmunicipio_clvcodigo').html(data);
                $('#Tblmunicipio_clvcodigo').val(" . $id_municipio . ");
                
            });
            $.get('" . CController::createUrl('ValidacionJs/BuscarParroquias') . "', {municipio: " . $id_municipio . "}, function(data){
                $('#Desarrollo_parroquia_id').html(data);
                $('#Desarrollo_parroquia_id').val(" . $model->parroquia_id . ");
            });
            $.get('" . CController::createUrl('ValidacionJs/CargarPrograma') . "', {fuente_financiamiento_id: " . $model->fuente_financiamiento_id . " }, function(data){
                $('#Desarrollo_programa_id').html(data);
                $('#Desarrollo_programa_id').val('" . $model->programa_id . "');
            });
        });


        ") */ ?>
<?php  Yii::app()->clientScript->registerScript('desarrollo', "

        $(document).ready(function(){
             $('#RegistroDocumento_registro_publico_id').numeric();
             $('#RegistroDocumento_asiento_registral').numeric();
             $('#RegistroDocumento_ano').numeric();
             $('#RegistroDocumento_folio_real').numeric();
        });

         $('#guardar').click(function(){
         
                if($('input:radio[name=id_doc]:checked').val()==null){
                   bootbox.alert('Por favor seleccione Documento a registrar');
                    return false;
                }


                if($('#RegistroDocumento_registro_publico_id').val()==''){
                   bootbox.alert('Por favor seleccione Registro Público');
                    return false;
                }

                if($('#RegistroDocumento_fecha_registro').val()==''){
                   bootbox.alert('Por favor seleccione Fecha de Registro');
                    return false;
                }

                if($('#RegistroDocumento_nro_protocolo').val()==''){
                   bootbox.alert('Por favor seleccione Número de Protocolo');
                    return false;
                }

                if($('#RegistroDocumento_ano').val()==''){
                   bootbox.alert('Por favor seleccione el año');
                    return false;
                }

                if($('#RegistroDocumento_asiento_registral').val()==''){
                   bootbox.alert('Por favor indique Asiento Registral');
                    return false;
                }

                if($('#RegistroDocumento_folio_real').val()==''){
                   bootbox.alert('Por favor indique Folio Real');
                    return false;
                }

                if($('#RegistroDocumento_nro_matricula').val()==''){
                   bootbox.alert('Por favor indique Número de Matricula');
                    return false;
                }
            });

        ") ?>
<?php /*
if (isset($sms) && !empty($sms)) {
    $user = Yii::app()->getComponent('user');
    $user->setFlash(
            'warning', "<strong>Ya existe un desarrollo con este nombre.</strong>"
    );
    $this->widget('booster.widgets.TbAlert', array(
        'fade' => true,
        'closeText' => '&times;', // false equals no close link
        'events' => array(),
        'htmlOptions' => array(),
        'userComponentId' => 'user',
        'alerts' => array(// configurations per alert type
            'warning' => array('closeText' => false),
        ),
    ));
}*/
?>

<!--<h1>Desarrollo</h1>-->

<div class="row">
    <div class="col-md-12">
        <?php
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Documentos',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'headerIcon' => 'globe',
            'content' => $this->renderPartial('_documentos', array('docs'=>$docs), TRUE),
                )
        );
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Datos Magistrales',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'headerIcon' => 'globe',
            'content' => $this->renderPartial('_formRegistral', array('form' => $form, 'model' => $model, 'docs'=>$docs), TRUE),
                )
        );
        ?>
    </div>
</div>

<div class="well">
    <div class="pull-center" style="text-align: right;">
        <?php
        $this->widget('booster.widgets.TbButton', array(
//            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon glyphicon-step-backward',
            'size' => 'large',
            'id' => 'cancelar',
            'context' => 'danger',
            'label' => 'Cancelar',
            'htmlOptions' => array(
                'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/adminmultifamiliar') . '"'),
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

<?php //echo $this->renderPartial('_form', array('model'=>$model));   ?>

<?php $this->endWidget(); ?>