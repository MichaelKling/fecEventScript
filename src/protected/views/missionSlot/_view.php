<?php
/* @var $this MissionSlotController */
/* @var $data MissionSlot */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('missionSlotGroup_id')); ?>:</b>
	<?php echo CHtml::encode($data->missionSlotGroup_id); ?>
	<br />


</div>