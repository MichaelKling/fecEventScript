<?php
/* @var $this ServerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Servers',
);

$this->menu=array(
	array('label'=>'Create Server', 'url'=>array('create')),
	array('label'=>'Manage Server', 'url'=>array('admin')),
    array('label'=>'Query All Server', 'url'=>array('queryAll')),
);
?>

<h1>Servers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
