<?php
/* @var $this SlotController */
/* @var $model Slot */

$this->breadcrumbs=array(
	'Slots'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Slot', 'url'=>array('index')),
	array('label'=>'Create Slot', 'url'=>array('create')),
	array('label'=>'Update Slot', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Slot', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Slot', 'url'=>array('admin')),
);
?>

<h1>View Slot #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'slotGroup_id',
	),
)); ?>
