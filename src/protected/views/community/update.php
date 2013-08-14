<?php
/* @var $this CommunityController */
/* @var $model Community */

$this->breadcrumbs=array(
	'Communities'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Community', 'url'=>array('index')),
	array('label'=>'Create Community', 'url'=>array('create')),
	array('label'=>'View Community', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Community', 'url'=>array('admin')),
);
?>

<h1>Update Community <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>