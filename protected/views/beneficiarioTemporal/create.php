<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'beneficiario-temporal-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        // 'validateOnChange' => true,
        'validateOnType' => true,
    ),
        ));
?>
<?php
$baseUrl = Yii::app()->baseUrl;
$numeros = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/js_jquery.numeric.js');
$mascara = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/jquery.mask.min.js');
?>
<?php Yii::app()->clientScript->registerScript('BeneficiarioTemporal', "
     $(document).ready(function(){
         $('#BeneficiarioTemporal_telf_habitacion').mask('02AA-BBBBBBB', {translation: { 'A': {pattern: /[0-9]/}, 'B':{pattern: /[0-9]/}}, clearIfNotMatch: true});
         $('#BeneficiarioTemporal_telf_celular').mask('04AA-BBBBBBB', {translation: { 'A': {pattern: /[0-9]/}, 'B':{pattern: /[0-9]/}}, clearIfNotMatch: true});
    }); 
        $('#guardar').click(function(){
            if( $('#BeneficiarioTemporal_nacionalidad').val() == ''){
                bootbox.alert('Seleccione la Nacionalidad .');
                return false;
            }
            if( $('#BeneficiarioTemporal_cedula').val() == ''){
                   bootbox.alert('Indique su Cédula .');
                   return false;
             }
            if( $('#BeneficiarioTemporal_sexo').val() == ''){
                   bootbox.alert('Selecione su sexo .');
                   return false;
             }

            if( $('#BeneficiarioTemporal_estado_civil').val() == ''){
                   bootbox.alert('Seleccione su estado civil.');
                   return false;
             }
            if( $('#BeneficiarioTemporal_telf_habitacion').val() == ''  &&  $('#BeneficiarioTemporal_telf_celular').val() == '' ){
                bootbox.alert('Usted debe registrar al menos un número Telefónico.');
                return false;
            }
             if( $('#Tblestado_clvcodigo').val() == ''){
                   bootbox.alert('Seleccione el Estado .');
                   return false;
             }
            if( $('#Tblmunicipio_clvcodigo').val() == ''){
                   bootbox.alert('Seleccione el Municipio.');
                   return false;
             }
            if( $('#Tblparroquia_clvcodigo').val() == ''){
                   bootbox.alert('Seleccione la parroquia.');
                   return false;
             }
            if( $('#Desarrollo_id_desarrollo').val() == ''){
                   bootbox.alert('Seleccione el nombre del Desarrollo Habitacional.');
                   return false;
             }
            if( $('#BeneficiarioTemporal_unidad_habitacional_id').val() == ''){
                   bootbox.alert('Seleccione el Nombre de la Unidad Multifamiliar.');
                   return false;
             }
            if( $('#BeneficiarioTemporal_vivienda_nro').val() == ''){
                   bootbox.alert('Seleccione el número de la vivienda.');
                   return false;
             }
            if( $('#BeneficiarioTemporal_tipo_vivienda').val() == ''){
                   bootbox.alert('Seleccione el tipo de vivienda.');
                   return false;
             }
        });

        "); ?>


<h1>Cargar Nuevo Adjudicado</h1>
<br><br>
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
<div class="row">
    <div class="col-md-12">
        <?php
        /* ------------  Datos Beneficiario  --------- */



        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Beneficiario',
            'context' => 'primary',
            'headerIcon' => 'user',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model), TRUE),
                #'content' => $this->renderPartial('_form', array('model'=>$model),TRUE),
                )
        );
        echo '<br>';
        /*  ------------------------------------------ */

        /*         * ******  Caracteristicas del Desarrollo   ****** */


        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Características del Desarrollo',
            'headerIcon' => 'user',
            'context' => 'primary',
            'headerIcon' => 'home',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_desarrollo', array(
                'form' => $form, 'model' => $model,
                'estado' => $estado, 'municipio' => $municipio,
                'parroquia' => $parroquia, 'desarrollo' => $desarrollo
                    ), TRUE),
                )
        );

        /*         * ********************************************** */


        /*  +++++++++++++  Grupo Familiar    +++++++++ */



        /*  ++++++++++++++++++++++++++++++++++++++++++ */
        ?>
    </div>
</div>

<br>

<div class="form-actions">


    <div class="well">
        <div class="pull-center" style="text-align: right;">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'submit',
                'icon' => 'glyphicon glyphicon-floppy-saved',
                'size' => 'large',
                'id' => 'guardar',
                'context' => 'success',
                'label' => 'Guardar',
            ));
            ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'submit',
                'icon' => 'glyphicon glyphicon-floppy-saved',
                'size' => 'large',
                'id' => 'guardar',
                'context' => 'primary',
                'label' => 'Guardar y Agregar Nuevo Registro',
                'htmlOptions' => array('name' => 'CARGAR_OTRO', 'value' => '1')
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
                    'onclick' => 'document.location.href ="' . $this->createUrl('admin') . '";'
                )
            ));
            ?>
        </div>
    </div>


    <!-- *********** -->


</div>

<?php $this->endWidget(); ?>