<?php
/* @var $this MissionSlotController */
/* @var $model MissionSlot */

$this->breadcrumbs=array(
	'Mission Slots'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List MissionSlot', 'url'=>array('index')),
	array('label'=>'Create MissionSlot', 'url'=>array('create')),
	array('label'=>'Update MissionSlot', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MissionSlot', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MissionSlot', 'url'=>array('admin')),
);
?>

<h1>View MissionSlot #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'missionSlotGroup_id',
	),
)); ?>
