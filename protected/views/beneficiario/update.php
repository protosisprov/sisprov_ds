

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'datosLaborales-form',
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
if (!empty($model->parroquia_id)) {
    $id_parroquia = Tblparroquia::model()->findByPk($model->parroquia_id); // consulta en la tabla ciudad el id_ciudad y id_estado 
    $id_municipio = $id_parroquia->clvmunicipio0->clvcodigo;
    $id_estado = $id_parroquia->clvmunicipio0->clvestado0->clvcodigo;
}
?>
<?php
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/jquery.mask.min');
$Validacion = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/js_jquery.numeric.js');
Yii::app()->clientScript->registerScript('telefono', "
        $(document).ready(function(){
            $('#Beneficiario_telefono_trabajo').numeric();  
            $('#Beneficiario_ingreso_declarado').numeric();         
        
  
        }),
        
         $('#guardar').click(function(){
         if($('#Tblestado_clvcodigo').val()==''){
                    bootbox.alert('Por favor indique Estado');
                    return false;
         }    
         if($('#Tblmunicipio_clvcodigo').val()==''){
                    bootbox.alert('Por favor indique Municipio');
                    return false;
         }    
         if($('#Beneficiario_parroquia_id').val()==''){
                    bootbox.alert('Por favor indique Parroquia');
                    return false;
         }    
         if($('#Beneficiario_urban_barrio').val()==''){
                    bootbox.alert('Por favor indique Urbanización/Barrio');
                    return false;
         }    
         
         if($('#Beneficiario_urban_barrio').val()==''){
                    bootbox.alert('Por favor indique Urbanización/Barrio');
                    return false;
         }    
         
         if($('#Beneficiario_av_call_esq_carr').val()==''){
                    bootbox.alert('Por favor indique Avenida/Calle/Esquina/Carretera');
                    return false;
         }    
        
         if($('#Beneficiario_condicion_trabajo_id').val()==''){
                    bootbox.alert('Por favor indique Condición de trabajo');
                    return false;
         }    
         if($('#Beneficiario_fuente_ingreso_id').val()==''){
                    bootbox.alert('Por favor indique fuente de ingreso');
                    return false;
         }    
         if($('#Beneficiario_ingreso_declarado').val()==''){
                    bootbox.alert('Por favor indique ingreso declarado');
                    return false;
         }  
         
         
        }),
        
             $(document).ready(function(){
            $('#Tblestado_clvcodigo').val(" . $id_estado . ");
                    
            $.get('" . CController::createUrl('ValidacionJs/BuscarMunicipios') . "', {clvcodigo: " . $id_estado . " }, function(data){
                $('#Tblmunicipio_clvcodigo').html(data);
                $('#Tblmunicipio_clvcodigo').val(" . $id_municipio . ");
                
            });
            $.get('" . CController::createUrl('ValidacionJs/BuscarParroquias') . "', {municipio: " . $id_municipio . "}, function(data){
                $('#Beneficiario_parroquia_id').html(data);
                $('#Beneficiario_parroquia_id').val(" . $model->parroquia_id . ");
            });

        });
  
        ");
?>


<h1>Modificar Datos del Beneficiario: </h1>
<h3><center><?php echo $model->beneficiarioTemporal->nombre_completo; ?></center></h3>

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
        /* ------------  Direccion Anterior Beneficiario --------- */
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Dirección Anterior del Beneficiario',
            'context' => 'primary',
            'headerIcon' => 'globe',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'content' => $this->renderPartial('_direccionAnterior', array('form' => $form, 'model' => $model, 'municipio' => $municipio, 'estado' => $estado, 'parroquia' => $parroquia,), TRUE),
                )
        );
        ?>
    </div>
    <div class="col-md-12">
        <?php
        /* ------------  Direccion Anterior Beneficiario --------- */
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Datos Laborales',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'context' => 'primary',
            'headerIcon' => 'briefcase',
            'content' => $this->renderPartial('_datosLaborales', array('form' => $form, 'model' => $model), TRUE),
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
            'label' => $model->isNewRecord ? 'Finalizar' : 'Finalizar',
          
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
                'onclick' => 'document.location.href ="' . $this->createUrl('vswCensosCulminados/admin') . '";'
            )
        ));
        ?>
    </div>
</div>




<?php $this->endWidget(); ?>
