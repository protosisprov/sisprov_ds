<?php echo $form->hiddenField($model, 'beneficiario_temporal_id'); ?>

<div class="row">
    <div class="col-md-4">
        <?php
        echo $form->dropDownListGroup($model, 'nacionalidad', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(96, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $form->textFieldGroup($model, 'cedula', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 8,
//                    'onblur' => "buscarBeneficiarioTemporal($('#Beneficiario_nacionalidad').val(),$(this).val())"
        ))));
        ?>
        <?php echo $form->error($model, 'cedula'); ?>
    </div>
    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'rif', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20, 'placeholder' => 'Ejemplo: V-00000000-0',))));
        ?>
    </div>
</div>
<div class="row">
    <div class='col-md-6'>
        <?php
        echo $form->dropDownListGroup($unidad_familiar, 'condicion_unidad_familiar_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(139, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>
    </div>
    <div class='col-md-6'>

        <?php
        echo $form->datePickerGroup($model, 'fecha_ultimo_censo', array('widgetOptions' =>
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
                 'readonly'=>TRUE,
                ),
            ),
            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
            'beforeShowDay' => 'DisableDays',
                )
        );
        ?>
    </div>
</div>
<div class="row">
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'primer_nombre', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20, 'readonly' => true))));
        ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'segundo_nombre', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20, 'readonly' => true))));
        ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'primer_apellido', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20, 'readonly' => true))));
        ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($model, 'segundo_apellido', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20, 'readonly' => true))));
        ?>
    </div>
</div>


<div class="row">
    <!--<div class='col-md-4'>-->
        <?php
//        echo $form->textFieldGroup($model, 'fecha_nacimiento', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20, 'readonly' => true))));
        ?>
    <div class='col-md-4'>
        <?php
        echo $form->datePickerGroup($model, 'fecha_nacimiento', array('widgetOptions' =>
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
                 'placeholder' => 'Fecha de Nacimiento',
                    'readonly'=>TRUE,
                ),
            ),
//            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
            'beforeShowDay' => 'DisableDays',
                )
        );
        ?>
    </div>
    <!--</div>-->

    <!--<div class='col-md-4'>-->

        <?php
//        echo $form->textFieldGroup($model, 'sexo', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 20, 'readonly' => true))));
        ?>
    <!--</div>-->    
   <div class='col-md-4'>
        <?php
        echo $form->dropDownListGroup($model, 'sexo', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
                'data' => array('1' => 'FEMENINO', '2' => 'MASCULINO'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>

    </div>

    <div class='col-md-4'>

        <?php
        echo $form->dropDownListGroup($model, 'estado_civil', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(162, 'descripcion ASC'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>

    </div>

</div>


<div class="row">
    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'telf_habitacion', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 12,))));
        ?>
    </div>
    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'telf_celular', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 12))));
        ?>
    </div>
    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'correo_electronico', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200, 'placeholder' => 'usuario@servidor.dominio'))));
        ?>

    </div>

</div>
