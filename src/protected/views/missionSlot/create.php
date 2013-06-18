<?php
/* @var $this MissionSlotController */
/* @var $model MissionSlot */

$this->breadcrumbs=array(
	'Mission Slots'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MissionSlot', 'url'=>array('index')),
	array('label'=>'Manage MissionSlot', 'url'=>array('admin')),
);
?>

<h1>Create MissionSlot</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>