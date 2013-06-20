<?php
/* @var $this ServerInfoController */
/* @var $data ServerInfo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('timeframe')); ?>:</b>
    <?php echo CHtml::encode(round($data->timeframe/60,2)).Yii::t('model',' Minuten'); ?>
    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('server_id')); ?>:</b>
	<?php echo CHtml::encode($data->server_id); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('playercount')); ?>:</b>
    <?php echo CHtml::encode($data->playercount); ?>
    <br />


</div>