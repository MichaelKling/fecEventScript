<?php
/* @var $this AddonController */
/* @var $model Addon */

$this->breadcrumbs=array(
	'Addons'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Addon', 'url'=>array('index')),
	array('label'=>'Create Addon', 'url'=>array('create')),
	array('label'=>'View Addon', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Addon', 'url'=>array('admin')),
);
?>

<h1>Update Addon <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>