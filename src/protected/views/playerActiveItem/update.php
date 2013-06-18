<?php
/* @var $this PlayerActiveItemController */
/* @var $model PlayerActiveItem */

$this->breadcrumbs=array(
	'Player Active Items'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PlayerActiveItem', 'url'=>array('index')),
	array('label'=>'Create PlayerActiveItem', 'url'=>array('create')),
	array('label'=>'View PlayerActiveItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PlayerActiveItem', 'url'=>array('admin')),
);
?>

<h1>Update PlayerActiveItem <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>