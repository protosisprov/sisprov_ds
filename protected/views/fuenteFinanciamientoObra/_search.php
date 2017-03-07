<?php
/* @var $this FuenteFinanciamientoObraController */
/* @var $model FuenteFinanciamientoObra */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_fuente_financiamiento_obra'); ?>
		<?php echo $form->textField($model,'id_fuente_financiamiento_obra'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre_fuente_financiamiento_obra'); ?>
		<?php echo $form->textField($model,'nombre_fuente_financiamiento_obra',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_creacion'); ?>
		<?php echo $form->textField($model,'fecha_creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_actualizacion'); ?>
		<?php echo $form->textField($model,'fecha_actualizacion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->