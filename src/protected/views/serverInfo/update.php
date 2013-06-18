<?php
/* @var $this ServerInfoController */
/* @var $model ServerInfo */

$this->breadcrumbs=array(
	'Server Infos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServerInfo', 'url'=>array('index')),
	array('label'=>'Create ServerInfo', 'url'=>array('create')),
	array('label'=>'View ServerInfo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ServerInfo', 'url'=>array('admin')),
);
?>

<h1>Update ServerInfo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>