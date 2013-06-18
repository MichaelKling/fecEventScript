<?php
/* @var $this MissionSlotGroupController */
/* @var $model MissionSlotGroup */

$this->breadcrumbs=array(
	'Mission Slot Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List MissionSlotGroup', 'url'=>array('index')),
	array('label'=>'Create MissionSlotGroup', 'url'=>array('create')),
	array('label'=>'Update MissionSlotGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MissionSlotGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MissionSlotGroup', 'url'=>array('admin')),
);
?>

<h1>View MissionSlotGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'mission_id',
	),
)); ?>
