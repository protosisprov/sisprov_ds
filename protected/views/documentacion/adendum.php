<?php

$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'documentacion-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
        )));
?>
<?php
$unidadHab = UnidadHabitacional::model()->findByAttributes(array('desarrollo_id' => $_GET['id']));
?>
<h1 class="text-center">Gestión de Documentos Multifamiliar.</h1> 
<h3 class="text-center"><b>Desarrollo: </b><?= $unidadHab->desarrollo->nombre ?></h3> 
<h3 class="text-center"><b>Unidad Habitacional: </b><?= $unidadHab->nombre ?></h3> 
<input type="hidden" name="id_unidad_habitacional" value="<?= $_GET['id'] ?>">
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
        echo CHtml::ajaxButton('Generar documento', Yii::app()->createUrl('documentacion/ListarDocumentoAdendum'),  array(
            'type' => 'POST',
            'data' => 'js:$("#documentacion-form").serialize()',
            'dataType' => 'json',
            'success' => 'function(data){
                if(data.sms == "1"){
                    bootbox.alert("Asegurese que el Agente y el Apoderado esten seleccionados.");
                    return false;
                }else if(data.sms == "2"){
                    $("#Documentacion_documento").redactor("set", data.cont);
                    $("#documento-edit").show();
                    $("#agente-abogado").hide();
                    $("#btn-agente").hide();
                    $("#guardar").show();
                    $("#error").hide();
                    $("#ids_unidad_familiar").val(data.ids_unidad_familiar);
                    return false;
                }else if(data.sms == "3"){
                    $("#guardar").hide();
                    $("#documento-edit").hide();
                    $("#error").show();
                    $("#ids_unidad_familiar").val(data.ids_unidad_familiar);
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
    <?php echo CHtml::hiddenField('ids_unidad_familiar','value' ,array('id' => 'ids_unidad_familiar')); ?>
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
<div class="rows" id="documento-edit" style="display:none">
    <div class="rows">
        <div class="col-md-12">
            <?php
            echo $form->redactorGroup(
                    $model, 'documento', array(
                'widgetOptions' => array(
                    'editorOptions' => array(
                        'class' => 'span4',
                        'rows' => 5,
                        'options' => array('plugins' => array('clips', 'fontfamily'), 'lang' => 'es')
                    )
                )
                    )
            );
            ?>
        </div>
    </div>
</div>
<div class="rows">
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
                        'label' => $model->isNewRecord ? 'Guardar' : 'Save',
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
                            'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/adminmultifamiliar') . '";'
                        )
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
