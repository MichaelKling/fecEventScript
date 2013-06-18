<?php
/* @var $this MissionSlotGroupController */
/* @var $model MissionSlotGroup */

$this->breadcrumbs=array(
	'Mission Slot Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MissionSlotGroup', 'url'=>array('index')),
	array('label'=>'Create MissionSlotGroup', 'url'=>array('create')),
	array('label'=>'View MissionSlotGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MissionSlotGroup', 'url'=>array('admin')),
);
?>

<h1>Update MissionSlotGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>