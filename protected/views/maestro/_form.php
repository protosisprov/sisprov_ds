<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'maestro-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'descripcion',array('widgetOptions'=>array('htmlOptions'=>array('style'=>'text-transform: uppercase;','class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'padre',array('widgetOptions'=>array('htmlOptions'=>array('readonly'=>'true','class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'hijo',array('widgetOptions'=>array('htmlOptions'=>array('readonly'=>'true','class'=>'span5')))); ?>

	<?php echo $form->checkBoxGroup($model,'es_activo'); ?>


<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'icon' => 'glyphicon glyphicon-save',
			'context'=>'primary',
			'size' => 'large',
			'label'=>$model->isNewRecord ? 'Guardar' : 'Actualizar',
		)); ?>

		<?php
		$this->widget('booster.widgets.TbButton', array(
				//'type'=>'primary',
				'label' => 'Regresar',
				'icon' => 'glyphicon glyphicon-chevron-left',
				'size' => 'large',
				'context' => 'danger',
				'buttonType' => 'link',
				'url' => CHtml::normalizeUrl(array('admin')),
		));
		?>
</div>

<?php $this->endWidget(); ?>
