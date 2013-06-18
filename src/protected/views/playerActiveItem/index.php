<?php
/* @var $this PlayerActiveItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Player Active Items',
);

$this->menu=array(
	array('label'=>'Create PlayerActiveItem', 'url'=>array('create')),
	array('label'=>'Manage PlayerActiveItem', 'url'=>array('admin')),
);
?>

<h1>Player Active Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
