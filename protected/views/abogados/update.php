
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'abogados-form',
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
$baseUrl = Yii::app()->baseUrl;
$numeros = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/js_jquery.numeric.js');
$mascara = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/jquery.mask.min.js');?>



<?php Yii::app()->clientScript->registerScript('abogadosupdate', "  
     $(document).ready(function(){
         $('#Abogados_rif_abogado').mask('A-BBBBBBBB-9', {translation: { 'A': {pattern: /[VEve]/}, 'B':{pattern: /[0-9]/}}, clearIfNotMatch: true});
         $('#Abogados_tomo').numeric();
         $('#Abogados_cedula').numeric();
    }); 
        $('#guardar').click(function(){
            if($('#Abogados_tipo_abogado_id').val()==''){
              bootbox.alert('Por favor indique el tipo de agente');
                    return false;
            }
            
            if($('#Abogados_tipo_abogado_id').val()=='101'){
                if($('#Abogados_inpreabogado').val()==''){
                    bootbox.alert('Por favor indique el inpreabogado');
                    return false;
                }
            }else{ 
            
                if($('#Abogados_tipo_abogado_id').val()=='100'){
                    if($('#Abogados_rif_abogado').val()==''){
                        bootbox.alert('Por favor indique el rif abogado');
                        return false;
                    }
                    if($('#Abogados_registro_publico_id').val()==''){
                        bootbox.alert('Por favor indique resgistro público');
                        return false;
                    }
                    if($('#Abogados_nun_protocolo').val()==''){
                        bootbox.alert('Por favor indique número de protocolo');
                        return false;
                    }
                    if($('#Abogados_folio').val()==''){
                        bootbox.alert('Por favor indique folio');
                        return false;
                    }
                    if($('#Abogados_tomo').val()==''){
                        bootbox.alert('Por favor indique tomo');
                        return false;
                    }
                    if($('#Abogados_anio').val()==''){
                        bootbox.alert('Por favor indique año');
                        return false;
                    }
                    
                }
            
            }
            

            if($('#Abogados_nacionalidad').val()==''){
              bootbox.alert('Por favor indique Nacionalidad');
                    return false;
            }
            if($('#Abogados_cedula').val()==''){
              bootbox.alert('Por favor indique la cédula');
                    return false;
            }
            if($('#Abogados_oficina_id').val()==''){
              bootbox.alert('Por favor indique la Oficina');
                    return false;
            }
        })
        "); ?>

<h1>Modificar Agente de Documentación y Cobranzas</h1>
 <?php  $this->widget(
                'booster.widgets.TbLabel', array(
            'context' => 'warning',
            'htmlOptions' => array('style' => 'padding:3px;text-aling:center; font-size:13px; span{color:red;}'),
            // 'success', 'warning', 'important', 'info' or 'inverse'
            'label' => 'Los campos marcados con * son requeridos',
                )
        ); ?>
        <br><br>
<div class="row">
    <div class="col-md-12">
        <?php
       
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Agente de Documentación y Cobranzas',
            'context' => 'danger',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'headerIcon' => 'globe',
            'content' => $this->renderPartial('_form_update', array('form' => $form, 'model' => $model, 'consulta' => $consulta), TRUE),
                )
        );
        ?>
    </div>
</div>

<div class="well">
    <div class="pull-center" style="text-align: right;">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'context' => 'danger',
            'label' => 'Cancelar',
            'size' => 'large',
            'id' => 'CancelarForm',
            'icon' => 'ban-circle',
            'htmlOptions' => array(
                'onclick' => 'document.location.href ="' . $this->createUrl('admin') . '";'
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
    </div>
</div>

<?php //echo $this->renderPartial('_form', array('model'=>$model));   ?>

<?php $this->endWidget(); ?>
