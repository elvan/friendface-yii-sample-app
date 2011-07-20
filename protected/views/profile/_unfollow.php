<div class="form">
  <?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'follow-form',
    'action' => $this->createUrl('/profile/unfollow'),
    'enableAjaxValidation'=>false,
  )); ?>
  <?php echo $form->hiddenField($profile, 'id'); ?>
  <div class="actions">
    <?php echo CHtml::submitButton('Unfollow'); ?>
  </div>
<?php $this->endWidget(); ?>
</div>
