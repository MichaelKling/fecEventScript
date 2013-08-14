<?php
/* @var $this CommunityController */
/* @var $model Community */

$this->breadcrumbs=array(
	'Communities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Community', 'url'=>array('index')),
	array('label'=>'Manage Community', 'url'=>array('admin')),
);
?>

<h1>Create Community</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>