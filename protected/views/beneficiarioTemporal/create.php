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
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
?>
<?php Yii::app()->clientScript->registerScript('BeneficiarioTemporal', "
     $(document).ready(function(){
         $('#BeneficiarioTemporal_telf_habitacion').mask('02AA-BBBBBBB', {translation: { 'A': {pattern: /[0-9]/}, 'B':{pattern: /[0-9]/}}, clearIfNotMatch: true});
         $('#BeneficiarioTemporal_telf_celular').mask('04AA-BBBBBBB', {translation: { 'A': {pattern: /[0-9]/}, 'B':{pattern: /[0-9]/}}, clearIfNotMatch: true});
    }); 
        $('.guardarD').click(function(){
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
<?php
$prue='';
if (!empty($desarrollo->id_desarrollo)) {
    
    $id_unidad = $vivienda->unidad_habitacional_id;
    $tipo_vivienda_id = $vivienda->tipo_vivienda_id;
    $id_desarrollo = $desarrollo->id_desarrollo;
 
    $id_parroquia = $desarrollo->parroquia_id;
    //$id_municipio = $unidad_habitacional->desarrollo->fkParroquia->clvmunicipio0->clvcodigo;
    
    $id_municipio = $desarrollo->fkParroquia->clvmunicipio0->clvcodigo;
    $id_estado = $desarrollo->fkParroquia->clvmunicipio0->clvestado0->clvcodigo;



Yii::app()->clientScript->registerScript('AdjudicadoContinuar', "


        $(document).ready(function(){
        
                    
             
          $.get('" . CController::createUrl('ValidacionJs/ConsultaEstado') . "', {clvcodigo: " . $id_estado . "}, function(data){
                $('#Tblestado_clvcodigo').html(data);
            });
          $.get('" . CController::createUrl('ValidacionJs/ConsultaMunicipios') . "', {clvcodigo: " . $id_municipio . "}, function(data){
                $('#Tblmunicipio_clvcodigo').html(data);
            });
          $.get('" . CController::createUrl('ValidacionJs/ConsultaParroquias') . "', {clvcodigo: " . $id_parroquia . "}, function(data){
                $('#Tblparroquia_clvcodigo').html(data);
                 $('#Tblparroquia_clvcodigo').val(" . $id_parroquia . ");
            });
          $.get('" . CController::createUrl('ValidacionJs/BuscarDesarrollo') . "', {desarrollo: " . $id_parroquia . "}, function(data){
                $('#Desarrollo_id_desarrollo').html(data);
                $('#Desarrollo_id_desarrollo').val(" . $id_desarrollo . ");
            });
            $.get('" . CController::createUrl('ValidacionJs/BuscarUnidadHabitacional') . "', {unidad: " . $id_desarrollo . "}, function(data){
                $('#BeneficiarioTemporal_unidad_habitacional_id').html(data);
                $('#BeneficiarioTemporal_unidad_habitacional_id').val(" . $id_unidad . ");
            });
            $.get('" . CController::createUrl('ValidacionJs/BuscarUnidadHabitacional') . "', {unidad: " . $id_desarrollo . "}, function(data){
                $('#BeneficiarioTemporal_unidad_habitacional_id').html(data);
                $('#BeneficiarioTemporal_unidad_habitacional_id').val(" . $id_unidad . ");
            });

if((".$tipo_vivienda_id."=='94')||(".$tipo_vivienda_id."=='95')){
    
        id_unidad_habiatacional = " . $id_unidad . ";
        $.ajax({
            url: '" . CController::createUrl('ValidacionJs/BuscarPisoVivienda') . "',
            async: true,
            type: 'POST',
            data: 'id_unidad_habiatacional='+id_unidad_habiatacional,
            dataType:'json',
            success: function(datos){
                if(datos != 'vacio'){
                  /*  ++ datos del desarollo habitacional  ++  */
                    html = '<option value>SELECCIONE</option>';
                    if(datos.tipo == 84){
                    /***** SI ES PARCELA ****/
                      $('#BeneficiarioTemporal_piso').html(html);
                      $('#BeneficiarioTemporal_vivienda_nro').html(datos.select);
                      $('#piso_vivienda_select').hide();
                    }else{
                      $('#BeneficiarioTemporal_piso').html(datos.select);
                      $('#BeneficiarioTemporal_vivienda_nro').html(html);
                      $('#piso_vivienda_select').show();
                    }
                    
                    /*   ++  ++  ++  ++  ++  ++  ++  ++  ++ ++ ++  + */
                }
            }
        });

$('#piso_vivienda_select').show();
}

 $('#Tblestado_clvcodigo').attr('readonly', true);
 $('#Tblmunicipio_clvcodigo').attr('readonly', true);
 $('#Tblparroquia_clvcodigo').attr('readonly', true);
 

        });


     ");
}
?>

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
    
        
        
        if (isset($carga_otro)){
//            
        }else{
           $carga_otro=''; 
        }
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
                'parroquia' => $parroquia, 'desarrollo' => $desarrollo, 'carga_otro' => $carga_otro
                    ), TRUE),
                )
        );

        /*         * ********************************************** */
        
          echo '<br>';
        
        /* ------------  Datos Beneficiario  --------- */

//        }

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
      
        /*  ------------------------------------------ */




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
                'htmlOptions' => array(
                'class' => 'guardarD'
        ),
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
                'htmlOptions' => array('name' => 'CARGAR_OTRO', 'value' => '1',  'class' => 'guardarD')
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
