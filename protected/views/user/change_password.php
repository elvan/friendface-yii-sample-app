<h1>Change Password</h1>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
  'id'=>'project-form',
  'enableAjaxValidation'=>false,
)); ?>

  <div class="field">
    <?php echo $form->labelEx($user,'password'); ?>
    <?php echo $form->passwordField($user,'password',array('size'=>40,'maxlength'=>40)); ?>
    <?php echo $form->error($user,'password'); ?>
  </div>

  <div class="field">
    <?php echo $form->labelEx($user,'password2'); ?>
    <?php echo $form->passwordField($user,'password2',array('size'=>40,'maxlength'=>40)); ?>
    <?php echo $form->error($user,'password2'); ?>
  </div>

  <div class="actions">
    <?php echo CHtml::submitButton('Save'); ?>
  </div>

  <p class="note">Fields with <span class="required">*</span> are required.</p>

<?php $this->endWidget(); ?>

</div>
