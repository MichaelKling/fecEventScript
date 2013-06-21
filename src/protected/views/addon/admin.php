<?php
/* @var $this AddonController */
/* @var $model Addon */

$this->breadcrumbs=array(
	'Addons'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Addon', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('addon-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Addons</h1>

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
	'id'=>'addon-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        'id',
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'type',
            'editable' => array(
                'type'     => 'select',
                'url'      => $this->createUrl('addon/updateAddon'),
                'source'   => $model->typeLabels(),
            ),
            'filter' => CHtml::activeDropDownList($model,'type', $model->typeLabels(), array('prompt' => Yii::t('model','Alle'))),
            'htmlOptions'=>array('width'=>'60px'),
        ),
        array(
            'name'=>'shortname',
            'value'=>'$data->shortname',
            'htmlOptions'=>array('width'=>'150px'),
        ),
        array(
            'class' => 'editable.EditableColumn',
            'name' => 'name',
            'editable' => array(
                'url'        => $this->createUrl('addon/updateAddon'),
                'placement'  => 'right',
            ),
            'htmlOptions'=>array('min-width'=>'200px'),
        ),

        array(
            'class' => 'editable.EditableColumn',
            'name' => 'link',
            'editable' => array(
                'url'        => $this->createUrl('addon/updateAddon'),
                'placement'  => 'right',
            ),
            'htmlOptions'=>array('min-width'=>'200px'),
        ),
        array(
            'name'=>'hash',
            'value'=>'$data->hash',
            'htmlOptions'=>array('width'=>'150px'),
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
                'controllerRoute' => 'addon/view',
                'actionParams' => array('id' => '$data->primaryKey'),
                'dialogTitle' => Yii::t('model',"Ansicht"),
                'dialogWidth' => 600,
                'dialogHeight' => 350,
                'closeButtonText' => Yii::t('model',"Schliessen"),
            ),
            'updateDialogEnabled' => true,
            'updateDialog'=>array(
                'controllerRoute' => 'addon/update',
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
