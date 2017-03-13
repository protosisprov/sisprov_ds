<?php
/* @var $this FuenteFinanciamientoObraController */
/* @var $data FuenteFinanciamientoObra */
?>


<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_fuente_financiamiento_obra')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_fuente_financiamiento_obra), array('view', 'id'=>$data->id_fuente_financiamiento_obra)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_fuente_financiamiento_obra')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_fuente_financiamiento_obra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_creacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_actualizacion); ?>
	<br />


</div>