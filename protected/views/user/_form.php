<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
  'id'=>'project-form',
  'action' => 'signup',
  'enableAjaxValidation'=>false,
)); ?>

  <div class="field">
    <?php echo $form->labelEx($profile,'first_name'); ?>
    <?php echo $form->textField($profile,'first_name',array('size'=>40,'maxlength'=>50)); ?>
    <?php echo $form->error($profile,'first_name'); ?>
  </div>

  <div class="field">
    <?php echo $form->labelEx($profile,'last_name'); ?>
    <?php echo $form->textField($profile,'last_name',array('size'=>40,'maxlength'=>50)); ?>
    <?php echo $form->error($profile,'last_name'); ?>
  </div>

  <div class="field">
    <?php $date = Helper::birthDate(); ?>
    <?php echo $form->labelEx($profile,'date_of_birth'); ?>
    <?php echo $form->dropDownList($profile, 'birth_date[day]', $date['day'], array('empty' => 'Day')); ?>
    <?php echo $form->dropDownList($profile, 'birth_date[month]', $date['month'], array('empty' => 'Month')); ?>
    <?php echo $form->dropDownList($profile, 'birth_date[year]', $date['year'], array('empty' => 'Year')); ?>
    <?php echo $form->error($profile,'date_of_birth'); ?>
  </div>

  <div class="field">
    <?php echo $form->labelEx($user,'email'); ?>
    <?php echo $form->textField($user,'email',array('size'=>40,'maxlength'=>50)); ?>
    <?php echo $form->error($user,'email'); ?>
  </div>
  
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
    <?php echo CHtml::submitButton($user->isNewRecord ? 'Sign Up' : 'Save'); ?>
  </div>

  <p class="note">Fields with <span class="required">*</span> are required.</p>

<?php $this->endWidget(); ?>

</div>
