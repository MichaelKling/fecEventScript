<?php
/* @var $this ServerInfoController */
/* @var $model ServerInfo */

$this->breadcrumbs=array(
	'Server Infos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ServerInfo', 'url'=>array('index')),
	array('label'=>'Manage ServerInfo', 'url'=>array('admin')),
);
?>

<h1>Create ServerInfo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>