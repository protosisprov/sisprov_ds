<?php
/* @var $this SalarioMinimoController */
/* @var $model SalarioMinimo */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_salario_minimo'); ?>
		<?php echo $form->textField($model,'id_salario_minimo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gaceta'); ?>
		<?php echo $form->textField($model,'gaceta'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'decreto'); ?>
		<?php echo $form->textField($model,'decreto'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_vigencia'); ?>
		<?php echo $form->textField($model,'fecha_vigencia'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'valor_salario'); ?>
		<?php echo $form->textField($model,'valor_salario'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'observacion'); ?>
		<?php echo $form->textField($model,'observacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_creacion'); ?>
		<?php echo $form->textField($model,'fecha_creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_actualizacion'); ?>
		<?php echo $form->textField($model,'fecha_actualizacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_id_creacion'); ?>
		<?php echo $form->textField($model,'usuario_id_creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_id_actualizacion'); ?>
		<?php echo $form->textField($model,'usuario_id_actualizacion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->