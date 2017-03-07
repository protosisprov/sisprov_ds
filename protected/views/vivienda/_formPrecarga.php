<?php
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
$Validacion = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/js_jquery.numeric.js');
$this->widget('application.extensions.moneymask.MMask', array(
    //   'element'=>'#testing',
    'currency' => 'PHP',
    'config' => array(
        'showSymbol' => true,
        'symbolStay' => true,
        'decimal' => ',',
    )
));
Yii::app()->clientScript->registerScript('desarollo', "
    $(document).ready(function(){
        $('#Vivienda_construccion_mt2').maskMoney('destroy');
        $('#Vivienda_porcentaje_vivienda').maskMoney('destroy');

        $('#Vivienda_precio_vivienda').maskMoney({thousands:'.', decimal:',', allowZero:false});
    });  
");


?>


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
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarMunicipios'),
                        'update' => '#' . CHtml::activeId($municipio, 'clvcodigo'),
                    ),
                    // 'title' => 'Por favor, Seleccione el estado de procedencia',
                    // 'data-toggle' => 'tooltip', 'data-placement' => 'right',
                    'disabled' => TRUE,
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
                        'update' => '#' . CHtml::activeId($parroquia, 'clvcodigo'),
                    ),
                    'empty' => 'SELECCIONE',
                    // 'title' => 'Por favor, Seleccione su municipio de procedencia',
                    //'data-toggle' => 'tooltip', 'data-placement' => 'right',
                    'disabled' => TRUE,
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
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarDesarrollo'),
                        'update' => '#' . CHtml::activeId($desarrollo, 'id_desarrollo'),
                    ),
                    'empty' => 'SELECCIONE',
                    'disabled' => TRUE,
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
        echo $form->dropDownListGroup($desarrollo, 'id_desarrollo', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                //   'data' => Maestro::FindMaestrosByPadreSelect(694, 'descripcion ASC'),
                'htmlOptions' => array(
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ValidacionJs/BuscarUnidadHabitacional'),
                        'update' => '#' . CHtml::activeId($model, 'unidad_habitacional_id'),
                    ),
                    'empty' => 'SELECCIONE',
                    'disabled' => TRUE,
                ),
            )
                )
        );
        ?>
    </div>

      
    <div class="col-md-4">
        
        <?php                

        
        echo $form->dropDownListGroup($unidad_habitacional, 'nombre', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            
            'widgetOptions' => array(
                
                'data' => UnidadHabitacional::FindUnidadByIdSelect($unidad_habitacional->id_unidad_habitacional, 'nombre DESC'),        
                                
                'htmlOptions' => array('disabled' => TRUE,
                
                ),
            )
                )
        );
       
        echo $form->hiddenField($model,'unidad_habitacional_id',array('type'=>"hidden",'size'=>2,'maxlength'=>2));
        
        ?>
        
        
        <?php //echo $form->textFieldGroup($unidad_habitacional, 'nombre', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 10, 'readonly' => 'readonly')))); ?>
    </div>     

    <div class="col-md-4">
        <?php echo $form->textFieldGroup($unidad_habitacional->genTipoInmueble, 'descripcion', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 10, 'readonly' => 'readonly')))); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?php
        echo $form->dropDownListGroup($model, 'tipo_vivienda_id', array('wrapperHtmlOptions' => array('class' => 'col-sm-12 limpiar'),
            'widgetOptions' => array(
                'data' => Maestro::FindMaestrosByPadreSelect(92, 'descripcion ASC'),
                'htmlOptions' => array('empty' => 'SELECCIONE',
                ),
            )
                )
        );
        ?>
    </div>
    <div class="col-md-3" id="piso_vivienda" >
        <?php echo $form->textFieldGroup($model, 'nro_piso', array('widgetOptions' => array('htmlOptions' => array('class' => 'limpiar span5', 'maxlength' => 4, 'placeholder' => 'Número de piso')))); ?>
    </div>

    <div class="col-md-3">
        <?php
        echo $form->textFieldGroup($model, 'nro_vivienda', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 limpiar', 'maxlength' => 8,
                    'onblur' => "Viviendas($('#Vivienda_unidad_habitacional_id').val(),$('#Vivienda_nro_piso').val(),$(this).val())"))));
        ?>
        <?php echo $form->error($model, 'nro_vivienda'); ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model, 'construccion_mt2', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 limpiar lock', 'maxlength' => 6, 'placeholder' => 'Area de vivienda Mt2')))); ?>

    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <?php
     if ($model->sala == false){
         $sala = 'NO';
         echo $form->dropDownListGroup(
            $model,
            'sala',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                    ),
                'widgetOptions' => array(
                    
                    'data' => array('FALSE'=>$sala, 'TRUE'=>'SI'),
                    'htmlOptions' => array(),
                    )
                )
                ); 
     }else{
         $sala = 'SI';
         echo $form->dropDownListGroup(
            $model,
            'sala',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                    ),
                'widgetOptions' => array(
                    
                    'data' => array('TRUE'=>$sala, 'FALSE'=>'NO'),
                    'htmlOptions' => array(),
                    )
                )
                ); 
         
     }
       ?>
</div>
    <div class="col-md-3">
        <?php
        if ($model->comedor == false){
         $comedor = 'NO';
         echo $form->dropDownListGroup(
            $model,
            'comedor',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                    ),
                'widgetOptions' => array(
                    
                    'data' => array('FALSE'=>$comedor, 'TRUE'=>'SI'),
                    'htmlOptions' => array(),
                    )
                )
                ); 
     }else{
         $comedor = 'SI';
         echo $form->dropDownListGroup(
            $model,
            'comedor',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                    ),
                'widgetOptions' => array(
                    
                    'data' => array('TRUE'=>$comedor, 'FALSE'=>'NO'),
                    'htmlOptions' => array(),
                    )
                )
                ); 
         
     }
       ?>
        
    </div>

    <div class="col-md-3">
        <?php
        
         if ($model->cocina == false){
         $cocina = 'NO';
         echo $form->dropDownListGroup(
            $model,
            'cocina',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                    ),
                'widgetOptions' => array(
                    
                    'data' => array('FALSE'=>$cocina, 'TRUE'=>'SI'),
                    'htmlOptions' => array(),
                    )
                )
                ); 
     }else{
         $cocina = 'SI';
         echo $form->dropDownListGroup(
            $model,
            'cocina',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                    ),
                'widgetOptions' => array(
                    
                    'data' => array('TRUE'=>$cocina, 'FALSE'=>'NO'),
                    'htmlOptions' => array(),
                    )
                )
                ); 
         
     }
        
        
        ?>
    </div>
    <div class="col-md-3">
        <?php
          if ($model->lavandero == false){
         $lavandero = 'NO';
         echo $form->dropDownListGroup(
            $model,
            'lavandero',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                    ),
                'widgetOptions' => array(
                    
                    'data' => array('FALSE'=>$lavandero, 'TRUE'=>'SI'),
                    'htmlOptions' => array(),
                    )
                )
                ); 
     }else{
         $lavandero = 'SI';
         echo $form->dropDownListGroup(
            $model,
            'lavandero',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                    ),
                'widgetOptions' => array(
                    
                    'data' => array('TRUE'=>$lavandero, 'FALSE'=>'NO'),
                    'htmlOptions' => array(),
                    )
                )
                ); 
         
     } 
        
        
        
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model, 'nro_habitaciones', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 limpiar lock', 'maxlength' => 2,)))); ?>

    </div>
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model, 'nro_banos', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 limpiar lock', 'maxlength' => 2)))); ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model, 'nro_banos_auxiliar', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 limpiar lock', 'maxlength' => 2)))); ?>

    </div>
    <div class="col-md-3">

        <?php
        echo $form->textAreaGroup(
                $model, 'coordenadas', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5 limpiar lock',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 1, 'maxlength' => 200, 'class' => 'limpiar lock'
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
                $model, 'lindero_norte', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5 limpiar lock',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 1, 'maxlength' => 2000, 'class' => 'limpiar lock'
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
                'class' => 'col-sm-5 limpiar lock',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 1, 'maxlength' => 2000, 'class' => 'limpiar lock'
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
                'class' => 'col-sm-5 limpiar lock',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 1, 'maxlength' => 2000, 'class' => 'limpiar lock'
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
                'class' => 'col-sm-5 limpiar lock',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 1, 'maxlength' => 2000, 'class' => 'limpiar lock'
                ),
            )
                )
        );
        ?>
    </div>

</div>
<div class="row">
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model, 'nro_estacionamientos', array('widgetOptions' => array('htmlOptions' => array('class' => 'limpiar span5 lock', 'maxlength' => 16)))); ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model, 'descripcion_estac', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 limpiar lock', 'maxlength' => 16)))); ?>
    </div>
    <div class="col-md-3">
        <?php  //echo $form->textFieldGroup($model, 'precio_vivienda', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 limpiar lock', 'maxlength' => 16, 'value' => Generico::FormatearBs($model->precio_vivienda))))); ?>
                             
        <?php  echo $form->textFieldGroup($model, 'precio_vivienda', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 limpiar lock', 'maxlength' => 16, 'value' => number_format((float) $model->precio_vivienda, 2, ",", "."))))); ?>
    </div>
    <div class="col-md-3">
        <?php echo $form->textFieldGroup($model, 'porcentaje_vivienda', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5 limpiar', 'maxlength' => 6, 'placeholder' => 'Porcentaje de Vivienda')))); ?>
    </div>
</div>
