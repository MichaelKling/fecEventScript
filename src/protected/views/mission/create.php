<?php
/* @var $this MissionController */
/* @var $model Mission */

$this->breadcrumbs=array(
	'Missions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Mission', 'url'=>array('index')),
	array('label'=>'Manage Mission', 'url'=>array('admin')),
);
?>

<h1>Create Mission</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>