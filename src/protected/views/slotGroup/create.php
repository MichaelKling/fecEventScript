<?php
/* @var $this SlotGroupController */
/* @var $model SlotGroup */

$this->breadcrumbs=array(
	'Slot Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SlotGroup', 'url'=>array('index')),
	array('label'=>'Manage SlotGroup', 'url'=>array('admin')),
);
?>

<h1>Create SlotGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>