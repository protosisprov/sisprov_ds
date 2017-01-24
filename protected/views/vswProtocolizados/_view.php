<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_desarrollo')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_desarrollo),array('view','id'=>$data->id_desarrollo)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_desarrollo')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_desarrollo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_estado')); ?>:</b>
	<?php echo CHtml::encode($data->id_estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_estado')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_estado); ?>
	<br />


</div>