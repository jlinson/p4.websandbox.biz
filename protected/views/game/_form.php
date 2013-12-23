<?php
/* @var $this GameController */
/* @var $model Game */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'game-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'level_cd'); ?>
		<?php echo $form->textField($model,'level_cd'); ?>
		<?php echo $form->error($model,'level_cd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grid_string'); ?>
		<?php echo $form->textField($model,'grid_string',array('size'=>60,'maxlength'=>400)); ?>
		<?php echo $form->error($model,'grid_string'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Save New Grid' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->