<?php
/* @var $this ServerController */
/* @var $model Server */

$this->breadcrumbs=array(
	'Servers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Server', 'url'=>array('index')),
	array('label'=>'Create Server', 'url'=>array('create')),
    array('label'=>'Query All Server', 'url'=>array('queryAll')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('server-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Servers</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'server-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
        array(
            'name' => 'name',
            'value' => 'CHtml::link($data->name,array("server/view", "id" => $data->id))',
            'type' => 'raw',
        ),
		'ip',
        'port',
        array(
            'name' => 'type',
            'value' => '$data->getTypeLabel($data->type)',
            'filter' => CHtml::activeDropDownList($model,'type', $model->typeLabels(), array('prompt' => 'All')),
        ),
        array(
            'name' => 'mission_id',
            'value' => '($data->mission)?CHtml::link($data->mission->name,array("mission/view", "id" => $data->mission->id)):null',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($model,'mission_id', CHtml::listData(Mission::model()->findAll(),'id', 'name'), array('prompt' => 'All'))
        ),
		'hostname',
		'maxPlayer',
        array(
            'name' => 'passwordProtected',
            'value' => '($data->passwordProtected == null)?null:(($data->passwordProtected)?Yii::t("model","Ja"):Yii::t("model","Nein"))',
            'filter' => CHtml::activeDropDownList($model,'passwordProtected', array(true => Yii::t("model","Ja"), false => Yii::t("model","Nein")), array('prompt' => 'All')),
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
