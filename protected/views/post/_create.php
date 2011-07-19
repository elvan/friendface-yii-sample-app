<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
  'id'=>'post-form',
  'action' => $this->createUrl('/post/create'),
  'enableAjaxValidation'=>true,
)); ?>

  <div class="field">
    <?php echo $form->label($post,'content', array('label' => 'Share something')); ?>
    <?php echo $form->textArea($post,'content',array('cols'=>60, 'rows' => 4, 'maxlength'=>1024)); ?>
    <?php echo $form->hiddenField($post,'recipient_id'); ?>
    <?php echo CHtml::hiddenField('returnUrl', $returnUrl); ?>
  </div>

  <div class="actions">
    <?php echo CHtml::submitButton('Share'); ?>
  </div>

<?php $this->endWidget(); ?>

</div>
