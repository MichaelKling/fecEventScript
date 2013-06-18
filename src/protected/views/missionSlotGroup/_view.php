<?php
/* @var $this MissionSlotGroupController */
/* @var $data MissionSlotGroup */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mission_id')); ?>:</b>
	<?php echo CHtml::encode($data->mission_id); ?>
	<br />


</div>