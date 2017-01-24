

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_salario_minimo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_salario_minimo), array('view', 'id'=>$data->id_salario_minimo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gaceta')); ?>:</b>
	<?php echo CHtml::encode($data->gaceta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('decreto')); ?>:</b>
	<?php echo CHtml::encode($data->decreto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_vigencia')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_vigencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valor_salario')); ?>:</b>
	<?php echo CHtml::encode($data->valor_salario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observacion')); ?>:</b>
	<?php echo CHtml::encode($data->observacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_creacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_creacion); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_actualizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_id_creacion')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_id_creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_id_actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_id_actualizacion); ?>
	<br />

	*/ ?>

</div>