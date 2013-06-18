<?php
/* @var $this SlotController */
/* @var $model Slot */

$this->breadcrumbs=array(
	'Slots'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Slot', 'url'=>array('index')),
	array('label'=>'Manage Slot', 'url'=>array('admin')),
);
?>

<h1>Create Slot</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>