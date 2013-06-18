<?php
/* @var $this AddonController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Addons',
);

$this->menu=array(
	array('label'=>'Create Addon', 'url'=>array('create')),
	array('label'=>'Manage Addon', 'url'=>array('admin')),
);
?>

<h1>Addons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
