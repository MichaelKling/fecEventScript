<?php
/* @var $this AddonController */
/* @var $model Addon */

$this->breadcrumbs=array(
	'Addons'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Addon', 'url'=>array('index')),
	array('label'=>'Create Addon', 'url'=>array('create')),
	array('label'=>'Update Addon', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Addon', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Addon', 'url'=>array('admin')),
);
?>

<h1>View Addon #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        'shortname',
		'name',
        array(
            'name' => 'link',
            'value' => ($model->link)?CHtml::link($model->link,$model->link):null,
            'type' => 'raw',
        ),
		'hash',
        array(
            'name' => 'type',
            'value' => $model->getTypeLabel($model->type),
        ),
	),
)); ?>
