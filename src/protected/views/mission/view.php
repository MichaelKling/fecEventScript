<?php
/* @var $this MissionController */
/* @var $model Mission */

$this->breadcrumbs=array(
	'Missions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Create Mission', 'url'=>array('create')),
	array('label'=>'Update Mission', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Mission', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Mission', 'url'=>array('admin')),
);
?>

<h1>View Mission #<?php echo $model->id; ?></h1>

<?php
foreach(Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'filehash',
		'filename',
	),
)); ?>


