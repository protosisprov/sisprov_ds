<?php
/* @var $this RegistroDocumentoController */
/* @var $data RegistroDocumento */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_registro_documento')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_registro_documento), array('view', 'id'=>$data->id_registro_documento)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registro_publico_id')); ?>:</b>
	<?php echo CHtml::encode($data->registro_publico_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_registro')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_registro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tomo')); ?>:</b>
	<?php echo CHtml::encode($data->tomo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ano')); ?>:</b>
	<?php echo CHtml::encode($data->ano); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asiento_registral')); ?>:</b>
	<?php echo CHtml::encode($data->asiento_registral); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('folio_real')); ?>:</b>
	<?php echo CHtml::encode($data->folio_real); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('nro_protocolo')); ?>:</b>
	<?php echo CHtml::encode($data->nro_protocolo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nro_matricula')); ?>:</b>
	<?php echo CHtml::encode($data->nro_matricula); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estatus')); ?>:</b>
	<?php echo CHtml::encode($data->estatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_creacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_actualizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_id_creacion')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_id_creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_id_actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_id_actualizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nro_documento')); ?>:</b>
	<?php echo CHtml::encode($data->nro_documento); ?>
	<br />

	*/ ?>

</div>