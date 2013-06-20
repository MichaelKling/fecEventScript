<?php
/* @var $this ServerController */
/* @var $model Server */

$this->breadcrumbs=array(
	'Servers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Create Server', 'url'=>array('create')),
	array('label'=>'Update Server', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Query Server', 'url'=>array('query', 'id'=>$model->id)),
	array('label'=>'Delete Server', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Server', 'url'=>array('admin')),
);
?>

<h1>View Server #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'ip',
        'port',
        array(
            'name' => 'type',
            'value' => $model->getTypeLabel($model->type),
        ),
        array(
            'name' => 'country',
            'value' => ($model->country)?Countries::getCountry($model->country):null,
        ),
        array(
            'name' => 'mission_id',
            'value' => ($model->mission)?CHtml::link($model->mission->name,array("mission/view", "id" => $model->mission->id)):null,
            'type' => 'raw',
        ),
		'hostname',
		'maxPlayer',
        array(
            'name' => 'passwordProtected',
            'value' => ($model->passwordProtected == null)?null:(($model->passwordProtected)?Yii::t("model","Ja"):Yii::t("model","Nein")),
        ),
        array(
            'name' => 'lastServerInfo.date',
            'header'=> $model->getAttributeLabel('lastUpdate'),
            'value' => (!empty($model->lastServerInfo))?$model->lastServerInfo[0]->date:null,
        ),
        array(
            'name' => 'lastServerInfo.playercount',
            'header'=> $model->getAttributeLabel('playercount'),
            'value' => (!empty($model->lastServerInfo) && $model->lastServerInfo[0]->playercount)?$model->lastServerInfo[0]->playercount:null,
        ),
	),
)); ?>
<br />
<h2>Addons</h2>
<?php foreach($model->addons as $addon) : ?>
<br />
<h3><?php echo $addon->shortname; ?></h3>
<?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$addon,
        'attributes'=>array(
            'id',
            array(
                'name' => 'name',
                'value' => CHtml::link($addon->name,array("addon/view", "id" => $addon->id)),
                'type' => 'raw',
            ),
            array(
                'name' => 'link',
                'value' => CHtml::link($addon->link,$addon->link),
                'type' => 'raw',
            ),
            'hash',
            'shortname',
            array(
                'name' => 'type',
                'value' => $addon->getTypeLabel($addon->type),
            ),
        ),
    )); ?>
<?php endforeach; ?>
