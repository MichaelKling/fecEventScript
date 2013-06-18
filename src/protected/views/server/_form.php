<?php
/* @var $this ServerController */
/* @var $model Server */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'server-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip'); ?>
		<?php echo $form->textField($model,'ip',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'ip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mission_id'); ?>
		<?php echo $form->textField($model,'mission_id'); ?>
		<?php echo $form->error($model,'mission_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hostname'); ?>
		<?php echo $form->textField($model,'hostname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'hostname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'maxPlayer'); ?>
		<?php echo $form->textField($model,'maxPlayer'); ?>
		<?php echo $form->error($model,'maxPlayer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passwordProtected'); ?>
		<?php echo $form->textField($model,'passwordProtected'); ?>
		<?php echo $form->error($model,'passwordProtected'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->