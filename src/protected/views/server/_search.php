<?php
/* @var $this ServerController */
/* @var $model Server */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ip'); ?>
		<?php echo $form->textField($model,'ip',array('size'=>45,'maxlength'=>45)); ?>
	</div>


    <div class="row">
        <?php echo $form->label($model,'port'); ?>
        <?php echo $form->textField($model,'port',array('size'=>45,'maxlength'=>45)); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model,'type',$model->typeLabels(),array('prompt' => Yii::t('model','Alle'))); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'country'); ?>
        <?php echo $form->dropDownList($model,'country',Countries::getCountries(),array('prompt' => Yii::t('model','Alle'))); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'mission_id'); ?>
        <?php echo $form->dropDownList($model,'mission_id',CHtml::listData(Mission::model()->findAll(),'id', 'name'),array('prompt' => Yii::t('model','Alle'))); ?>
    </div>

	<div class="row">
		<?php echo $form->label($model,'hostname'); ?>
		<?php echo $form->textField($model,'hostname',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'maxPlayer'); ?>
		<?php echo $form->textField($model,'maxPlayer'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('model','Suche')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->