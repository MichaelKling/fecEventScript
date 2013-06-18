<?php
/* @var $this MissionSlotController */
/* @var $model MissionSlot */

$this->breadcrumbs=array(
	'Mission Slots'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MissionSlot', 'url'=>array('index')),
	array('label'=>'Create MissionSlot', 'url'=>array('create')),
	array('label'=>'View MissionSlot', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MissionSlot', 'url'=>array('admin')),
);
?>

<h1>Update MissionSlot <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>