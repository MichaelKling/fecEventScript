<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michael
 * Date: 25.07.13
 * Time: 13:52
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="form">

<b><?php echo Yii::t("model","Slots aus Missionsdatei einlesen:") ?></b>

<?php $form=$this->beginWidget('CActiveForm', array(
                                                   'id'=>'missionUploadForm-form',
                                                   'enableAjaxValidation'=>false,
                                                   'htmlOptions' => array('enctype' => 'multipart/form-data'),
                                              )); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>
<?php if ($slots): ?>
<div class="errorSummary">
    <p><?php echo Yii::t("model","ACHTUNG: Dies überschreibt alle vorherigen Sloteinträge!"); ?></p>
</div>
<?php endif; ?>

<div class="row">
    <?php echo $form->labelEx($model,'algorithm'); ?>
    <?php echo $form->dropDownList($model,'algorithm',$model->algorithmLabels()); ?>
    <?php echo $form->error($model,'algorithm'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'missionFile'); ?>
    <?php echo $form->fileField($model,'missionFile',array('size'=>60,'maxlength'=>255)); ?>
    <?php echo $form->error($model,'missionFile'); ?>
    <?php echo CHtml::submitButton(($filehash)?Yii::t('model','Neue Missionsdatei einlesen'):Yii::t('model','Missionsdatei einlesen')); ?>
</div>


<?php $this->endWidget(); ?>

</div>