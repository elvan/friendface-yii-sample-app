<h2>Edit Profile</h2>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
  'id'=>'profile-form',
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
    <?php echo $form->labelEx($profile,'home_town'); ?>
    <?php echo $form->textField($profile,'home_town',array('size'=>40,'maxlength'=>50)); ?>
    <?php echo $form->error($profile,'home_town'); ?>
  </div>

  <div class="field">
    <?php echo $form->labelEx($profile,'current_town'); ?>
    <?php echo $form->textField($profile,'current_town',array('size'=>40,'maxlength'=>50)); ?>
    <?php echo $form->error($profile,'current_town'); ?>
  </div>

  <div class="field">
    <?php $date = Helper::birthDate(); ?>
    <?php echo $form->labelEx($profile,'date_of_birth'); ?>
    <?php echo $form->dropDownList($profile, 'birth_date[day]', $date['day'], array('empty' => 'Day')); ?>
    <?php echo $form->dropDownList($profile, 'birth_date[month]', $date['month'], array('empty' => 'Month')); ?>
    <?php echo $form->dropDownList($profile, 'birth_date[year]', $date['year'], array('empty' => 'Year')); ?>
    <?php echo $form->error($profile,'date_of_birth'); ?>
  </div>

  <div class="actions">
    <?php echo CHtml::submitButton('Save'); ?> or <?php echo CHtml::link('Cancel', Yii::app()->baseUrl . Helper::profile()); ?>
  </div>

  <p class="note">Fields with <span class="required">*</span> are required.</p>

<?php $this->endWidget(); ?>

</div>
