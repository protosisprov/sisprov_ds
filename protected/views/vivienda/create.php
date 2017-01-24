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
<?php Yii::app()->clientScript->registerScript('desarrolloVal', "
         $(document).ready(function(){
            $('#Vivienda_tipo_vivienda_id').html('<option value=\'\'>SELECCIONE</option>');
//          $('#Vivienda_nro_piso').numeric(); 
            $('#Vivienda_nro_habitaciones').numeric(); 
            $('#Vivienda_nro_banos').numeric(); 
            $('#Vivienda_construccion_mt2').numeric(); 
            $('#Vivienda_precio_vivienda').numeric(); 
            $('#Vivienda_nro_estacionamientos').numeric(); 
            $('#Vivienda_construccion_mt2').attr('readonly', true);
            $('#Vivienda_nro_habitaciones').attr('readonly', true);
            $('#Vivienda_nro_banos_auxiliar').attr('readonly', true);
            $('#Vivienda_nro_banos').attr('readonly', true);
            $('#Vivienda_coordenadas').attr('readonly', true);
            $('#Vivienda_lindero_norte').attr('readonly', true);
            $('#Vivienda_lindero_sur').attr('readonly', true);
            $('#Vivienda_lindero_este').attr('readonly', true);
            $('#Vivienda_lindero_oeste').attr('readonly', true);
            $('#Vivienda_nro_estacionamientos').attr('readonly', true);
            $('#Vivienda_descripcion_estac').attr('readonly', true);
            $('#Vivienda_precio_vivienda').attr('readonly', true);
        });
                
        $('#Tblestado_clvcodigo').change(function(){
            html = '<option value>SELECCIONE</option>';
            $('#Vivienda_tipo_vivienda_id').html(html);
            $('#Vivienda_unidad_habitacional_id').html(html);
            $('#Desarrollo_id_desarrollo').html(html);
            $('#Tblparroquia_clvcodigo').html(html);
            $('.limpiar').val('');
            $('.lock').attr('readonly', true);
            $('#Vivienda_sala').val('');
            $('#Vivienda_comedor').val('');
            $('#Vivienda_cocina').val('');
            $('#Vivienda_tipo_vivienda').val('');
            $('#Vivienda_lavandero').val('');
            $('#Vivienda_nro_banos_auxiliar').val('');
        });
        
        $('#Tblmunicipio_clvcodigo').change(function(){
            html = '<option value>SELECCIONE</option>';
            $('#Vivienda_tipo_vivienda_id').html(html);
            $('#Vivienda_unidad_habitacional_id').html(html);
            $('#Desarrollo_id_desarrollo').html(html);
            $('.limpiar').val('');
            $('.lock').attr('readonly', true);
            $('#Vivienda_sala').val('');
            $('#Vivienda_comedor').val('');
            $('#Vivienda_cocina').val('');
            $('#Vivienda_tipo_vivienda').val('');
            $('#Vivienda_lavandero').val('');
            $('#Vivienda_nro_banos_auxiliar').val('');
        });
        
        $('#Tblparroquia_clvcodigo').change(function(){
            html = '<option value>SELECCIONE</option>';
            $('#Vivienda_tipo_vivienda_id').html(html);
            $('#Vivienda_unidad_habitacional_id').html(html);
            $('.limpiar').val('');
            $('.lock').attr('readonly', true);
            $('#Vivienda_sala').val('');
            $('#Vivienda_comedor').val('');
            $('#Vivienda_cocina').val('');
            $('#Vivienda_tipo_vivienda').val('');
            $('#Vivienda_lavandero').val('');
            $('#Vivienda_nro_banos_auxiliar').val('');
        });
        
        $('#Desarrollo_id_desarrollo').change(function(){
            html = '<option value>SELECCIONE</option>';
            $('#Vivienda_tipo_vivienda_id').html(html);
            $('.limpiar').val('');
            $('.lock').attr('readonly', true);
            $('#Vivienda_sala').val('');
            $('#Vivienda_nro_banos_auxiliar').val('');
            $('#Vivienda_comedor').val('');
            $('#Vivienda_cocina').val('');
            $('#Vivienda_tipo_vivienda').val('');
            $('#Vivienda_lavandero').val('');
        });
        
        $('#Vivienda_unidad_habitacional_id').change(function(){
            idUnidadMulti = $('#Vivienda_unidad_habitacional_id').val();
            $('.limpiar').val('');
            $('.lock').attr('readonly', true);
            $('#Vivienda_sala').val('');
            $('#Vivienda_nro_banos_auxiliar').val('');
            $('#Vivienda_comedor').val('');
            $('#Vivienda_cocina').val('');
            $('#Vivienda_lavandero').val('');

            if(idUnidadMulti == ''){
                $('#Vivienda_tipo_vivienda_id').html('<option value=\'\'>SELECCIONE</option>');
            }
            
            $.ajax({
               url: '" . Yii::app()->createAbsoluteUrl('ValidacionJs/TipoUnidadMultifamiliar') . "',
               async: true,
               type: 'POST',
               data: 'idUnidadMulti=' +idUnidadMulti,
               dataType: 'json',
               success: function(data) {
                    if(data == 'PARCELA'){
                        html = '<option value=\'\'>SELECCIONE</option><option value=\'93\'>CASA</option><option value=\'95\'>TOWNHOUSE</option>';
                        $('#Vivienda_tipo_vivienda_id').html(html);
                        $('#Vivienda_nro_piso').val('');
                        $('#piso_vivienda').hide();
                    }else{
                        html = '<option value=\'\'>SELECCIONE</option><option value=\'94\'>APARTAMENTO</option>';
                        $('#Vivienda_tipo_vivienda_id').html(html);
                        $('#piso_vivienda').show();
                        $('#Vivienda_nro_piso').val('');
                    }
                    $('#Vivienda_tipo_vivienda').val(data);
                },
                error: function(data) {
                    bootbox.alert('Ocurrio un error');
                }
            });
        });
"); ?>


<?php Yii::app()->clientScript->registerScript('vivienda', "

        $('#guardarVivienda').click(function(){
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
            if($('#Desarrollo_id_desarrollo').val()==''){
                bootbox.alert('Por favor seleccione el Desarrollo');
                return false;
            }

            if($('#Vivienda_unidad_habitacional_id').val()==''){
                bootbox.alert('Por favor seleccione nombre de la unidad habitacional');
                return false;
            }
            if($('#Vivienda_tipo_vivienda_id').val()==''){
                bootbox.alert('Por favor seleccione tipo de vivienda');
                return false;
            }

//            if($('#Vivienda_nro_piso').val()==''){
//                bootbox.alert('Por favor indique número piso');
//                return false;
//            }
            if($('#Vivienda_nro_vivienda').val()==''){
                bootbox.alert('Por favor indique número de vivienda');
                return false;
            }
//            if($('#Vivienda_construccion_mt2').val()==''){
//                bootbox.alert('Por favor indique metros cuadrado de la vivienda');
//                return false;
//            }

//            if($('#Vivienda_nro_habitaciones').val()==''){
//                bootbox.alert('Por favor indique número de habitaciones');
//                return false;
//            }

//            if($('#Vivienda_nro_banos').val()==''){
//                bootbox.alert('Por favor indique número de baños');
//                return false;
//            }
        });
") ?>

<?php
if (isset($sms) && !empty($sms)) {
    $user = Yii::app()->getComponent('user');
    $user->setFlash(
            'warning', "<strong>Número de vivienda ya se encuentra registado.</strong>"
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

<h1>Cargar Identificación del Inmueble Familiar </h1>

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
        $this->widget(
                'booster.widgets.TbPanel', array(
            'title' => 'Unidad Unifamiliar',
            'context' => 'info',
            'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
            'headerIcon' => 'home',
            'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia, 'desarrollo' => $desarrollo), TRUE),
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
            'id' => 'guardarVivienda',
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
            'label' => 'Guardar y Agregar Nuevo Registro' ,
            'htmlOptions'=>array('name'=>'cargar_otro', 'value'=>'1')
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
                'onclick' => 'document.location.href ="' . $this->createUrl('/vswUnifamiliar/admin') . '";'
            )
        ));
        ?>
    </div>
</div>

<?php //echo $this->renderPartial('_form', array('model'=>$model));  ?>

<?php $this->endWidget(); ?>

