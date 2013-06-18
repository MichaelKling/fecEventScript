<?php
/* @var $this ServerInfoController */
/* @var $model ServerInfo */

$this->breadcrumbs=array(
	'Server Infos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ServerInfo', 'url'=>array('index')),
	array('label'=>'Create ServerInfo', 'url'=>array('create')),
	array('label'=>'Update ServerInfo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ServerInfo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ServerInfo', 'url'=>array('admin')),
);
?>

<h1>View ServerInfo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'server_id',
	),
)); ?>
