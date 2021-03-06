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
<?php Yii::app()->clientScript->registerScript('desarrollo', "
         $('#guardar').click(function(){
                if($('#Desarrollo_nombre').val()==''){
                    bootbox.alert('Por favor indique el nombre del Desarrollo');
                    return false;
                }
         
                if($('#Tblestado_clvcodigo').val()==''){
                    bootbox.alert('Por favor seleccione Estado');
                    return false;
                }
                if($('#Tblmunicipio_clvcodigo').val()==''){
                   bootbox.alert('Por favor seleccione Municipio');
                    return false;
                }
                if($('#Desarrollo_parroquia_id').val()==''){
                    bootbox.alert('Por favor seleccione Parroquia');
                    return false;
                }
                
                if($('#Desarrollo_nombre').val()==''){
                    bootbox.alert('Por favor de indicar el Nombre del Desarrollo');
                    return false;
                }
                if($('#Desarrollo_descripcion').val()==''){
                    bootbox.alert('Por favor de indicar la Descripción del Desarrollo');
                    return false;
                }
                if($('#Desarrollo_fuente_financiamiento_id').val()==''){
                    bootbox.alert('Por favor indicar Fuente de Finacinamiento');
                    return false
                }
                if($('#Desarrollo_ente_ejecutor_id').val()==''){
                   bootbox.alert('Por favor indicar Fuente de Finacinamiento');
                    return false;
                }
                if($('#titularidad_del_terreno').is(':checked')){
                    if($('#Desarrollo_fecha_transferencia').val()== ''){
                        bootbox.alert('Por favor indique Fecha de transferencia');
                        return false;       
                    }
                }
                
                
        });
         
        
        $('#Desarrollo_lote_terreno_mt2').numeric()
        ") ?>

<?php
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
}
?>

<h1 class="text-center">Cargar Nuevo Desarrollo</h1>

<?php 
        $this->widget(
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
            'title' => 'Desarrollo Habitacional',
            'context' => 'info',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'headerIcon' => 'globe',
             'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia, 'enteEjecutor' => $enteEjecutor, 'fuenteFinacimiento' => $fuenteFinacimiento), TRUE),
                )
        );
        ?>
    </div>
</div>
<div class="well">
    <div class="pull-center" style="text-align: right;">
        <?php /*
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'large',
            'id' => 'guardar',
            'context' => 'success',
            'label' => 'Guardar',
        )); */
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'large',
            'id' => 'guardar',
            'context' => 'primary',
            'label' => 'Guardar' ,
            'htmlOptions'=>array('name'=>'CARGAR_OTRO', 'value'=>'1')
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'large',
            'id' => 'guardar',
            'context' => 'primary',
            'label' => 'Guardar-Agregar Unidad H.' ,
            'htmlOptions'=>array('name'=>'cargar_unidad', 'value'=>'1')
        ));
        ?>
        <?php
            $this->widget('booster.widgets.TbButton', array(
                'context' => 'danger',
                'label' => 'Regresar',
                'size' => 'large',
                'id' => 'CancelarForm',
                'icon' => 'ban-circle',
                'htmlOptions' => array(
                    'onclick' => 'document.location.href ="' . $this->createUrl('admin') . '";'
                )
            ));
        ?>
    </div>
</div>

<?php //echo $this->renderPartial('_form', array('model'=>$model));  ?>

<?php $this->endWidget(); ?>
