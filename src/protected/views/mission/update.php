<?php
/* @var $this MissionController */
/* @var $model Mission */

$this->breadcrumbs=array(
	'Missions'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Mission', 'url'=>array('create')),
	array('label'=>'View Mission', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Mission', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
?>

<h1>Update Mission <?php echo $model->id; ?></h1>

<div class="missionFormAccordion">
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Yii::t("model","Missionsdaten"); ?></h3>
    <div style="border:1px solid #E5F1F4;margin:5px;padding:5px;">
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Yii::t("model","Laden von Missionsdatei"); ?></h3>
    <div style="border:1px solid #E5F1F4;margin:5px;padding:5px;">
        <?php echo $this->renderPartial('_missionUpload', array('model'=>$missionUploadForm,'filehash' => $model->filehash, 'slots' => $model->slotcount)); ?>
    </div>
    <h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Yii::t("model","Editieren der Slots"); ?></h3>
    <div style="border:1px solid #E5F1F4;margin:5px;padding:5px;">
        <?php echo $this->renderPartial('_slotEdit', array('model'=>$missionSlotEditForm,'mission'=>$model)); ?>
    </div>
</div>

<script>
    $(function() {
        $( ".missionFormAccordion" ).accordion({
            autoHeight: false,
            collapsible: true,
            active: <?php echo ($model->hasErrors())?0:(($missionUploadForm->hasErrors())?1:(($missionSlotEditForm->hasErrors())?2:0)); ?>
        });
    });
</script>
