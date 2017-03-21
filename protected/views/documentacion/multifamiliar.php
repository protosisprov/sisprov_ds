
<script src="<?php echo Yii::app()->baseUrl; ?>/js/diff_match_patch.js"></script>

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
//                    $('#Documentacion_documento').redactor('set', datos.documento);
                    $('#guardar').show();
                    
                }else{
                    $('#guardar').hide();
                }
            },
            error : function(datos){alert('error');},
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
$unidadHab = UnidadHabitacional::model()->findByAttributes(array('id_unidad_habitacional' => $_GET['id']));
//var_dump($doc_banavih["documento"]);die;
//zvar_dump($modell["documento"]);die;
?>

<div class="well">
    <h3 class="text-center"><b>Desarrollo: </b><?= $unidadHab->desarrollo->nombre ?>, <b>Unidad Multifamiliar: </b><?= $unidadHab->nombre ?></h3>  



</div>
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
        echo CHtml::ajaxButton('Generar documento', CHtml::normalizeUrl(array('documentacion/listarDocumento')), /* Yii::app()->createUrl('vivienda/listarDocumento'), */ array(
            'type' => 'POST',
            'data' => 'js:$("#vivienda-form").serialize()',
            'dataType' => 'json',
            'success' => 'function(data){
                if(data.sms == "1"){
                    bootbox.alert("Asegurese que el Agente y el Apoderado esten seleccionados.");
                    return false;
                }else if(data.sms == "2"){
                   // $("#Documentacion_documento").redactor("set", data.cont);
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
<?php echo CHtml::hiddenField('ids_unidad_familiar', 'value', array('id' => 'ids_unidad_familiar')); ?>
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




<!--VISTA DE BANAVIH CUANDO EL DOCUMENTO ES DEVULTO POR SAREN-->
<?php if ($model["estatus"] == 295) { ?> 

    <SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
        var dmp = new diff_match_patch();

        function launch() {

            var text2 = document.getElementById('text2').value;
            var text1 = $('#Documentacion_documento').val();
            var d = dmp.diff_main(text1, text2);


            var ds = dmp.diff_prettyHtml(d);
            document.getElementById('outputdiv').innerHTML = ds;

        }
    </SCRIPT>
    <?php if (!Yii::app()->user->checkAccess('administrador_documentacion')) { ?>


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
                    'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/adminmultifamiliar') . '";'
                )
            ));
            ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'context' => 'success',
                'label' => 'Guardar correcciones del SAREN',
                'size' => 'large',
                'id' => 'CancelarForm',
                'icon' => 'glyphicon glyphicon-ok',
                'visible' => '($data["estatus_msj"] == "") && DocumentoExistMulti($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"]) && EstatusDocumentoDevuelto($data["id_unidad_habitacional"]) || ($data["estatus_msj"] == "DEVUELTO POR SAREN (EN ESPERA DE BANAVIH)") && !EstatusDocumentoAprobado($data["id_unidad_habitacional"])&& EstatusDocumentoDevuelto($data["id_unidad_habitacional"])',
                'htmlOptions' => array(
                    'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/multifamiliarguardar', array("id" => $_GET['id'])) . '";'
                )
            ));
            ?>
        </div>
    <?php } ?>

    <div class="row">

        <div class="col-md-4" >

            <table class="table">
                <!--<tr >-->

                <!--</tr>--> 
                <tr bgcolor="#CEF6F5"><font color="black"><B><center>Leyenda de Corrección de Documento</center></B></font></tr>
                <tr>
                    <td bgcolor="#A9F5E1"><font color="black"><B><center>Campo Añadido</center></B></font></td>
                    <td bgcolor="#F5A9A9"><font color="BLACK"><B><center>Campo Eliminado</center></B></font></td>
                </tr> 
            </table>
        </div>
    </div>

    <div class="rows" id="documento-edit" style="display:none">

        <div class="rows">
            <div class="col-md-6">


                <H3>Documento Banavih</H3>

                <?php
                echo $form->redactorGroup(
                        $model, 'documento', array(
                    'widgetOptions' => array(
                        'editorOptions' => array(
                            'class' => 'span4',
                            'rows' => 5,
                            'options' => array('plugins' => array('clips', 'fontfamily'), 'lang' => 'sv')
                        )
                    )
                        )
                );
                ?>

            </div>
            <div class="col-md-6">
                <H3>Saren</H3>
                <TEXTAREA ID="text2"  ROWS=10 style="display:none"> <?php echo $modell["documento"]; ?></TEXTAREA>

                                                                                                                <P><INPUT TYPE="button" onClick="launch()" VALUE="Ver Corrección"></P>

                                                                                                                <DIV ID="outputdiv"></DIV>

                                                                                                            </div>
                                                                                                        </div>
                                                                    
                                                                    <!--VISTA DE BANAVIH AL GENERAR EL DOCUMENTO POR PRIMERA VEZ-->
                                                                                                    
    <?php } else if ($model["estatus"] == 53) { ?>
                                                                    
        <?php if (!Yii::app()->user->checkAccess('administrador_documentacion')) { ?>
                                                                        
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
                        'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/adminmultifamiliar') . '";'
                    )
                ));
                ?>
                </div>  
        <?php } ?>                                                           

                                                                                                            <div class="rows">
                                                                                                                <div class="col-md-12">
                                                                                                                    <H3>Banavih</H3>

                    <?php
                    echo $form->redactorGroup(
                            $model, 'documento', array(
                        'widgetOptions' => array(
                            'editorOptions' => array(
                                'class' => 'span4',
                                'rows' => 5,
                                'options' => array('plugins' => array('clips', 'fontfamily'), 'lang' => 'sv')
                            )
                        )
                            )
                    );
                    ?>

                                                                                                                </div>
                                                                                                           
                                                                                                                    
                                                                                                            </div>

                                                                            
                                                                            <!--VISTA DE SAREN CUANDO EL DOCUMENTO ES ENVIADO POR BANAVIH-->
                                                                            
        <?php } else if ($model["estatus"] == 285 && $model["doc_primera_vez"] == true) { ?>

                <?php if (!Yii::app()->user->checkAccess('administrador_documentacion')) { ?>                                                            
                <div class="pull-center" style="text-align: right;">
                 <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'buttonType' => 'submit',
                        'icon' => 'glyphicon glyphicon-floppy-saved',
                        'size' => 'large',
                        'id' => 'guardar',
                        'context' => 'primary',
                        'label' => $model->isNewRecord ? 'Guardar con Observaciones' : 'Guardar con Observaciones',
                    ));
                    ?>

                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'context' => 'success',
                        'label' => 'Conforme',
                        'size' => 'large',
                        'id' => 'CancelarForm',
                        'icon' => 'ban-circle',
                        'htmlOptions' => array(
                            'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/adminsarenMulti') . '";'
                        )
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
                            'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/adminsarenMulti') . '";'
                        )
                    ));
                    ?>
                </div>
                <?php } ?>
                                                                            
                <div class="col-md-12">

                <H3>Saren</H3>

                                            
                <?php
                echo $form->redactorGroup(
                        $model, 'documento', array(
                    'widgetOptions' => array(
                        'editorOptions' => array(
                            'class' => 'span4',
                            'rows' => 5,
                            'options' => array('plugins' => array('clips', 'fontfamily'), 'lang' => 'sv')
                        )
                    )
                        )
                );
                ?>
                                                                                    
                                    
                </div>                                                            


                                                                            
        <?php } else if ($model["estatus"] == 285) { ?> 
                                                                            
                <SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
                var dmp = new diff_match_patch();

                function launch() {

                    var text2 = document.getElementById('text1').value;
                    var text1 = document.getElementById('text2').value;
                    //            var text2 = $('#Documentacion_documento').val();
                    var d = dmp.diff_main(text1, text2);


                    var ds = dmp.diff_prettyHtml(d);
                    document.getElementById('outputdiv').innerHTML = ds;

                }
                </SCRIPT>                                                            
                                                                            
<div class="rows">
    <?php if (!Yii::app()->user->checkAccess('administrador_documentacion')) { ?>
                <div class="pull-center" style="text-align: right;">
                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'buttonType' => 'submit',
                        'icon' => 'glyphicon glyphicon-floppy-saved',
                        'size' => 'large',
                        'id' => 'guardar',
                        'context' => 'primary',
                        'label' => $model->isNewRecord ? 'Guardar con Observaciones' : 'Guardar con Observaciones',
                    ));
                    ?>

                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'context' => 'success',
                        'label' => 'Conforme',
                        'size' => 'large',
                        'id' => 'CancelarForm',
                        'icon' => 'ban-circle',
                        'htmlOptions' => array(
                            'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/adminsarenMulti') . '";'
                        )
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
                            'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/adminsarenMulti') . '";'
                        )
                    ));
                    ?>
                </div>
    <?php } ?>
                <div class="row">

                    <div class="col-md-4" >

                        <table class="table">
                            <!--<tr >-->

                            <!--</tr>--> 
                            <tr bgcolor="#CEF6F5"><font color="black"><B><center>Leyenda de Corrección de Documento</center></B></font></tr>
                                <tr>
                                    <td bgcolor="#A9F5E1"><font color="black"><B><center>Campo Añadido</center></B></font></td>
                                    <td bgcolor="#F5A9A9"><font color="BLACK"><B><center>Campo Eliminado</center></B></font></td>
                                </tr> 
                        </table>
                    </div>
                </div>
                                                                                
                                                                                <div class="col-md-6">


                                                                                    <H3>Saren</H3>

                                            
                    <?php
                    echo $form->redactorGroup(
                            $model, 'documento', array(
                        'widgetOptions' => array(
                            'editorOptions' => array(
                                'class' => 'span4',
                                'rows' => 5,
                                'options' => array('plugins' => array('clips', 'fontfamily'), 'lang' => 'sv')
                            )
                        )
                            )
                    );
                    ?>
                    <?php
//                var_dump($doc_banavih);die;
                    ?>
                                                                                    
                                    
            </div>
            <div class="col-md-6">
            <H3>Banavih</H3>
            <TEXTAREA ID="text1"  ROWS=10 style="display:none"> <?php echo $modell["documento"]; ?></TEXTAREA>
            <TEXTAREA ID="text2"  ROWS=10 style="display:none"> <?php echo $doc_banavih["documento"]; ?></TEXTAREA>
            <P><INPUT TYPE="button" onClick="launch()" VALUE="Ver Correcciones"></P>

            <DIV ID="outputdiv"></DIV>

            </div>
             </div>
                                                                            

                  
        <?php } ?>


    </div>


    <!--/////////////////////////////////-->

    <?php if ((!$model["estatus"] == 285) || ($model["estatus"] == 53)) { ?> 

                <div class="rows">
                    <div class="col-md-12">
                        <div class="form-actions">
                            <div class="well">
                                <?php if (!Yii::app()->user->checkAccess('administrador_documentacion')) { ?>
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
                                    'onclick' => 'document.location.href ="' . $this->createUrl('documentacion/adminmultifamiliar') . '";'
                                )
                            ));
                            ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
    <?php } ?> 
    <?php $this->endWidget(); ?>
