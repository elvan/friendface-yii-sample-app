<h1>Upload Profile Picture</h1>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
  'id'=>'profile-picture-form',
  'htmlOptions' => array('enctype' => 'multipart/form-data'),
  'enableAjaxValidation'=>false,
)); ?>

  <div class="field">
    <?php echo $form->labelEx($profile,'profile_pic'); ?>
    <?php echo $form->fileField($profile,'profile_pic'); ?>
    <?php echo $form->error($profile,'profile_pic'); ?>
  </div>

  <div class="actions">
    <?php echo CHtml::submitButton('Upload'); ?> or <?php echo CHtml::link('Cancel', Yii::app()->baseUrl . Helper::profile()); ?>
  </div>

  <p class="note">Fields with <span class="required">*</span> are required.</p>

<?php $this->endWidget(); ?>

</div>
