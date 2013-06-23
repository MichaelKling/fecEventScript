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
?>

<h1>Update Mission <?php echo $model->id; ?></h1>

<div style="border:1px solid #E5F1F4;margin:5px;padding:5px;">

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>

    <br /><h2><?php echo Yii::t("model","oder:") ?></h2>

<div class="form" style="border:1px solid #E5F1F4;margin:5px;padding:5px;">

    <b><?php echo Yii::t("model","Slots aus Missionsdatei einlesen:") ?></b>

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'missionUploadForm-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($missionUploadForm); ?>


    <div class="row">
        <?php echo $form->labelEx($missionUploadForm,'algorithm'); ?>
        <?php echo $form->dropDownList($missionUploadForm,'algorithm',$missionUploadForm->algorithmLabels()); ?>
        <?php echo $form->error($missionUploadForm,'algorithm'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($missionUploadForm,'missionFile'); ?>
        <?php echo $form->fileField($missionUploadForm,'missionFile',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($missionUploadForm,'missionFile'); ?>
        <?php echo CHtml::submitButton(($model->filehash)?Yii::t('model','Neue Missionsdatei einlesen'):Yii::t('model','Missionsdatei einlesen')); ?>
    </div>


    <?php $this->endWidget(); ?>

</div>