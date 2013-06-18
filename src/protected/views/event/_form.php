<?php
/* @var $this EventController */
/* @var $model Event */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'eventType_id'); ?>
		<?php echo $form->textField($model,'eventType_id'); ?>
		<?php echo $form->error($model,'eventType_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'server_id'); ?>
		<?php echo $form->textField($model,'server_id'); ?>
		<?php echo $form->error($model,'server_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'duration'); ?>
		<?php echo $form->textField($model,'duration'); ?>
		<?php echo $form->error($model,'duration'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mission_id'); ?>
		<?php echo $form->textField($model,'mission_id'); ?>
		<?php echo $form->error($model,'mission_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'slotFreeRegistration'); ?>
		<?php echo $form->textField($model,'slotFreeRegistration'); ?>
		<?php echo $form->error($model,'slotFreeRegistration'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->