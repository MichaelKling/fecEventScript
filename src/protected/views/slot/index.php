<?php
/* @var $this SlotController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Slots',
);

$this->menu=array(
	array('label'=>'Create Slot', 'url'=>array('create')),
	array('label'=>'Manage Slot', 'url'=>array('admin')),
);
?>

<h1>Slots</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
