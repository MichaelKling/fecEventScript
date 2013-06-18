<?php
/* @var $this ServerInfoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Server Infos',
);

$this->menu=array(
	array('label'=>'Create ServerInfo', 'url'=>array('create')),
	array('label'=>'Manage ServerInfo', 'url'=>array('admin')),
);
?>

<h1>Server Infos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
