<?php
/* @var $this SlotGroupController */
/* @var $model SlotGroup */

$this->breadcrumbs=array(
	'Slot Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SlotGroup', 'url'=>array('index')),
	array('label'=>'Create SlotGroup', 'url'=>array('create')),
	array('label'=>'View SlotGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SlotGroup', 'url'=>array('admin')),
);
?>

<h1>Update SlotGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>