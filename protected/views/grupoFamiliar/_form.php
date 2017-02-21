<?php
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/js_jquery.numeric.js');
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
Yii::app()->clientScript->registerScript('grupoFamiliar', "
    $(document).ready(function(){
        $('.numeric').numeric();   
    }),
    
    $('#GrupoFamiliar_ingreso_mensual').change(function(){
        $('#GrupoFamiliar_gen_parentesco_id').val('');
        $('#GrupoFamiliar_tipo_persona_faov').val('');
    }),
    
     $('#GuardarFamiliar').click(function(){

        var idPersona = $('#GrupoFamiliar_persona_id').val();
        var cedula = $('#GrupoFamiliar_cedula').val();
        var nacionalidad = $('#GrupoFamiliar_nacionalidad').val();
        var primerNombre = $('#GrupoFamiliar_primer_nombre').val();
        var segundoNombre = $('#GrupoFamiliar_segundo_nombre').val();
        var primerApellido = $('#GrupoFamiliar_primer_apellido').val();
        var segundoApellido = $('#GrupoFamiliar_segundo_apellido').val();
        var parentesco = $('#GrupoFamiliar_gen_parentesco_id').val();
        var tipoSujeto = $('#GrupoFamiliar_tipo_sujeto_atencion').val();
        var tipoDiscapacidad = $('#GrupoFamiliar_tipo_discapacidad').val();
        var ingresoM = $('#GrupoFamiliar_ingreso_mensual').val();
        var ingresoMFaov = $('#GrupoFamiliar_ingreso_mensual_faov').val();
        var fechaNac = $('#GrupoFamiliar_fecha_nacimiento').val();
        var IdUnidadF = '" . $_GET['id'] . "';
        var tipoPersonaFaov = $('#GrupoFamiliar_tipo_persona_faov').val();
        var fechaNacMenor = $('#GrupoFamiliar_fecha_nacimiento_menor').val();
        

        if(cedula == ''){
            bootbox.alert('Ingrese un número de cédula!');
            $('#GrupoFamiliar_gen_parentesco_id').val('');
            return false;
        }
        if(cedula == '0'){
            if(fechaNacMenor == ''){
                bootbox.alert('Ingrese la fecha de Nacimiento');
                return false;
            }
        }
        
        if(ingresoM == ''){
            bootbox.alert('Indique el Ingreso Mensual.');
            return false;
        }
        
        if(primerNombre == ''){
            bootbox.alert('Ingrese el Primer nombre.');
            return false;
        }
        
//        if(segundoNombre == ''){
//            bootbox.alert('Ingrese el Segundo nombre.');
//            return false;
//        }
        
        if(primerApellido == ''){
            bootbox.alert('Ingrese el Primer Apellido.');
            return false;
        }
        
//        if(segundoApellido == ''){
//            bootbox.alert('Ingrese el Segundo Apellido.');
//            return false;
//        }

       

        contadorPadre = parseInt(0);
        contadorConyuge = parseInt(0);
        contadorMadre = parseInt(0);
        contadorSuegro = parseInt(0);
        contadorAbuelo = parseInt(0);
        contadorConcubina = parseInt(0);
        $('#listado_familiar tr').each(function () {
            var parentescoTable = $(this).find('td:eq(2)').html();
            if (parentescoTable == 'PADRE') {
                contadorPadre++
            }
            if (parentescoTable == 'MADRE') {
                contadorMadre++
            }
            if (parentescoTable == 'CÓNYUGE') {
                contadorConyuge++
            }
            if (parentescoTable == 'ABUELO(A)') {
                contadorAbuelo++
            }
            if (parentescoTable == 'SUEGRO') {
                contadorSuegro++
            }
            if (parentescoTable == 'CONCUBINO(A)') {
                contadorConcubina++
            }
        });


        if (parentesco == 161) {
            if (contadorConyuge > 0) {
                bootbox.alert('Usted ya tiene registrado un Conyuge.');
                $('#GrupoFamiliar_gen_parentesco_id').val('');
                return false;
            }
        } else if (parentesco == 152) {
            if (contadorMadre > 0) {
                bootbox.alert('Usted ya tiene registrado a su Madre.');
                $('#GrupoFamiliar_gen_parentesco_id').val('');
                return false;
            }
        } else if (parentesco == 150) {
            if (contadorPadre > 0) {
                bootbox.alert('Usted ya tiene registrado a su Padre.');
                $('#GrupoFamiliar_gen_parentesco_id').val('');
                return false;
            }
        } else if (parentesco == 157) {
            if (contadorSuegro >= 2) {
                bootbox.alert('Usted ya posee asociado dos Suegros.');
                $('#GrupoFamiliar_gen_parentesco_id').val('');
                return false;
            }
        } else if (parentesco == 156) {
            if (contadorAbuelo >= 4) {
                bootbox.alert('Usted ya posee asociado cuatro Abuelos.');
                $('#GrupoFamiliar_gen_parentesco_id').val('');
                return false;
            }
        } else if (parentesco == 161) {
            if (contadorConcubina > 0) {
                bootbox.alert('Usted ya posee una Concubina(o) asociada(o).');
                $('#GrupoFamiliar_gen_parentesco_id').val('');
                return false;
            }
        }
        
        if ($('#GrupoFamiliar_tipo_sujeto_atencion').is(':checked')) 
        {
            if(tipoDiscapacidad == '')
            {
                bootbox.alert('Seleccione Tipo de Discapacidad');
                return false;
            }
            else
            {
                tipoSujeto = '231';
            }
        }
        else
        {
            tipoSujeto = '';
        }

        if ($('#GrupoFamiliar_cotiza_faov').is(':checked')) {var faov = '1';}else{var faov = '0';}
        $('.loader').fadeIn('slow');
        

        $.ajax({
            url: '" . Yii::app()->createAbsoluteUrl('GrupoFamiliar/InsertFamiliar') . "',
            async: true,
            type: 'POST',
            data: 'cedula=' +cedula + '&nacionalida=' +nacionalidad + '&primerNombre=' + primerNombre +'&segundoNombre=' +segundoNombre + '&primerApellido=' +primerApellido +'&segundoApellido=' +segundoApellido +'&idPersona=' +idPersona +'&parentesco=' +parentesco +'&tipoSujeto=' +tipoSujeto +'&tipoDiscapacidad='+tipoDiscapacidad +'&ingresoM='+ ingresoM+ '&faov='+faov+'&fechaNac='+fechaNac+'&IdUnidadF='+IdUnidadF+'&ingresoMFaov='+ingresoMFaov+ '&tipoPersonaFaov='+tipoPersonaFaov+ '&fechaNacMenor='+fechaNacMenor,
            dataType: 'json',
            success: function(data,faov) {
                if(data == 3){
                    $('#GrupoFamiliar_primer_nombre').val('');
                    $('#GrupoFamiliar_cedula').val('');
                    $('#GrupoFamiliar_segundo_nombre').val('');
                    $('#GrupoFamiliar_persona_id').val('');
                    $('#GrupoFamiliar_primer_apellido').val('');
                    $('#GrupoFamiliar_segundo_apellido').val('');
                    $('#GrupoFamiliar_fecha_nacimiento').val('');
                    $('#GrupoFamiliar_ingreso_mensual_faov').val('');
                    $('#GrupoFamiliar_gen_parentesco_id').val('');
                    $('#GrupoFamiliar_tipo_sujeto_atencion').val('');
                    $('#GrupoFamiliar_tipo_discapacidad').val('');
                    $('#GrupoFamiliar_ingreso_mensual').val('');
                    $('#GrupoFamiliar_tipo_persona_faov').val('');
                    $('.loader').fadeOut('slow');
                    $.fn.yiiGridView.update('listado_familiar');
                }else if(data == 4){
                    $('#GrupoFamiliar_primer_nombre').val('');
                    $('#GrupoFamiliar_cedula').val('');
                    $('#GrupoFamiliar_segundo_nombre').val('');
                    $('#GrupoFamiliar_persona_id').val('');
                    $('#GrupoFamiliar_primer_apellido').val('');
                    $('#GrupoFamiliar_segundo_apellido').val('');
                    $('#GrupoFamiliar_fecha_nacimiento').val('');
                    $('#GrupoFamiliar_ingreso_mensual_faov').val('');
                    $('#GrupoFamiliar_gen_parentesco_id').val('');
                    $('#GrupoFamiliar_tipo_sujeto_atencion').val('');
                    $('#GrupoFamiliar_tipo_discapacidad').val('');
                    $('#GrupoFamiliar_ingreso_mensual').val('');
                    $('#GrupoFamiliar_tipo_persona_faov').val('');
                    $('.loader').fadeOut('slow');
                    $.fn.yiiGridView.update('listado_familiar');
                    bootbox.alert('Esta persona es mayor de 15 años, por favor indique una cédula.');  
                }else if(data == 1){
                    $('#GrupoFamiliar_primer_nombre').val('');
                    $('#GrupoFamiliar_cedula').val('');
                    $('#GrupoFamiliar_segundo_nombre').val('');
                    $('#GrupoFamiliar_persona_id').val('');
                    $('#GrupoFamiliar_primer_apellido').val('');
                    $('#GrupoFamiliar_segundo_apellido').val('');
                    $('#GrupoFamiliar_fecha_nacimiento').val('');
                    $('#GrupoFamiliar_ingreso_mensual_faov').val('');
                    $('#GrupoFamiliar_gen_parentesco_id').val('');
                    $('#GrupoFamiliar_tipo_sujeto_atencion').val('');
                    $('#GrupoFamiliar_tipo_discapacidad').val('');
                    $('#GrupoFamiliar_ingreso_mensual').val('');
                    $('#GrupoFamiliar_tipo_persona_faov').val('');
                    $('.loader').fadeOut('slow');
                    $.fn.yiiGridView.update('listado_familiar');
                    bootbox.alert('Esta persona ya se pertenece a un grupo familiar.');  
                }
            },
            error: function(data) {
                $('.loader').fadeOut('slow');
                bootbox.alert('Ocurrio un error');
            }
        });

    });
");
?>

<?php // echo $form->errorSummary($model); ?>
<div class="row">
    <?php echo $form->hiddenField($model, 'persona_id'); ?>
    <?php echo $form->hiddenField($model, 'fecha_nacimiento'); ?>
    <div class='col-md-2'>
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
    <div class='col-md-2'>
        <?php
        echo $form->textFieldGroup($model, 'cedula', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 numeric', 'maxlength' => 8,
                    'title' => 'Si es menor de edad indique cero',
                    'data-toggle' => 'tooltip',
                    'onblur' => "buscarPersonaFamiliar($('#GrupoFamiliar_nacionalidad').val(),$(this).val())"
        ))));
        ?>
    </div>
    <div class="col-md-2">
        <?php echo $form->textFieldGroup($model, 'ingreso_mensual', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 16)))); ?>
    </div>
    <div class="col-md-2">
        <?php echo $form->textFieldGroup($model, 'ingreso_mensual_faov', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 16, 'readonly' => 'readonly')))); ?>

    </div>
    <div class="col-md-2"  style="display: none" id="fecha_menor">
        <?php
        echo $form->datePickerGroup($model, 'fecha_nacimiento_menor', array('widgetOptions' =>
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
    <div class="col-md-2"  id="iconLoding" style="display: none">
        <img src="<?php echo Yii::app()->baseUrl; ?>/images/loading.gif" width="50px" height="60px">
    </div>

</div>
<div class="row">
    <div class='col-md-3'>

        <?php echo $form->textFieldGroup($model, 'primer_nombre', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100, 'readonly' => true,)))); ?>
    </div>
    <div class='col-md-3'>
        <?php echo $form->textFieldGroup($model, 'segundo_nombre', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100, 'readonly' => true,)))); ?>
    </div>
    <div class='col-md-3'>
        <?php echo $form->textFieldGroup($model, 'primer_apellido', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100, 'readonly' => true,)))); ?>
    </div>
    <div class='col-md-3'>
        <?php echo $form->textFieldGroup($model, 'segundo_apellido', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100, 'readonly' => true,)))); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3" id='parentesco'>
        <?php
        echo $form->dropDownListGroup($model, 'gen_parentesco_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12',),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(149, 'descripcion ASC'),
                'htmlOptions' => array(
                    'empty' => 'SELECCIONE',
                    'disabled' => true,
                    'onchange' => "aceptante($(this).val())"
                ),
            )
                )
        );
        ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->dropDownListGroup($model, 'tipo_persona_faov', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(234, 'descripcion ASC'),
               // 'htmlOptions' => array('empty' => 'NO APLICA',
               // ),
            )
                )
        );
        ?>
    </div>
    <div class='col-md-3'>

        <?php
        echo $form->dropDownListGroup($model, 'estado_civil_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(162, 'descripcion ASC'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>

    </div>
    <div class='col-md-3'></div>
    <!--<div class="col-md-3">

        <?php /*
        echo $form->dropDownListGroup($model, 'tipo_sujeto_atencion', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => array('231' => 'SI', '' => 'NO'),
                'htmlOptions' => array('empty' => 'SELECCIONE',
                ),
            )
                )
        ); */
        ?>
    </div>-->
    
</div>

<div class="row">
    <div class="col-md-3">
        <?php echo CHtml::activeLabel($model, 'tipo_sujeto_atencion'); ?><br>
        <?php
        $this->widget('booster.widgets.TbSwitch', array(
            'name' => 'GrupoFamiliar_tipo_sujeto_atencion',
            'options' => array(
                'size' => 'large',
                'onText' => 'SI',
                'offText' => 'NO',
            ),
            'htmlOptions' => array(
                'class' => 'tipo_discapacidad',
                'onChange' => 'Tipo_discapacidad()',
            )
                )
        );
        ?> 
    </div>
    <div class="col-md-3" style="display: none" id="tipo_discapacidad_div">

        <?php
        echo $form->dropDownListGroup($model, 'tipo_discapacidad', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(231, 'descripcion ASC'),
                'htmlOptions' => array('empty' => 'SELECCIONE',
                ),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
</div>
<div style="margin-bottom: 1%"></div>
<div class="row">
    <div class="pull-center text-right col-md-6">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'button',
            'icon' => 'glyphicon glyphicon-plus',
            'id' => 'GuardarFamiliar',
            'context' => 'primary',
            'label' => 'Guardar y Agregar Familiar',
        ));
        ?>
    </div>
    <div class="pull-center text-left col-md-6">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'button',
            'icon' => 'glyphicon glyphicon-log-in',
            'context' => 'success',
            'label' => 'Siguiente',
            'id'=>'siguiente',
            'htmlOptions' => array(
                'onclick' => "if(confirm('Esta seguro que culminó el registro de su carga familiar.')== true){document.location.href ='".$this->createUrl('grupoFamiliar/create/', array('id' => $_GET['id'], 'caso' => 1)) ."';}else{ return false;}"
            )
        ));
        ?>
    </div>
</div>