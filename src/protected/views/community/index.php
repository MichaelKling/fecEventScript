<?php
/* @var $this CommunityController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Communities',
);

$this->menu=array(
	array('label'=>'Create Community', 'url'=>array('create')),
	array('label'=>'Manage Community', 'url'=>array('admin')),
);
?>

<h1>Communities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
