<?php
/* @var $this MissionSlotGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mission Slot Groups',
);

$this->menu=array(
	array('label'=>'Create MissionSlotGroup', 'url'=>array('create')),
	array('label'=>'Manage MissionSlotGroup', 'url'=>array('admin')),
);
?>

<h1>Mission Slot Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
