<?php
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
$Validacion = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/js_jquery.numeric.js');
?>
<?php 
$this->widget('application.extensions.moneymask.MMask',array(
 //   'element'=>'#testing',
    'currency'=>'PHP',
//    'config'=>array(
//        'showSymbol'=>true,
//        'symbolStay'=>true,
//    )
));
Yii::app()->clientScript->registerScript('desarollo', "
    $(document).ready(function(){
        
//        $('#Desarrollo_lote_terreno_mt2').maskMoney({prefix:' ', allowNegative: true, decimal:','});
    });  
");
?>
<div class="row">
    <div class="col-md-6">
        <?php echo $form->textFieldGroup($model, 'nombre', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200)))); ?>
    </div>
    <div class="col-md-6">
        <?php echo $form->textFieldGroup($model, 'descripcion', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 300)))); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4" >
        <?php
        echo $form->dropDownListGroup($model, 'fuente_financiamiento_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => CHtml::listData(FuenteFinanciamiento::model()->findAll(), 'id_fuente_financiamiento', 'nombre_fuente_financiamiento'),
                'htmlOptions' => array('empty' => 'SELECCIONE', 'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/CargarPrograma'),
                        'update' => '#' . CHtml::activeId($model, 'programa_id'),
                    )
                ),
            )
                )
        );
        ?>
    </div>

    <div class="col-md-4" >
        <?php
        echo $form->dropDownListGroup($model, 'id_fuente_financiamiento_obra', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => CHtml::listData(FuenteFinanciamientoObra::model()->findAll(), 'id_fuente_financiamiento_obra', 'nombre_fuente_financiamiento_obra'),
                'htmlOptions' => array('empty' => 'SELECCIONE', 
                    ),
                    )
                
            
                )
        );
        ?>
    </div>
    <div class="col-md-4">
        <?php
        echo $form->dropDownListGroup($model, 'programa_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => CHtml::listData(Programa::model()->findAll(), 'id_programa', 'nombre_programa'),
                'htmlOptions' => array('empty' => 'SELECCIONE',
                ),
            )
                )
        );
        ?>
    </div>
    
</div>
<div class="row">
    <div class="col-md-4" >
        <?php
        echo $form->dropDownListGroup($model, 'ente_ejecutor_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => CHtml::listData(EnteEjecutor::model()->findAll(), 'id_ente_ejecutor', 'nombre_ente_ejecutor'),
                'htmlOptions' => array('empty' => 'SELECCIONE',
                ),
            )
                )
        );
        ?>
    </div>

    <div class="col-md-4">

        <?php
        $criteria = new CDbCriteria;
        $criteria->order = 'strdescripcion ASC';
        echo $form->dropDownListGroup($estado, 'clvcodigo', array('wrapperHtmlOptions' => array('class' => 'col-sm-4',),
            'widgetOptions' => array(
                'data' => CHtml::listData(Tblestado::model()->findAll($criteria), 'clvcodigo', 'strdescripcion'),
                'htmlOptions' => array(
                    'empty' => 'SELECCIONE',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarMunicipios'),
                        'update' => '#' . CHtml::activeId($municipio, 'clvcodigo'),
                    ),
                // 'title' => 'Por favor, Seleccione el estado de procedencia',
                // 'data-toggle' => 'tooltip', 'data-placement' => 'right',
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
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarParroquias'),
                        'update' => '#' . CHtml::activeId($model, 'parroquia_id'),
                    ),
                    'empty' => 'SELECCIONE',
                // 'title' => 'Por favor, Seleccione su municipio de procedencia',
                //'data-toggle' => 'tooltip', 'data-placement' => 'right',
                ),
            )
                )
        );
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">

        <?php
        echo $form->dropDownListGroup($model, 'parroquia_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar',),
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'empty' => 'SELECCIONE',
                // 'title' => 'Por favor, Seleccione su parroquia ',
                //'data-toggle' => 'tooltip', 'data-placement' => 'right',
                ),
            )
                )
        );
        ?>
    </div>


    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model, 'urban_barrio', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200)))); ?>
    </div>
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model, 'av_call_esq_carr', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200)))); ?>
    </div>
</div>
<div class="row">

    <div class="col-md-6">
        <?php
        echo $form->textAreaGroup(
                $model, 'zona', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 1, 'maxlength' => 200,
                ),
            )
                )
        );
        ?>
        <?php // echo $form->textFieldGroup($model, 'zona', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200))));   ?>
    </div>



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
</div>
<div class="row">
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
        <?php //echo $form->textFieldGroup($model, 'lindero_sur', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200))));    ?>
    </div>


    <div class="col-md-6">
        <?php //echo $form->textFieldGroup($model, 'lindero_este', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200))));  ?>
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
</div>
<div class="row">
    <div class="col-md-6">

        <?php //echo $form->textFieldGroup($model, 'lindero_oeste', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 200))));  ?>
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


    <div class="col-md-6">
        <?php echo $form->textFieldGroup($model, 'coordenadas', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 7)))); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model, 'lote_terreno_mt2', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 8)))); ?>
    </div>
    <div class='col-md-3'>
        <?php
        echo $form->dropDownListGroup($model, 'modalidad_documento_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(246, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-3 " >
        <?php echo CHtml::activeLabel($model, 'titularidad_del_terreno'); ?><br>
        <?php
        $this->widget('booster.widgets.TbSwitch', array(
            'name' => 'titularidad_del_terreno',
            'options' => array(
                'size' => 'large',
                'onText' => 'SI',
                'offText' => 'NO',
            ),
            'htmlOptions' => array(
                'class' => 'titularidad',
                'onChange' => 'Terreno()',
            )
                )
        );
        ?> 
    </div>

    <div class='col-md-3'>
        <?php
        echo $form->dropDownListGroup($model, 'propiedad_terreno_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(258, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>
    </div>
    
</div>

    <div class="row">
        <div class="col-md-4 fecha" style="display: none" >
        <?php echo CHtml::activeLabel($model, 'matricula'); ?><br>
        <?php
        $this->widget('booster.widgets.TbSwitch', array(
            'name' => 'matricula',
            'options' => array(
                'size' => 'large',
                'onText' => 'SI',
                'offText' => 'NO',
            ),
            'htmlOptions' => array(
                'class' => 'matricula matri',
                'onChange' => 'Matricula()',
            )
                )
        );
        ?>
    </div>
        
    
  
        
    
    
    <div class='col-md-4 fecha'  style="display: none">
        <?php
        echo $form->dropDownListGroup($model, 'ente_titular_terreno_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(253, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE'),
            )
                )
        );
        ?>
    </div>
    
    <div class="col-md-4 fecha" style="display: none">
        
        
        
        <?php
        echo $form->datePickerGroup($model, 'fecha_transferencia', array('widgetOptions' =>
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
                    'placeholder' => 'Seleccione Fecha de Transferencia'
                ),
            ),
//            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
            'beforeShowDay' => 'DisableDays',
                )
        );
        ?>
    </div>
</div>


<div class='row fecha' style="display: none">
    <div class='col-md-4'>
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
 <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'nro_documento', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'placeholder' => 'Número de Documento'))));
        ?>
    </div>
    
</div>

<div class="row col2" style="display: none">


    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'tomo', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'placeholder' => 'Nuḿero de tomo', 'maxlength' => 3))));
        ?>
    </div>
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

    <div class='col-md-4'>
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
   <div class='col-md-4'>
        <?php
        echo $form->dropDownListGroup($model, 'num_protocolo', array('wrapperHtmlOptions' => array('class' => ''),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(144, 'descripcion DESC'),
                'htmlOptions' => array('empty' => 'SELECCIONE',),
            )
                )
        );
        ?>

    </div>
</div>

<div class="row col1" style="display: none">

    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'asiento_registral', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'placeholder' => 'Asiento Registral', 'maxlength' => 20))));
        ?>
    </div>


    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'folio_real', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'placeholder' => 'Folio Real', 'maxlength' => 3))));
        ?>
    </div>
    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'num_matricula', array('widgetOptions' => array('htmlOptions' => array('class' => '', 'placeholder' => 'Número de Matricula'))));
        ?>
    </div>

</div>

