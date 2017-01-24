<?php
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
$Validacion = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/js_jquery.numeric.js');
$this->widget('application.extensions.moneymask.MMask',array(
 //   'element'=>'#testing',
    'currency'=>'PHP',
    'config'=>array(
        'showSymbol'=>true,
        'symbolStay'=>true,
    )
));
Yii::app()->clientScript->registerScript('desarollo', "
    $(document).ready(function(){
       $('#SalarioMinimo_gaceta').numeric();
        $('#SalarioMinimo_decreto').numeric();
        $('#SalarioMinimo_valor_salario').maskMoney('destroy');
    });  
");
?>

	

	<div class="row">
        <div class="row-fluid">

            <div class='col-md-3'>
              <?php echo $form->textFieldGroup($model,'gaceta',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
	
            </div>
            
            
              <div class='col-md-3'>
              <?php echo $form->textFieldGroup($model,'decreto',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
	
            </div>
            
              <div class='col-md-3'>
        <?php
        echo $form->datePickerGroup($model, 'fecha_vigencia', array('widgetOptions' =>
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
                   'readonly'=>'readonly',
                ),
            ),
            'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
            'beforeShowDay' => 'DisableDays',
                )
        );
        ?>
        </div>
            
              <div class='col-md-3'>
         <?php echo $form->textFieldGroup($model,'valor_salario',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>
        </div>
            
            
        </div>
    </div>
    
   
 

	 <div class="row">
        <div class="row-fluid">
            <div class='col-md-12'>
		 <?php
                echo $form->textAreaGroup(
                        $model, 'observacion', array(
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-sm-5',
                    ),
                    'widgetOptions' => array(
                        'htmlOptions' => array('rows' => 2, 'maxlength' => 200,
                        ),
                    )
                        )
                );
            ?>
	</div>
        </div>
         </div>

	


