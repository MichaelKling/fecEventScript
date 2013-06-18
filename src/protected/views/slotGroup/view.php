<?php
/* @var $this SlotGroupController */
/* @var $model SlotGroup */

$this->breadcrumbs=array(
	'Slot Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SlotGroup', 'url'=>array('index')),
	array('label'=>'Create SlotGroup', 'url'=>array('create')),
	array('label'=>'Update SlotGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SlotGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SlotGroup', 'url'=>array('admin')),
);
?>

<h1>View SlotGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'event_id',
	),
)); ?>
