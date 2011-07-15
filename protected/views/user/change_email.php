<h1>Change Email</h1>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
  'id'=>'user-form',
  'enableAjaxValidation'=>false,
)); ?>

  <div class="field">
    <?php echo $form->labelEx($user,'email'); ?>
    <?php echo $form->textField($user,'email',array('size'=>40,'maxlength'=>40)); ?>
    <?php echo $form->error($user,'email'); ?>
  </div>

  <div class="actions">
    <?php echo CHtml::submitButton('Save'); ?>
  </div>

  <p class="note">Fields with <span class="required">*</span> are required.</p>

<?php $this->endWidget(); ?>

</div>
