<?php
/* @var $this MissionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Missions',
);

$this->menu=array(
	array('label'=>'Create Mission', 'url'=>array('create')),
	array('label'=>'Manage Mission', 'url'=>array('admin')),
);
?>

<h1>Missions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
