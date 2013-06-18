<?php
/* @var $this PlayerActiveItemController */
/* @var $model PlayerActiveItem */

$this->breadcrumbs=array(
	'Player Active Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PlayerActiveItem', 'url'=>array('index')),
	array('label'=>'Manage PlayerActiveItem', 'url'=>array('admin')),
);
?>

<h1>Create PlayerActiveItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>