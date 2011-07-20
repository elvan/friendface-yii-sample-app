<h1>Sign in</h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'login-form',
  'enableAjaxValidation'=>false,
)); ?>

  <div class="field">
    <?php echo $form->labelEx($model,'email'); ?>
    <?php echo $form->textField($model,'email'); ?>
    <?php echo $form->error($model,'email'); ?>
  </div>

  <div class="field">
    <?php echo $form->labelEx($model,'password'); ?>
    <?php echo $form->passwordField($model,'password'); ?>
    <?php echo $form->error($model,'password'); ?>
  </div>

  <div class="field rememberMe">
    <?php echo $form->checkBox($model,'rememberMe'); ?>
    <?php echo $form->label($model,'rememberMe'); ?>
    <?php echo $form->error($model,'rememberMe'); ?>
  </div>

  <div class="actions buttons">
    <?php echo CHtml::submitButton('Sign In'); ?>
  </div>

  <p class="note">Fields with <span class="required">*</span> are required.</p>
<?php $this->endWidget(); ?>
</div><!-- form -->

<p>New user? <?php echo CHtml::link('Sign up now!', Yii::app()->baseUrl . '/signup'); ?></p>
