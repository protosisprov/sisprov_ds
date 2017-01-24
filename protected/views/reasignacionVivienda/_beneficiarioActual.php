<?php echo $form->hiddenField($model, 'beneficiario_id_actual'); ?>
<div class="row">

    <div class='col-md-3'>
        <b>Nacionalidad </b> <span class="required">*</span>
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
    <div class='col-md-3'>
        <b>Cédula del Beneficiario Actual</b> <span class="required">*</span>
        <?php
        echo $form->textFieldGroup($model, 'cedula', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 8,
                    'onblur' => "buscarBenefAnterior($('#ReasignacionVivienda_nacionalidad').val(), $(this).val())"
        ))));
        ?>
        <?php // echo $form->error($model, 'cedula'); ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->textFieldGroup($beneficiario, 'rif', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 12, 'placeholder' => 'Ejemplo: V-00000000-0',))));
        ?>
    </div>
    <div class="col-md-3"  id="iconLoding" style="display: none">
        <img src="<?php echo Yii::app()->baseUrl; ?>/images/loading.gif" width="50px" height="60px">
    </div>

</div>


<div class="row">
    <div class='col-md-3'>
        <b>Primer Nombre</b> <span class="required">*</span>
        <?php
        echo $form->textFieldGroup($model, 'primer_nombreActual', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200, 'readonly' => true))));
        ?>
    </div>
    <div class='col-md-3'>
        <b>Segundo Nombre</b> <span class="required">*</span>
        <?php
        echo $form->textFieldGroup($model, 'segundo_nombreActual', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200, 'readonly' => true))));
        ?>
    </div>


    <div class='col-md-3'>
        <b>Primer Apellido</b> <span class="required">*</span>
        <?php
        echo $form->textFieldGroup($model, 'primer_apellidoActual', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200, 'readonly' => true))));
        ?>
    </div>
    <div class='col-md-3'>
        <b>Segundo Apellido</b> <span class="required">*</span>
        <?php
        echo $form->textFieldGroup($model, 'segundo_apellidoActual', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200, 'readonly' => true))));
        ?>
    </div>


</div>




<div class="row"> 
    <div class='col-md-4'>
        <b>Fecha de Nacimiento</b> <span class="required">*</span>

        <?php
        echo $form->datePickerGroup($model, 'fecha_nacimientoActual', array('widgetOptions' =>
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
                    'readonly' => TRUE,
                ),
            ),
//            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
            'beforeShowDay' => 'DisableDays',
                )
        );
//        echo $form->textFieldGroup($model, 'fecha_nacimientoActual', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200, 'readonly' => true))));
        ?>
    </div>
    <div class='col-md-4'>
        <b>Sexo</b> <span class="required">*</span>
        <?php
        echo $form->dropDownListGroup($model, 'sexoActual', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
                'data' => array('1' => 'FEMENINO', '2' => 'MASCULINO'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>

    </div>

    <div class='col-md-4'>
        <b>Estado Civil</b> <span class="required">*</span>
        <?php
        echo $form->dropDownListGroup($model, 'estado_civilActual', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
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
        echo $form->textFieldGroup($model, 'telf_habitacionActual', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 12, 'readonly' => true))));
        ?>
    </div>
    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'telf_celularActual', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 12, 'readonly' => true))));
        ?>
    </div>
    <div class='col-md-4'>
        <?php echo $form->labelEx($model, 'correo_electronicoActual'); ?>

        <?php
        $this->widget(
                'booster.widgets.TbSelect2', array('asDropDownList' => false,
            'name' => CHtml::activeId($model, 'correo_electronicoActual'),
            'attribute' => 'correo_electronicoActual',
            'htmlOptions' => array(
                'onchange' => 'emailCheck(this.value,this.id);',
                'title' => 'Por favor, Ingrese un correo electrónico',
                'data-toggle' => 'tooltip', 'data-placement' => 'right',),
            'options' => array(
                'tags' => array(),
                'placeholder' => 'usuario@servidor.dominio POR FAVOR PRESIONE ENTER',
                'width' => '100%',
                'tokenSeparators' => array(',', ' '),
                'multiple' => true,
                'maximumInputLength' => 150,
                //'minimumInputLength' => ,
                'maximumSelectionSize' => 1,
                'allowClear' => true,
                'items' => 4,
            )
                )
        );
        ?>
        <?php
//        echo $form->textFieldGroup($model, 'correo_electronicoActual', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200))));
        ?>
    </div>
</div>
<div class="row">
    <div class='col-md-6'>
        <?php
        echo $form->datePickerGroup($beneficiario, 'fecha_ultimo_censo', array('widgetOptions' =>
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
                /* 'class' => 'span5 limpiar', */
                ),
            ),
            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
            'beforeShowDay' => 'DisableDays',
                )
        );
        ?>
    </div>

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

</div>



