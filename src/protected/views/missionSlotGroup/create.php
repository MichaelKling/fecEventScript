<?php
/* @var $this MissionSlotGroupController */
/* @var $model MissionSlotGroup */

$this->breadcrumbs=array(
	'Mission Slot Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MissionSlotGroup', 'url'=>array('index')),
	array('label'=>'Manage MissionSlotGroup', 'url'=>array('admin')),
);
?>

<h1>Create MissionSlotGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>