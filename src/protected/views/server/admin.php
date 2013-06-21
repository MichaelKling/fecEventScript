<?php
/* @var $this ServerController */
/* @var $model Server */

$this->breadcrumbs=array(
	'Servers'=>array('index'),
	'Manage',
);

$this->menu=array(
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

<?php  $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'server-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
        array(
            'name' => 'id',
            'value' => 'CHtml::link($data->id,array("server/view", "id" => $data->id))',
            'type' => 'raw',
            'htmlOptions'=>array('width'=>'40px'),
        ),
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
            'filter' => CHtml::activeDropDownList($model,'type', $model->typeLabels(), array('prompt' => Yii::t('model','Alle'))),
        ),
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'country',
            'editable' => array(
                'type'     => 'select',
                'url'      => $this->createUrl('server/updateServer'),
                'source'   => Countries::getCountries(),
            ),
            'filter' => CHtml::activeDropDownList($model,'country', Countries::getCountries(), array('prompt' => Yii::t('model','Alle'))),
            'htmlOptions'=>array('width'=>'60px'),
        ),
        array(
            'name' => 'mission_id',
            'value' => '($data->mission)?CHtml::link($data->mission->name,array("mission/view", "id" => $data->mission->id)):null',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($model,'mission_id', CHtml::listData(Mission::model()->findAll(),'id', 'name'), array('prompt' => Yii::t('model','Alle')))
        ),
		'hostname',
		'maxPlayer',
        array(
            'name' => 'passwordProtected',
            'value' => '($data->passwordProtected == null)?null:(($data->passwordProtected)?Yii::t("model","Ja"):Yii::t("model","Nein"))',
            'filter' => CHtml::activeDropDownList($model,'passwordProtected', array(true => Yii::t("model","Ja"), false => Yii::t("model","Nein")), array('prompt' => Yii::t('model','Alle'))),
        ),
        array(
            'name' => 'lastServerInfo.date',
            'header'=> $model->getAttributeLabel('lastUpdate'),
            'value' => 'CHtml::link((!empty($data->lastServerInfo))?$data->lastServerInfo[0]->date:Yii::t("model","Jetzt Updaten"),array("query", "id" => $data->id))',
            'filter' => null,
            'type' => 'raw',
        ),
        array(
            'name' => 'lastServerInfo.playercount',
            'header'=> $model->getAttributeLabel('playercount'),
            'value' => '(!empty($data->lastServerInfo) && $data->lastServerInfo[0]->playercount)?$data->lastServerInfo[0]->playercount:null',
            'filter' => null,
        ),
		array(
            'class'=>'EJuiDlgsColumn',
            'template' => '{view} {statistic} {update} {delete}',
            'htmlOptions'=>array('width'=>'80px'),
            'buttons'=>array(
                'statistic' => array(
                    'label'=>'Statistic', // text label of the button
                    'url'=>"CHtml::normalizeUrl(array('statistic', 'id'=>\$data->id))",
                    'imageUrl'=>Yii::app()->baseUrl.'/images/chart.png',  // image URL of the button. If not set or false, a text link is used
                    'options' => array('class'=>'statistic'), // HTML options for the button
                ),
            ),
            'viewDialogEnabled' => false,
            'updateDialogEnabled' => true,
            'updateDialog'=>array(
                'controllerRoute' => 'server/update',
                'actionParams' => array('id' => '$data->primaryKey'),
                'dialogTitle' => Yii::t('model',"Bearbeiten"),
                'dialogWidth' => 600,
                'dialogHeight' => 500,
                'closeButtonText' => Yii::t('model',"Abbruch"),
                'iframeHtmlOptions' => array('style' => "min-height:100%;background-color:#FFFFFF;")
            ),
		),
	),
)); ?>
