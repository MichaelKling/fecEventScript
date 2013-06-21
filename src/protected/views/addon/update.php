<?php
/* @var $this AddonController */
/* @var $model Addon */

$this->breadcrumbs=array(
	'Addons'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Addon', 'url'=>array('create')),
	array('label'=>'Manage Addon', 'url'=>array('admin')),
);
?>

<h1>Update Addon <?php echo $model->id; ?> - <?php echo $model->shortname; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>