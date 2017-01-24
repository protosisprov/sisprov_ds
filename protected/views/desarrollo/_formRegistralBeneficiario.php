<?php
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
$Validacion = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/js_jquery.numeric.js');
?>
<br />
<div class='row fecha' style="display: block">
    <div class='col-md-3'>
        <?php
        echo $form->dropDownListGroup($model, 'registro_publico_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => CHtml::listData(RegistroPublico::model()->findAll(), 'id_registro_publico', 'nombre_registro_publico'),
                'htmlOptions' => array('empty' => 'SELECCIONE',),
            )
                )
        );
        ?>
    </div>

     <div class='col-md-3'>
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
                    'class' => 'span5 limpiar',
                    'readonly' => true,
                    'placeholder' => 'Seleccione Fecha de Registro'
                ),
            ),
//            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
            'beforeShowDay' => 'DisableDays',
                )
        );
        ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->dropDownListGroup($model, 'nro_protocolo', array('wrapperHtmlOptions' => array('class' => ''),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(144, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE',),
            )
                )
        );
        ?>

    </div>
    <div class='col-md-3'>
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
//                    'class' => 'col-xs-6 col-md-4', 
//                    'width' => '17%'
                    'readonly' => true,
                    'placeholder' => 'Seleccione Año',
                ),
            ),
//            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
                )
        );
        ?>
    </div>
</div>

<div class='row fecha' style="display: block">
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'asiento_registral', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'placeholder' => 'Asiento Registral', 'maxlength' => 20))));
        ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'folio_real', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'placeholder' => 'Folio Real', 'maxlength' => 3))));
        ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'nro_matricula', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'placeholder' => 'Número de Matricula'))));
        ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'tomo', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'placeholder' => 'Nuḿero de tomo', 'maxlength' => 3))));
        ?>
    </div>
</div>
<!--<div class="row fecha" style="display: block">-->

    <!--<div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'tomo', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'placeholder' => 'Nuḿero de tomo', 'maxlength' => 3))));
        ?>
    </div>-->
    <!--<div class='col-md-4'>-->
        <?php
//        echo $form->dropDownListGroup($model, 'tipo_documento_id', array('wrapperHtmlOptions' => array('class' => ''),
//            'widgetOptions' => array(
//                'data' => Maestro::FindMaestrosByPadreSelect(86, 'descripcion DESC'),
//                'htmlOptions' => array('empty' => 'SELECCIONE',),
//            )
//                )
//        );
        ?>
    <!--</div>-->
<!--</div>-->