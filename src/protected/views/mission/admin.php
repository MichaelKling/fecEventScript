<?php
/* @var $this MissionController */
/* @var $model Mission */

$this->breadcrumbs=array(
	'Missions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Mission', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('mission-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Missions</h1>

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
	'id'=>'mission-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name' => 'id',
            'htmlOptions'=>array('width'=>'25px'),
        ),
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'name',
            'editable' => array(
                'url'        => $this->createUrl('mission/updateMission'),
                'placement'  => 'right',
            ),
        ),
		'filehash',
		'filename',
        array(
            'name' => 'slotcount',
            'header'=> $model->getAttributeLabel('slotcount'),
            'value' => '$data->slotcount',
            'filter' => "",
        ),
        array(
            'class'=>'EJuiDlgsColumn',
            'buttons'=>array(
                'view' => array(
                    'label'=> Yii::t('model',"Anzeigen"),
                ),
                'update' => array(
                    'label'=> Yii::t('model',"Bearbeiten"),
                ),
            ),
            'viewDialogEnabled' => true,
            'viewDialog'=>array(
                'controllerRoute' => 'mission/view',
                'actionParams' => array('id' => '$data->primaryKey'),
                'dialogTitle' => Yii::t('model',"Ansicht"),
                'dialogWidth' => 600,
                'dialogHeight' => 500,
                'closeButtonText' => Yii::t('model',"Schliessen"),
            ),
            'updateDialogEnabled' => true,
            'updateDialog'=>array(
                'controllerRoute' => 'mission/update',
                'actionParams' => array('id' => '$data->primaryKey'),
                'dialogTitle' => Yii::t('model',"Bearbeiten"),
                'dialogWidth' => 600,
                'dialogHeight' => 600,
                'closeButtonText' => Yii::t('model',"Abbruch"),
                'iframeHtmlOptions' => array('style' => "min-height:100%;background-color:#FFFFFF;")
            ),
        ),
	),
)); ?>
<?php EQuickDlgs::iframeButton(
    array(
        'controllerRoute' => 'create',
        'dialogTitle' => Yii::t('model','Erstelle neue Mission'),
        'dialogWidth' => 600,
        'dialogHeight' => 300,
        'openButtonText' => Yii::t('model','Erstelle neue Mission'),
        'closeButtonText' => Yii::t('model','Abbruch'),
        'closeOnAction' => true, //important to invoke the close action in the actionCreate
        'refreshGridId' => 'mission-grid', //the grid with this id will be refreshed after closing
        'iframeHtmlOptions' => array('style' => "min-height:100%;background-color:#FFFFFF;")
    )
); ?>
