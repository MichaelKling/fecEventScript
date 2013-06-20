<?php
/* @var $this ServerController */
/* @var $data Server */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip')); ?>:</b>
	<?php echo CHtml::encode($data->ip); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('port')); ?>:</b>
    <?php echo CHtml::encode($data->port); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
    <?php echo CHtml::encode($data->getTypeLabel($data->type)); ?>
    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mission_id')); ?>:</b>
	<?php echo CHtml::encode(($data->mission)?$data->mission->name:null); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hostname')); ?>:</b>
	<?php echo CHtml::encode($data->hostname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('maxPlayer')); ?>:</b>
	<?php echo CHtml::encode($data->maxPlayer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passwordProtected')); ?>:</b>
	<?php echo CHtml::encode(($data->passwordProtected == null)?null:(($data->passwordProtected)?Yii::t("model","Ja"):Yii::t("model","Nein"))); ?>
	<br />


</div>