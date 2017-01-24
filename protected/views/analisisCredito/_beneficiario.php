
<?php
//Yii::app()->clientScript->registerScript('desarrollo', "
//  $(document).ready(function(){
//    $.get('" . CController::createUrl('ValidacionJs/CargarPrograma') . "', {fuente_financiamiento_id: " . $desarrollo->fuente_financiamiento_id . " }, function(data){
//    $('#Desarrollo_programa_id').html(data);
//    $('#Desarrollo_programa_id').val(" . $desarrollo->programa_id . ");
//    });
//    
//    $('#Desarrollo_programa_id').attr('readonly', true);
//    $('#Desarrollo_fuente_financiamiento_id').attr('readonly', true);
//
//  });
//");
?>



<?php echo $form->hiddenField($model, 'unidad_familiar_id'); ?>

<div class='row'>
    <div class='col-md-6'>
        <?php
        echo $form->textFieldGroup($beneficiario, 'cedula', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => $beneficiario->beneficiarioTemporal->fkNacionalidad->descripcion . ' - ' . $beneficiario->beneficiarioTemporal->cedula, 'maxlength' => 8, 'readonly' => 'readonly'
        ))));
        ?>
    </div>
    <div class='col-md-6'>
        <?php
        echo $form->textFieldGroup($beneficiario, 'nombre', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => $beneficiario->beneficiarioTemporal->nombre_completo, 'maxlength' => 8, 'readonly' => 'readonly'
        ))));
        ?>
    </div>
  
</div>
<div class='row'>
    <div class='col-md-3'>
        <?php echo $form->textFieldGroup($model, 'desarrollo', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => $beneficiario->beneficiarioTemporal->desarrollo->nombre, 'readonly' => 'readonly')))); ?>
    </div>
    <div class='col-md-3'>
        <?php echo $form->textFieldGroup($model, 'unidad_habitacional', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => $beneficiario->beneficiarioTemporal->unidadHabitacional->nombre, 'readonly' => 'readonly')))); ?>
    </div>
    <div class='col-md-3'>
        <?php echo $form->textFieldGroup($model, 'tipo_vivienda', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => $beneficiario->beneficiarioTemporal->vivienda->tipoVivienda->descripcion, 'readonly' => 'readonly')))); ?>
    </div>
    <div class='col-md-3'>
        <?php echo $form->textFieldGroup($model, 'nro_vivienda', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => !empty($beneficiario->beneficiarioTemporal->vivienda->nro_piso)? 
            'Piso: '.$beneficiario->beneficiarioTemporal->vivienda->nro_piso.' / N°: '.$beneficiario->beneficiarioTemporal->vivienda->nro_vivienda : ''.$beneficiario->beneficiarioTemporal->vivienda->nro_vivienda, 'readonly' => 'readonly')))); ?>
    </div>
</div>
<div class='row'>
    <div class='col-md-6'>
        <?php echo $form->hiddenField($desarrollo, 'fuente_financiamiento_id');?>
        <?php
        echo $form->textFieldGroup($model, 'nombre_fuente_financiamiento', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
//                'data' => CHtml::listData(FuenteFinanciamiento::model()->findAll(), 'id_fuente_financiamiento', 'nombre_fuente_financiamiento'),
                'htmlOptions' => array(
                    'class' => 'span5', 
                    'value' => $benetemp->nombre_fuente_financiamiento, 
                    'readonly' => 'readonly',
//                    'empty' => 'SELECCIONE',
                    //'onchange'=>'calcularSueldo($(this).val())',
//                    'ajax' => array(
//                        'type' => 'POST',
//                        'url' => CController::createUrl('ValidacionJs/CargarPrograma'),
//                        'update' => '#' . CHtml::activeId($desarrollo, 'programa_id'),
//                    )
                    ),
            )
                )
        );
        ?>
    </div>
    <div class='col-md-6'>
        <?php echo $form->hiddenField($desarrollo, 'programa_id');?>
        <?php
        echo $form->textFieldGroup($model, 'nombre_programa', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
//                'data' => CHtml::listData(Programa::model()->findAll(), 'id_programa', 'nombre_programa'),
                'htmlOptions' => array( 'class' => 'span5', 
                    'value' => $beneficiario->beneficiarioTemporal->vivienda->unidadHabitacional->desarrollo->programa->nombre_programa, 
                    'readonly' => 'readonly',
                ),
            )
                )
        );
        ?>
    </div>
</div>
