<?php  
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
?>

<?php

$this->breadcrumbs = array(
    'Viviendas' => array('index'),
    $model->id_vivienda => array('view', 'id' => $model->id_vivienda),
    'Precarga',
);
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

        var fieldDescripcion = $('#Maestro_descripcion').val();
            if(fieldDescripcion == 'PARCELA' || fieldDescripcion == 'TETRA' || fieldDescripcion == 'PENDIENTE'){
                html = '<option value=\'\'>SELECCIONE</option><option value=\'93\'>CASA</option><option value=\'94\'>APARTAMENTO</option><option value=\'95\'>TOWNHOUSE</option>';
                $('#Vivienda_tipo_vivienda_id').html(html);
                $('#Vivienda_nro_piso').val('');
                $('#piso_vivienda').hide();
            }else{
                html = '<option value=\'\'>SELECCIONE</option><option value=\'94\'>APARTAMENTO</option><option value=\'95\'>TOWNHOUSE</option>';
                $('#Vivienda_tipo_vivienda_id').html(html);
                $('#piso_vivienda').show();
                $('#Vivienda_nro_piso').val('');
            }
            //$('#Vivienda_tipo_vivienda').val(fieldDescripcion);
            
        $('#Vivienda_tipo_vivienda_id').change(function(){
            //alert($('#Vivienda_tipo_vivienda_id option:selected').text());
            var tipoVivienda = $('#Vivienda_tipo_vivienda_id option:selected').text();
            var tipoUnidadMultifamiliar = $('#Maestro_descripcion').val();

            if(tipoVivienda == 'APARTAMENTO')
                $('#piso_vivienda').show();
            else{
                if(tipoVivienda == 'TOWNHOUSE' && tipoUnidadMultifamiliar == 'EDIFICIO DE APARTAMENTO')
                    $('#piso_vivienda').show();
                else
                    $('#piso_vivienda').hide();
            }
        });
    });
    
    
"); ?>

<?php
if (isset($sms) && !empty($sms)) {
    $user = Yii::app()->getComponent('user');
    switch ($sms) {
        case 1:
            $user->setFlash(
                'warning', "<strong>Número de vivienda ya se encuentra registado.</strong>"
            );
            $tipo = 'warning';
            break;
        case 2:
            $user->setFlash(
                'success', "<strong>Vivienda registrada exitósamente.</strong>"
            );
            $tipo = 'success';
            break;
    }

    $this->widget('booster.widgets.TbAlert', array(
        'fade' => true,
        'closeText' => '&times;', // false equals no close link
        'events' => array(),
        'htmlOptions' => array(),
        'userComponentId' => 'user',
        'alerts' => array(// configurations per alert type
            $tipo => array('closeText' => false),
        ),
    ));
    
    Yii::app()->clientScript->registerScript(
        'myHideEffect',
        '$("#yw0").animate({opacity: 0.2}, 5000, function(){$("#yw0").css("visibility","hidden")});',
        CClientScript::POS_READY
    );
}
?>

<?php

if (!empty($unidad_habitacional->id_unidad_habitacional)) {
    
    
    $id_unidad = $unidad_habitacional->id_unidad_habitacional;
    $id_desarrollo = $unidad_habitacional->desarrollo_id;
 
    $id_parroquia = $unidad_habitacional->desarrollo->parroquia_id;
    //$id_municipio = $unidad_habitacional->desarrollo->fkParroquia->clvmunicipio0->clvcodigo;
    
    $id_municipio = $unidad_habitacional->desarrollo->fkParroquia->clvmunicipio0->clvcodigo;
    $id_estado = $unidad_habitacional->desarrollo->fkParroquia->clvmunicipio0->clvestado0->clvcodigo;

}
?>
<?php
Yii::app()->clientScript->registerScript('vivienda', "


        $(document).ready(function(){
        
                    
         $('#Tblestado_clvcodigo').val(" . $id_estado . ");
          $.get('" . CController::createUrl('ValidacionJs/ConsultaMunicipios') . "', {clvcodigo: " . $id_municipio . "}, function(data){
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
                $('#Vivienda_unidad_habitacional_id').val(" . $unidad_habitacional->id_unidad_habitacional . ");
            });


        });


     ");
?>

<?php Yii::app()->clientScript->registerScript('viviendaValidacion', "
    
       function validarForm(){
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
            if($('#Vivienda_tipo_vivienda_id option:selected').text() == 'APARTAMENTO'){
                if($('#Vivienda_nro_piso').val()==''){
                    bootbox.alert('Por favor indique número piso');
                    return false;
                }
            }else{
                if($('#Vivienda_tipo_vivienda_id option:selected').text() == 'TOWNHOUSE' && $('#Vivienda_tipo_vivienda').val() == 'EDIFICIO DE APARTAMENTO'){
                    if($('#Vivienda_nro_piso').val()==''){
                        bootbox.alert('Por favor indique número piso');
                        return false;
                    }
                }
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
            }
        };
", CClientScript::POS_END) ?>


<h1> Precarga del Inmueble Familiar</h1>

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
    'title' => 'Precarga del Inmueble Familiar',
    'context' => 'info',
    'headerHtmlOptions' => array('style' => 'background-color: #1fb5ad !important;color: #FFFFFF !important;'),
    'headerIcon' => 'globe',
    'content' => $this->renderPartial('_formPrecarga', array('form' => $form, 'model' => $model, 'estado' => $estado, 'municipio' => $municipio, 'parroquia' => $parroquia, 'desarrollo' => $desarrollo, 'unidad_habitacional' => $unidad_habitacional), TRUE),
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
        'onclick' => 'document.location.href ="' . $this->createUrl('vswUnifamiliar/admin') . '"'),
        //'onclick' => 'goBack()'),    
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
            'htmlOptions'=>array('onclick'=>'validarForm()')
        ));
        ?>
        
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'large',
            'id' => 'cargar_inmueble',
            'context' => 'primary',
            'label' => 'Guardar y Cargar Nueva Vivienda' ,
            'htmlOptions'=>array('name'=>'cargar_inmueble', 'value'=>'1','onclick'=>'validarForm()')
        ));
        ?>
    </div>
</div>

<?php //echo $this->renderPartial('_form', array('model'=>$model));    ?>

<?php $this->endWidget(); ?>
