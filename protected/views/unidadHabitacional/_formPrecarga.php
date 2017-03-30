<?php 
$baseUrl = Yii::app()->baseUrl;
$Validacion = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/js_jquery.numeric.js');
?>
<?php Yii::app()->clientScript->registerScript('desarrolloVal', "
    $(document).ready(function(){
        //$('#es_parcela').bootstrapSwitch('state', true, true);
        $('#UnidadHabitacional_asiento_registral').numeric(); 
        $('#UnidadHabitacional_folio_real').numeric(); 
        $('#UnidadHabitacional_cant_vivienda_piso').numeric(); 
        $('#UnidadHabitacional_cant_vivienda').numeric(); 
        $('#UnidadHabitacional_gen_tipo_inmueble_id option[value=\'84\']').remove();

   });
"); ?>
<script type="text/javascript">
    function parcela() {
        if ($('#es_parcela').is(":checked")) {
            $('#UnidadHabitacional_gen_tipo_inmueble_id').val('');
            $('#pertenece_parcela').bootstrapSwitch('state', false, false);
             $("#UnidadHabitacional_gen_tipo_inmueble_id").append("<option value='84'>PARCELA</option>");
            $('#UnidadHabitacional_gen_tipo_inmueble_id').val('84');
            $('#div-parcela').hide('fade');
        } else {
            $('#UnidadHabitacional_gen_tipo_inmueble_id option[value=\'84\']').remove();
            $('#div-parcela').show('fade');
        }
    }
    function parcelasDesarrollo() {
        if ($('#pertenece_parcela').is(":checked")) {
            $('#parcelaDesarrollo').show('fade');
        } else {
            $('#UnidadHabitacional_id_parcela').val('');
            $('#parcelaDesarrollo').hide('fade');
        }
    }
</script>
<div class="row">
    <div class="col-md-4">

        <?php
        $criteria = new CDbCriteria;
        $criteria->order = 'strdescripcion ASC';
        echo $form->dropDownListGroup($estado, 'clvcodigo', array('wrapperHtmlOptions' => array('class' => 'col-sm-4',),
            'widgetOptions' => array(
                'data' => CHtml::listData(Tblestado::model()->findAll($criteria), 'clvcodigo', 'strdescripcion'),
                'htmlOptions' => array(
                    'empty' => 'SELECCIONE',
                    'disabled' => TRUE,
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarMunicipios'),
                        'update' => '#' . CHtml::activeId($municipio, 'clvcodigo'),
                        
                    ),
                ),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $form->dropDownListGroup($municipio, 'clvcodigo', array('wrapperHtmlOptions' => array('class' => 'col-sm-12',),
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'disabled' => TRUE,
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarParroquias'),
                        'update' => '#' . CHtml::activeId($parroquia, 'clvcodigo'),
                    ),
                    'empty' => 'SELECCIONE',
                ),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-4">

        <?php
        echo $form->dropDownListGroup($parroquia, 'clvcodigo', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar',),
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'disabled' => true,
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarDesarrollo'),
                        'update' => '#' . CHtml::activeId($model, 'desarrollo_id'),
                    ),
                    
                ),
            )
                )
        );
        ?>
    </div>

</div>
<div class="row">

    <div class='col-md-4'>
        <?php
        echo $form->dropDownListGroup($model, 'desarrollo_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarParcelas'),
                        'update' => '#' . CHtml::activeId($model, 'id_parcela'),
                    ),
                    'empty' => 'SELECCIONE',
                ),
            )
                )
        );
        ?>
    </div>
    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'nombre', array('widgetOptions' => array('htmlOptions' => array('class' => ''))));
        ?>
    </div>
    <div class='col-md-4'>
        <?php echo CHtml::activeLabel($model, 'es_parcela'); ?><br>
        <?php
        $this->widget('booster.widgets.TbSwitch', array('name' => 'es_parcela',
            'options' => array(
                'size' => 'large',
                'onText' => 'SI',
                'offText' => 'NO',
            ),
            'htmlOptions' => array(
                'onChange' => 'parcela()'
            )
        ));
        ?> 
    </div>

</div>
<div class="row"  id='div-parcela'>

    <div class='col-md-4'>
        <?php
        echo $form->dropDownListGroup($model, 'gen_tipo_inmueble_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(81, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>
    </div>

    <div class='col-md-4'>
        <?php echo CHtml::activeLabel($model, 'pertenece_parcela'); ?><br>
        <?php
        $this->widget('booster.widgets.TbSwitch', array('name' => 'pertenece_parcela',
            'options' => array(
                'size' => 'large',
                'onText' => 'SI',
                'offText' => 'NO',
            ),
            'htmlOptions' => array(
                'onChange'=>'parcelasDesarrollo()'
        )));
        ?> 
    </div>

    <div class='col-md-4' id="parcelaDesarrollo" style="display: none">
        <?php
        echo $form->dropDownListGroup($model, 'id_parcela', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
              //  'data' => Maestro::FindMaestrosByPadreSelect(81, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>
    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <?php
        echo $form->textAreaGroup(
                $model, 'lindero_norte', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 1, 'maxlength' => 2000,
                ),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-6">
        <?php
        echo $form->textAreaGroup(
                $model, 'lindero_sur', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 1, 'maxlength' => 2000,
                ),
            )
                )
        );
        ?>
    </div>

</div>
<div class="row">
    <div class="col-md-6">
        <?php
        echo $form->textAreaGroup(
                $model, 'lindero_este', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 1, 'maxlength' => 2000,
                ),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-6">
        <?php
        echo $form->textAreaGroup(
                $model, 'lindero_oeste', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 1, 'maxlength' => 2000,
                ),
            )
                )
        );
        ?>

    </div>
</div>



<div class='row'>
    <div class='col-md-4'>
        <?php
        echo $form->dropDownListGroup($model, 'registro_publico_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => CHtml::listData(RegistroPublico::model()->findAll(), 'id_registro_publico', 'nombre_registro_publico'),
                'htmlOptions' => array('empty' => 'SELECCIONE', 'disabled' => true),
            )
                )
        );
        ?>
    </div>
    <div class='col-md-4'>
        <?php
        echo $form->datePickerGroup($model, 'fecha_registro', array('widgetOptions' =>
            array(
                'options' => array(
                    'language' => 'es',
                    'format' => 'dd/mm/yyyy',
                    'startView' => 0,
                    'minViewMode' => 0,
                    'todayBtn' => 'linked',
                    'weekStart' => 0,
                    'endDate' => 'now()',
                    'autoclose' => true,
                ),
                'htmlOptions' => array(
                    'class' => 'col-md-4 limpiar',
                    'disabled' => true,
                    'width' => '17%',
                // 'size' => '10',
                ),
            ),
            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
            'beforeShowDay' => 'DisableDays',
                )
        );
        ?>
    </div>

    <div class='col-md-4'>
        <?php
        echo $form->dropDownListGroup($model, 'num_protocolo', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(144, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE', 'disabled' => true),
            )
                )
        );
        ?>

    </div>
</div>

<div class="row">

    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'tomo', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'readonly' => true))));
        ?>
    </div>
    <div class='col-md-4'>
        <?php
        echo $form->dropDownListGroup($model, 'tipo_documento_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(86, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE', 'disabled' => true),
            )
                )
        );
        ?>
    </div>

    <div class='col-xs-6 col-md-4'>
        <?php
        echo $form->datePickerGroup($model, 'ano', array('widgetOptions' =>
            array(
                'options' => array(
                    'language' => 'es',
                    'format' => 'yyyy',
                    'startView' => 1,
                    'minViewMode' => 2,
                    'autoclose' => true,
                    'endDate' => 'now()',
                ),
                'htmlOptions' => array(
                    'class' => 'col-xs-6 col-md-4',
                    'disabled' => true,
                    'width' => '17%',
                ),
            ),
            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
                )
        );
        ?>
    </div>
</div>
<div class="row">

    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'nro_documento', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'readonly' => true,))));
        ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'asiento_registral', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'readonly' => true,))));
        ?>
    </div>


    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'folio_real', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'readonly' => true,))));
        ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'nro_matricula', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'readonly' => true,))));
        ?>
    </div>

</div>



