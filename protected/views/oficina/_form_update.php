<?php
$baseUrl = Yii::app()->baseUrl;
$Validaciones = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/validacion.js');
$numeros = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/js_jquery.numeric.js');
$mascara = Yii::app()->getClientScript()->registerScriptFile($baseUrl . '/js/jquery.mask.min.js');?>
<?php 
Yii::app()->clientScript->registerScript('oficina', "
    $(document).ready(function(){
         $('#Oficina_cedula').numeric();
    }); ")
        ?>

<?php #echo $form->errorSummary($model);   ?>



<div class="row">
    <div class="row-fluid">
        <div class='col-md-4'>
            
        
        <label class="control-label" for="Tblestado_clvcodigo">Estado</label>
        <select id="Tblestado_clvcodigo" class="form-control" name="Tblestado[clvcodigo]" placeholder="Estado" disabled="disabled"> 
            
            <option value=""><?php echo $model->parroquia->clvmunicipio0->clvestado0->strdescripcion ?></option>
        </select>
    
        </div>
        
        <div class="col-md-4">
           <label class="control-label" for="Tblestado_clvcodigo">Estado</label>
        <select id="Tblestado_clvcodigo" class="form-control" name="Tblestado[clvcodigo]" placeholder="Estado" disabled="disabled"> 
            
            <option value=""><?php echo $model->parroquia->clvmunicipio0->strdescripcion ?></option>
        </select>
        </div>
        <div class="col-md-4">

           <label class="control-label" for="Tblestado_clvcodigo">Estado</label>
        <select id="Tblestado_clvcodigo" class="form-control" name="Tblestado[clvcodigo]" placeholder="Estado" disabled="disabled"> 
            
            <option value=""><?php echo $model->parroquia->strdescripcion ?></option>
        </select>
        </div>
    </div>
</div><br>

<div class="row">
    <div class="row-fluid">
        <div class='col-md-12'>
            <?php echo $form->textFieldGroup($model, 'nombre', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100)))); ?>
        </div>
        <?php echo $form->hiddenField($model, 'persona_id_jefe'); ?>
        <?php echo $form->hiddenField($model, 'fechaNac'); ?>

    </div>
</div>
<div class="row">
    <div class='col-md-4'>
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
    <div class='col-md-4'>
        <?php
        echo $form->textFieldGroup($model, 'cedula', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 8,
                    'onblur' => "buscarPersonaOficina($('#Oficina_nacionalidad').val(),$(this).val())"
        ))));
        ?>
    </div>
    <div class="col-md-4"  id="iconLoding" style="display: none">
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
    <div class="row-fluid">
        <div class='col-md-12'>
            <?php # echo $form->textFieldGroup($model,'observaciones',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','height'=>50,'maxlength'=>200)))); ?>
            <?php
            echo $form->textAreaGroup(
                    $model, 'observaciones', array(
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

</div>


<?php #$this->endWidget();  ?>
