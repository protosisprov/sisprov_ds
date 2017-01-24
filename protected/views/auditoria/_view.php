<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_auditoria')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_auditoria),array('view','id'=>$data->id_auditoria)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tabla')); ?>:</b>
	<?php echo CHtml::encode($data->tabla); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_bd')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_bd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accion')); ?>:</b>
	<?php echo CHtml::encode($data->accion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valores_viejos')); ?>:</b>
	<?php echo CHtml::encode($data->valores_viejos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valores_nuevos')); ?>:</b>
	<?php echo CHtml::encode($data->valores_nuevos); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_cols')); ?>:</b>
	<?php echo CHtml::encode($data->updated_cols); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('query')); ?>:</b>
	<?php echo CHtml::encode($data->query); ?>
	<br />

	*/ ?>

</div>