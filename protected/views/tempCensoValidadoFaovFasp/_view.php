<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_temp_censo_validado_faov_fasp')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_temp_censo_validado_faov_fasp),array('view','id'=>$data->id_temp_censo_validado_faov_fasp)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_beneficiario')); ?>:</b>
	<?php echo CHtml::encode($data->id_beneficiario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_beneficiario_temporal')); ?>:</b>
	<?php echo CHtml::encode($data->id_beneficiario_temporal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cedula')); ?>:</b>
	<?php echo CHtml::encode($data->cedula); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_completo')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_completo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cod_estado')); ?>:</b>
	<?php echo CHtml::encode($data->cod_estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_desarrollo')); ?>:</b>
	<?php echo CHtml::encode($data->id_desarrollo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_desarrollo')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_desarrollo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_fuente_financiamiento')); ?>:</b>
	<?php echo CHtml::encode($data->id_fuente_financiamiento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_fuente_financiamiento')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_fuente_financiamiento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iduser')); ?>:</b>
	<?php echo CHtml::encode($data->iduser); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empadronador_usuario')); ?>:</b>
	<?php echo CHtml::encode($data->empadronador_usuario); ?>
	<br />

	*/ ?>

</div>