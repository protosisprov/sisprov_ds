<?php
/* @var $this RegistroDocumentoController */
/* @var $model RegistroDocumento */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_registro_documento'); ?>
		<?php echo $form->textField($model,'id_registro_documento'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'registro_publico_id'); ?>
		<?php echo $form->textField($model,'registro_publico_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_registro'); ?>
		<?php echo $form->textField($model,'fecha_registro'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tomo'); ?>
		<?php echo $form->textField($model,'tomo',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ano'); ?>
		<?php echo $form->textField($model,'ano'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'asiento_registral'); ?>
		<?php echo $form->textField($model,'asiento_registral'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'folio_real'); ?>
		<?php echo $form->textField($model,'folio_real'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nro_protocolo'); ?>
		<?php echo $form->textField($model,'nro_protocolo',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nro_matricula'); ?>
		<?php echo $form->textField($model,'nro_matricula',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estatus'); ?>
		<?php echo $form->textField($model,'estatus'); ?>
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

	<div class="row">
		<?php echo $form->label($model,'nro_documento'); ?>
		<?php echo $form->textField($model,'nro_documento',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->