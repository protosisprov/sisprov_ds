<?php
$Validaciones = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/validacion.js');
$numeric = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/js_jquery.numeric.js');
$mascara = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mask.min.js');
Yii::app()->clientScript->registerScript('reasignacion', "
    $(document).ready(function(){
            $('#ReasignacionVivienda_cedulaAnterior').numeric();   
            $('#ReasignacionVivienda_cedula').numeric();  
             $('#Vivienda_construccion_mt2').numeric();
            $('#Beneficiario_rif').mask('A-BBBBBBBB-9', {translation: { 'A': {pattern: /[VEve]/}, 'B':{pattern: /[0-9]/}}, clearIfNotMatch: true});
            $('#ReasignacionVivienda_telf_habitacionActual').mask('02AA-BBBBBBB', {translation: { 'A': {pattern: /[0-9]/}, 'B':{pattern: /[0-9]/}}, clearIfNotMatch: true});
            $('#ReasignacionVivienda_telf_celularActual').mask('04AA-BBBBBBB', {translation: { 'A': {pattern: /[0-9]/}, 'B':{pattern: /[0-9]/}}, clearIfNotMatch: true});
    });
        $('#guardar').click(function(){
            if( $('#ReasignacionVivienda_nacionalidad').val() == ''){
                bootbox.alert('Seleccione la Nacionalidad .');
                return false;
            }
            if( $('#ReasignacionVivienda_cedula').val() == ''){
                   bootbox.alert('Indique la Cédula .');
                   return false;
             }
            if( $('#ReasignacionVivienda_sexoActual').val() == ''){
                   bootbox.alert('Seleccione su sexo .');
                   return false;
             }
            if( $('#ReasignacionVivienda_estado_civilActual').val() == ''){
                   bootbox.alert('Seleccione su estado civil.');
                   return false;
             }
             if( $('#ReasignacionVivienda_telf_habitacionActual').val() == ''  &&  $('#ReasignacionVivienda_telf_celularActual').val() == '' ){
                bootbox.alert('Usted debe registrar al menos un número Telefónico.');
                return false;
            }
            if($('#Beneficiario_fecha_ultimo_censo').val()==''){
                    bootbox.alert('Por favor indique Fecha del censo');
                    return false;
            }
            if($('#UnidadFamiliar_condicion_unidad_familiar_id').val()==''){
                    bootbox.alert('Por favor indique Condición de la Unidad Familiar');
                    return false;
            }
            if( $('#ReasignacionVivienda_tipo_reasignacion_id').val() == ''){
                   bootbox.alert('Seleccione el tipo de Reasignación de Vivienda.');
                   return false;
             }
            if( $('#ReasignacionVivienda_fecha_reasignacion').val() == ''){
                   bootbox.alert('Indique la fecha de Reasignación.');
                   return false;
             }
            if($('#Vivienda_construccion_mt2').val()==''){
                bootbox.alert('Por favor indique Construcción metros cuadrados de la vivienda');
                return false;
             }


        });

");
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'reasignacion-vivienda-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
        )));
?>

<h1 class="text-center">Situación Irregular</h1>


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

<?php #echo $this->renderPartial('_form', array('model'=>$model));  ?>

<div class="row">
    <div class="col-md-12">
        <?php
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Beneficiario Anterior',
            'context' => 'info',
            'headerIcon' => 'user',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_beneficiarioAnterior', array('form' => $form, 'model' => $model), TRUE),
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
            'title' => 'Beneficiario Actual',
            'context' => 'info',
            'headerIcon' => 'user',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_beneficiarioActual', array('form' => $form, 'model' => $model, 'unidad_familiar' => $unidad_familiar, 'beneficiario' => $beneficiario, 'vivienda' => $vivienda), TRUE),
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
            'title' => 'Re-Asignación ',
            'context' => 'info',
            'headerIcon' => 'user',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model, 'vivienda' => $vivienda), TRUE),
                )
        );
        ?>
    </div>
</div>

<div class="well">
    <div class="pull-center" style="text-align: right;">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'large',
            'id' => 'guardar',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Guardar y Continuar' : 'Save',
        ));
        ?>

        <?php
        $this->widget('booster.widgets.TbButton', array(
            'context' => 'danger',
            'label' => 'Cancelar',
            'size' => 'large',
            'id' => 'CancelarForm',
            'icon' => 'ban-circle',
            'htmlOptions' => array(
                'onclick' => 'document.location.href ="' . $this->createUrl('/vswEmpadronadorCensos/admin') . '";'
            )
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>