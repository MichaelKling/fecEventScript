<?php
/* @var $this MissionSlotController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mission Slots',
);

$this->menu=array(
	array('label'=>'Create MissionSlot', 'url'=>array('create')),
	array('label'=>'Manage MissionSlot', 'url'=>array('admin')),
);
?>

<h1>Mission Slots</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
