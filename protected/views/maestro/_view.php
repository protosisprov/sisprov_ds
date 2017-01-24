<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_maestro')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_maestro),array('view','id'=>$data->id_maestro)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('padre')); ?>:</b>
	<?php echo CHtml::encode($data->padre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hijo')); ?>:</b>
	<?php echo CHtml::encode($data->hijo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('es_activo')); ?>:</b>
	<?php echo CHtml::encode($data->es_activo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_creacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_actualizacion); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_id_creacion')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_id_creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_id_actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_id_actualizacion); ?>
	<br />

	*/ ?>

</div>