<?php
/* @var $this AddonController */
/* @var $model Addon */

$this->breadcrumbs=array(
	'Addons'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Addon', 'url'=>array('index')),
	array('label'=>'Manage Addon', 'url'=>array('admin')),
);
?>

<h1>Create Addon</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>