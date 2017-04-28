<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'empadronador-censo-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => true,
    ),
        ));
?>
<h1 class="text-center">Re-Asignación Empadronador</h1>
<br>

<div class="row">
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model, 'nombre_desarrollo', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100, 'readonly' => true,)))); ?>
    </div>
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model, 'nombre_unidad_multifamiliar', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100, 'readonly' => true,)))); ?>
    </div>
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model, 'nombre_adjudicado', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 100, 'readonly' => true,)))); ?>
    </div>
</div>
    
<div class="row">
    
    <div class="col-md-4">
        <label><?php echo CHtml::activeLabel($model, 'empadronador_usuario_id'); ?></label>
        <?php
        $n = CrugeStoredUser::model()->findall();
        echo '<select class="form-control" id="EmpadronadorCenso_empadronador_usuario_id" name="EmpadronadorCenso[empadronador_usuario_id]"  placeholder="Empadronador">';
        echo '<option value="'.$model->iduser.'">'.$model->Emp.'</option>';
        foreach ($n as $result):
            if ($result->iduser != 1 && $result->iduser != 2) {
                echo '<option value="' . $result->iduser . '">' . $result->username . '</option>';
            }
        endforeach;
        echo '</select>';
        ?>
    </div>
   
</div>
<br>
<div class="form-actions">


    
  <div class="well">
    <div class="pull-center" style="text-align: right;">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'glyphicon glyphicon-floppy-saved',
            'size' => 'large',
            'id' => 'guardarAsignacion',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Actualizar' : 'Actualizar',
            
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'context' => 'danger',
            'label' => 'Cancelar',
            'size' => 'large',
            'id' => 'CancelarForm',
            'icon' => 'ban-circle',
            'htmlOptions' => array(
              'onclick' => 'document.location.href ="javascript:window.history.back();"'
            )
        ));
        ?>
    </div>
</div>
    
    
    
    
<?php $this->endWidget(); ?>


