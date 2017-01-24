<?php
Yii::app()->clientScript->registerScript('abogados', "
    $(document).ready(function(){
        $.ajax({
            url: '" . CController::createUrl('Documentacion/DocumentoExiste') . "',
            async: true,
            type: 'POST',
            data: 'id=" . $_GET['id'] . "',
            dataType:'json',
            success: function(datos){
                if(datos.sms  == '2'){
                    $('#documento-edit').show();
                    $('#agente-abogado').hide();
                    $('#Documentacion_documento').val(datos.documento);
                    $('#read-document').html(datos.documento);
                    $('#guardar').hide();
                }else{
                    $('#guardar').hide();
                }
            },
            error : function(datos){alert('Ocurrio un error de conexión.');},
        });
    }),

");

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'vivienda-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
        )));
?>
<?php
$beneficiario = Beneficiario::model()->findByPk($_GET['id']);
//echo '<pre>';
//var_dump($beneficiario);
//die;
?>
<h1 class="text-center">Gestión de Documentos UniFamiliares</h1> 
<h3 class="text-center"><b>Desarrollo: </b><?= $beneficiario->beneficiarioTemporal->unidadHabitacional->desarrollo->nombre ?></h3> 
<h3 class="text-center"><b>Unidad Habitacional: </b><?= $beneficiario->beneficiarioTemporal->unidadHabitacional->nombre ?></h3> 
<h4 class="text-center">Beneficiario: <?= $beneficiario->beneficiarioTemporal->nombre_completo ?></h4> 
<input type="hidden" name="id_beneficiario" value="<?= $_GET['id'] ?>">
<?php
/* * ** BUSQUEDA DEL NOMBRE COMPLETO DEL AGENTE DE DOCUMENTACION  *** */
$agente_documentacion_list = Abogados::model()->findAll('tipo_abogado_id=101');
foreach ($agente_documentacion_list as &$valor) {
    $nombre = ConsultaOracle::getPersonaByPk("PRIMER_NOMBRE", (int) $valor->persona_id);
    $apellido = ConsultaOracle::getPersonaByPk("PRIMER_APELLIDO", (int) $valor->persona_id);
    $valor->persona_id = $nombre['PRIMER_NOMBRE'] . ' ' . $apellido['PRIMER_APELLIDO'];
}

/* * ** BUSQUEDA DEL NOMBRE COMPLETO DEL APODERADO *** */
$apoderado_list = Abogados::model()->findAll('tipo_abogado_id=100');
foreach ($apoderado_list as &$valor) {
    $nombre = ConsultaOracle::getPersonaByPk("PRIMER_NOMBRE", (int) $valor->persona_id);
    $apellido = ConsultaOracle::getPersonaByPk("PRIMER_APELLIDO", (int) $valor->persona_id);
    $valor->persona_id = $nombre['PRIMER_NOMBRE'] . ' ' . $apellido['PRIMER_APELLIDO'];
}
?>

<div class="rows" id="agente-abogado">
    <!--<div class="rows" id="select-abogados">-->
    <div class="col-md-4" >
        <?php
        echo $form->dropDownListGroup($model, 'agente_documentacion', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => CHtml::listData($agente_documentacion_list, 'id', 'persona_id'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $form->dropDownListGroup($model, 'apoderado', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => CHtml::listData($apoderado_list, 'id', 'persona_id'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo CHtml::ajaxButton('Generar documento', CHtml::normalizeUrl(array('vivienda/listarDocumento')), /* Yii::app()->createUrl('vivienda/listarDocumento'), */ array(
            'type' => 'POST',
            'data' => 'js:$("#vivienda-form").serialize()',
            'dataType' => 'json',
            'success' => 'function(data){
                if(data.sms == "1"){
                    bootbox.alert("Asegurese que el Agente y el Apoderado esten seleccionados.");
                    return false;
                }else if(data.sms == "2"){
                    $("#documento-edit").show();
                    $("#agente-abogado").hide();
                    $("#Documentacion_documento").val(data.cont);
                    $("#read-document").html(data.cont);
                    $("#guardar").show();
                    $("#error").hide();

                    return false;
                }else if(data.sms == "3"){
                    $("#documento-edit").hide();
                    $("#error").show();
                    $("#CancelarForm").show();
                    $("#sms").html("<b><i><center>La siguiente información es requerida:</center></i></b><br>"+data.cont);
                    return false;
                }
            }',
            'error' => 'js:function(string){ bootbox.alert("Ocurrio un error."); }',
                ), array('class' => 'btn btn-success')
        );
        ?>
    </div>
</div>
<div class="rows" id="error" style="display:none">
    <div class="rows">
        <div class="col-md-12">
            <?php
            echo '<div class="alert alert-danger" role="alert" id="sms">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only" >Error:</span>
            </div>';
            ?>
        </div>
    </div>
</div>
<div class="rows" id="documento-edit" style="display:block">

    <div class="rows">
        <div class="col-md-12" id="read-document"></div>
        <div class="col-md-12">
            <?php echo $form->hiddenField($model, 'documento', array('type' => "hidden", 'size' => 2, 'maxlength' => 2)); ?>
        </div>
    </div>
</div>
<div class="rows" id='bontones'>
    <div class="col-md-12">
        <div class="form-actions">
            <div class="well">
                <div class="pull-center" style="text-align: right;">
                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'buttonType' => 'submit',
                        'icon' => 'glyphicon glyphicon-floppy-saved',
                        'size' => 'large',
                        'id' => 'guardar',
                        'context' => 'primary',
                        'label' => $model->isNewRecord ? 'Guardar' : 'Guardar',
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
                            'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/adminbeneficiario') . '";'
                        )
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
