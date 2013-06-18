<?php
/* @var $this SlotGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Slot Groups',
);

$this->menu=array(
	array('label'=>'Create SlotGroup', 'url'=>array('create')),
	array('label'=>'Manage SlotGroup', 'url'=>array('admin')),
);
?>

<h1>Slot Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
