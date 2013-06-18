<?php
/* @var $this EventController */
/* @var $data Event */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eventType_id')); ?>:</b>
	<?php echo CHtml::encode($data->eventType_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('server_id')); ?>:</b>
	<?php echo CHtml::encode($data->server_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('duration')); ?>:</b>
	<?php echo CHtml::encode($data->duration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('mission_id')); ?>:</b>
	<?php echo CHtml::encode($data->mission_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slotFreeRegistration')); ?>:</b>
	<?php echo CHtml::encode($data->slotFreeRegistration); ?>
	<br />

	*/ ?>

</div>