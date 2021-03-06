
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'asignacion-censo-form',
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
<?php Yii::app()->clientScript->registerScript('asignacionCenso', "
    $(document).ready(function(){
            $('#AsignacionCenso_cedula').numeric();
            $('#asignacion-censo-form').keypress(function(e) {
                  if (e.which == 13) {
                      return false;
                  }
              });         

    });    

         $('#guardarAsignacion').click(function(){
         
                if ($('#Tblestado_clvcodigo').val()==''){
                    bootbox.alert('Por favor seleccione estado');
                    return false;
                }
                if ($('#Tblmunicipio_clvcodigo').val()==''){
                    bootbox.alert('Por favor seleccione municipio');
                    return false;
                }
                if ($('#Tblparroquia_clvcodigo').val()==''){
                    bootbox.alert('Por favor seleccione parroquia');
                    return false;
                }
                if ($('#AsignacionCenso_desarrollo_id').val()==''){
                    bootbox.alert('Por favor seleccione el desarrollo');
                    return false;
                }
                if ($('#AsignacionCenso_oficina_id').val()==''){
                    bootbox.alert('Por favor seleccione la oficina');
                    return false;
                }
                if ($('#AsignacionCenso_fecha_asignacion').val()==''){
                    bootbox.alert('Por favor indique la fecha de asignación');
                    return false;
                }
                if ($('#AsignacionCenso_nacionalidad').val()==''){
                    bootbox.alert('Por favor indique la nacionalidad');
                    return false;
                }
                if ($('#AsignacionCenso_cedula').val()==''){
                    bootbox.alert('Por favor indique la cedula');
                    return false;
                }
               
            });

") ?>

<h1 class="text-center">Asignación de Censo</h1>

<?php #echo $this->renderPartial('_form', array('model'=>$model)); ?>

<?php
$this->widget(
        'booster.widgets.TbLabel', array(
    'context' => 'warning',
    'htmlOptions' => array('style' => 'padding:3px;text-aling:center; font-size:13px; span{color:red;}'),
    // 'success', 'warning', 'important', 'info' or 'inverse'
    'label' => 'Los campos marcados con * son requeridos',
        )
);
?>
<br><br>

<div>
    <?php
    $this->widget(
            'booster.widgets.TbPanel', array(
        'title' => 'Asignación de Censo',
        'context' => 'danger',
        'headerIcon' => 'stats',
        'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
        'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia), TRUE),
            )
    );
    ?>
</div>
<div>
    <?php
    $this->widget(
            'booster.widgets.TbPanel', array(
        'title' => 'Responsable del Censo',
        'context' => 'danger',
        'headerIcon' => 'user',
        'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
        'content' => $this->renderPartial('_responsable', array('form' => $form, 'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia), TRUE),
            )
    );
    ?>
</div>

<div class="well">
    <div class="pull-center" style="text-align: right;">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'large',
            'id' => 'guardarAsignacion',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Guardar' : 'Actualizar',
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
                'onclick' => 'document.location.href ="' . $this->createUrl('/vswAsignacionCenso/admin') . '";'
            )
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>