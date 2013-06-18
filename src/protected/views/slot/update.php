<?php
/* @var $this SlotController */
/* @var $model Slot */

$this->breadcrumbs=array(
	'Slots'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Slot', 'url'=>array('index')),
	array('label'=>'Create Slot', 'url'=>array('create')),
	array('label'=>'View Slot', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Slot', 'url'=>array('admin')),
);
?>

<h1>Update Slot <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>